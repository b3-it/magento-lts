<?php

class Egovs_Informationservice_Model_Requestmasterproduct extends Mage_Core_Model_Abstract
{
	public function getMasterProductsAsOptionArray()
	{
		$collection = Mage::getModel('catalog/product')->getCollection();
		$collection->addAttributeToSelect('name')
				   ->addAttributeToFilter('infoservice_is_master_product','1');
		$res = array();
		foreach($collection->getItems() as $item)
		{
			$res[$item->getId()] = $item->getName();
		}
		//die($collection->getSelect()->__toString());
		return $res;
	}
    
}