<?php

class Bkg_Shapefile_FileController extends Mage_Core_Controller_Front_Action
{
    public function filesAction() {
        $id = $this->getRequest()->get('id');
        $srs = $this->getRequest()->get('srs');
        
        /**
         * @var Bkg_Shapefile_Model_Resource_File_Collection $col
         */
        $col = Mage::getModel('bkg_shapefile/file')->getCollection();
        $col->join(['georef' => 'virtualgeo/components_georef_entity'], 'main_table.georef_id = georef.id', 'epsg_code');
        $col->addFieldToFilter('customer_id',['eq' => $id]);
        if (isset($srs)) {
            $col->addFieldToFilter('georef.epsg_code', ['eq' => $srs]);
        }

        $data = $col->toArray(['id', 'name', 'epsg_code']);
        
        $this->getResponse()->setHeader('Content-type', 'application/json');
        $this->getResponse()->setBody(json_encode($data['items']));
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
}