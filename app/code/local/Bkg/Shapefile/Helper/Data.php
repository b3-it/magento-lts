<?php
// need to register, needed on other servers
require_once(Mage::getBaseDir('lib'). DS . 'ShapeFile'. DS .'ShapeFileAutoloader.php');
\ShapeFile\ShapeFileAutoloader::register();

/**
 Bkg_Shapefile_Helper_Data
 
*/
class Bkg_Shapefile_Helper_Data extends Mage_Core_Helper_Data {
	
	public function newShapeFile($shp, $dbf, $shx, $name, $georef_id, $customer_id) {
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
	}
}