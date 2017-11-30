<?php
/**
 * Print Invoice Pdf controller
 *
 * @category   	Sid
 * @package    	Gka_Checkout
 * @author		Holger K�gel <h.koegel@edv-beratung-hempel.de>
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2012 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2012 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Gka_Checkout_InvoiceController extends Mage_Checkout_Controller_Action
{

    
	 /***
	  * Rechnung als Pdf Anzeigen
	  * @return Mage_Adminhtml_Controller_Action
	  */
    public function PdfInvoiceAction()
    {
    	$orderId = $this->getRequest()->getParam('order_id');
    	$flag = false;
    	
    	/** @var $invoices Mage_Sales_Model_Resource_Order_Invoice_Collection */
    	$invoices = Mage::getResourceModel('sales/order_invoice_collection')
    	->setOrderFilter($orderId);
    	
    	//sicherstellen das der Kunde auch seine Rechnung druckt
    	$customer_id = Mage::getSingleton('customer/session')->getCustomer()->getId();
    	$invoices->getSelect()
    		->join(array('order'=>$invoices->getTable('sales/order')),'main_table.order_id = order.entity_id AND customer_id='.$customer_id);
    	
    	$invoices->load();
    	if ($invoices->getSize()){
    		$flag = true;
    		if (!isset($pdf)){
    			$pdf = Mage::getModel('sales/order_pdf_invoice')->getPdf($invoices);
    		} else {
    			$pages = Mage::getModel('sales/order_pdf_invoice')->getPdf($invoices);
    			$pdf->pages = array_merge ($pdf->pages, $pages->pages);
    		}
    	}
    	
    	if ($flag) {
    		return $this->_prepareDownloadResponse(
    				'docs'.Mage::getSingleton('core/date')->date('Y-m-d_H-i-s').'.pdf',
    				$pdf->render(), 'application/pdf'
    				);
    	} else {
    		Mage::getSingleton('customer/session')->addError($this->__('There are no printable documents related to selected orders.'));
    		$this->_redirect('*/*/');
    	}
    }
    
}
