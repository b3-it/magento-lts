<?php
/**
 * Prüft ob ePayBL erreicht werden kann.
 *
 * @category   	Egovs
 * @package    	Egovs_SepaDebitSax
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright  	Copyright (c) 2014 B3 IT Service GmbH - http://www.b3-it.de
 * @license    	http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_SepaDebitSax_Model_System_Config_Backend_Alive extends Mage_Core_Model_Config_Data
{
	/**
	 * Prüft ob ePayBL erreicht werden kann
	 * 
	 * @return Egovs_SepaDebitSax_Model_System_Config_Backend_Alive
	 * 
	 * @see Mage_Core_Model_Abstract::_beforeSave()
	 */
    protected function _beforeSave() {
        $value = $this->getValue();

        if ($value == true) {
        	try {
        		//Bei Zertifikatfehlern gibt PHP Soap die Meldung als Warning aus.
        		//der SoapClient setzt das error_reporting jedoch immer auf 0 -> siehe mageCoreErrorHandler!
        		set_error_handler(array(Mage::helper('paymentbase'), 'epayblErrorHandler'));
        		Mage::helper('sepadebitsax')->isZmvAlive();        		
        		Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('paymentbase')->__('The mandate management server is alive.'));
        	} catch (Egovs_SepaDebitSax_Model_SepaMvException $zmve) {
                Mage::getSingleton('adminhtml/session')->addNotice(Mage::helper('paymentbase')->__($zmve->getMessage()));
            } catch (Exception $e) {
        		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('paymentbase')->__('The mandate management server is not available, check log files for further information.'));
        	}
        	restore_error_handler();
        }         

        //Am Ende muss es immer deaktiviert sein
        $this->setValue(false);
        return $this;
    }
}