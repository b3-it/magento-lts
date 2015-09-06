<?php

class Slpb_Extstock_Model_Mysql4_Extstock_Inwards_Collection extends Slpb_Extstock_Model_Mysql4_Extstock_Collection {
	
	protected $_storeId = null;

    public function setStore($store)
    {
        $this->setStoreId(Mage::app()->getStore($store)->getId());
        return $this;
    }

    public function setStoreId($storeId)
    {
        if ($storeId instanceof Mage_Core_Model_Store) {
            $storeId = $storeId->getId();
        }
        $this->_storeId = $storeId;
        return $this;
    }

    public function getStoreId()
    {
        if (is_null($this->_storeId)) {
            $this->setStoreId(Mage::app()->getStore()->getId());
        }
        return $this->_storeId;
    }

    public function getDefaultStoreId()
    {
        return Mage_Catalog_Model_Abstract::DEFAULT_STORE_ID;
    }
    
	protected function _joinFields($from = '', $to = '')
    {
        $this->getSelect()
         	->where("date_delivered >='".$from."' AND date_delivered <='".$to."'"); 
        return $this;
    }

    public function setDateRange($from, $to)
    {
        $this->_reset()
            ->_joinFields($from, $to);
        return $this;
    }
    
	/**
     * Set Store filter to collection
     *
     * @param array $storeIds
     * @return $this
     */
    public function setStoreIds($storeIds)
    {
        $storeId = array_pop($storeIds);
        $this->setStoreId($storeId);
        
        //TODO: Falls nötig Einbauen
        //$this->addStoreFilter($storeId);
        
        return $this;
    }
}