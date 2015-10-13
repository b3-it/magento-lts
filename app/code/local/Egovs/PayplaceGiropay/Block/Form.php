<?php

/**
 * Formblock für Giropay Zahlungen per Payplace
 *
 * Setzt ein eigenes Template
 *
 * @category   	Egovs
 * @package    	Egovs_PayplaceGiropay
 * @name       	Egovs_PayplaceGiropay_Block_Redirect
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright  	Copyright (c) 2014 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 * @see Mage_Payment_Block_Form
 */
class Egovs_PayplaceGiropay_Block_Form extends Mage_Payment_Block_Form
{
	/**
	 * Setzt ein eigenes Template
	 * 
	 * @return void
	 * 
	 * @see Mage_Core_Block_Abstract::_construct()
	 */
	protected function _construct()
	{
		parent::_construct();
		$this->setTemplate('egovs/payplace/giropay_form.phtml');
	}
	
	public function getIsDebug() {
		return $this->getMethod()->getIsDebug();
	}
	
	public function getCustomer() {
		return Mage::getSingleton('customer/session')->getCustomer();
	}
	
	public function isCustomerLoggedIn() {
		return Mage::getSingleton('customer/session')->isLoggedIn();
	}
	
	public function getIban() {
		return null;
	}
	
	public function getBic() {
		return null;
	}
}
