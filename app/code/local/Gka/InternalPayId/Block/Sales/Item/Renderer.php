<?php
class Gka_InternalPayId_Block_Sales_Item_Renderer extends Mage_Sales_Block_Order_Item_Renderer_Default
{
	
	public function getPayId(Mage_Sales_Model_Order_Item $item)
	{
		$br = $item->getBuyRequest();
		return $br->getPayId();
		
	}

}