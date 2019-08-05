<?php

/**
 * Infoblock für Zahlungen per Vorkasse
 *
 * @category   	Egovs
 * @package    	Egovs_BankPayment
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright  	Copyright (c) 2011-2017 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license		http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 * @see Mage_Payment_Block_Info
 */
class Egovs_BankPayment_Block_Info extends Mage_Payment_Block_Info
{
	/**
	 * Überschreibt das Template
	 * 
	 * @return void
	 * 
	 * @see Mage_Payment_Block_Info::_construct()
	 */
    protected function _construct() {
        parent::_construct();
        $this->setTemplate('egovs/bankpayment/info.phtml');
    }
    
    /**
     * Liefert den Kontoinhaber
     * 
     * Wird in Template als erstes aufgerufen.
     * 
     * @return string|boolean
     */
    public function getAccountHolder() {
    	if ($value = call_user_func(array($this->getMethod(), __FUNCTION__))) {
    		return $value;
    	}
    	$value = trim(Mage::getStoreConfig('general/imprint/bank_account_owner'));
    	if (!empty($value)) {
    		return $value;
    	}
    	
    	return false;
    }
    
    /**
     * Liefert die Kontonummer
     *
     * @return string|boolean
     */
    public function getAccountNumber() {
    	if ($value = call_user_func(array($this->getMethod(), __FUNCTION__))) {
    		return $value;
    	}
    	
    	$value = trim(Mage::getStoreConfig('general/imprint/bank_account'));
    	if (!empty($value)) {
    		return $value;
    	}
    	
    	return false;
    }
    
    /**
     * Liefert die BLZ
     *
     * @return string|boolean
     */
    public function getSortCode() {
    	if ($value = call_user_func(array($this->getMethod(), __FUNCTION__))) {
    		return $value;
    	}
    	
    	$value = trim(Mage::getStoreConfig('general/imprint/bank_code_number'));
    	if (!empty($value)) {
    		return $value;
    	}
    	return false;
    }
    
    /**
     * Liefert den Banknamen
     *
     * @return string|boolean
     */
    public function getBankName() {
    	if ($value = call_user_func(array($this->getMethod(), __FUNCTION__))) {
    		return $value;
    	}
    	
    	$value = trim(Mage::getStoreConfig('general/imprint/bank_name'));
    	if (!empty($value)) {
    		return $value;
    	}
    	return false;
    }
    
    /**
     * Liefert die IBAN
     *
     * @return string|boolean
     */
    public function getIBAN() {
    	if ($value = call_user_func(array($this->getMethod(), __FUNCTION__))) {
    		return $value;
    	}
    	
    	$value = trim(Mage::getStoreConfig('general/imprint/iban'));
    	if (!empty($value)) {
    		return $value;
    	}
    	return false;
    }
    
    /**
     * Liefert die BIC
     *
     * @return string|boolean
     */
    public function getBIC() {
    	if ($value = call_user_func(array($this->getMethod(), __FUNCTION__))) {
    		return $value;
    	}
    	$value = trim(Mage::getStoreConfig('general/imprint/swift'));
    	if (!empty($value)) {
    		return $value;
    	}
    	return false;
    }
    
    public function showBankDetails() {
    	if (!$this->getMethod() || !method_exists($this->getMethod(), __FUNCTION__)) {
    		return true;
    	}
    	
    	return call_user_func(array($this->getMethod(), __FUNCTION__));
    }

    /**
     * Retrieve payment method model
     *
     * @return Mage_Payment_Model_Method_Abstract
     */
    public function getMethod()
    {
        try {
            return $this->getInfo()->getMethodInstance();
        } catch (Exception $e) {

        }
        return Mage::getModel('bankpayment/bankpayment');
    }
}
