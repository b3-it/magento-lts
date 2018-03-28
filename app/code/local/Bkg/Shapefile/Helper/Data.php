<?php

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
	        //var_dump($record['dbf']);
	    }
	    //var_dump($shape);
	    
	    $m = Mage::getModel('bkg_shapefile/file');
	    $m->setData('customer_id', $customer_id);
	    $m->setData('georef_id', $georef_id);
	    $m->setData('name', $name);
	    $m->save();
	    foreach ($shapes as $shape){
	        $s = Mage::getModel('bkg_shapefile/shape');
	        $s->setData('file_id', $m->getId());
	        $s->setWkt($shape);
	        $s->save();
	    }
	}
}