<?php

class Egovs_Base_Model_Sales_Order_Observer extends Mage_Core_Model_Abstract
{
//Mage::dispatchEvent('egovs_paymentbase_saferpay_sales_order_invoice_after_pay', array('invoice'=>$invoice));
	
	public function onSaferpaySalesOrderInvoiceAfterPay($observer)
	{
		$invoice = $observer->getInvoice();
		if($invoice instanceof Mage_Sales_Model_Order_Invoice)
		{
			
			$this->_sendInvoice($invoice);
			
		}
	}
	
	public function onCheckoutSubmitAllAfter($observer)
	{

		$order = $observer->getOrder();
		if($order == null ) return;
		$icollection = Mage::getResourceModel('sales/order_invoice_collection')
	                ->addAttributeToSelect('*')
	                ->setOrderFilter($order->getId());
	    $invoice = null;
	    foreach ($icollection->getItems() as $item) 
	    {
	         	$invoice = $item;
	    }
	    
	    $this->_sendInvoice($invoice);
	    
	}
	
	private function _sendInvoice($invoice)
	{
		if($invoice == null) return;
	    if($invoice->getEmailSent()) return;
		if($invoice->getDoNotSendEmail()) return;
		if(Mage::getStoreConfig("sales_email/invoice/send_mail", $invoice->getStoreId()) == 0) return;
		try 
		{
			//$order = $invoice->getOrder();
			//$payment = $order->getPayment();
			$invoice->sendEmail();
		}
		catch(Exception $ex)
		{
			Mage::logException($ex);
		}
	}
 
}

