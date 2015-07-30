<?php
class Egovs_Base_Model_Checkout_Observer
{
	public function onCheckoutCartSaveBefore($observer) {
		$cart = $observer->getCart();
		
		$cart->getQuote()->getBaseAddress();
	}
	
	public function onCheckoutTypeOnepageSaveOrder($observer) {
		$order = $observer->getOrder();
		$quote = $observer->getQuote();
		
		if (!$quote) {
			return;
		}
		
		$convertQuote = Mage::getModel('sales/convert_quote');
		/* @var $convertQuote Mage_Sales_Model_Convert_Quote */
		//$order = Mage::getModel('sales/order');
		if ($quote->hasVirtualItems()) {
			$address = $convertQuote->addressToOrderAddress($quote->getBaseAddress());
			/* @var $order Mage_Sales_Model_Order */
			$oldAddress = false;
			foreach ($order->getAddressesCollection() as $oldAddress) {
				if ($oldAddress->getAddressType()=='base_address' && !$oldAddress->isDeleted()) {
					break;
				}
				$oldAddress = false;
			}
			
			if (!empty($oldAddress)) {
				$address->setId($oldAddress->getId());
			}
			$order->addAddress($address->setAddressType('base_address'));
		}
	}
}