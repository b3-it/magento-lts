<?php
/**
 *
 *  Klasse für Sendungen Templates zum Erzeugen von pdf's
 *  @category Egovs
 *  @package  Egovs_Pdftemplate
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Pdftemplate_Model_Pdf_Shipment extends Egovs_Pdftemplate_Model_Pdf_Abstract
{
	public function preparePdf($invoices = array())
    {
   		$this->Name = Mage::helper('pdftemplate')->__('Deliverynote').'_' . Mage::getSingleton('core/date')->date('d_m_Y__H_i_s').'.pdf';
    	
		//normalisieren
        foreach ($invoices as $invoice) 
        {
        	$order = $invoice->getOrder();
        	$group = Mage::getModel('customer/group')->load($order->getCustomerGroupId());
        	if($group->getShippingTemplate() > 0)
        	{
        		$id = $group->getShippingTemplate();
        	}
        	else 
        	{
        		$id = Mage::getStoreConfig('sales_pdf/shipment/shipment_pdf_template', $order->getStoreId());
        	}
        	
        	$invoice->setTemplateId($id);
        	$invoice->setConfig($this->getConfig($order->getStoreId()));
        	$invoice->setImprint($this->getImprint($order->getStoreId()));
        	
        	$order = $invoice->getOrder();
        	if($order->getPayment()!= null)
        	{
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
        	}
        	
        }
        	
        return parent::preparePdf($invoices);
    }
    
 
}