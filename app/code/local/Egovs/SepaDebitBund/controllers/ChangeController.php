<?php
/**
 * Controller zur Änderung des Mandates für SEPA Lastschriftzahlungen 
 *
 * @category   	Egovs
 * @package    	Egovs_DebitPIN
 * @author 		Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @author 		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011-2014 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 * @see Mage_Core_Controller_Front_Action
 */
class Egovs_SepaDebitBund_ChangeController extends Mage_Core_Controller_Front_Action
{
	
	private $_Customer = null;
	/**
	 * Standardaufruf
	 * 
	 * @return void
	 */
	public function indexAction() {
		$this->loadLayout();
		try {
			$this->renderLayout();
		} catch (Exception $e) {
			Mage::getSingleton('core/session')->addError($e->getMessage());
			$this->_redirect('customer/account/index');
			return;
		}
	}

	/**
	 * Aufruf bei Änderung der PIN
	 * 
	 * @return void
	 */
	public function changeAction() {
		//$this->loadLayout();

		
		$payment = $this->getRequest()->getParam('payment');
		
		while(strlen($payment['cc_type']) < 11)
		{
			$payment['cc_type'] .= "X";
		}
		
		
		$mandateRemoved = false;
		
		
		
		/* @var $customer Mage_Customer_Model_Customer */
		$customer = $this->getCustomer();
		if(!$customer)
		{
			$this->_redirect('*/*/*');
			return;
		}
		try {
			
			$info = Mage::getModel('payment/info');
			$info->setMethod('sepadebitbund');
			$quote = new Varien_Object();
			$quote->setCustomerId($customer->getId());
			$info->setQuote($quote);
			/* @var $model Egovs_SepaDebitBund_Model_Sepadebitbund */
			$model = $info->getMethodInstance();
			$ref = $model->getMandateReferenceFromCustomer();
			if($ref)
			{
				Mage::helper('paymentbase')->changeAdditionalCustomerMandateData($customer,array("change_mandate"=>$model->getMandateReferenceFromCustomer()));
			}
			$model->removeCurrentMandate();
			$mandateRemoved = true;
			$mandate = $model->createNewMandateFromCustomer($customer, new Varien_Object($payment));
		}
		catch (Exception $e) {
			Mage::getSingleton('core/session')->addError($e->getMessage());
			$ref = Mage::helper('paymentbase')->getAdditionalCustomerMandateData($customer,"change_mandate");
			if ($ref && !$mandateRemoved) {
				$customer->setData(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_SEPA_MANDATE_ID, $ref);
				$resource = $customer->getResource();
				$resource->saveAttribute($customer, Egovs_Paymentbase_Helper_Data::ATTRIBUTE_SEPA_MANDATE_ID);
				Mage::helper('paymentbase')->unsAdditionalCustomerMandateData($customer,"change_mandate");
			}
			else
			{
				Mage::getSingleton('core/session')->addWarning($this->__('Old Mandate has been disabled.'));
			}
			$this->_redirect('*/*/index');
			return;
		}

		Mage::getSingleton('core/session')->addSuccess($this->__('Mandate successfully modified.'));
		$this->_redirect('*/*/index');
	}
	
	private function getCustomer()
	{
		if ($this->_Customer === null) {
			$this->_Customer = Mage::getSingleton('customer/session')->getCustomer();
		}
		return $this->_Customer;
	}

	
	/**
	 * Zusätzliche Authentifizierung
	 *
	 * @return void
	 * 
	 * @see Mage_Core_Controller_Front_Action::preDispatch()
	 */
	public function preDispatch() {
		parent::preDispatch();

		if (!Mage::getSingleton('customer/session')->authenticate($this)) {
			$this->setFlag('', 'no-dispatch', true);
		}
	}
}