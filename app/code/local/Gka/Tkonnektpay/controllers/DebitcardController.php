<?php
/**
 * Debitkarten Controller
 *
 * @category   	Gka
 * @package    	Gka_Tkonnektpay
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Gka_Tkonnektpay_DebitcardController extends Egovs_Paymentbase_Controller_Tkonnekt_Abstract
{
	/**
	 * Implementation der abstrakten Methode
	 * 
	 * @param Mage_Sales_Model_Order $order Bestellinstanz
	 * 
	 * @return void
	 * 
	 * @see Egovs_Paymentbase_Controller_Abstract::_redirectActionAddStatusToHistory($order)
	 */
	protected function _redirectActionAddStatusToHistory($order) {
		
	}
	/**
	 * Implementation der abstrakten Methode
	 * 
	 * @return void
	 * 
	 * @see Egovs_Paymentbase_Controller_Abstract::_successActionRedirectFailure()
	 */
	protected function _successActionRedirectFailure() {
		Mage::getSingleton('core/session')->addError(Mage::helper($this->_getModuleName())->__('Payment with Debitcard failed'));
		$this->_redirect('checkout/cart', array('_secure' => true));
	}
	/**
	 * Gibt den Modulnamen zurück
	 * 
	 * Implementation der abstrakten Methode
	 * 
	 * @return string 'gka_tkonnektpay'
	 * 
	 * @see Egovs_Paymentbase_Controller_Abstract::_getModuleName()
	 */
	protected function _getModuleName() {
		return "gka_tkonnektpay";
	}

	/**
	 * Liefert Debug-Flag
	 *
	 * @return boolean
	 */
	public function getDebug() {
		return Mage::getStoreConfigFlag('payment/gka_tkonnektpay_debitcard/debug_flag');
	}
}