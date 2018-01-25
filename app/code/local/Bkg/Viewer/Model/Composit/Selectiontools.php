<?php
/**
 *
 * @category   	Bkg Viewer
 * @package    	Bkg_Viewer
 * @name       	Bkg_Viewer_Model_Composit_Layer
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */

class Bkg_Viewer_Model_Composit_Selectiontools extends Mage_Core_Model_Abstract
{
	protected $_children = array();
	protected $_Service = null;
	protected $_ServiceLayer = null;
	protected static $Count = 0;
	
    public function _construct()
    {
        parent::_construct();
        $this->_init('bkgviewer/composit_selectiontools');
    }
    
   
	public function getOptions4Product($compositId)
	{
		$collection = $this->getCollection();
		$collection->getSelect()
		->join(array('layer'=>$collection->getTable('bkgviewer/service_layer')),'layer.id= main_table.layer_id',array('title'))
		->where('composit_id = ?', $compositId)
		->order('pos');
		
		return $collection;
	}
	
	
	/**
	 * Ermittelt denService zu diesem CompositLayer
	 * @return Bkg_Viewer_Model_Service_Service
	 */
	public function getService()
	{
	    if($this->_Service == null)
	    {
	        $this->_Service = Mage::getModel('bkgviewer/service_service')->load($this->getServiceLayer()->getServiceId());
	    }
	    return $this->_Service ;
	}
	
	
	/**
	 *
	 * @return Bkg_Viewer_Model_Service_Layer
	 */
	public function getServiceLayer()
	{
	    if($this->_ServiceLayer == null)
	    {
	        $this->_ServiceLayer = Mage::getModel('bkgviewer/service_layer')->load($this->getLayerId());
	    }
	    return $this->_ServiceLayer ;
	}
	
    public function getOpenLayers($geocode = false) {
        self::$Count++;
        $text = array();
        $helper = Mage::helper("core");

        $text[] = "var url = '" . $this->getService()->getUrlFeatureinfo()."&typename=".$this->getServiceLayer()->getName() . "';";
        if ($geocode) {
            $text[] = "url += '&srsname=EPSG:' + " . $geocode .";";
        }

        $text[] = "var vectorSource".self::$Count." = new ol.source.Vector({";
        $text[] = "	format: new ol.format.WFS({gmlFormat: new ol.format.GML3()}),";

        $text[] = "	url: url,";
        // srsName set somehow?

        //$text[] = "	strategy: ol.loadingstrategy.bbox";
        $text[] = "});";
        
        $text[] = "var vector = new ol.layer.Vector({";
        $text[] = "  source: vectorSource".self::$Count.",";
        $text[] = "  title: '" . $helper->jsQuoteEscape($this->getLabel()) . "',";
        $text[] = "  zIndex: " .(100+self::$Count). ",";
        $text[] = "  visible: false,";
        $text[] = "  style: new ol.style.Style({";
        $text[] = "    stroke: new ol.style.Stroke({";
        $text[] = "      color: 'red',";
        $text[] = "      width: 2";
        $text[] = "    }),";
        $text[] = "  }),";
        $text[] = "});";
        $text[] = "tools.push(vector);";
        
        return implode("\n", $text);
    }
}
