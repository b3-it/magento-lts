<?php

class TuChemnitz_Voucher_Model_Email extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
       
    }
    
    /**
     * Versand der Tans an Kunden nach Bezahlung
     * @param Mage_Sales_Model_Order $order
     * @return TuChemnitz_Voucher_Model_Email
     */
    public function sendVoucherEmail($order)
    {
    	$items = $this->_getVoucherItems($order->getAllItems());
    	if(count($items) > 0)
    	{
    		
			$this->sendEmail($order, $items);
    	}
		
    	return $this;
    }
    
   
    
    
	public function sendEmail($order,$items)
    {
    	$storeid = $order->getStoreId();
    	
    	
    	
    	$translate = Mage::getSingleton('core/translate');
        /* @var $translate Mage_Core_Model_Translate */
        $translate->setTranslateInline(false);

        $mailTemplate = Mage::getModel('core/email_template');
        /* @var $mailTemplate Mage_Core_Model_Email_Template */
 
        
        $template = Mage::getStoreConfig("tucvoucher/email/tan_template", $storeid);
        
        
		$sender = array();
		$sender['name'] = Mage::getStoreConfig("trans_email/ident_sales/name", $storeid);
        $sender['email'] = Mage::getStoreConfig("trans_email/ident_sales/email", $storeid);
        
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
        $data['items'] = $items;
       
        
       
        $mailTemplate->setDesignConfig(array('area'=>'frontend', 'store'=>$storeid));
        $mailTemplate->sendTransactional(
                    $template,
                    $sender,
                    $order->getCustomerEmail(),
                   	$order->getCustomerName(),
                   	$data
                );
        

        $translate->setTranslateInline(true);

        return $this;
    }
    
    
    
    /**
     * Extrahieren der VoucherItems und zugehöriger Tans
     */
    private function _getVoucherItems($items)
    {
    	$res = array();
    	foreach($items as $item)
    	{
    		if ($item->getProductType() == TuChemnitz_Voucher_Model_Product_Type_Tucvoucher::TYPE_VOUCHER
    		|| $item->getRealProductType() == TuChemnitz_Voucher_Model_Product_Type_Tucvoucher::TYPE_VOUCHER)
    		{
    			$collection = Mage::getModel('tucvoucher/tan')->getCollection();
    			$collection->getSelect()->where("order_item_id = ". $item->getItemId());
    	//die($collection->getSelect()->__toString());	
    			$tans = array();	
    			foreach($collection->getItems() as $tan)
    			{
    				$tans[] = $tan->getTan();
    				
    			}
    			$product_id = $item->getProductId();
    			$note  = Mage::getResourceModel('catalog/product')->getAttributeRawValue($product_id, 'tucvoucher_note_email',$item->getOrder()->getStoreId());
    			$res[] = array("order_item"=>$item,"tans"=>$tans,"note" => $note);
    		}
    	}
    	 
    	return $res;
    }
    
    
    
}