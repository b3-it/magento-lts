<?php

class Slpb_Extstock_Model_Mysql4_Stock_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{

	public function _construct()
	{
		parent::_construct();
		$this->_init('extstock/stock');
	}

	public function asOptionsArray()
	{
		$res = array();
		foreach($this->getItems() as $item)
		{
			$res[$item->getId()] = $item->getName();	
		}
		return $res;
	}

}