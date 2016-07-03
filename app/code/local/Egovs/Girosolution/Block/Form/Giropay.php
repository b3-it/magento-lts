<?php
/**
 * Formblock für Giropay
 *
 * @category   	Egovs
 * @package    	Egovs_Girosolution
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Girosolution_Block_Form_Giropay extends Mage_Payment_Block_Form
{
	/**
	 * Konstruktor
	 *
	 * @return void
	 *
	 * @see Mage_Core_Block_Abstract::_construct()
	 */
	protected function _construct() {

		parent::_construct();
		
		$this->setTemplate('egovs/girosolution/giropay_form.phtml');
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