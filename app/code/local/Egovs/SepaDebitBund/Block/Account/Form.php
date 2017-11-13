<?php

/**
 * Block zur Änderung des Mandates für SEPA Lastschriftzahlungen 
 *
 * @category   	Egovs
 * @package    	Egovs_DebitPIN
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @author 		Rene Sieberg <rsieberg@web.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 * @see Egovs_DebitPIN_Block_Account_Abstract
 */
class Egovs_SepaDebitBund_Block_Account_Form extends Egovs_SepaDebitBund_Block_Form
{
	
	protected $_Custumer = null;
	
	/**
	 * URL für Controller
	 * 
	 * @return string
	 */
	public function getActionUrl() {
		return $this->getUrl('sepadebitbund/change/change', array('_secure'=>'true'));
	}
	
	public function getMethod()
	{
		$info = Mage::getModel('payment/info');
		$info->setMethod('sepadebitbund');
		$this->setInfo($info);
		/* @var $model Egovs_SepaDebitBund_Model_Sepadebitbund */
		$model = $info->getMethodInstance();
		$customer = $this->getCustomer();
		$mandateRef = $customer->getSepaMandateId();
		if($mandateRef)
		{
			//$model->getMandate($mandateRef);
		}
		return $model;
	}
	
	public function getCustomer()
	{
		if ($this->_Custumer === null) {
			$this->_Custumer = Mage::getSingleton('customer/session')->getCustomer();
		}
		return $this->_Custumer;
	}
	
	
	
	public function hasMandate() {
		return false;
		$reference = $this->getCustomer()->getData(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_SEPA_MANDATE_ID);
		if (!$reference) {
			return false;
		}
	
		return true;
	}
	
	
}