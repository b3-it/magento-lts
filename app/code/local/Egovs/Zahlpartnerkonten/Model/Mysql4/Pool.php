<?php

class Egovs_Zahlpartnerkonten_Model_Mysql4_Pool extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct() {    
        // Note that the zahlpartnerkonten_pool_id refers to the key field in your database table.
        $this->_init('zpkonten/pool', 'zpkonten_pool_id');
    }
    
    /**
     * Load Pooleintrag by customer ID
     *
     * @param Egovs_Zahlpartnerkonten_Model_Pool $pool	   Pool
     * @param Mage_Customer_Model_Customer|int	 $customer Kunde
     * 
     * @throws Mage_Core_Exception
     * @return Mage_Customer_Model_Resource_Customer
     */
    public function loadByCustomer(Egovs_Zahlpartnerkonten_Model_Pool $pool, $customer) {
    	if ($customer instanceof Mage_Customer_Model_Customer) {
    		$customer = $customer->getId();
    	}
    	
    	if (!is_numeric($customer)) {
    		$pool->setData(array());
    		return $this;
    	}
    	
    	$adapter = $this->_getReadAdapter();
    	$bind    = array('customer' => $customer);
    	if (!$this->getIdFieldName()) {
    		$this->setIdFieldname($pool->getIdFieldName());
    	}
    	$select  = $adapter->select()
    		->from($this->getMainTable(), array($this->getIdFieldName()))
    		->where('customer_id = :customer and status = '.Egovs_Zahlpartnerkonten_Model_Status::STATUS_ZPKONTO)
    	;
    
    	$poolId = $adapter->fetchOne($select, $bind);
    	if ($poolId) {
    		$this->load($pool, $poolId);
    	} else {
    		$pool->setData(array());
    	}
    
    	return $this;
    }
    /**
     * Load Pooleintrag by Kassenzeichen, Mandant, Bewirtschafter
     *
     * @param Egovs_Zahlpartnerkonten_Model_Pool $pool	         Pool
     * @param string							 $kz             Kassenzeichen
     * @param string							 $mandant        Mandant
     * @param string							 $bewirtschafter Bewirtschafter
     *
     * @throws Mage_Core_Exception
     * @return Mage_Customer_Model_Resource_Customer
     */
    public function loadByKzMandantBewirtschafter(Egovs_Zahlpartnerkonten_Model_Pool $pool, $kz, $mandant, $bewirtschafter) {
    	if (!is_string($kz) || !is_string($mandant) || !is_string($bewirtschafter)) {
    		$pool->setData(array());
    		return $this;
    	}
    	
    	$adapter = $this->_getReadAdapter();
    	$bind    = array('kz' => $kz, 'mandant' => $mandant, 'bewirtschafter' => $bewirtschafter);
    	if (!$this->getIdFieldName()) {
    		$this->setIdFieldname($pool->getIdFieldName());
    	}
    	$select  = $adapter->select()
    		->from($this->getMainTable(), array($this->getIdFieldName()))
    		->where('kassenzeichen = :kz and mandant = :mandant and bewirtschafter = :bewirtschafter')
    	;
    	
    	$poolId = $adapter->fetchOne($select, $bind);
    	if ($poolId) {
    		$this->load($pool, $poolId);
    	} else {
    		$pool->setData(array());
    	}
    	
    	return $this;
    }
}