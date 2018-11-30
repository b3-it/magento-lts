<?php

/**
 * Formblock für SEPA-Lastschriftzahlungen
 *
 * Setzt ein eigenes Template
 *
 * @category   	Egovs
 * @package    	Egovs_SepaDebitSax
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright  	Copyright (c) 2013 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright	Copyright (c) 2015 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 * @see Mage_Payment_Block_Form
 */
class Egovs_SepaDebitSax_Block_Form extends Mage_Payment_Block_Form
{
	
	protected $_mask = false;
	
	protected $_mandate = null;
	
	/**
	 * Setzt ein eigenes Template
	 * 
	 * @return void
	 * 
	 * @see Mage_Core_Block_Abstract::_construct()
	 */
	protected function _construct() {
		parent::_construct();
		$this->setTemplate('egovs/debit/sepa_sax/sepa_form.phtml');
	}
	
	public function getIsDebug() {
		return $this->getMethod()->getIsDebug();
	}
	
	public function getIsInternalManagement() {
		return $this->getMethod()->getIsInternalManagement();
	}
	
	public function getAgreementText() {
		return Mage::getStoreConfig('payment/sepadebitsax/agree_text');
	}
	
	public function getAddress() {
		$address = $this->getData('address');
		if (is_null($address)) {
			$address = Mage::getSingleton('checkout/session')->getQuote()->getBillingAddress();
			$this->setData('address', $address);
		}
		return $address;
	}
	
	public function getAddressesHtmlSelect()
	{
		if ($this->isCustomerLoggedIn()) {
			$options = array();
			$helper = Mage::helper('mpcheckout/Addressformat');
			foreach ($this->getCustomer()->getAddresses() as $address) {
				$options[] = array(
						'value'=>$address->getId(),
						'label'=>$helper->formatOneLine($address)
				);
			}
	
			$addressId = $this->getAddress()->getId();
			if (empty($addressId)) {
				$address = $this->getCustomer()->getPrimaryBillingAddress();
				
				if ($address) {
					$addressId = $address->getId();
				}
			}
	
			$select = $this->getLayout()->createBlock('core/html_select')
						->setName('payment[additional_information][address_id]')
						->setId('sepa-mandat-address-select')
						->setClass('address-select')
						//->setExtraParams('onchange="'.$type.'.newAddress(!this.value)"')
						->setValue($addressId)
						->setOptions($options)
			;
	
			// $select->addOption('', Mage::helper('checkout')->__('New Address'));
	
			return $select->getHtml();
		}
		
		$address = $this->getAddress();
		
		if (empty($address)) {
			return '';
		}
		$options[] = array(
				'value'=>$address->getId(),
				'label'=>$helper->formatOneLine($address)
		);
		$addressId = $address->getId();
		$select = $this->getLayout()->createBlock('core/html_select')
					->setName('payment[additional_information][address_id]')
					->setId('billing-address-select')
					->setClass('address-select required-entry')
					//->setExtraParams('onchange="'.$type.'.newAddress(!this.value)"')
					->setValue($addressId)
					->setOptions($options)
		;
		return $select->getHtml();
	}
	
	public function getMandateTypesHtmlSelect() {
		$options = array();
		$options[] = array(
				'value'=>Egovs_Paymentbase_Model_Webservice_Types_SepaMandat::TYPE_SDD_CORE_BASE,
				'label'=>$this->__('SEPA Basis')
		);
		$options[] = array(
				'value'=>Egovs_Paymentbase_Model_Webservice_Types_SepaMandat::TYPE_B2B_SDD,
				'label'=>$this->__('SEPA B2B')
		);
		
		$select = $this->getLayout()->createBlock('core/html_select')
			->setName('payment[additional_information][mandate_type]')
			->setId('mandate_type')
			->setClass('select required-entry')
			->setValue(Egovs_Paymentbase_Model_Webservice_Types_SepaMandat::TYPE_SDD_CORE_BASE)
			->setOptions($options)
		;
		return $select->getHtml();
	}
	
	public function getCountriesHtmlSelect($id = 'countries', $name = 'payment[additional_information][custom_accountholder_land]') {
		$options = Mage::getResourceModel('directory/country_collection')->loadByStore()->toOptionArray();
		
		$select = $this->getLayout()->createBlock('core/html_select')
			->setName($name)
			->setId($id)
			->setClass('select')
			->setValue('')
			->setOptions($options)
		;
		return $select->getHtml();
	}
	
	public function getCustomer() {
		return Mage::getSingleton('customer/session')->getCustomer();
	}
	
	public function isCustomerLoggedIn() {
		return Mage::getSingleton('customer/session')->isLoggedIn();
	}
	
