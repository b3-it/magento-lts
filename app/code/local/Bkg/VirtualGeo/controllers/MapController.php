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
    		/**
    		 * @var Bkg_VirtualGeo_Model_Components_Structure $structure
    		 */
    		$structure = Mage::getModel('virtualgeo/components_structure')->load($structureId);
    		
    		/**
    		 * @var Bkg_VirtualGeo_Model_Components_Georef $geo
    		 */
    		$geo = Mage::getModel('virtualgeo/components_georef')->load($georef, 'code');
    		
    		/**
    		 * @var Bkg_Viewer_Model_Service_Service $service
    		 */
    		$service = Mage::getModel('bkgviewer/service_service')->load($structure->getServiceId());
    		$data = array();
    		if($service->getId() > 0)
    		{
    			$layer = $structure->getCode()."_".$georef;
    			$layer = "kachel:dgm10"."_".$georef;
    			
    			//check if layer does exist in layer list 
    			
    			/**
    			 * @var Bkg_Viewer_Model_Resource_Service_Layer_Collection $layerCollection
    			 */
    			$layerCollection = Mage::getModel('bkgviewer/service_layer')->getCollection();
    			
    			$select = $layerCollection->getSelect();
    			$select->where("service_id = ?", $service->getId());
    			$select->where("name = ?", $layer);
    			
    			if (!$layerCollection->count()) {
    			    Mage::log("Layer '" . $layer . "' für Service '" . $service->getTitle() . "' nicht gespeichert.");
    			} else {
    			    /**
    			     * @var Bkg_Viewer_Model_Service_Layer $lay
    			     */
    			    $lay = $layerCollection->getFirstItem();
    			    $data['id'] = $lay->getId();
    			}

    			// add EPSG code there
    			$result = $service->getUrlFeatureinfo()."&typename=".$layer;
    			if ($geo !== null && !empty($geo->getEpsgCode())) {
    			    $result .= "&srsname=EPSG:".$geo->getEpsgCode();
    			}
    			$data['url'] = $result;
    		}
    	}
    	$this->getResponse()->setHeader('Content-type', 'application/json');
    	$this->getResponse()->setBody(json_encode($data));
    }
    
    public function loadGeometryAction() {
        $r = $this->getRequest();
        $l = $r->getParam('layer');
        $c = $r->getParam("srs");
        
        Mage::helper('virtualgeo/geometry')->getPolygons($l, $c);
    }
    
    public function intersectGeometryAction() {
        $r = $this->getRequest();
        $s = $r->getParam('select');
        $t = $r->getParam("target");
        $c = $r->getParam("srs");
        $si = $r->getParam("id"); 
        // TODO add caching there or in the helper
        $key = implode("_", array(
            'intersectGeometry',
            $s, $t, $c, $si
        ));
        
        if (($data = Mage::app()->getCache()->load($key))) {
            //var_dump("data found!");
            $data = gzuncompress($data);
        } else {
            $data = Mage::helper('virtualgeo/geometry')->getIntersection($s,$t,$c, $si);
            $data = json_encode($data);
            $str = gzcompress($data, 9);

            Mage::app()->getCache()->save($str, $key, array(), null);
        }
        
        $this->getResponse()->setHeader('Content-type', 'application/json');
        $this->getResponse()->setBody($data);
    }

}