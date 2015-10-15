<?php
/**
 * Oberserver für gemeinsam genutzte Methoden zur ePayment-Kommunikation.
 *
 * @category	Egovs
 * @package		Egovs_SepaDebitBund
 * @author		Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2013 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_SepaDebitBund_Model_Observer extends Mage_Core_Model_Abstract
{
	/**
	 * Löscht den Kunden an der ePayment-Plattform
	 *
	 * Wird nach dem löschen eines Kunden aufgerufen.
	 *
	 * @param Varien_Event_Observer $observer Observer
	 *
	 * @return Egovs_Paymentbase_Model_Observer
	 *
	 * @throws Exception
	 */
	public function doMandateDeleteFromPlatform($observer) {
		/* @var $customer Mage_Customer_Model_Customer */
		$customer = $observer->getCustomer();
		$newId = $customer->getData(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_SEPA_MANDATE_ID);
		$oldId = $customer->getOrigData(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_SEPA_MANDATE_ID);
		if ((!$newId && $oldId)
			|| (strlen($newId) > 0 && strlen($oldId) > 0 && $newId != $oldId)
		) {
			/* @var $method Egovs_SepaDebitBund_Model_Sepadebitbund */
			$method = Mage::helper('payment')->getMethodInstance('sepadebitbund');
			if (!$method) {
				Mage::log("Can't delete mandate from ePayBL, no method instance available", Zend_Log::WARN, Egovs_Helper::LOG_FILE);
				return;
			}
			$method->setData('info_instance', Mage::getModel('payment/info', array('order' => new Varien_Object())));
			//Wird von removeCurrentMandate benötigt => wird durch removeCurrentMandate wieder entfernt!!
			$customer->setData(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_SEPA_MANDATE_ID, $oldId);
			$method->getInfoInstance()->getOrder()->setCustomer($customer);
			$method->getInfoInstance()->getOrder()->setCustomerId($customer->getId());
			$method->setCustomer($customer);
			$method->removeCurrentMandate($oldId);
		}
	}
}