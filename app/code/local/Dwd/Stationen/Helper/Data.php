<?php

class Dwd_Stationen_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function getCategoriesAsOptionArray()
	{
		$categories = Mage::getModel('catalog/category')->getCategories( Mage_Catalog_Model_Category::TREE_ROOT_ID);
		$res = array();
		foreach ($categories as $cat)
		{
			//$res[] = array('value'=>$cat->getId(),'label'=>$cat->getName());
			$this->getCategoriesNode($cat,$res, 0);
		}
		return $res;
	}


	public function getCategoriesAsOptionValueArray()
	{
		$categories = $this->getCategoriesAsOptionArray();
		$res = array();
		foreach ($categories as $cat)
		{
			$res[$cat['value']] = $cat['label'];
		}
		return $res;
	}


	public function getCategoriesNode($categories,&$array, $level)
	{
		$pre = "";
		for ($i =0; $i < $level; $i++) {
			$pre .= " - ";
		}
		$array[] = array('value'=>$categories->getId(),'label'=>$pre .$categories->getName());
		$childs = $categories->getChildren();
		if ($childs == null) return;
		foreach ($childs->getNodes() as $cat) {
				
			$this->getCategoriesNode($cat,$array, $level + 1);
		}
	}
	
	public function getStationsList(Mage_Catalog_Model_Product $product)
	{
	    $result = array();

	    $set_id = $product->getStationenSet();
        if( !$set_id) {$set_id = 0;}

        $storeId = $product->getStoreId();
        $collection = Mage::getModel('stationen/stationen')
        ->setStoreId($storeId)
        ->getCollection();
        $collection->setStoreId($storeId);
        $collection->addAttributeToSelect('*')->setOrder('name');
        $collection->getSelect()
        ->distinct()
        ->join(array('set'=>'stationen_set_relation'),'set.stationen_id = e.entity_id',array())
        ->where('set_id = ?', $set_id)
        ;
        $set = Mage::getModel('stationen/set')->load($set_id);

        if($set->getShowActiveOnly())
        {
            $collection->getSelect()
            ->where('status = ' . Dwd_Stationen_Model_Stationen_Status::STATUS_ACTIVE)
            ;
        }

        foreach ($collection->getItems() as $item)
        {
            $result[$item->getId()] = $item;
        }

	    return $result;
	}
	
	public function hasStationen(Mage_Catalog_Model_Product $product)
	{
	    return count($this->getStationsList($product)) > 0;
	}
	
	public function getStationenGeoJson(Mage_Catalog_Model_Product $product) {
	    $data = array(
	        "type" => "FeatureCollection",
	        "crs" => array(
	            "type" => "name",
	            "properties" => array(
	                "name" => "EPSG:4326"
	            )
	        )
	    );

	    $features = array();
	    foreach($this->getStationsList($product) as $station) {
	        $features[] = array(
	            "type" => "Feature",
	            "properties" => array(
	                "id" => intval($station->getId()),
	                "name" => $station->getName()
	            ),
	            "geometry" => array(
	                "type" => "Point",
	                "coordinates" => array(
	                    floatval($station->getLon()),
	                    floatval($station->getLat())
	                )
	            )
	        );
	    }
	    $data["features"] = $features;
	    return $data;
	}
}