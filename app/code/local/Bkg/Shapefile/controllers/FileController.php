<?php

class Bkg_Shapefile_FileController extends Mage_Core_Controller_Front_Action
{
    public function filesAction() {
        $id = $this->getRequest()->get('id');
        $srs = $this->getRequest()->get('srs');
        
        /**
         * @var Bkg_Shapefile_Helper_Data $helper
         */
        $helper = Mage::helper('bkg_shapefile');
        
        $this->getResponse()->setHeader('Content-type', 'application/json');
        $this->getResponse()->setBody(json_encode($helper->getFilesByUser($id, $srs)));
    }
    
    
    public function shapesAction() {
        $id = $this->getRequest()->get('id');
        
        /**
         * @var Bkg_Shapefile_Model_Resource_Shape_Collection $col
         */
        $col = Mage::getModel('bkg_shapefile/shape')->getCollection();
        $col->getSelect()
        ->where('file_id = ?', $id);
        
        $data = $col->toArray(['id', 'shape']);

        $this->getResponse()->setHeader('Content-type', 'application/json');
        $this->getResponse()->setBody(json_encode($data['items']));
    }
    
    public function shapeIntersectionAction() {
        $id = $this->getRequest()->get('id');
        $lid = $this->getRequest()->get('layer');
        
        // TODO add caching there or in the helper
        $key = implode("_", array(
            'intersectShape',
            $id, $lid
        ));
        
        if (($data = Mage::app()->getCache()->load($key))) {
            //var_dump("data found!");
            $data = gzuncompress($data);
        } else {
            /**
             * @var Bkg_Shapefile_Helper_Data $helper
             */
            $helper = Mage::helper('bkg_shapefile');
            $data = $helper->getShapeIntersection($id, $lid);
            $data = json_encode($data);
            $str = gzcompress($data, 9);
            
            Mage::app()->getCache()->save($str, $key, array(), null);
        }
        
        $this->getResponse()->setHeader('Content-type', 'application/json');
        $this->getResponse()->setBody($data);
    }
}