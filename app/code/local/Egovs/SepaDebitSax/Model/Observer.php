<?php
/**
 * Class Egovs_SepaDebitSax_Model_Observer
 *
 * @category	Egovs
 * @package		Egovs_SepaDebitSax
 * @author		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2011 - 2018 B3 IT Systeme GmbH - https://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 */
class Egovs_SepaDebitSax_Model_Observer extends Mage_Core_Model_Abstract
{
	
	
	/**
	 * schließt das Mandat falls die Referenz gelöscht wurde
	 *
	 * @param Varien_Event_Observer $observer Observer
	 *
	 * @return void
	 */
	public function doRemoveMandateReference($observer) {
		/* @var $customer Mage_Customer_Model_Customer */
		$customer = $observer->getCustomer();
	
		if (!$customer || $customer->getId() < 1) {
			return;
		}
	

		if (!($customer instanceof Mage_Customer_Model_Customer)) {
			return $this;
		}
		
		if ($customer->isEmpty()
		|| !$customer->getData(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_SEPA_MANDATE_ID)
		) {
			return $this;
		}
		
		$flag = Mage::app()->getRequest()->getPost("remove_sepa_mandate");
		if($flag !== null)
		{
			$this->__closeMandate($customer);
			$customer->unsetData(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_SEPA_MANDATE_ID);
			$resource = $customer->getResource();
			$resource->saveAttribute($customer, Egovs_Paymentbase_Helper_Data::ATTRIBUTE_SEPA_MANDATE_ID);
		}
	}
	
	public function doRemoveMandateReferenceOnDelete($observer) {
		/* @var $customer Mage_Customer_Model_Customer */
		$customer = $observer->getCustomer();
	
		if (!$customer || $customer->getId() < 1) {
			return;
		}
	
	
		if (!($customer instanceof Mage_Customer_Model_Customer)) {
			return $this;
		}
	
		if ($customer->isEmpty()
		|| !$customer->getData(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_SEPA_MANDATE_ID)
		) {
			return $this;
		}
	
		$this->__closeMandate($customer);
		
	}
	
	
	private function __closeMandate($customer)
	{
		$ref = $customer->getData(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_SEPA_MANDATE_ID);
		if($ref)
		{
			$model = Mage::getModel('sepadebitsax/sepadebitsax');
			$mandate = $model->getMandate($ref);
			$model->closeMandate($mandate);
		}
	}
	
	

}