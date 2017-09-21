<?php

class Gka_Checkout_Block_Cart_Cart extends Mage_Checkout_Block_Cart
{
	private $_CheckoutUrl = 'gkacheckout/singlepage/overview';
    
    public function getDeleteAllUrl()
    {
    	$url = $this->getUrl('gkacheckout/cart/deleteall', array(
                'id'=>'0',
                Mage_Core_Controller_Front_Action::PARAM_NAME_URL_ENCODED => $this->helper('core/url')->getEncodedUrl(),
                '_secure'=>true
            ));
        //$img = $this->getSkinUrl('images/btn_trash.gif');
        //$text = Mage::helper('mpcheckout')->__('Delete All Items');
        return $url;//"<a title=\"$text\" href=\"#\" onclick=\"deleteAll(\'$url\')\" ><img height=\"16\" width=\"16\" alt=\"$text\" src=\"$img\"/></a>";
    }
    
   public function getCheckoutUrl()
    {
        return $this->getUrl($this->_CheckoutUrl, array('_secure'=>true));
    }
    
   	public function setCheckoutUrl($url)
    {
        $this->_CheckoutUrl = $url;
    }
    
    public function getFormActionUrl()
    {
    	return $this->getUrl('checkout/cart/updatePost', array('_secure' => $this->_isSecure()));
    }
    
}
