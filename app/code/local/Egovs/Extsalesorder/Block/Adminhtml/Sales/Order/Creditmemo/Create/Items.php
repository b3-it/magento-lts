<?php
class Egovs_Extsalesorder_Block_Adminhtml_Sales_Order_Creditmemo_Create_Items extends Mage_Adminhtml_Block_Sales_Order_Creditmemo_Create_Items
{
    /**
     * Whether to show 'Return to stock' checkbox for item
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
}