	public function hasMandate() {
		$reference = $this->getCustomer()->getData(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_SEPA_MANDATE_ID);
		if (!$reference) {
			return false;
		}
	
		return true;
	}
	
	public function getMandateDownloadUrl() {
		return $this->getUrl('sepadebitsax/mandate/link', array('_secure' => true));
	}
	
	public function getAllowOneoff() {
		$this->getMandate(); //damit PaymentInfo ausgefüllt wird
		return $this->getMethod()->getAllowOneoff();
	}
	
	public function getIbanOnly() {
		return $this->getMethod()->getIbanOnly();
	}
	
	
	/**
	 * Liefert den Kontoinhaber
	 *
	 * @return string|boolean
	 */
	public function getAccountName() {
		$this->getMandate(); //damit PaymentInfo ausgefüllt wird
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
		$this->getMandate(); //damit PaymentInfo ausgefüllt wird
		
		if ($value = call_user_func(array($this->getMethod(), __FUNCTION__))) {
			return $value;// $this->_maskValue($value);
		}
		return false;
	}
	
	/**
	 * Liefert die BIC
	 *
	 * @return string|boolean
	 */
	public function getBic() {
		$this->getMandate(); //damit PaymentInfo ausgefüllt wird
		if (!$this->getIbanOnly() && ($value = call_user_func(array($this->getMethod(), __FUNCTION__)))) {
			return $value;//$this->_maskValue($value);;
		}
		return false;
	}
	
