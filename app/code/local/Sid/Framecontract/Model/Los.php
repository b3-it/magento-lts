<?php

class Sid_Framecontract_Model_Los extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('framecontract/los');
    }
    
   	protected function xx_beforeDelete()
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
    
    protected function _afterSave(){
    	$old = $this->getOrigData('status');
    	$neu = $this->getData('status');
    	
    	if($old != $neu){
    		$productIds = $this->getProductIds();
    		$this->alterProductStatus($productIds, $neu);
    	}
    }
    
    
    public function getProductIds()
    {
    	return $this->getResource()->getProductIds($this);
    }
    
    
    /*
     * setzt den Status für Produkte mit den angegebenen Id's
     */
    public function alterProductStatus($productIds, $status)
    {
    	//status vom los auf produktstatus umschreiben - falls unterschiedlich
    	if ($status == Sid_Framecontract_Model_Status::STATUS_ENABLED){
    		$status = Mage_Catalog_Model_Product_Status::STATUS_ENABLED;
    	}
    	elseif ($status == Sid_Framecontract_Model_Status::STATUS_DISABLED){
    		$status = Mage_Catalog_Model_Product_Status::STATUS_DISABLED;
    	}
    	
    	//für alle Produkte setzen
    	if(count($productIds) > 0){
    		Mage::getSingleton('catalog/product_action')
    		->updateAttributes($productIds, array('status' => $status), 0);
    	}
    	
    }
}