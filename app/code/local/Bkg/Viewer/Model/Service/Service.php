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
class Bkg_Viewer_Model_Service_Service extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('bkgviewer/service_service');
    }
    
    
    public function fetchLayers($url)
    {
    	$helper = Mage::helper('bkgviewer');
    	try 
    	{
    		$xml = $helper->fetchData($url);
    		$wms = new B3it_XmlBind_Wms13_WmsCapabilities();
    		$wms->bindXml($xml);
    		$this->setUrl($url);
    		$this->setTitle($wms->getService()->getTitle()->getValue());
    		$this->save();
    		$capa = $wms->getCapability();
    		$layer = $capa->getLayer();
			$this->_saveLayer($layer);
    	}
    	catch(Exception $ex)
    	{
    		Mage::logException($ex);
    	}
    	
    }
    
    protected function _saveLayer(B3it_XmlBind_Wms13_Layer $layer, $parent_id = null)
    {
    	$model = Mage::getModel('bkgviewer/service_layer');
    	$model->setTitle($layer->getTitle()->getValue());
    	$model->setName($layer->getName()->getValue());
    	$model->setAbstract($layer->getAbstract()->getValue());
    	$model->setParentId($parent_id);
    	$model->setServiceId($this->getId());
    	//$model->setCrs();
//     	$model->setBbWest();
//     	$model->setBbEast();
//     	$model->setBbSouth();
//     	$model->setBbNorth();
//    	$model->setStyle();
    	$model->save();
    	
    	
    	foreach($layer->getAllCrs() as $crs)
    	{
    		$mod_crs = Mage::getModel('bkgviewer/service_crs');
    		$mod_crs->setName($crs->getValue());
    		$mod_crs->setLayerId($model->getId());
    		$mod_crs->save();
    		
    	}
    	
    	foreach($layer->getAllLayer() as $ly)
    	{
    		$this->_saveLayer($ly,$model->getId());
    	}

    }
    
}
