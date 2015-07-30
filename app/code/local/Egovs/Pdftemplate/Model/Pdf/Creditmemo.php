<?php
/**
 *
 *  Klasse für Gutschriften Templates zum Erzeugen von pdf's
 *  @category Egovs
 *  @package  Egovs_Pdftemplate
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Pdftemplate_Model_Pdf_Creditmemo extends Egovs_Pdftemplate_Model_Pdf_Abstract
{
	public function preparePdf($invoices = array())
    {
   		$this->Name = Mage::helper('pdftemplate')->__('Creditmemo').'_' . Mage::getSingleton('core/date')->date('d_m_Y__H_i_s').'.pdf';
    	
		//normalisieren
        foreach ($invoices as $invoice) 
        {
        	$order = $invoice->getOrder();
        	//echo '<pre>'; var_dump($order->getData());die();
        	$group = Mage::getModel('customer/group')->load($order->getCustomerGroupId());
        	if($group->getCreditmemoTemplate() > 0)
        	{
        		$id = $group->getCreditmemoTemplate();
        	}
        	else 
        	{
        		$id = Mage::getStoreConfig('sales_pdf/creditmemo/creditmemo_pdf_template', $order->getStoreId());
        	}
        	
        	$invoice->setTemplateId($id);
        	$invoice->setConfig($this->getConfig($order->getStoreId()));
        	$invoice->setImprint($this->getImprint($order->getStoreId()));
        	
        	$order = $invoice->getOrder();
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
	        if ($shipments = $order->getShipmentsCollection())
	        {
	        	$shipment = $shipments->getItems();
	        	$shipment = array_pop($shipment); 
	        	if($shipment){
	        		$order->setShipmentDate($shipment->getCreatedAt());
	        	}
	        }
	        $tmp = array();
	        foreach ($order->getInvoiceCollection()->getItems() as $i)
	        {
	        	$tmp[] = $i->getIncrementId();
	        }
	        
	        $order->setInvoiceIncrementIds(implode(', ', $tmp));
       	
        }
        
        return parent::preparePdf($invoices);
    }
    
 
}