<?php

class Egovs_Informationservice_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function getUsername($id)
	{
		$user =Mage::getModel('admin/user')->load($id);
		return $user->getFirstname()." " . $user->getLastname();
	}

	public function getUsernamesAsOptionArray()
	{
		$res = array();
		$collection = 	Mage::getModel('admin/user')->getCollection();
		foreach ($collection->getItems() as $user)
		{
			if($user->getIsActive())
			{
				$res[] = array('value'=>$user->getId(),'label'=>$user->getFirstname()." " . $user->getLastname());
			}
		}
		 
		return $res;
	}

	public function getUsernamesAsOptionValues()
	{
		$res = array();
		$collection = 	Mage::getModel('admin/user')->getCollection();
		foreach ($collection->getItems() as $user)
		{
			$res[$user->getId()] = $user->getFirstname()." " . $user->getLastname();
		}
		 
		return $res;
	}

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
			$pre .= "&nbsp;&nbsp;";
		}
		$array[] = array('value'=>$categories->getId(),'label'=>$pre .$categories->getName());
		$childs = $categories->getChildren();
		if ($childs == null) return;
		foreach ($childs->getNodes() as $cat) {
				
			$this->getCategoriesNode($cat,$array, $level + 1);
		}
	}
}