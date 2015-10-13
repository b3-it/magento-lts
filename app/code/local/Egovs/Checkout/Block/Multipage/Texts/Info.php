<?php
class Egovs_Checkout_Block_Multipage_Texts_Info extends Mage_Core_Block_Template
{
	public function getTexts()
	{
		$res = array();
		$texts = Mage::getModel('mpcheckout/cmsblock')->loadInfoTexts($this->__getItems(), Mage::app()->getStore()->getId());
		foreach($texts as $text)
		{
			$res[] = $this->__getText($text);
		}		
		return $res;
	}
	
	private function __getItems()
    {
    	$res = array();
		$items = Mage::getSingleton('checkout/session')->getQuote()->getAllVisibleItems();
		foreach($items as $item)
		{
			$res[] = $item->getData('product_id');
		}
		
		return $res;
    }
    
	private function __getText($id)
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
}