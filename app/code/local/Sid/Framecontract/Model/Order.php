<?php

class Sid_Framecontract_Model_Order extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('framecontract/order');
    }
    
    public function sendOrderEmail($orders)
    {
    	foreach ($orders as $order)
    	{
    		if($order->getFramecontract())
    		{
	    		$address = $order->getShippingAddress();
		    	$this->setOrderId($order->getId());
		    	$this->setFramecontractId($order->getFramecontract());
		    	if($address){
		    		$this->setShippingOrderAddressId($address->getId());
		    	}
		    	$this->sendEmail($order, $address);
		    	
		    	
		    	$this->save();
    		}
    	}
    }
    
	public function sendEmail($order,$address)
    {
    	$storeid = $order->getStoreId();
    	
    	if($this->getFramecontractId())
    	{
    		$contract = Mage::getModel('framecontract/contract')->load($this->getFramecontractId());
    	}
    	
	    $this->setVendorEmail($contract->getOrderEmail());

	    $this->setPrincipalEmail(Mage::getStoreConfig("framecontract/checkout_email/office_email_address", $storeid));
    	if(Mage::getStoreConfig("framecontract/checkout_email/office_email", $storeid))
    	{
    		
	    
    		$vendorEMail = array();
    		$vendorEMail[] = $this->getPrincipalEmail();
    		$vendorEMail[] = $this->getVendorEmail();
    	}
    	else 
    	{
    		$vendorEMail =  $this->getVendorEmail();
    		if(strlen($vendorEMail) < 1) return;    
    	}
    	
    	$translate = Mage::getSingleton('core/translate');
        /* @var $translate Mage_Core_Model_Translate */
        $translate->setTranslateInline(false);

        $mailTemplate = Mage::getModel('core/email_template');
        /* @var $mailTemplate Mage_Core_Model_Email_Template */
 
        
        $template = Mage::getStoreConfig("framecontract/checkout_email/order_template", $storeid);
        
        
		$sender = array();
		$sender['name'] = Mage::getStoreConfig("framecontract/checkout_email/office_sender", $storeid);
        $sender['email'] = Mage::getStoreConfig("framecontract/checkout_email/office_email_address", $storeid);
        
        /*
        foreach($files->getItems() as $file)
        {
        	$fileContents = file_get_contents($file->getDiskFilename());
    		$attachment = $mailTemplate->getMail()->createAttachment($fileContents);
    		$attachment->filename = $file->getfilenameOriginal();	
        }
        */
        
        $data = array();
        $data['order'] = $order;
        $data['address'] = $address;
        $data['contract'] = $contract;
        
        $mailTemplate->setReturnPath($this->getPrincipalEmail());
        $mailTemplate->setDesignConfig(array('area'=>'frontend', 'store'=>$storeid));
        $mailTemplate->sendTransactional(
                    $template,
                    $sender,
                    $vendorEMail,
                    $vendorEMail,
                   	$data
                );
        

        $translate->setTranslateInline(true);

        return $this;
    }
}