<?php

class Sid_Wishlist_Model_Email extends Mage_Core_Model_Abstract
{

	private $_message = "";
	private $_wishlist = null;
	private $_recipients = array();
	private $_sender = null;
    private $_link = "";
	
	public function setWishlist($wishlist)
	{
		$this->_wishlist = $wishlist;
		return $this;
	}
	
	public function setMessage($message)
	{
		$this->_message = $message;
		return $this;
	}
	
	public function addRecipient($email)
	{
		$this->_recipients[] = $email;
		return $this;
	}
	
	public function setSender($name,$email)
	{
		$this->_sender = array('name'=>$name,'email'=>$email); 
		return $this;
	}
	
	public function setLink($link)
	{
		$this->_link = $link;
		return $this;
	}
	
	
	public function sendEmail()
    {
    	
    	//die($this->__renderItems());
    	$storeid = Mage::app()->getStore()->getId();
    	
    	$translate = Mage::getSingleton('core/translate');
        /* @var $translate Mage_Core_Model_Translate */
        $translate->setTranslateInline(false);

        $mailTemplate = Mage::getModel('core/email_template');
        /* @var $mailTemplate Mage_Core_Model_Email_Template */
 
        
        $template = Mage::getStoreConfig("sidwishlist/general/email_template", $storeid);
       
        if (!$template) {
        	$template = Mage::getStoreConfig('wishlist/email/email_template');
        }
        $data = array();
        $data['message'] = $this->_message;
        $data['items'] = $this->__renderItems();
        $data['link'] = $this->_link;
        
        $mailTemplate->setReturnPath($this->_sender['email']);
        $mailTemplate->setDesignConfig(array('area'=>'frontend', 'store'=>$storeid));
        
        foreach ($this->_recipients as $recipient) {
       
	        $mailTemplate->sendTransactional(
	                    $template,
	                    $this->_sender,
	                    $recipient,
	                    null,
	                   	$data
	                );
        }
        

        $translate->setTranslateInline(true);

        return $this;
    }
    
    
    
    private function __renderItems()
    {
    	$wishlistBlock = $this->getLayout()->createBlock('sidwishlist/view');
    	$wishlistBlock->setTemplate('sid/wishlist/emailview.phtml');
    	$wishlistBlock->clearItemRenderer()
    		->addItemRender('default', 'sidwishlist/view_quote_item_renderer', 'sid/wishlist/emailview/quote/item/default.phtml');
    	return $wishlistBlock->toHtml();
    }
    
	public function getLayout()
    {
        return Mage::getSingleton('core/layout');
    }
}