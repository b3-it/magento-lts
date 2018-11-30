<?php
/**
 * Prüft ob ePayBL erreicht werden kann.
 *
 * @category   	Egovs
 * @package    	Egovs_Paymentbase
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2012 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2012 TRW-NET - http://www.trw-net.de 
 * @license    	http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Model_System_Config_Backend_Alive extends Mage_Core_Model_Config_Data
{
	/**
	 * Prüft ob ePayBL erreicht werden kann
	 * 
	 * @return Egovs_Paymentbase_Model_System_Config_Backend_Alive
	 * 
	 * @see Mage_Core_Model_Abstract::_beforeSave()
	 */
    protected function _beforeSave() {
    	parent::_beforeSave();
    	
        $value = $this->getValue();

        if ($value == true) {
        	if ($this->getScope() == 'websites') {
        		$scopeId = $this->getScopeId();
        		$storeId = Mage::app()->getWebsite($scopeId)->getDefaultStore()->getId();
        		// Start store emulation process
        		$appEmulation = Mage::getSingleton('core/app_emulation');
        		$initialEnvironmentInfo = $appEmulation->startEnvironmentEmulation($storeId);
        	}
        	
        	try {
        		//Bei Zertifikatfehlern gibt PHP Soap die Meldung als Warning aus.
        		//der SoapClient setzt das error_reporting jedoch immer auf 0 -> siehe mageCoreErrorHandler!
        		set_error_handler(array(Mage::helper('paymentbase'), 'epayblErrorHandler'));
        		Mage::helper('paymentbase')->isAlive();
        		Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('paymentbase')->__('The ePayBL Server is alive.'));
        	} catch (Exception $e) {
        		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('paymentbase')->__('The ePayBL Server is not available, check log files for further information.'));
        	}
        	restore_error_handler();
        	if (isset($appEmulation)) {
        		// Stop store emulation process
        		$appEmulation->stopEnvironmentEmulation($initialEnvironmentInfo);
        	}
        }

        //Am Ende muss es immer deaktiviert sein
        $this->setValue(false);
        return $this;
    }
}