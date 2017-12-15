<?php

/***
 * Class Bkg_VirtualGeo_MapController
 */

class Bkg_VirtualGeo_MapController extends Mage_Core_Controller_Front_Action
{
   
    
    public function structurLayerAction() {
    
    	$structureId = intval($this->getRequest()->getParam('id'));
    	$georef = $this->getRequest()->getParam('georef');
    	$result = "";
    	if($structureId > 0)
    	{
    		
    		$structure = Mage::getModel('virtualgeo/components_structure')->load($structureId);
    		$service = Mage::getModel('bkgviewer/service_service')->load($structure->getServiceId());
    		if($service->getId() > 0)
    		{
    			$layer = $structure->getCode()."_".$georef;
    			$layer = "kachel:dgm10"."_".$georef;
    			//http://sg.geodatenzentrum.de/wfs_kachel?Request=GetFeature&SERVICE=wfs&VERSION=2.0.0&typename=kachel:dgm10_gk3
    			$result = $service->getUrlFeatureinfo()."Request=GetFeature&SERVICE=wfs&VERSION=2.0.0&typename=".$layer;
    		}
    	}
    
    	$this->getResponse()->setBody($result);
    }

}