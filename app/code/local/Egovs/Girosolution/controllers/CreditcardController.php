<?php
/**
 * Kreditkarten Controller
 *
 * @category   	Egovs
 * @package    	Egovs_Girosolution
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Girosolution_CreditcardController extends Egovs_Paymentbase_Controller_Abstract
{
	/**
	 * Redirect Block Type
	 *
	 * @var string
	 */
	protected $_redirectBlockType = 'egovs_girosolution/redirect';
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
		Mage::getSingleton('core/session')->addError(Mage::helper($this->_getModuleName())->__('Payment with Creditcard failed'));
		$this->_redirect('checkout/cart', array('_secure' => true));
	}
	/**
	 * Gibt den Modulnamen zurück
	 * 
	 * Implementation der abstrakten Methode
	 * 
	 * @return string 'egovs_girosolution'
	 * 
	 * @see Egovs_Paymentbase_Controller_Abstract::_getModuleName()
	 */
	protected function _getModuleName() {
		return "egovs_girosolution";
	}

	/**
	 * Liefert Debug-Flag
	 *
	 * @return string
	 */
	public function getDebug() {
		return Mage::getStoreConfig('payment/egovs_girosolution_creditcard/debug_flag');
	}
}