	/**
	 * Liefert den Banknamen
	 *
	 * @return string|boolean
	 */
	public function getAccountBankname() {
		$this->getMandate(); //damit PaymentInfo ausgefüllt wird
		if ($value = call_user_func(array($this->getMethod(), __FUNCTION__))) {
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
	
	
	/**
	 * gibt das Mandate zurück
	 */
	public function getMandate() {
		if ($this->_mandate == null)	{
				
			$ref = $this->getCustomer()->getData(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_SEPA_MANDATE_ID);
			if ($ref) {
			    $this->_mandate = $this->getMethod()->getMandate($ref);
			}
		}
	
		return $this->_mandate;
	}
	
	public function getAccountholderStreet()
	{
		$mandate = $this->getMandate();
		if($mandate)
		{
			return $mandate->getAccountholderAddress()->getStrasse();
		}
		
		return "";
	}
	
	public function getAccountholderFirstName()
	{
		/* @var $mandate Egovs_SepaDebitSax_Model_Sepa_Mandate */
		$mandate = $this->getMandate();
		if($mandate)
		{
			return $mandate->getAccountholderName();
		}
		
		//$adr = $this->getCustomer()->getDefaultBillingAddress();
		$adr = $this->getBillingAddress();
		if($adr)
		{
			return $adr->getFirstname();
		}
	
		return "";
	}
	
	public function getAccountholderSurname()
	{
		/* @var $mandate Egovs_SepaDebitSax_Model_Sepa_Mandate */
		$mandate = $this->getMandate();
		if($mandate)
		{
			return $mandate->getAccountholderSurname();
		}
	
	
		return "";
	}
	
	
	public function getAccountholderCity()
	{
		/* @var $mandate Egovs_SepaDebitSax_Model_Sepa_Mandate */
		$mandate = $this->getMandate();
		if($mandate)
		{
			return $mandate->getAccountholderAddress()->getCity();
		}
	
		
		
		
		return "";
	}
	
	public function getAccountholderZip()
	{
		/* @var $mandate Egovs_SepaDebitSax_Model_Sepa_Mandate */
		$mandate = $this->getMandate();
		if($mandate)
		{
			return $mandate->getAccountholderAddress()->getZip();
		}
	
		return "";
	}
	
	public function getAccountholderCountry()
	{
		/* @var $mandate Egovs_SepaDebitSax_Model_Sepa_Mandate */
		$mandate = $this->getMandate();
		if($mandate)
		{
			return $this->_parseIsoCountryCode($mandate->getAccountholderAddress()->getCountry());
		}
	
		return "";
	}
	
	protected function _parseIsoCountryCode($countryCode) {
		/* @var $item Mage_Directory_Model_Country */
		try {
			$item = Mage::getModel('directory/country')->loadByCode($countryCode);
			if (!$item->isEmpty()) {
				return $item->getName();
			}
		} catch (Exception $e) {
		}
		
		return $countryCode;
	}
	
	public function getAccountholderPostofficeBox()
	{
		/* @var $mandate Egovs_SepaDebitSax_Model_Sepa_Mandate */
		$mandate = $this->getMandate();
		if($mandate)
		{
			return $mandate->getAccountholderAddress()->getPostofficeBox();
		}
	
		return "";
	}
	
	
	public function getAccountholderDiffers()
	{
		/* @var $mandate Egovs_SepaDebitSax_Model_Sepa_Mandate */
		$mandate = $this->getMandate();
		if($mandate)
		{
			return $mandate->getAccountholderDiffers();
		}
	
		return "";
	}
	
	
	public function getDebitorFirstName()
	{
		/* @var $mandate Egovs_SepaDebitSax_Model_Sepa_Mandate */
		$mandate = $this->getMandate();
		if($mandate)
		{
			return $mandate->getDebitorName();
		}
		
		//$adr = $this->getCustomer()->getDefaultBillingAddress();
		$adr = $this->getBillingAddress();
		if($adr)
		{
			return $adr->getFirstname();
		}
	
		return "";
	}
	
	public function getDebitorSurName()
	{
		/* @var $mandate Egovs_SepaDebitSax_Model_Sepa_Mandate */
		$mandate = $this->getMandate();
		if($mandate)
		{
			return $mandate->getDebitorSurname();
		}
		//$adr = $this->getCustomer()->getDefaultBillingAddress();
		$adr = $this->getBillingAddress();
		if($adr)
		{
			return $adr->getLastname();
		}
	
		return "";
	}
	
	
	public function getDebitorStreet()
	{
		/* @var $mandate Egovs_SepaDebitSax_Model_Sepa_Mandate */
		$mandate = $this->getMandate();
		if($mandate)
		{
			return $mandate->getDebitorAddress()->getStrasse();
		}
	
		/* @var $adr  Mage_Customer_Model_Address */
		//$adr = $this->getCustomer()->getDefaultBillingAddress();
		$adr = $this->getBillingAddress();
		if($adr)
		{
			return $adr->getStreetFull();
		}
		
		return "";
	}
	
	public function getDebitorCity()
	{
		/* @var $mandate Egovs_SepaDebitSax_Model_Sepa_Mandate */
		$mandate = $this->getMandate();
		if($mandate)
		{
			return $mandate->getDebitorAddress()->getCity();
		}
	
		//$adr = $this->getCustomer()->getDefaultBillingAddress();
		$adr = $this->getBillingAddress();
		if($adr)
		{
			return $adr->getCity();
		}
		return "";
	}
	
	public function getDebitorZip()
	{
		/* @var $mandate Egovs_SepaDebitSax_Model_Sepa_Mandate */
		$mandate = $this->getMandate();
		if($mandate)
		{
			return $mandate->getDebitorAddress()->getZip();
		}
		
		//$adr = $this->getCustomer()->getDefaultBillingAddress();
		$adr = $this->getBillingAddress();
		if($adr)
		{
			return $adr->getPostcode();
		}
	
		return "";
	}
	
	public function getDebitorCountry()
	{
		/* @var $mandate Egovs_SepaDebitSax_Model_Sepa_Mandate */
		$mandate = $this->getMandate();
		if($mandate)
		{
			return $this->_parseIsoCountryCode($mandate->getDebitorAddress()->getCountry());
		}
		
		//$adr = $this->getCustomer()->getDefaultBillingAddress();
		$adr = $this->getBillingAddress();
		if($adr)
		{
			return $this->_parseIsoCountryCode($adr->getCountry());
		}
	
		return "";
	}
	
	public function getDebitorPostofficeBox()
	{
		/* @var $mandate Egovs_SepaDebitSax_Model_Sepa_Mandate */
		$mandate = $this->getMandate();
		if($mandate)
		{
			return $mandate->getDebitorAddress()->getPostofficeBox();
		}
	
		//$adr = $this->getCustomer()->getDefaultBillingAddress();
		$adr = $this->getBillingAddress();
		if($adr)
		{
			return $adr->getPostbox();
		}
		
		
		return "";
	}
	
	
	public function getCountriesHtmlSelectValue($id = 'countries', $name = 'payment[additional_information][custom_accountholder_land]', $value = "") 
	{
		
		if(Mage::getStoreConfig('payment/sepadebitsax/allowspecific') == 1)
		{
			//TODO:: noch fertig machen falls benötigt
			$countries = Mage::getStoreConfig('payment/sepadebitsax/specificcountry');
		}
		else 
		{
			$options = Mage::getResourceModel('directory/country_collection')->loadByStore()->toOptionArray();
		}
		
		
		$select = $this->getLayout()->createBlock('core/html_select')
		->setName($name)
		->setId($id)
		->setClass('select required-entry')
		->setValue($value)
		->setOptions($options)
		;
		return $select->getHtml();
	}
	
	
	public function getCheckout()
	{
		return Mage::getSingleton('mpcheckout/multipage');
	}
	
	public function getBillingAddress()
	{
		return $this->getCheckout()->getQuote()->getBillingAddress();
	}
	
}
