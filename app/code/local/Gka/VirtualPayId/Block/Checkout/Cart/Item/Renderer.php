<?php

class Gka_VirtualPayId_Block_Checkout_Cart_Item_Renderer extends Mage_Checkout_Block_Cart_Item_Renderer
{

   public function getPayId($item)
   {
	   	if($item->getProduct())
	   	{
	   		$pay_id = $item->getProduct()->getCustomOption('pay_id');
	   		return $pay_id->getValue();
	   	}
	   	return "";
   } 

   
}
