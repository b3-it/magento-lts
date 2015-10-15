<?php
/**
 * Backend Model für Objektnummern
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2012 - 2013 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Model_System_Config_Backend_Apikey
	extends Mage_Adminhtml_Model_System_Config_Backend_Encrypted
{
	/**
	 * Encrypt value before saving
	 *
	 */
	protected function _beforeSave() {
		
		$user = $this->getFieldsetDataValue('api_user');
		$value = (string)$this->getValue();
		
		// don't change value, if an obscured value came
		if (preg_match('/^\*+$/', $value)) {
			$value = $this->getOldValue();
		}
		
		if ($this->getOldValue() != $value && $user && !empty($value)) {
			$user = Mage::getModel('api/user')->load($user);

			if (!Mage::helper('core')->validateHash($value, $user->getApiKey())) {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('paymentbase')->__('Invalid Password for Api User '). $user->getName());
				$this->setValue(Mage::helper('core')->encrypt($this->getOldValue()));
				return;
			}
		}
		
		if (!empty($value) && ($encrypted = Mage::helper('core')->encrypt($value))) {
			$this->setValue($encrypted);
		}
	}
}
