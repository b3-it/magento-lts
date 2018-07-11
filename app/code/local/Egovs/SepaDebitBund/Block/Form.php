<?php

/**
 * Formblock für SEPA-Lastschriftzahlungen
 *
 * Setzt ein eigenes Template
 *
 * @category   	Egovs
 * @package    	Egovs_SepaDebitBund
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright  	Copyright (c) 2013-2018 B3 IT Systeme GmbH - https://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 * @see Mage_Payment_Block_Form
 */
class Egovs_SepaDebitBund_Block_Form extends Mage_Payment_Block_Form
{
	
	protected $_mandate = null;
	
	protected $_invalidMandate = false;

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
		$this->setTemplate('egovs/debit/sepa_bund/sepa_form.phtml');
	}
	
	/**
	 * Gibt das Mandat zurück
	 * 
	 * @return Egovs_Paymentbase_Model_Sepa_Mandate
	 */
	protected function _getMandate() {
		if (($this->_mandate == null) && (!$this->_invalidMandate)) {
				
			$ref = $this->getMethod()->getInfoInstance()->getData(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_SEPA_MANDATE_ID);
			if (!$ref) {
				$ref = $this->getMethod()->getMandateReferenceFromCustomer();
			}
			if ($ref) {
				$this->_mandate = $this->getMethod()->readMandate($ref);
				if ($this->_mandate == null) {
					$this->_invalidMandate = true;
				}
			}
		}
	
		return $this->_mandate;
	}
	
	
	public function getIsDebug() {
		return $this->getMethod()->getIsDebug();
	}
	
	public function getIsInternalManagement() {
		return $this->getMethod()->getIsInternalManagement();
	}
	
	public function getAgreementText() {
		return Mage::getStoreConfig('payment/sepadebitbund/agree_text');
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
        $helper = Mage::helper('mpcheckout/Addressformat');

		if ($this->isCustomerLoggedIn()) {
			$options = array();

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
			->setClass('select required-entry')
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
	
	public function getIban() {
		if ($_mandate = $this->_getMandate()) {
			return $_mandate->getBankingAccount()->getIban();
		}
		
		return null;
	}
	
	public function getBic() {
		if (!$this->getIbanOnly() && ($_mandate = $this->_getMandate())) {
			return $_mandate->getBankingAccount()->getBic();
		}
		
		return null;
	}
	
	public function getAccountName() {
		if ($_mandate = $this->_getMandate()) {
			return $_mandate->getAccountholderFullname();
		}
		
		return null;
	}
	
	public function getAccountBankname() {
		return $this->getMethod()->getAccountBankname();
	}
	
	public function hasMandate() {
		$reference = $this->getCustomer()->getData(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_SEPA_MANDATE_ID);
		if (!$reference) {
			return false;
		}
		
		return true;
	}
	
	public function getMandateDownloadUrl() {
		return $this->getUrl('paymentbase/sepa_mandate/link', array('_secure' => true, 'method' => $this->getMethodCode()));
	}
	
	public function getAllowOneoff() {
		return $this->getMethod()->getAllowOneoff();
	}
	
	public function getIbanOnly() {
		return $this->getMethod()->getIbanOnly();
	}

	public function getSequenceTypeForMultiUsage() {
        return Mage::helper('sepadebitbund')->getSequenceTypeForMultiUsage();
    }
}
