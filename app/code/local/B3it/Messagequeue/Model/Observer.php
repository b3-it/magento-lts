<?php

class B3it_Messagequeue_Model_Observer
{
    public function onCheckoutSubmitAllAfter($observer)
    {
        $order = $observer->getOrder();

        $sets = Mage::getResourceModel('b3it_mq/queue_ruleset_collection')->getModels4Categrory('order');


        foreach($sets as $set){

            $set->processEvent($order, 'checkout_submit_all_after');
        }

    }
    
    
    
    public function onSalesOrderInvoicePay($observer)
    {
    	$data = $observer->getInvoice();
    	
    	$sets = Mage::getResourceModel('b3it_mq/queue_ruleset_collection')->getModels4Categrory('invoicepay');
    	
    	foreach($sets as $set){
    		$set->processEvent($data, 'sales_order_invoice_pay');
    	}
    }
    
}
