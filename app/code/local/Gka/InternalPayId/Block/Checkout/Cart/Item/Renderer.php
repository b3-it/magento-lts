<?php

class Gka_InternalPayId_Block_Checkout_Cart_Item_Renderer extends Mage_Checkout_Block_Cart_Item_Renderer
{

   public function getPayId($item)
   {
	   	if($item->getProduct())
	   	{
	   		$pay_client = $item->getProduct()->getCustomOption('pay_client');
	   		$pay_id = $item->getProduct()->getCustomOption('pay_id');
	   		if(!empty($pay_id) && !empty($pay_client)){
	   			return "{$pay_client->getValue()}/{$pay_id->getValue()}";
	   		}
	   		if($pay_id){
	   			return $pay_id->getValue();
	   		}
	   	}
	   	return "";
   } 

   
}
