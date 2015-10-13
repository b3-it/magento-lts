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
}