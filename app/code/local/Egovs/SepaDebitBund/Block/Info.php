<?php

/**
 * Infoblock für SEPA Laschriftzahlungen
 *
 * Setzt eigene Templates
 *
 * @category   	Egovs
 * @package    	Egovs_SepaDebitBund
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright  	Copyright (c) 2013 - 2016 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 * @see Mage_Payment_Block_Info
 */
class Egovs_SepaDebitBund_Block_Info extends Mage_Payment_Block_Info
{
	protected $_mask = true;
	
	/**
	 * Setzt ein eigenes Template
	 * 
	 * @return void
	 * 
	 * @see Mage_Payment_Block_Info::_construct()
	 */
	protected function _construct()
	{
		parent::_construct();
		$this->setTemplate('egovs/debit/sepa_info.phtml');
	}
	
	/**
	 * Liefert den Kontoinhaber
	 *
	 * @return string|boolean
	 */
	public function getAccountName() {
		if ($value = call_user_func(array($this->getMethod(), __FUNCTION__))) {
			return $value;
		}
		return false;
	}
	
	/**
	 * Liefert die IBAN
	 *
	 * @return string|boolean
	 */
	public function getIban() {
		if ($value = call_user_func(array($this->getMethod(), __FUNCTION__))) {
			return $this->_maskValue($value);
		}
		return false;
	}
	
	/**
	 * Liefert die BIC
	 *
	 * @return string|boolean
	 */
	public function getBic() {
		if ($value = call_user_func(array($this->getMethod(), __FUNCTION__))) {
			return $this->_maskValue($value);;
		}
		return false;
	}
	
	/**
	 * Liefert den Banknamen
	 *
	 * @return string|boolean
	 */
	public function getAccountBankname() {
		if ($value = call_user_func(array($this->getMethod(), __FUNCTION__))) {
			return $value;
		}
		return false;
	}
	
	/**
	 * Setzt ein eigenes Template
	 * 
	 * @return string
	 * 
	 * @see Mage_Payment_Block_Info::toPdf()
	 */
	public function toPdf() {
		$this->_mask = false;
		$this->setTemplate('egovs/debit/sepa_debit.phtml');
		$html = $this->toHtml();
		$this->_mask = true;
		return $html;
	}
	
	public function getMandateReference() {
		if ($value = $this->getMethod()->getInfoInstance()->getAdditionalInformation('mandate_reference')) {
			return $value;
		}
		return false;
	}

	protected function _maskValue($value) {
		if (!is_string($value) || !$this->_mask) {
			return $value;
		}
		 
		if (strlen($value) > 4) {
			$_visible = 4;
		} else {
			$_visible = 1;
		}
		$_aS = str_split($value);
		for ($i = 0; $i < strlen($value) - $_visible; $i++) {
			$_aS[$i] = '*';
		}
		$value = implode('', $_aS);
		return $value;
	}
	
	public function getMandateDownloadUrl() {
		if (Mage::app()->getStore()->isAdmin() || Mage::getDesign()->getArea() == 'adminhtml') {
			Mage::getSingleton('core/session', array('name'=>'adminhtml'));
			/* @var $order mage_Sales_Model_Order */
			$order = Mage::registry('current_order');
			if (!$order) {
				$invoice = Mage::registry('current_invoice');
				if (!$invoice) {
					return false;
				} else {
					$order = $invoice->getOrder();
				}
			}
			if (!$order) {
				return false;
			}
			$mandateRef = $order->getPayment()->getAdditionalInformation('mandate_reference');
			
			if (!$mandateRef) {
				return false;
			}
			$customerId = $order->getCustomerId();
			if (!$customerId) {
				return false;
			}
			
			return Mage::helper('adminhtml')->getUrl('adminhtml/paymentbase_mandate/link', array('_secure' => true, 'method' => $this->getMethod()->getCode(), 'id' => $customerId, 'reference' => $mandateRef, 'rkey' => md5($this->getIban().now())));			
		}
		//Der key ist nur für den Varnish-Cache da dieser die URL sonst Cached und man immer das selbe Mandat bekommt.
		//Das Mandat kann dann auch von einem völlig anderen Kunden stammen.
		if($order = Mage::registry('current_order'))
		{
			$param =  array('_secure' => true,'order_id' => $order->getId(), 'method' => $this->getMethod()->getCode(), 'rkey' => md5($this->getIban().now()));
		}
		else {
			$param =  array('_secure' => true, 'method' => $this->getMethod()->getCode(), 'rkey' => md5($this->getIban().now()));
		}
		
		
		return $this->getUrl('paymentbase/sepa_mandate/linkaccount',$param);
	}
}
