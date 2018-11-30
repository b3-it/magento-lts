<?php
// need to register, needed on other servers
require_once(Mage::getBaseDir('lib'). DS . 'ShapeFile'. DS .'ShapeFileAutoloader.php');
\ShapeFile\ShapeFileAutoloader::register();

/**
 Bkg_Shapefile_Helper_Data
 
*/
class Bkg_Shapefile_Helper_Data extends Mage_Core_Helper_Data {
	
	public function newShapeFile($shp, $dbf, $shx, $name, $georef_id, $customer_id) {
	    try {
    	    $shapeFile = new \ShapeFile\ShapeFile(array(
    	        'shp' => $shp,
    	        'dbf' => $dbf,
    	        'shx' => $shx
    	    ));
    	    
    	    $shapeFile->setDefaultGeometryFormat(\ShapeFile\ShapeFile::GEOMETRY_WKT);
    	    
    	    $shapes = [];
    	    foreach ($shapeFile as $record) {
    	        if ($record['dbf']['_deleted']) continue;
    	        // Geometry
    	        $shapes[] =$record['shp'];
    	    }
    	    // this should close the files
    	    $shapeFile = NULL;
    	    
    	    /**
    	     * @var Bkg_Shapefile_Model_File $m
    	     */
    	    $m = Mage::getModel('bkg_shapefile/file');
    	    $m->setData('customer_id', $customer_id);
    	    $m->setData('georef_id', $georef_id);
    	    $m->setData('name', $name);
    	    $m->save();
    	    foreach ($shapes as $shape){
    	        /**
    	         * @var Bkg_Shapefile_Model_Shape $s
    	         */
    	        $s = Mage::getModel('bkg_shapefile/shape');
    	        $s->setData('file_id', $m->getId());
    	        $s->setWkt($shape);
    	        $s->save();
    	    }
	    } finally {
    	    // check if file exist and try to delete them
    	    if (file_exists($shp)) {
    	        @unlink($shp);
    	    }
    	    if (file_exists($dbf)) {
    	        @unlink($dbf);
    	    }
    	    if (file_exists($shx)) {
    	        @unlink($shx);
    	    }
	    }
	}
	
	
	public function getShapeIntersection($shape_id, $layer_id) {
	    //TODO check session User
	    /**
	     * @var Bkg_Shapefile_Model_File $m
	     */
	    $m = Mage::getModel('bkg_shapefile/file')->load($shape_id);
	    // get the crs
	    $crs_id = $m->getData('georef_id');

	    /**
	     * @var Bkg_VirtualGeo_Model_Resource_Service_Geometry_Collection $col
	     */
	    $col = Mage::getModel('virtualgeo/service_geometry')->getCollection();
	    $col->getSelect()
	    ->reset(Zend_Db_Select::COLUMNS)
	    ->columns(array('shape_id' => 'vg.id', 'lname' => 'main_table.name'));
	    $col->join(array('vg' => 'bkg_shapefile/shape'), "(ST_Intersects(main_table.shape, vg.shape) = 1) AND main_table.layer_id = {$layer_id} AND vg.file_id = {$shape_id} AND main_table.crs_id = {$crs_id}", '');

	    $data = $col->toArray();

	    $result = array();
	    foreach ($data['items'] as $d) {
	        $result[$d['shape_id']][] = $d['lname'];
	    }
	    
	    return $result;
	}
	
	public function getFilesByUser($user_id, $srs = null) {
	    /**
	     * @var Bkg_Shapefile_Model_Resource_File_Collection $col
	     */
	    $col = Mage::getModel('bkg_shapefile/file')->getCollection();
	    $col->join(['georef' => 'virtualgeo/components_georef_entity'], 'main_table.georef_id = georef.id', 'epsg_code');
	    $col->addFieldToFilter('customer_id',['eq' => $user_id]);
	    if (isset($srs)) {
	        $col->addFieldToFilter('georef.epsg_code', ['eq' => $srs]);
	    }
	    
	    $data = $col->toArray(['id', 'name', 'epsg_code', 'zIndex']);

	    return $data['items'];
	}
}