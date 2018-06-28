<?php
/**
 * Prüft ob TKonnekt erreicht werden kann.
 *
 * @category   	Gka
 * @package    	Gka_Tkonnektpay
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license    	http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Gka_Tkonnektpay_Model_Adminhtml_System_Config_Backend_Alive extends Mage_Core_Model_Config_Data
{
	/**
	 * Prüft ob ePayBL erreicht werden kann
	 * 
	 * @return Gka_Tkonnektpay_Model_Adminhtml_System_Config_Backend_Alive
	 * 
	 * @see Mage_Core_Model_Abstract::_beforeSave()
	 */
    protected function _beforeSave() {
    	parent::_beforeSave();
    	
        $value = $this->getValue();

        if ($value == true) {
        	try {
        		//Bei Zertifikatfehlern gibt PHP Soap die Meldung als Warning aus.
        		//der SoapClient setzt das error_reporting jedoch immer auf 0 -> siehe mageCoreErrorHandler!
        		set_error_handler(array(Mage::helper('paymentbase'), 'epayblErrorHandler'));
        		Mage::helper('gka_tkonnektpay')->isAlive();
        		Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('paymentbase')->__('The TKonnekt Server is alive.'));
        	} catch (Exception $e) {
        		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('paymentbase')->__('The TKonnekt Server is not available, check log files for further information. Message: %s', $e->getMessage()));
        	}
        	restore_error_handler();
        }         

        //Am Ende muss es immer deaktiviert sein
        $this->setValue(false);
        return $this;
    }
}