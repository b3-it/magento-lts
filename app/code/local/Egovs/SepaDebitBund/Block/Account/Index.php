<?php

/**
 * Block zur Änderung des Mandates für SEPA Lastschriftzahlungen 
 *
 * @category   	Egovs
 * @package    	Egovs_DebitPIN
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 * 
 */
class Egovs_SepaDebitBund_Block_Account_Index extends Mage_Core_Block_Template
{
    /**
	 * URL für Controller
	 * 
	 * @return string
	 */
	public function getActionUrl() {
		return $this->getUrl('sepadebitbund/change/change', array('_secure'=>'true'));
	}
	
	
	protected function _toHtml()
	{
		$customer = $this->getCustomer();
		if(!$customer) {
			return "";
		}
		
		$mandateRef = $customer->getSepaMandateId();
		if(!$mandateRef)
		{
			$mandateRef = Mage::helper('paymentbase')->getAdditionalCustomerMandateData($customer,"old_mandate");
		}
		
    	return parent::_toHtml();
	}
	
	
	public function getCustomer()
	{
		if ($this->_Custumer === null) {
			$this->_Custumer = Mage::getSingleton('customer/session')->getCustomer();
		}
		return $this->_Custumer;
	}
	
	public function hasMandate() {
		$reference = $this->getCustomer()->getData(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_SEPA_MANDATE_ID);
		if (!$reference) {
			return false;
		}
	
		return true;
	}
	
	
}