<?php

class Sid_Framecontract_Model_Contract extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('framecontract/contract');
    }
    
   	protected function _beforeDelete()
    {
    	//files müssen explized gelscht werden damit das dateisystem gesaubert wird
    	$collection = Mage::getModel('framecontract/files')->getCollection();
      	$collection->getSelect()->where('framecontract_contract_id='. intval($this->getId()));
    	
      	foreach ($collection->getItems() as $item)
      	{
      		$item->delete();
      	}
      	
    	
    	return parent::_beforeDelete();
    }
}