<?php
/**
 *
 * @category   	Bkg Viewer
 * @package    	Bkg_Viewer
 * @name       	Bkg_Viewer_Model_Service_Service
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */




class Bkg_Viewer_Model_Service_Tilesystem extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('bkgviewer/service_tilesystem');
    }
    
 
    public function fetchLayers($url)
    {
    	$helper = Mage::helper('bkgviewer');
    	//try
    	{
    		$url = trim($url,'?');
    		$url .= "?Request=GetCapabilities&SERVICE=WMS&VERSION=1.3.0";
    		$xml = $helper->fetchData($url);
    		$wms = new B3it_XmlBind_Wms13_WmsCapabilities();
    		$capa = $wms->getCapability();
    		$wms->bindXml($xml);
    		$this->setUrl($url);
    		$this->setTitle($wms->getService()->getTitle()->getValue());
    		$this->setUrlFeatureinfo($this->_getHref($capa->getRequest()->getGetfeatureinfo()->getAllDcptype()));
    		$this->setUrlMap($this->_getHref($capa->getRequest()->getGetmap()->getAllDcptype()));
    		$this->save();
    
    		$layer = $capa->getLayer();
    		$this->_saveLayer($layer);
    	}
    	//     	catch(Exception $ex)
    	//     	{
    	//     		Mage::logException($ex);
    	//     	}
       
    }
    
    public function importFile($path)
    {
    	$path .= DS . $this->getFilename();
    	$data = file_get_contents($path);
    	$this->_import($data);
        
    	return $this;
    }
    
    protected function _import($data)
    {
    	$this->setIdent('import '.now())->save();
    	
    	
    	$xmlobj = new \DOMDocument();
    	$xmlobj->loadXML($data);
    	foreach ($xmlobj->getElementsByTagName('featureMember') as $node) {
    		/** @var \DOMElement $node */
    		if ($node instanceof \DOMElement) {
    			$id = $node->getElementsByTagName('ID')->item(0)->textContent;
    	
    			$polygons = array();
	    		try{
	    			foreach ($node->getElementsByTagName('Polygon') as $polynode) {
	    				if ($polynode instanceof \DOMElement) {
	    	
	    					$lines = [];
	    					foreach ($polynode->getElementsByTagName('posList') as $listnode) {
	    						$cords = array_chunk(explode(" ", trim($listnode->textContent)), 2);
	    						$linestring = new Bkg_Geometry_LineString();
	    						$linestring->load($cords);
	    					}
	    					$text = implode(', ', $lines);
	    					
	    					$polygon  = new Bkg_Geometry_Polygon();
	    					$polygon->setExterior($linestring);
	    					$polygons[] = $polygon;
	    				}
	    			}
	    	
	    			if (!empty($polygons)) {
	    				foreach($polygons as $polygon)
	    				{
		    				$tile = Mage::getModel('bkgviewer/service_tile');
		    				$tile
		    				->setGEOShape($polygon)
		    				->setSystemId($this->getId())
		    				->setIdent($id)
		    				->save();
	    				//$gmls[$id] = call_user_func_array(array(MultiPolygon::class, 'of'), $polygons);
	    				}
	    			}
	    		}
	    		catch(Exception $ex)
	    		{
	    			die($ex);
	    		}
    		}
    	}
    }
    
    
    /**
     * Laden eines Kachelsystems anhand der ident und CRS
     * @param string $ident
     * @param string $crs
     * @return Bkg_Viewer_Model_Resource_Service_Tilesystem
     */
    public function loadWithCRS($ident, $crs = null)
    {
    	$this->_beforeLoad(null, null);
        $this->_getResource()->loadWithCRS($this, $ident, $crs);
        $this->_afterLoad();
        $this->setOrigData();
        $this->_hasDataChanges = false;
        return $this;
    }
    
}
