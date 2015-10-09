<?php
/**
 * Payplace Paypage Controller
 *
 * @category   	Egovs
 * @package    	Egovs_PayplacePaypage
 * @name       	Egovs_PayplacePaypage_PayplacePaypageController
 * @author		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright	Copyright (c) 2014 B3 IT Systeme GmbH
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_PayplacePaypage_PayplacepaypageController extends Egovs_Paymentbase_Controller_Payplace_Abstract
{
	
	/**
	 * Redirect Block Type
	 *
	 * @var string
	 */
	protected $_redirectBlockType = 'payplacepaypage/redirect';
	
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
		$order->addStatusToHistory(Mage_Sales_Model_Order::STATE_PENDING_PAYMENT, Mage::helper('payplacepaypage')->__('Customer was redirected to Payplace.'));
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
		$this->_redirect('payplacepaypage/payplacepaypage/failure', array('_secure'=>$this->isSecureUrl()));
	}
	/**
	 * Zeigt den Warenkorb an falls Saferpay mit eiem Fehler antwortet
	 * 
	 * @return void
	 */
	public function failureAction() {
		$this->_cancel('payplacepaypage','There was an error at Payplace Payment. Customers payment was not valid.');
	}

	/**
	 * Zeigt den Warenkorb an falls der Benutzer den Zahlvorgang abbricht
	 * 
	 * @return void
	 */
	public function cancelAction() {
		$this->_cancel('payplacepaypage', 'Customer canceled Payplace payment or an error occured.');
	}
}