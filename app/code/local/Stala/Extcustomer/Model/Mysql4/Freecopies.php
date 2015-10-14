<?php
class Stala_Extcustomer_Model_Mysql4_Freecopies extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the extcustomer_sales_discount_id refers to the key field in your database table.
        $this->_init('extcustomer/freecopies', 'extcustomer_freecopies_id');
    }
    
    /**
     * Lädt das Freiexemplar mit der Produkt- und Kunden-ID aus der Datenbank
     * 
     * Produkt- & Kunden-ID bilden zusammen einen eindeutigen Schlüssel.<br>
     * Es ist möglich die Hauptkunden mit zu berücksichtigen.
     * 
     * 
     * @param Stala_Extcustomer_Model_Freecopies $freecopies
     * @param int $product_id
     * @param int $customer_id
     * @param boolean $withRelations Hauptkunden berücksichtigen?
     * @return Stala_Extcustomer_Model_Mysql4_Freecopies
     */
    public function loadByProductCustomerId(
    	Stala_Extcustomer_Model_Freecopies $freecopies,
    	$product_id,
    	$customer_id,
    	$withRelations = false
    ) {
    	if (is_numeric($customer_id)) {
    		$customer = Mage::getModel('customer/customer')->load($customer_id);
    	} elseif ($customer_id instanceof Mage_Customer_Model_Customer) {
    		$customer = $customer_id;
    	} else {
    		Mage::throwException('Customer must be ID or type of Mage_Customer_Model_Customer.');
    	}
    	
    	if (!($customer instanceof Mage_Customer_Model_Customer)) {
    		return $this;
    	}
    	
    	do {
	    	$select = $this->_getReadAdapter()->select()
	            ->from($this->getMainTable(), array($this->getIdFieldName()))
	            ->where('product_id=:productId')
	            ->where('customer_id=:customerId')
	        ;
	        
	        if ($id = $this->_getReadAdapter()->fetchOne($select
	        			, array('productId'	=> $product_id, 'customerId' => $customer->getId())
	        	)) {
	            $this->load($freecopies, $id);
	        }
	        else {
	            $freecopies->setData(array());
	        }
	        
	        $customer = Mage::getModel('customer/customer')->load($customer->getParentCustomerId());
	        
    	} while ($withRelations && $freecopies->isEmpty() && !$customer->isEmpty() && $customer->getId() > 0);
        
        return $this;
    }
}