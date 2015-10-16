<?php

/**
 * Infoblock für SEPA Laschriftzahlungen
 *
 * Setzt eigene Templates
 *
 * @category   	Egovs
 * @package    	Egovs_SepaDebitSax
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright  	Copyright (c) 2013 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright	Copyright (c) 2015 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 * @see Mage_Payment_Block_Info
 */
class Egovs_SepaDebitSax_Block_Info extends Mage_Payment_Block_Info
{
	protected $_mask = true;
	
	protected $_mandate = null;
	
	protected $_invalidMandate = false;
	
	/**
	 * Setzt ein eigenes Template
	 * 
	 * @return void
	 * 
	 * @see Mage_Payment_Block_Info::_construct()
	 */
	protected function _construct() {
		parent::_construct();
		$this->setTemplate('egovs/debit/sepa_sax/sepa_info.phtml');
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
	 * gibt das Mandate zurück
	 */
	public function getMandate()
	{
		if (($this->_mandate == null) && (! $this->_invalidMandate)) {
			
			$ref = $this->getMethod ()->getInfoInstance ()->getData ( Egovs_Paymentbase_Helper_Data::ATTRIBUTE_SEPA_MANDATE_ID );
			if ($ref) {
				$this->_mandate = $this->getMethod ()->readMandate ( $ref );
				if ($this->_mandate == null) {
					$this->_invalidMandate = true;
				}
			}
		}
		
		return $this->_mandate;
	}
	
	public function getAccountholderStreet() {
		$mandate = $this->getMandate();
		if ($mandate) {
			return $mandate->getAccountholderAddress ()->getStrasse ();
		}
		
		return "";
	}
	
	public function getAccountholderFirstName() {
		/* @var $mandate Egovs_SepaDebitSax_Model_Sepa_Mandate */
		$mandate = $this->getMandate();
		if ($mandate) {
			return $mandate->getAccountholderName ();
		}
	
		return "";
	}
	
	public function getAccountholderSurname() {
		/* @var $mandate Egovs_SepaDebitSax_Model_Sepa_Mandate */
		$mandate = $this->getMandate();
		if ($mandate) {
			return $mandate->getAccountholderSurname ();
		}
	
		return "";
	}
	
	
	public function getAccountholderCity() {
		/* @var $mandate Egovs_SepaDebitSax_Model_Sepa_Mandate */
		$mandate = $this->getMandate();
		if ($mandate) {
			return $mandate->getAccountholderAddress ()->getCity ();
		}
	
		return "";
	}
	
	public function getAccountholderZip() {
		/* @var $mandate Egovs_SepaDebitSax_Model_Sepa_Mandate */
		$mandate = $this->getMandate();
		if ($mandate) {
			return $mandate->getAccountholderAddress ()->getZip ();
		}
	
		return "";
	}
	
	public function getAccountholderCountry() {
		/* @var $mandate Egovs_SepaDebitSax_Model_Sepa_Mandate */
		$mandate = $this->getMandate();
		if ($mandate) {
			return $mandate->getAccountholderAddress ()->getCountry ();
		}
	
		return "";
	}
	
	public function getAccountholderPostofficeBox() {
		/* @var $mandate Egovs_SepaDebitSax_Model_Sepa_Mandate */
		$mandate = $this->getMandate();
		if ($mandate) {
			return $mandate->getAccountholderAddress ()->getPostofficeBox ();
		}
	
		return "";
	}
	
	
	public function getAccountholderDiffers() {
		/* @var $mandate Egovs_SepaDebitSax_Model_Sepa_Mandate */
		$mandate = $this->getMandate();
		if ($mandate) {
			return $mandate->getAccountholderDiffers ();
		}
	
		return "";
	}
	
	
	public function getDebitorFirstName() {
		/* @var $mandate Egovs_SepaDebitSax_Model_Sepa_Mandate */
		$mandate = $this->getMandate();
		if ($mandate) {
			return $mandate->getDebitorName ();
		}
	
		return "";
	}
	
	public function getDebitorSurName() {
		/* @var $mandate Egovs_SepaDebitSax_Model_Sepa_Mandate */
		$mandate = $this->getMandate();
		if ($mandate) {
			return $mandate->getDebitorSurname ();
		}
	
		return "";
	}
	
	
	public function getDebitorStreet() {
		/* @var $mandate Egovs_SepaDebitSax_Model_Sepa_Mandate */
		$mandate = $this->getMandate();
		if ($mandate) {
			//return $mandate->getDebitorAddress()->getStrasse();
			return $mandate->getDebitorAddress()->Strasse;
		}
	
		return "";
	}
	
	public function getDebitorCity() {
		/* @var $mandate Egovs_SepaDebitSax_Model_Sepa_Mandate */
		$mandate = $this->getMandate();
		if ($mandate) {
			// return $mandate->getDebitorAddress()->getCity();
			return $mandate->getDebitorAddress ()->Stadt;
		}
	
		return "";
	}
	
	public function getDebitorZip() {
		/* @var $mandate Egovs_SepaDebitSax_Model_Sepa_Mandate */
		$mandate = $this->getMandate();
		if ($mandate) {
			// return $mandate->getDebitorAddress()->getZip();
			return $mandate->getDebitorAddress ()->Plz;
		}
	
		return "";
	}
	
	public function getDebitorCountry() {
		/* @var $mandate Egovs_SepaDebitSax_Model_Sepa_Mandate */
		$mandate = $this->getMandate();
		if ($mandate) {
			// return $mandate->getDebitorAddress()->getCountry();
			return $mandate->getDebitorAddress ()->Land;
		}
	
		return "";
	}
	
	public function getDebitorPostofficeBox() {
		/* @var $mandate Egovs_SepaDebitSax_Model_Sepa_Mandate */
		$mandate = $this->getMandate();
		if ($mandate) {
			// return $mandate->getDebitorAddress()->getPostofficeBox();
			return $mandate->getDebitorAddress ()->Postfach;
		}
	
		return "";
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
				
			return Mage::helper('adminhtml')->getUrl('adminhtml/sepadebitsax_mandate/link', array('_secure' => true, 'method' => $this->getMethod()->getCode(), 'id' => $customerId, 'mandateid' => $mandateRef, 'rkey' => md5($this->getIban().now())));
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
	
	
		return $this->getUrl('sepadebitsax/mandate/link',$param);
	}
	
	
	public function getMandateReference() {
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
			
	
			return $mandateRef;
		}
		return false;
	}
	
	public function getMaturity() {
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
		
		$date = $order->getPayment()->getMaturity(); 
		$date = Mage::app()->getLocale()->date(strtotime($date), null, null,true);
		$format = Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM);
		$date = $date->toString($format);
		
		return $date;
	}
	
}
