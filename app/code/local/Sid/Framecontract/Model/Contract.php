<?php

class Sid_Framecontract_Model_Contract extends Mage_Core_Model_Abstract
{
	private $_vendor = null;
	
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
    
    
    public function alterLosStatus($status)
    {
    	$collection = Mage::getModel('framecontract/los')->getCollection();
    	$collection->getSelect()->where('framecontract_contract_id = '. intval($this->getId()));
    	
    	foreach($collection->getItems() as $los)
    	{
    		if($los->getStatus() != $status){
    			$los->setStatus($status)
    				->save();
    		}
    	}
    }
    
    
    public function getVendor()
    {
    	if($this->_vendor == null)
    	{
    		$this->_vendor = Mage::getModel('framecontract/vendor')->load($this->getFramecontractVendorId());
    	}
    	
    	return $this->_vendor;
    }
    
    /**
     * ermitteln aller ProduktId's die mit diesem Los verbunden sind
     */
    public function getProductIds()
    {
    	return $this->getResource()->getProductIds($this);
    }
    

    
}