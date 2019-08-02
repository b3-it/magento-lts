<?php
/**
 *
 * @category   	Dwd Fix
 * @package    	Dwd_Fix
 * @name       	Dwd_Fix_Model_Rechnung_Rechnung
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Fix_Model_Rechnung_Rechnung extends Mage_Core_Model_Abstract
{
	
	private $__limit = 2;
	
	
	
	const XML_PATH_EMAIL_TEMPLATE               = 'sales_email/invoice/template';
	const XML_PATH_EMAIL_GUEST_TEMPLATE         = 'sales_email/invoice/guest_template';
	const XML_PATH_EMAIL_IDENTITY               = 'sales_email/invoice/identity';
	const XML_PATH_EMAIL_COPY_TO                = 'sales_email/invoice/copy_to';
	const XML_PATH_EMAIL_COPY_METHOD            = 'sales_email/invoice/copy_method';
	const XML_PATH_EMAIL_ENABLED                = 'sales_email/invoice/enabled';
	
    public function _construct()
    {
        parent::_construct();
        $this->_init('dwd_fix/rechnung_rechnung');
    }
    
    
    public function process()
    {
    	
    	$von = intval(Mage::getStoreConfig('dwd_fix/fix/min'));
    	$bis = intval(Mage::getStoreConfig('dwd_fix/fix/max'));
    	
    	if(($von < 1) || ($bis < 1) || ($bis < $von)){
    		Mage::log('DWD Fix Bereichsgrenzen richtig nicht angegeben!', Zend_Log::INFO, Egovs_Helper::LOG_FILE);
    		return $this;
    	}
    	
    	
    	$collection = Mage::getModel('sales/order')->getCollection();
    	$expr = new Zend_Db_Expr('(SELECT order_id FROM dwd_fix_rechnung_rechnung)');
    	$collection->getSelect()
    	->where('entity_id >=?',$von)
    	->where('entity_id <=?',$bis)
    	->where('entity_id NOT IN (?)',$expr)
    	->limit($this->__limit)
    	;
    	
    	//die($collection->getSelect()->__toString());
    	$order_ids = array();
    	foreach($collection as $order){
    		$this->_processOrder($order);
    		$order_ids[] = $order->getId();
    		Mage::getModel('dwd_fix/rechnung_rechnung')
    		->setOrderId($order->getId())
    		->setSend(now())
    		->save();
    	}
    	Mage::log('DWD Fix processing Orders: '. implode(',', $order_ids), Zend_Log::INFO, Egovs_Helper::LOG_FILE);
    	
    }
    
    
    protected function _processOrder(Mage_Sales_Model_Order $order)
    {
    	$invoices = $order->getInvoiceCollection()->getItems();
    	foreach($invoices as $invoice){
    		try
    		{
    			$this->_sendEmail($order,$invoice);
    			
    		}catch(Exception $ex)
    		{
    			Mage::logException($ex);
    		}
    	}
    }
    
    
    /**
     * Send email with invoice data
     *
     * @param boolean $notifyCustomer
     * @param string $comment
     * @return Mage_Sales_Model_Order_Invoice
     */
    protected function _sendEmail($order, $invoice)
    {
    	
    	$storeId = $order->getStore()->getId();
    
    	
    	// Get the destination email addresses to send copies to
    	$copyTo = $this->_getEmails(self::XML_PATH_EMAIL_COPY_TO);
    	//$copyMethod = Mage::getStoreConfig(self::XML_PATH_EMAIL_COPY_METHOD, $storeId);
    	// Check if at least one recepient is found
    	
    
    	// Start store emulation process
    	$appEmulation = Mage::getSingleton('core/app_emulation');
    	$initialEnvironmentInfo = $appEmulation->startEnvironmentEmulation($storeId);
    
    	try {
    		// Retrieve specified view block from appropriate design package (depends on emulated store)
    		$paymentBlock = Mage::helper('payment')->getInfoBlock($order->getPayment())
    		->setIsSecureMode(true);
    		$paymentBlock->getMethod()->setStore($storeId);
    		$paymentBlockHtml = $paymentBlock->toHtml();
    	} catch (Exception $exception) {
    		// Stop store emulation process
    		$appEmulation->stopEnvironmentEmulation($initialEnvironmentInfo);
    		throw $exception;
    	}
    
    	// Stop store emulation process
    	$appEmulation->stopEnvironmentEmulation($initialEnvironmentInfo);
    
    	// Retrieve corresponding email template id and customer name
    	if ($order->getCustomerIsGuest()) {
    		$templateId = Mage::getStoreConfig(self::XML_PATH_EMAIL_GUEST_TEMPLATE, $storeId);
    		
    	} else {
    		$templateId = Mage::getStoreConfig(self::XML_PATH_EMAIL_TEMPLATE, $storeId);
    		
    	}

    	/**
    	 * @var Egovs_Base_Model_Core_Email_Template_Mailer $mailer
    	 */
    	$mailer = Mage::getModel('egovsbase/core_email_template_mailer');
    	$emailInfo = Mage::getModel('core/email_info');
    		
    	
    	// Email copies are sent as separated emails if their copy method is 'copy' or a customer should not be notified
    	if ($copyTo) {
    		foreach ($copyTo as $email) {
    			$emailInfo = Mage::getModel('core/email_info');
    			$emailInfo->addTo($email, $email);
    			$mailer->addEmailInfo($emailInfo);
    		}
    	}
    
    	// Set all required params and send emails
    	$mailer->setSender(Mage::getStoreConfig(self::XML_PATH_EMAIL_IDENTITY, $storeId));
    	$mailer->setStoreId($storeId);
    	$mailer->setTemplateId($templateId);
    	$mailer->setTemplateParams(array(
    			'order'        => $order,
    			'invoice'      => $invoice,
    			'comment'      => 'Rechnung nachträglich gesendet',
    			'billing'      => $order->getBillingAddress(),
    			'payment_html' => $paymentBlockHtml
    	)
    			);
    
    	$pdf = Mage::getModel('pdftemplate/pdf_invoice');
    	if($pdf)
    	{
    		$name = 'Rechnung_' .Mage::getSingleton('core/date')->date('d_m_Y__H_i_s').'_'.$invoice->getId().'.pdf';
    		$pdf = $pdf->getPdf(array($invoice));
    		$pdf->Mode = Egovs_Pdftemplate_Model_Pdf_Abstract::MODE_EMAIL;
    		$mailer->setAttachment($pdf->render(),$name);
    	}
    
    	$mailer->send();
 		
    	
    
    	return $this;
    }
    
    protected function _getEmails($configPath)
    {
    	$data = Mage::getStoreConfig($configPath, $this->getStoreId());
    	if (!empty($data)) {
    		return explode(',', $data);
    	}
    	return false;
    }
}
