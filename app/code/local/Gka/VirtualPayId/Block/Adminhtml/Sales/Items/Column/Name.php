<?php

class Gka_VirtualPayId_Block_Adminhtml_Sales_Items_Column_Name extends Mage_Adminhtml_Block_Sales_Items_Column_Name
{
	public function getPayId(Mage_Sales_Model_Order_Item $item)
	{
		$br = $item->getBuyRequest();
		return $br->getPayId();
	
	}
}
?>
