<?php
/**
 * Synchronisiert die Bankverbidnung des Bewirtschafters der ePayBL mit den Daten des Impressums.
 *
 * @category   	Egovs
 * @package    	Egovs_Paymentbase
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 IT Systeme GmbH - http://www.b3-it.de 
 * @license    	http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Model_System_Config_Backend_SyncBankAccountData extends Egovs_Paymentbase_Model_System_Config_Backend_Abstract_Data
{
	/**
	 * Synchronisiert die Bankverbidnung des Bewirtschafters der ePayBL mit den Daten des Impressums.
	 * 
	 * @return Egovs_Paymentbase_Model_System_Config_Backend_SyncBankAccountData
	 * 
	 * @see Mage_Core_Model_Abstract::_beforeSave()
	 */
    protected function _beforeSave() {
    	parent::_beforeSave();
    	
        $value = $this->getValue();

        if ($value == true) {
        	if ($this->getField() == 'auto_sync_epaybl_data_now') {
        		$_autoSync = Mage::getStoreConfigFlag('payment_services/paymentbase/auto_sync_epaybl_data');
        	} else {
        		if (Mage::getStoreConfigFlag('payment_services/paymentbase/auto_sync_epaybl_data') == (bool) $value) {
        			return $this;
        		}
        		$_autoSync = Mage::getStoreConfigFlag('payment_services/paymentbase/auto_sync_epaybl_data') != (bool) $value ? true : false;
        	}
        	
        	if (!$_autoSync) {
        		Mage::getSingleton('adminhtml/session')->addNotice(
        			Mage::helper('paymentbase')->__('Bank account data synchronization with ePayBL is not enabled. Please enable it under Payments/ePayBL Settings')
        		);
        	} else {
	        	try {
	        		//Bei Zertifikatfehlern gibt PHP Soap die Meldung als Warning aus.
	        		//der SoapClient setzt das error_reporting jedoch immer auf 0 -> siehe mageCoreErrorHandler!
	        		set_error_handler(array(Mage::helper('paymentbase'), 'epayblErrorHandler'));
	        		Mage::helper('paymentbase/sync_bankAccountData')->sync();
	        		Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('paymentbase')->__('Bank account data synchronized with ePayBL Server'));
	        	} catch (Exception $e) {
	        		Mage::logException($e);
	        		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('paymentbase')->__('The ePayBL Server is not available, check log files for further information.'));
	        	}
	        	restore_error_handler();
        	}
        }         
		
        if ($this->getField() == 'auto_sync_epaybl_data') {
	        //Am Ende muss es immer deaktiviert sein
	        $this->setValue(false);
        }
        return $this;
    }
}
