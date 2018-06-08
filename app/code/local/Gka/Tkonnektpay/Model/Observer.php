<?php

/**
 * TKonnekt Debitkarten Payment
 *
 * Überschreibt hier nur Egovs_Paymentbase_Helper_Data
 *
 * @category   	Gka
 * @package    	Gka_Tkonnektpay
 * @name       	Gka_Tkonnektpay_Helper_Data
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Gka_Tkonnektpay_Model_Observer
{ 
    public function paymentMethodIsActive(Varien_Event_Observer $observer) {
        $event           = $observer->getEvent();
        $method          = $event->getMethodInstance();
        $result          = $event->getResult();
        $currencyCode    = Mage::app()->getStore()->getCurrentCurrencyCode();
       
         
        if( $currencyCode != 'EUR'){
            if ($method->getCode() == 'gka_tkonnektpay_debitcard' ){
                $result->isAvailable = false;
            }
        }
    }
 
    public function onInvoicePrepare(Varien_Event_Observer $observer)
    {
    	$order = $observer->getOrder();
    	if($order)
    	{
    		/* @var $payment Mage_Sales_Model_Order_Payment */
    		$payment = $order->getPayment();
    		if($payment->getMethod() == "gka_tkonnektpay_debitcard")
    		{
    			$collection = Mage::getModel('sales/order_payment_transaction')->getCollection()
    			->setOrderFilter($order)
    			->addPaymentIdFilter($payment->getId())
    			->addTxnTypeFilter('order');
    			
    			foreach($collection->getItems() as $item)
    			{
    				$data = ($item->getadditionalInformation());	
    				if(isset($data['raw_details_info'])){
	    				if(isset($data['raw_details_info']['tkCustomerReceipt'])){
	    					$order->setTerminalCustomerReceipt($data['raw_details_info']['tkCustomerReceipt']);
	    				}
                        if(isset($data['raw_details_info']['tkMerchantReceipt'])){
                            $order->setTerminalMerchantReceipt($data['raw_details_info']['tkMerchantReceipt']);
                            if(strpos($data['raw_details_info']['tkMerchantReceipt'],"Unterschrift") !== false) {
                                $order->setSignatureRequired(true);
                            }
                        }

    				}
    			}
    		}
    	}
    	
    }
}