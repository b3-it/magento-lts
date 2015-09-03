<?php

class Slpb_Extstock_Model_Mysql4_Salesorder_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
	public function _construct()
	{
		parent::_construct();
		$this->_init('extstock/salesorder');
	}

	public function load($printQuery = false, $logQuery = false)
	{		
		parent::load($printQuery, $logQuery);
	}
}