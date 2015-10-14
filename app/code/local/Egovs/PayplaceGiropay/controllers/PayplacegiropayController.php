<?php
/**
 * Payplace Giropay Controller
 *
 * @category   	Egovs
 * @package    	Egovs_PayplaceGiropay
 * @name       	Egovs_PayplaceGiropay_PayplacegiropayController
 * @author		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright	Copyright (c) 2014 B3 IT Systeme GmbH
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_PayplaceGiropay_PayplacegiropayController extends Egovs_Paymentbase_Controller_Payplace_Abstract
{
	
	/**
	 * Redirect Block Type
	 *
	 * @var string
	 */
	protected $_redirectBlockType = 'payplacegiropay/redirect';
	
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
		$order->addStatusToHistory(Mage_Sales_Model_Order::STATE_PENDING_PAYMENT, Mage::helper('payplacegiropay')->__('Customer was redirected to Payplace.'));
	}
	/**
	 * Implementation der abstrakten Methode
	 * 
	 * @return void
	 * 
	 * @see Egovs_Paymentbase_Controller_Abstract::_successActionRedirectFailure()
	 */
	protected function _successActionRedirectFailure() {
		// something is wrong -> redirect to failure controller
		$this->_redirect('payplacegiropay/payplacegiropay/failure', array('_secure'=>$this->isSecureUrl()));
	}
	/**
	 * Zeigt den Warenkorb an falls Saferpay mit eiem Fehler antwortet
	 * 
	 * @return void
	 */
	public function failureAction() {
		$this->_cancel('payplacegiropay','There was an error at Payplace Payment. Customers payment was not valid.');
	}

	/**
	 * Zeigt den Warenkorb an falls der Benutzer den Zahlvorgang abbricht
	 * 
	 * @return void
	 */
	public function cancelAction() {
		$this->_cancel('payplacegiropay', 'Customer canceled Payplace payment or an error occured.');
	}
}