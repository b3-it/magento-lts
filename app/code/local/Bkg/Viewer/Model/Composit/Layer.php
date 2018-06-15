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
    
    public function getOpenLayer($level = 0, $espg = false) {
        $result = "";
        // no service layer means its a category one
        if ($this->getServiceLayerId() === null) {
            $helper = Mage::helper('core');
            // can't use let there because of Browser support
            $result = "layers_" . ($level + 1) ." = [];".PHP_EOL;
            foreach ($this->getChildren() as $child) {
                //var_dump($child);
                //die();
                $result .= $child->getOpenLayer($level + 1, $espg);
            }
            
            $lines = [];
            
            $lines[] = "layers_$level.push(new ol.layer.Group({";
            // need title
            $lines[] = "title: '" . $helper->jsQuoteEscape($this->getTitle()) . "',";
            $lines[] = "visible: " . ($this->getIsChecked() ? "true" : "false") . ",";
            $lines[] = "layers: layers_". ($level + 1);
            $lines[] = "}));";
            //$result =
            return $result.implode(PHP_EOL, $lines).PHP_EOL;
        }
        $type = $this->getService()->getFormat();
        if($type === 'wfs') {
            $result = $this->getOpenLayerWfs($level, $espg);
        } else if($type === 'wms') {
            $result = $this->getOpenLayerWms($level, $espg);
        } else if($type === 'wmts') {
            $result = $this->getOpenLayerWmts($level);
        }
        return $result.PHP_EOL;
    }
    
    
    public function getOpenLayerWmts($level, $espg = false) {
        $text = array();
        $helper = Mage::helper("core");
        
        self::$Count++;
        
        $text[] = "var layer".self::$Count." = new ol.layer.Tile({";
        $text[] = "  title: '" . $helper->jsQuoteEscape($this->getTitle()) . "',";
        $text[] = "  visible: " . ($this->getIsChecked() ? "true" : "false") . ",";
        $text[] = "  zIndex: " . $this->getVisualPos();
        //source: null
        $text[] = "})";
        
        $text[] = "var wmfsparser = new ol.format.WMTSCapabilities();";

        $text[] = "\$j.ajax('".$this->getService()->getUrl()."',{";
        // TODO add ajax handler for loading overlay
        $text[] = "dataType: 'text',";
        
        $text[] = "beforeSend: incLoading,";
        $text[] = "complete: decLoading,";
        $text[] = "success: function(text) {";
        $text[] = "  var result = wmfsparser.read(text);";
        $text[] = "  var options = ol.source.WMTS.optionsFromCapabilities(result, {";
        $text[] = "    layer: '".$this->getServiceLayer()->getName()."',";
        if ($espg) {
            $text[] = "   projection: 'EPSG:' + " . $espg .",";
        }
        $text[] = "});";
        $text[] = "  layer".self::$Count.".setSource(new ol.source.WMTS(options));";
        $text[] = "}";
        $text[] = "});";

        $text[] = "layers_$level.push(layer".self::$Count.");";
        
        return implode(PHP_EOL, $text);
    }
    
    
    
    public function getOpenLayerWms($level, $espg = false) {
        $text = array();
        $helper = Mage::helper("core");
        self::$Count++;
        $text[] = "var layer".self::$Count." = new ol.layer.Tile({";
        $text[] = "  title: '" . $helper->jsQuoteEscape($this->getTitle()) . "',";
        $text[] = "  visible: " . ($this->getIsChecked() ? "true" : "false") . ",";
        $text[] = "  zIndex: " . $this->getVisualPos() . ",";
        $text[] = "    source: new ol.source.TileWMS({";
        $text[] = "        url: '". $this->getService()->getUrlMap()."',";
        if ($espg) {
            $text[] = "         projection: 'EPSG:' + " . $espg .",";
        }
        $text[] = "         params: {LAYERS: '".$this->getServiceLayer()->getName()."'}";
        $text[] = "    })";
        $text[] = "});";
        $text[] = "layers_$level.push(layer".self::$Count.");";
        return implode("\n", $text);
    }
    
    public function getOpenLayerWfs($level, $espg = false)
    {
        $helper = Mage::helper('core');
        
    	self::$Count++;
    	$text = array();
    	
    	$name = $this->getServiceLayer()->getName();
    	$text[] = "var url = '" . $this->getService()->getUrlFeatureinfo()."&typename=".$helper->jsQuoteEscape($name). "';";
    	if ($espg) {
    	    $text[] = "url += '&srsname=EPSG:' + " . $espg .";";
    	}

    	$text[] = "var vectorSource".self::$Count." = new ol.source.Vector({";
    	$text[] = "	format: new ol.format.WFS({gmlFormat: new ol.format.GML3()}),";
/*
    	$text[] = "	url: function(extent) {";
    	$text[] = "		return '".$this->getService()->getUrlMap()."&request=GetFeature&typename=kachel:dgm10_gk3&' +";
    	$text[] = "		'srsname=EPSG:6.9:31467&' +";
    	$text[] = "		'bbox=' + extent.join(',') + ',EPSG:6.9:31467';";
    	$text[] = "	},";
//*/

    	$text[] = "	url: url,";
    	$text[] = " loader: ajaxLoader,";

    	//$text[] = "	strategy: ol.loadingstrategy.bbox";
    	$text[] = "});";

    	$text[] = "var vector = new ol.layer.Vector({";
    	$text[] = "  source: vectorSource".self::$Count.",";
    	$text[] = "  title: '" . $helper->jsQuoteEscape($this->getTitle()) . "',";
    	$text[] = "  visible: " . ($this->getIsChecked() ? "true" : "false") . ",";
    	$text[] = "  zIndex: " . intval($this->getVisualPos());
    	$text[] = "});";
    	$text[] = "layers_$level.push(vector);";
    	 
    	return implode("\n", $text);
    }
}
