<?php

class Dwd_Periode_Model_Mysql4_Periode extends Mage_Core_Model_Mysql4_Abstract
{
	
	/**
	 * Store id
	 *
	 * @var int
	 */
	protected $_storeId                  = 0;
	
	
    public function _construct()
    {    
        // Note that the periode_periode_id refers to the key field in your database table.
        $this->_init('periode/periode', 'entity_id');
    }
    
    /**
     * Set store Id
     *
     * @param integer $storeId
     * @return Mage_Catalog_Model_Resource_Category
     */
    public function setStoreId($storeId)
    {
    	$this->_storeId = $storeId;
    	return $this;
    }
    
    /**
     * Return store id
     *
     * @return integer
     */
    public function getStoreId()
    {
    	if ($this->_storeId === null) {
    		return Mage::app()->getStore()->getId();
    	}
    	return $this->_storeId;
    }
    
    
    /**
     * Perform actions after object load
     *
     * @param Varien_Object $object
     * @return Mage_Core_Model_Resource_Db_Abstract
     */
    protected function _afterLoad(Mage_Core_Model_Abstract $object)
    {
    	if(!$object->getStoreLabel()){
    		$label = Mage::getModel('periode/storelabel')->loadByPeriode($object->getId(), $this->getStoreId());
    		if($label->getId() > 0){
    			$object->setStoreLabel($label->getLabel());
    		}
    	}
    	return $this;
    }
    
}