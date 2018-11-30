<?php
/**
 * Führt den AutoFileAssignment Dienst sofort aus.
 *
 * @category   	Dwd
 * @package    	Dwd_AutoFileAssignment
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2012 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2012 TRW-NET - http://www.trw-net.de 
 * @license    	http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_AutoFileAssignment_Model_Adminhtml_System_Config_Backend_Runnow extends Mage_Core_Model_Config_Data
{
	/**
	 * Führt den AFA bei true aus
	 * 
	 * @return Dwd_AutoFileAssignment_Model_Adminhtml_System_Config_Backend_Runnow
	 * 
	 * @see Mage_Core_Model_Abstract::_beforeSave()
	 */
    protected function _beforeSave() {
        $value = $this->getValue();

        if ($value == true) {
        	switch ($this->getField()) {
        		case 'run_now':
		        	try {
		        		Mage::helper('dwdafa')->runAfa();
		        		Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('dwdafa')->__('AFA service started'));
		        	} catch (Dwd_AutoFileAssignment_Exception $dafae) {
		        		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('dwdafa')->__($dafae->getMessage()));
		        	} catch (Exception $e) {
		        		Mage::logException($e);
		        		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('dwdafa')->__('There was an runtime error for the AFA service. Please check your log files.'));
		        	}
		        	break;
        		case 'run_clean_expired':
        			try {
        				Mage::helper('dwdafa')->cleanExpiredDynamicLinks();
        				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('dwdafa')->__('Cleaned up expired links'));
        			} catch (Exception $e) {
        				Mage::logException($e);
        				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('dwdafa')->__('There was an runtime error for the AFA service. Please check your log files.'));
        			}
        			break;
        		case 'run_unlock':
        			try {
        				if (Mage::helper('dwdafa')->unlock()) {
        					Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('dwdafa')->__('Unlocked AFA'));
        				} else {
        					Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('dwdafa')->__("AFA wasn't locked"));
        				}
        			} catch (Exception $e) {
        				Mage::logException($e);
        				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('dwdafa')->__("Can't unlock the afa. Please check your log files."));
        			}
        			break;
        	}
        }

        //Am Ende muss es immer deaktiviert sein
        $this->setValue(false);
        return $this;
    }
}
