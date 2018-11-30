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

        $name = $this->getServiceLayer()->getName();
        $text[] = "var url = '" . $this->getService()->getUrlFeatureinfo()."&typename=". $helper->jsQuoteEscape($name) . "';";
        if ($geocode) {
            // need urn:x-ogc:def:crs, otherwise it might be wrong Axis?
            $text[] = "url += '&srsname=urn:x-ogc:def:crs:EPSG:' + " . $geocode .";";
        }

        $text[] = "var vectorSource".self::$Count." = new ol.source.Vector({";
        $text[] = "	format: new ol.format.WFS({gmlFormat: new ol.format.GML3()}),";

        $text[] = "	url: url,";
        // srsName set somehow?
        
        // ajaxLoader to be make use of Overlay
        $text[] = " loader: ajaxLoader,";
        
        //$text[] = "	strategy: ol.loadingstrategy.bbox";
        $text[] = "});";
        
        // need to use gdz helper there?
        if (class_exists(Mage::getConfig()->getHelperClassName("virtualgeo/gdz"))) {
            $exp =  explode(":", $name);
            /**
             * @var BKG_VirtualGeo_Helper_Gdz $gdz
             */
            $gdz = Mage::helper("virtualgeo/gdz");

            if ($gdz != null && isset($exp[1]) && $gdz->includeLayer($exp[1])) {
                $json = $gdz->describe($exp[1]);
                if (isset($json['attributeName'])) {
                    $text[] = "vectorSource".self::$Count.".set('attributeName','" . $helper->jsQuoteEscape($json['attributeName']) . "');";
                }
            }
        }

        $text[] = "var vector = new ol.layer.Vector({";
        $text[] = "  source: vectorSource".self::$Count.",";
        $text[] = "  title: '" . $helper->jsQuoteEscape($this->getLabel()) . "',";
        $text[] = "  layer_id: ".intval($this->getLayerId()).",";
        
        $vpos = $this->getVisualPos();
        if ($vpos === null) {
            $vpos = $this->getPos();
        }
        $text[] = "  zIndex: " .intval($vpos). ",";
        // default invisible, will be set visible with menu
        $text[] = "  visible: false,";
        $text[] = "  style: selectionStyle,";
        $text[] = "});";
        $text[] = "tools.push(vector);";
        
        return implode("\n", $text);
    }
}
