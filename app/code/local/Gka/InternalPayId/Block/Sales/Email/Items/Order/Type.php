<?php

class Gka_InternalPayId_Block_Sales_Email_Items_Order_Type extends Mage_Sales_Block_Order_Email_Items_Order_Default
{
	public function getPayId(Mage_Sales_Model_Order_Item $item)
	{
		$br = $item->getBuyRequest();
		return $br->getPayId();
	
	}
}
