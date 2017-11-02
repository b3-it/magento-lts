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
/**
 *  @method int getId()
 *  @method setId(int $value)
 *  @method string getTitle()
 *  @method setTitle(string $value)
 *  @method string getType()
 *  @method setType(string $value)
 *  @method int getParentId()
 *  @method setParentId(int $value)
 *  @method int getCompositId()
 *  @method setCompositId(int $value)
 *  @method int getPos()
 *  @method setPos(int $value)
 *  @method int getServiceLayerId()
 *  @method setServiceLayerId(int $value)
 */
class Bkg_Viewer_Model_Composit_Layer extends Mage_Core_Model_Abstract
{
	protected $_children = array();
	protected $_Service = null;
	protected $_ServiceLayer = null;
	protected static $Count = 0;
	
    public function _construct()
    {
        parent::_construct();
        $this->_init('bkgviewer/composit_layer');
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
    		$this->_ServiceLayer = Mage::getModel('bkgviewer/service_layer')->load($this->getServiceLayerId());
    	}
    	return $this->_ServiceLayer ;
    }
    
    
    /**
     * Kind hinzufügen und sortieren
     * @param Bkg_Viewer_Model_Composit_Layer $node
     */
    public function addChild(Bkg_Viewer_Model_Composit_Layer $node)
    {
    	//sortieren
    	$tmp = array();
    
    
    	foreach ($this->_children as $item)
    	{
    		if($node)
    		{
    			if($item->getPos() < $node->getPos())
    			{
    				$tmp[] = $item;
    			}
    			else {
    				$tmp[] = $node;
    				$tmp[] = $item;
    				$node = null;
    			}
    		}else{
    			$tmp[] = $item;
    		}
    	}
    	if($node)
    	{
    		$tmp[] = $node;
    	}
    
    	$this->_children = $tmp;
    }
    
    
    /**
     * alle Kinder nach der Id durchsuchen
     * @param string $id
     * @param string $recursiv
     * @return Bkg_Viewer_Model_Composit_Layer|NULL
     */
    public function getChild($id, $recursiv = false)
    {
    	foreach ($this->_children as $item)
    	{
    		if($item->getId() == $id){
    			return $item;
    		}
    		if($recursiv){
    			$tmp = $item->getChild($id,true);
    			if($tmp){
    				return $tmp;
    			}
    		}
    	}
    
    	return null;
    }
    
    public function getChildrenArray($recursiv = false)
    {
    	$result = array();
    	foreach ($this->_children as $item)
    	{
    		$result[] = $item;
    		if($recursiv){
    			$tmp = $item->getChildrenArray(true);
    			$result = array_merge($result,$tmp);
    		}
    	}
    
    	return $result;
    }
    
    public function getChildren()
    {
    	return $this->_children;
    }
    
    public function getOpenLayer() {
        $result = "";
        
        $type = $this->getService()->getFormat();
        if($type === 'wfs') {
            $result = $this->getOpenLayerWfs();
        } else if($type === 'wms') {
            $result = $this->getOpenLayerWms();
        } else if($type === 'wmts') {
            $result = $this->getOpenLayerWmts();
        }
        return $result.PHP_EOL;
    }
    
    
    public function getOpenLayerWmts() {
        $text = array();
        
        self::$Count++;
        
        $text[] = "var wmfsparser = new ol.format.WMTSCapabilities();";
        $text[] = "fetch('".$this->getService()->getUrl()."').then(function(response) {";
        $text[] = "  return response.text();";
        $text[] = "}).then(function(text) {";
        $text[] = "  var result = wmfsparser.read(text);";
        $text[] = "  var options = ol.source.WMTS.optionsFromCapabilities(result, {";
        $text[] = "    layer: '".$this->getServiceLayer()->getName()."',";
        $text[] = "  });";
        $text[] = "  layer".self::$Count.".setSource(new ol.source.WMTS(options));";
        $text[] = "});";
        
        $text[] = "var layer".self::$Count." = new ol.layer.Tile({";
            //source: null
        $text[] = "})";
        $text[] = "layers.push(layer".self::$Count.");";
        
        return implode(PHP_EOL, $text);
    }
    
    
    
    public function getOpenLayerWms() {
        $text = array();
        self::$Count++;
        $text[] = "var layer".self::$Count." = new ol.layer.Tile({";
        $text[] = "    source: new ol.source.TileWMS({";
        $text[] = "        url: '". $this->getService()->getUrlMap()."',";
        //$text[] = "         projection: 'EPSG:4326',";
        $text[] = "         params: {LAYERS: '".$this->getServiceLayer()->getName()."'}";
        $text[] = "    })";
        $text[] = "});";
        return implode("\n", $text);
    }
    
    public function getOpenLayerWfs()
    {
//        var_dump($this);
//        die();
        
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

    	// TODO fixed bugs in OL and others, no loader is needed
/*
    	// need loader to convert features
    	$text[] = "loader: function(extent, resolution, projection) {";
    	$text[] = "   src = this;";
        $text[] = "   console.log([extent, resolution, projection]);";
        
        //$text[] = " path = '".$this->getService()->getUrlMap()."&request=GetFeature&typename=".$this->getServiceLayer()->getName()."' +";
    	//$text[] = "		'&srsname=EPSG:6.9:31467&' +";
    	//$text[] = "		'bbox=' + extent.join(',') + ',EPSG:6.9:31467';";
    	
        $text[] = "path = 'http://sg.geodatenzentrum.de/wfs_vertriebseinheiten?SERVICE=wfs&VERSION=1.1.0&request=GetFeature&typename=vertriebseinheiten:tk200&srsname=urn:x-ogc:def:crs:EPSG:25832';";
        
        $text[] = "   console.log(path);";
        $text[] = "jQuery.ajax(path, {cache: false }).then(function(response,textStatus, jqXHR ) {";
        $text[] = "srcProjection = src.getFormat().readProjection(response);";
        //$text[] = "console.log(srcProjection."
        $text[] = "   console.log(ol.proj.get(srcProjection));";
//        $text[] = "srcProjection ='EPSG:25832';";
        $text[] = "data = src.getFormat().readFeatures(response, {dataProjection: srcProjection, featureProjection: projection});";
        //$text[] = "   console.log(data);";
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
    	$text[] = "  style: function(feature, resolution) {";
    	$text[] = "    j = jQuery('#qty-' + feature.get('sku'));";
    	
    	$text[] = "    return new ol.style.Style({";
    	$text[] = "      stroke: new ol.style.Stroke({";
    	$text[] = "        color: 'rgba(0, 0, 0, 1.0)',";
    	$text[] = "        width: 1";
    	$text[] = "      }),";
    	$text[] = "      fill: new ol.style.Fill({";
    	$text[] = "        color: j.length == 0 ? 'rgba(255, 0, 0, 0.25)' : j.val() == 0 ? 'rgba(0, 0, 255, 0.25)' : 'rgba(0, 255, 0, 0.25)',";
    	$text[] = "      }),";
/*
    	$text[] = "      text:  new ol.style.Text({";
    	//$text[] = "        scale: 2,";
    	$text[] = "        fill: new ol.style.Fill({";
    	$text[] = "          color: 'rgba(0, 0, 255, 1.0)',";
    	$text[] = "        }),";
    	$text[] = "        text: feature.get('name')";
    	$text[] = "      }),";
//*/
    	$text[] = "    });";
    	$text[] = "  }";
    	$text[] = "});";
    	$text[] = "layers.push(vector);";
    	 
    	return implode("\n", $text);
    }
}
