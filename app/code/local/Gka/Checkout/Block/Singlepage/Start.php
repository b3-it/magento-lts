<?php

class Gka_Checkout_Block_Singlepage_Start extends Mage_Sales_Block_Items_Abstract
{
   

 	public function getCardUrl()
 	{
 		return $this->getUrl('gkacheckout/cart', array('_secure'=>true));
 	}
 	
 	public function getPostUrl()
 	{
 		return $this->getUrl('gkacheckout/singlepage/startPost', array('_secure'=>true));
 	}
}
