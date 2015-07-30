<?php
/**
 *
 *  Klasse für Rechnungen Templates zum Erzeugen von pdf's
 *  @category Egovs
 *  @package  Egovs_Pdftemplate
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Pdftemplate_Model_Pdf_Invoice extends Egovs_Pdftemplate_Model_Pdf_Abstract
{
	public function preparePdf($invoices = array())
    {
   		$this->Name = Mage::helper('pdftemplate')->__('Invoice').'_' .Mage::getSingleton('core/date')->date('d_m_Y__H_i_s').'.pdf';
    	
		//normalisieren
        foreach ($invoices as $invoice) 
        {
        	$order = $invoice->getOrder();
        	$group = Mage::getModel('customer/group')->load($order->getCustomerGroupId());
        	if($group->getInvoiceTemplate() > 0)
        	{
        		$id = $group->getInvoiceTemplate();
        	}
        	else 
        	{
        		$id = Mage::getStoreConfig('sales_pdf/invoice/invoice_pdf_template', $order->getStoreId());
        	}
        	
        	$invoice->setTemplateId($id);
        	$invoice->setConfig($this->getConfig($order->getStoreId()));
        	$invoice->setImprint($this->getImprint($order->getStoreId()));
        	
        	     	
        	
        	
            $paymentInfo = Mage::helper('payment')->getInfoBlock($order->getPayment())
            			->setIsSecureMode(true)
            			->toPdf();
        	$payment = explode('{{pdf_row_separator}}', $paymentInfo);
	        foreach ($payment as $key=>$value){
	            if (strip_tags(trim($value))==''){
	                unset($payment[$key]);
	            }
	        }
	        $paymentInfo = implode('<br>', $payment);
	        

			$order->setPaymentInfo($paymentInfo);
	       	$taxInfo = $order->getFullTaxInfo();       
	        
	        $order->setTaxInfo($taxInfo);
			$order->setTaxInfoArray($this->getTaxInfoArray($order));
			
	        $date = "";
	        $datum = Mage::helper('core')->formatDate($invoice->getCreatedAtStoreDate());
            if ($invoice->getState() == Mage_Sales_Model_Order_Invoice::STATE_OPEN) {
	            $date = Mage::helper('sales')->__('Payable until');
	            $paymentInstance = $order->getPayment()->getMethodInstance();
	            if (method_exists($paymentInstance, "getPayWithinXDays")) {
	            	$datum = Mage::helper('core')->formatDate($invoice->getCreatedAtStoreDate()->addDay(intval($paymentInstance->getPayWithinXDays($invoice->getStoreId()))));
	            	$date .= ': '. $datum;
	            } else {
	            	$date = Mage::helper('sales')->__('The total invoice amount is due immediately.');
	            }
	 	    
            } elseif ($invoice->getState()== Mage_Sales_Model_Order_Invoice::STATE_PAID) {
	            $date = Mage::helper('sales')->__('Account is settled!');
	        }
	        $invoice->setPayableUntil($date);
	        $invoice->setToPayUntil($datum);
	        $invoice->setIsSettled((bool)$invoice->getState()== Mage_Sales_Model_Order_Invoice::STATE_PAID);
	        //echo '<pre>'; print_r($order->getData()); die();
	        //echo '<pre>'; print_r($invoice->getData()); die();
        	
        }
        
        return parent::preparePdf($invoices);
    }
    
   
 
}