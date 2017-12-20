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
	
    public function getOpenLayers() {
        self::$Count++;
        $text = array();
        $text[] = "var vectorSource".self::$Count." = new ol.source.Vector({";
        $text[] = "	format: new ol.format.WFS({gmlFormat: new ol.format.GML3()}),";
        /*
         $text[] = "	url: function(extent) {";
         $text[] = "		return '".$this->getService()->getUrlMap()."&request=GetFeature&typename=kachel:dgm10_gk3&' +";
         $text[] = "		'srsname=EPSG:6.9:31467&' +";
         $text[] = "		'bbox=' + extent.join(',') + ',EPSG:6.9:31467';";
         $text[] = "	},";
         //*/
        
        $text[] = "	url: '".$this->getService()->getUrlFeatureinfo()."&typename=".$this->getServiceLayer()->getName()."',";
        // srsName set somehow?
        
        /*//
         $text[] = "	loader: function(extent, resolution, projection) {";
         //$text[] = "	console.log(extent, resolution, projection);";
         $text[] = "	console.log(this.getUrl());";
         $text[] = "	src = this;";
         
         $text[] = "	jQuery.get(this.getUrl(), function( data ) {";
         //$text[] = "	console.log(data);";
         $text[] = "	srcProjection = ol.proj.get(src.getFormat().readProjection(data));";
         $text[] = "	console.log(srcProjection, projection);";
         $text[] = "	features = src.getFormat().readFeatures(data, {dataProjection: projection, featureProjection: srcProjection});";
         $text[] = "for (var i=0;i<features.length;i++) {";
         // BUG in OL
         //$text[] = "    features[i].getGeometry().transform(srcProjection, projection);";
         $text[] = "}";
         $text[] = "	src.addFeatures(features);";
         $text[] = "});";
         $text[] = "	},";
         
         //*/
        
        // TODO fixed bugs in OL and others, no loader is needed
        /*
         // need loader to convert features
         //*
         
         $text[] = "for (var i=0;i<data.length;i++) {";
         
         // need to flip x and y cordinates BUG in OL
         // this can be fixed in manipulate the proj4 file
         /* //
         $text[] = "  data[i].getGeometry().applyTransform(function (coords, coords2, stride) {";
         $text[] = "    for (var j=0;j<coords.length;j+=stride) {";
         $text[] = "      var y = coords[j];";
         $text[] = "      var x = coords[j+1];";
         $text[] = "      coords[j] = x;";
         $text[] = "      coords[j+1] = y;";
         $text[] = "    }";
         $text[] = "  });";
         //* /
         
         // currently it doesn't transform into the wanted projection, need to do it myself
         // BUG in OL
         //$text[] = "    data[i].getGeometry().transform(srcProjection, projection);";
         $text[] = "}";
         //* /
         $text[] = "src.addFeatures(data);";
         
         $text[] = "});";
         
         $text[] = "},";
         //*/
        //$text[] = "	strategy: ol.loadingstrategy.bbox";
        $text[] = "});";
        
        $text[] = "var vector = new ol.layer.Vector({";
        $text[] = "  source: vectorSource".self::$Count.",";
        //$text[] = "  title: '" . $this->getTitle() . "',";
        $text[] = "  zIndex: " .(100+self::$Count). ",";
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
