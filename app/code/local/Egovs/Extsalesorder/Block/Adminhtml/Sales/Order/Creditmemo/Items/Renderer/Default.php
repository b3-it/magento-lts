<?php
class Egovs_Extsalesorder_Block_Adminhtml_Sales_Order_Creditmemo_Items_Renderer_Default extends Mage_Adminhtml_Block_Sales_Items_Renderer_Default
{
	/**
	 * Prüft ob der Status der Checkbox 'Zurück ins Lager' verändert werden darf
	 * 
	 * @param Mage_Sales_Model_Order_Creditmemo_Item $item Item
	 * 
	 * @return bool
	 */
	public function canReturnItemToStock($item=null) {
		$canReturnToStock = parent::canReturnItemToStock($item);
    	
    	if (!$item)
    		return $canReturnToStock;
    	
    	if ($item->getOrderItem()->getQtyShipped() > 0) {
    		return $canReturnToStock & true;
    	}
    	
    	return false;
	}
	
	/**
	 * Check availability to edit quantity of item
	 *
	 * @return boolean
	 */
	public function xcanEditQty()
	{
		
		$canEditQty = parent::canEditQty();
		
		$item = $this->getItem();
		
		if (!$item)
			return $canEditQty;
		 
		if ($item->getOrderItem()->getQtyShipped() > 0) {
			return $canEditQty & true;
		}
		 
		return false;
	}
	
	/**
	 * Check if item is shipped
	 *
	 * @return boolean
	 */
	public function isShipped()
	{
		$item = $this->getItem();
	
		if (!$item)
			return false;
			
		if ($item->getOrderItem()->getQtyShipped() > 0) {
			return true;
		}
			
		return false;
	}
}