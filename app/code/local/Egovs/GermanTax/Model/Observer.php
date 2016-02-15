<?php
/**
 * Observer für Tax-Erweiterung
 * 
 * - Omit Customer Messages
 *
 * @category	Egovs
 * @package		Egovs_GermanTax
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright	Copyright (c) 2016 B3 IT Systeme GmbH <www.b3-it.de> 
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_GermanTax_Model_Observer
{
	/**
	 * Retrieve customer session model object
	 *
	 * @return Mage_Customer_Model_Session
	 */
	protected function _getSession() {
		return Mage::getSingleton('customer/session');
	}
	
	/**
	 * Check whether VAT ID validation is enabled
	 *
	 * @param Mage_Core_Model_Store|string|int $store
	 * @return bool
	 */
	protected function _isVatValidationEnabled($store = null) {
		return  $this->_getHelper('customer/address')->isVatValidationEnabled($store);
	}
	
	/**
	 * Get Helper
	 *
	 * @param string $path
	 * @return Mage_Core_Helper_Abstract
	 */
	protected function _getHelper($path) {
		return Mage::helper($path);
	}
	
	/**
	 * Get Url method
	 *
	 * @param string $url
	 * @param array $params
	 * @return string
	 */
	protected function _getUrl($url, $params = array()) {
		return Mage::getUrl($url, $params);
	}
	
	/**
	 * GermanTax benötigt diese Meldung nicht!
	 * 
	 * @param Varien_Object $observer
	 * 
	 * @return void
	 * 
	 * @see Mage_Customer_AccountController::_welcomeCustomer
	 */
	public function onCoreSessionAbstractAddMessage($observer) {
		$messages = $this->_getSession()->getMessages();
		$last = $messages->getLastAddedMessage();
		
		if (!$last || $last->getType() != Mage_Core_Model_Message::SUCCESS || !$this->_isVatValidationEnabled()) {
			return;
		}
		
		
		// Show corresponding VAT message to customer
		$configAddressType =  $this->_getHelper('customer/address')->getTaxCalculationAddressType();
		$userPrompt = '';
		switch ($configAddressType) {
			case Mage_Customer_Model_Address_Abstract::TYPE_SHIPPING:
				$userPrompt = $this->_getHelper('customer')->__('If you are a registered VAT customer, please click <a href="%s">here</a> to enter you shipping address for proper VAT calculation',
					$this->_getUrl('customer/address/edit'));
				break;
			default:
				$userPrompt = $this->_getHelper('customer')->__('If you are a registered VAT customer, please click <a href="%s">here</a> to enter you billing address for proper VAT calculation',
					$this->_getUrl('customer/address/edit'));
		}
		
		if ($last->getText() == $userPrompt) {
			$messages->deleteMessageByIdentifier($last->getIdentifier());
		}
	}
}