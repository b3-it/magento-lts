<?php

/***
 * Class Bkg_VirtualGeo_MapController
 */

class Bkg_VirtualGeo_MapController extends Mage_Core_Controller_Front_Action
{
    public function structurLayerAction() {

        $layerId = intval($params = $this->getRequest()->getParam('id'));
        $result = "";
        if($layerId > 0)
        {
            $layer = Mage::getModel('bkgviewer/service_layer')->load($layerId);
            if($layer->getId())
            {
               $service = Mage::getModel('bkgviewer/service_service')->load($layer->getServiceId());
               $result = $service->getUrlFeatureinfo()."&typename=".$layer->getName()."',";
            }
        }

       $this->getResponse()->setBody($result);
    }

}