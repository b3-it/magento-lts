<?php

class BKG_VirtualGeo_Helper_Geometry extends Mage_Core_Helper_Abstract
{
    public function getPolygons($layerId, $crsId) {
        /**
         * @var Bkg_Viewer_Helper_Data $helper
         */
        $helper = Mage::helper('bkgviewer');
        /**
         * @var Bkg_Viewer_Model_Service_Layer $layer
         */
        $layer = Mage::getModel('bkgviewer/service_layer')->load($layerId);
        
        /**
         * @var Bkg_Viewer_Model_Service_Service $service
         */
        $service = Mage::getModel('bkgviewer/service_service')->load($layer->getServiceId());
        
        $type = $service->getFormat();
        if($type !== 'wfs') {
            return;
        }
        
        /**
         * @var Bkg_VirtualGeo_Model_Components_Georef $crs
         */
        $crs = Mage::getModel('virtualgeo/components_georef')->load($crsId);
        
        $url = $service->getUrlFeatureinfo()."&typename=".$layer->getName()."&srsname=EPSG:".$crs->getEpsgCode();
        var_dump($url);
        $data = $helper->fetchData($url);
        
        
        $xmlobj = new \DOMDocument();
        $xmlobj->loadXML($data);
        
        if ($xmlobj->documentElement->nodeName != "wfs:FeatureCollection") {
            return;
        }
        $i = 0;
        foreach ($xmlobj->getElementsByTagName('featureMember') as $featureMember) {
            $i++;
            //if ($i == 13) {
            //    continue;
            //}
            /** @var \DOMElement $featureMember */
            if ($featureMember instanceof \DOMElement) {
                //var_dump($featureMember);
                $id = $featureMember->firstChild->getAttribute('gml:id');
                
                // fall back if gml:id is empty, use ID element instead
                if (empty($id)) {
                    $id = $featureMember->firstChild->getElementsByTagName('ID')->item(0)->nodeValue;
                }
                
                /**
                 * @var Bkg_VirtualGeo_Model_Service_Geometry $tile
                 */
                $tile = Mage::getModel('virtualgeo/service_geometry');
                
                /**
                 * @var Mage_Core_Model_Resource_Db_Collection_Abstract $col
                 */
                $col = $tile->getCollection();
                $col->addFieldToFilter('name', $id);
                $col->addFieldToFilter('layer_id', $layerId);
                $col->addFieldToFilter('crs_id', $crsId);
                //var_dump($col->getSelectSql(true));
                // tile already exist
                if ( $col->count() > 0) {
                    continue;
                }
                
                //close for now?
                //Mage::getSingleton('core/resource')->getConnection('read')->closeConnection();             
                
                $multiPoly = new Bkg_Geometry_Multipolygon();
                //$polygons = array();
                try{
                    foreach ($featureMember->getElementsByTagName('Polygon') as $polynode) {
                        if ($polynode instanceof \DOMElement) {
                            $polygon = new Bkg_Geometry_Polygon();
                            
                            foreach ($polynode->getElementsByTagName('exterior') as $extnode)
                            {
                                foreach ($extnode->getElementsByTagName('posList') as $listnode) {
                                    $cords = array_chunk(explode(" ", trim($listnode->textContent)), 2);
                                    $linestring =  new Bkg_Geometry_LineString();
                                    $linestring->load($cords);
                                    $polygon->setExterior($linestring);
                                }
                                
                                
                                
                            }
                            foreach ($polynode->getElementsByTagName('interior') as $intnode)
                            {
                                foreach ($intnode->getElementsByTagName('posList') as $listnode) {
                                    $cords = array_chunk(explode(" ", trim($listnode->textContent)), 2);
                                    $linestring =  new Bkg_Geometry_LineString();
                                    $linestring->load($cords);
                                    $polygon->addInterior($linestring);
                                }
                            }
                            $multiPoly->addPoloygon($polygon);
                        }
                    }
                    
                    //if (!empty($polygons))
                    {
                        $tile
                        ->setName($id)
                        ->setLayerId($layerId)
                        ->setCrsId($crsId)
                        ->setGEOShape($multiPoly)
                        ->save();
                    }
                }
                catch(Exception $ex)
                {
                    //var_dump($i);
                    //$txt = "(MultiPolygonFromText('".$multiPoly->toString(Bkg_Geometry_Format::WKT)."'))";
                    //echo $txt;
                    var_dump(get_class($ex));
                    var_dump($ex);
                    die($ex);
                }
            }
        }
        die();
    }
    
    public function getIntersection($select_id, $value_id, $crs_id, $select_name) {
        /**
         * @var Bkg_VirtualGeo_Model_Resource_Service_Geometry_Collection $col
         */
        $col = Mage::getModel('virtualgeo/service_geometry')->getCollection();
        $col->getSelect()
        ->reset(Zend_Db_Select::COLUMNS)
        ->columns(array('vgname' => 'vg.name'));
        $col->join(array('vg' => 'virtualgeo/service_geometry'), "(ST_Intersects(main_table.shape, vg.shape) = 1) AND main_table.name = \"{$select_name}\" AND main_table.layer_id = {$select_id} AND vg.layer_id = {$value_id} AND main_table.crs_id = {$crs_id} AND vg.crs_id = {$crs_id}", '');
        
        //var_dump($col->getSelectSql(true));
        //var_dump($col->count());
        
        $data = $col->toArray(['vgname']);

        $result = array();
        foreach ($data['items'] as $d) {
            $result[] = $d['vgname'];
        }
        
        return $result;
    }
}

