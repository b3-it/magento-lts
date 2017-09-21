<?php
/**
 * 
 *  Abfangen der Bestellung und speichern der Anmeldedaten
 *  @category Gka
 *  @package  Gka_Barkasse_Model_Observer
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Gka_Barkasse_Model_Observer extends Varien_Object
{
	

	public function onCheckoutSubmitAllAfter($observer)
	{
		/** @var $order Mage_Sales_Model_Order */
		$order = $observer->getOrder();
		
		if($order == null) return;
		
		
		if($order->getPayment()->getMethod() != 'epaybl_cashpayment'){
			return;
		}
		
		$journal  = Mage::getModel('gka_barkasse/kassenbuch_journal')->getOpenJournal($order->getCustomerId());
		$journalItem = Mage::getModel('gka_barkasse/kassenbuch_journalitems');
		
		$givenamount = floatval($order->getGivenAmount());
		
		$journalItem->setBookingDate(now())
		->setBookingAmount($order->getBaseGrandTotal())
		->setJournalId($journal->getId())
		->setOrderId($order->getId())
		->setGivenAmount($givenamount)
		->setSource(0)
		->save();
	}

	/**
	 * Hinweis zur Eröffnung eines Kassenbuches anzeigen
	 * @param Gka_Barkasse_Model_Observer $observer
	 */
	public function onCustomerAuthenticated($observer)
	{
		return;
		$customer = $observer->getModel();
		if($customer->getId()){
			if(Mage::getModel('gka_barkasse/kassenbuch_journal')->isCustomerCanOpen($customer->getId()))
			{
					$text = "Sie haben zur Zeit keine Barkasse zur Verfügung! Bitte klicken Sie <a href=\"". Mage::getModel('core/url')->getUrl('gka_barkasse/kassenbuch_journal'). "\"> hier </a>";
					//Mage::getSingleton('customer/session')->addError($text);
			}
		}
	}

    
 
}