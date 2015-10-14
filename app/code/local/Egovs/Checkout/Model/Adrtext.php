<?php
class Egovs_Checkout_Model_Adrtext extends Mage_Checkout_Model_Type_Abstract
{
	public function getBillingtext()
	{
		if(Mage::getConfig()->getNode('default/checkout/adrtext/enable_billing_text')!= 1) return '';
		$id = Mage::getStoreConfig('checkout/adrtext/billing_block');	
		return $this->getText($id);
	
				
	}
	
	public function getShippingtext()
	{
		if(Mage::getConfig()->getNode('default/checkout/adrtext/enable_shipping_text')!= 1) return '';
		$id = Mage::getStoreConfig('checkout/adrtext/shipping_block');	
		return $this->getText($id);
				
	}
	
	
	private function getText($id)
	{
		$block = Mage::getModel('cms/block')
                ->setStoreId(Mage::app()->getStore()->getId())
                ->load($id);
        if($block == null) return '';
            if (!$block->getIsActive()) {
                $res = '';
            } else {
                $res = $block->getContent();
            }
		
		return $res;
	}
	
	
  	public function toOptionArray()
    {
    	$res = array();
        $collection = Mage::getModel('cms/block')->getCollection();
        $collection->distinct('identifier');
        $collection->load();
        foreach($collection->getItems() as $item)
        {
        	$res[] = array('value'=>$item->getData('identifier'),'label'=>$item->getData('identifier'));
        }
    	
    	return $res;
    }
}