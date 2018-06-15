<?php

/***
 * Class Bkg_VirtualGeo_MapController
 */

class Bkg_VirtualGeo_MapController extends Mage_Core_Controller_Front_Action
{
    public function structurLayerAction() {
    
    	$structureId = intval($this->getRequest()->getParam('id'));
    	$geoepsg = $this->getRequest()->getParam('geoepsg');

    	$productCode = $this->getRequest()->getParam("procode");

   	    $data = $this->__structureLayerData($structureId, $geoepsg, $productCode);

   	    $this->getResponse()->setHeader('Content-type', 'application/json', true);
    	$this->getResponse()->setBody(json_encode($data, JSON_FORCE_OBJECT));
    }
    
    private function __structureLayerData($structureId, $geoepsg, $productCode) {
        if($structureId <= 0) {
            return array();
        }

        /**
         * @var Bkg_VirtualGeo_Model_Components_Structure $structure
         */
        $structure = Mage::getModel('virtualgeo/components_structure')->load($structureId);
        
        if ($structure == null || $structure->getId() <= 0) {
            return array();
        }
        /**
         * @var Bkg_VirtualGeo_Model_Components_Georef $geo
         */
        $geo = Mage::getModel('virtualgeo/components_georef')->load($geoepsg, 'epsg_code');
        
        if ($geo == null || $geo->getId() <= 0) {
            return array();
        }
        // TODO: prefer load by epsg code, but allow to load by georef code too
        
        /**
         * @var Bkg_Viewer_Model_Service_Service $service
         */
        $service = Mage::getModel('bkgviewer/service_service')->load($structure->getServiceId());

        if($service == null || $service->getId() <= 0) {
            return  array();
        }
        
        $data = array();
        
        // layer prefix like vertriebseinheiten, need to be added there
        $namingRule = $structure->getData("layer_naming_rule");

        $layer = strtr($namingRule, array(
            "{{product_code}}" => $productCode,
            "{{crs_code}}"  => $geo->getData("code"),
            "{{structure_code}}" => $structure->getCode()
        ));

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

            // try to get the attributeName for the feature ids
            try {
                // need to split the layer name xxx:abc, only abc is needed there
                $name = explode(":", $layer);
                if (isset($name[1])) {
                    /**
                     * @var BKG_VirtualGeo_Helper_Gdz $helper
                     */
                    $helper = Mage::helper("virtualgeo/gdz");
                    $json = $helper->describe($name[1]);
                    // fdata has attributeName, srs and geometryName
                    if (isset($json['attributeName'])) {
                        $data['fid'] = $json['attributeName'];
                    }
                    if (isset($json["srs"])) {
                        $data['srs'] = $json["srs"];
                    }
                }
            } catch (Exception $e) {
                // do nothing for now?
                // still log the exception, even if it might be harmless
                Mage::logException($e);
            }
        }
        
        $result = $service->getUrlFeatureinfo()."&typename=".$layer;
        // add EPSG code there, if going through describe, use the srs from there
        if (isset($data['srs'])) {
            // need urn:x-ogc:def:crs, otherwise it might be wrong Axis
            $result .= "&srsname=urn:x-ogc:def:crs:".$data['srs'];
        } else if (!empty($geo->getEpsgCode())) {
            // need urn:x-ogc:def:crs, otherwise it might be wrong Axis
            $result .= "&srsname=urn:x-ogc:def:crs:EPSG:".$geo->getEpsgCode();
        }
        $data['url'] = $result;
        
        return $data;
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
        $c = $r->getParam("srs"); // currently not used anymore, target now has only one srs, but use it for cache key 
        $si = $r->getParam("id"); 
        
        $key = implode("_", array(
            'intersectGeometry',
            $s, $t, $c, $si
        ));

        if (($data = Mage::app()->getCache()->load($key))) {
            $data = gzuncompress($data);
            // gzuncompress doesn't seems to have any error value?
        } else {
            try {
                /**
                 * @var BKG_VirtualGeo_Helper_Gdz $gdz
                 */
                $gdz = Mage::helper('virtualgeo/gdz');
                $json = $gdz->intersect($s, $si, $t);

                if (isset($json[$si])) {
                    $data = json_encode($json[$si]);

                    // only cache if data is not empty
                    $str = gzcompress($data, 9);
                    if (false !== $str) {
                        Mage::app()->getCache()->save($str, $key, array(), null);
                    }
                }
            } catch (Exception $e) {
                Mage::logException($e);
            }
        }
        if ($data === false) {
            // return json doesn't has the data, return empty object but don't store it
            $data = json_encode(array());
        }
        
        $this->getResponse()->setHeader('Content-type', 'application/json', true);
        $this->getResponse()->setBody($data);
    }

}