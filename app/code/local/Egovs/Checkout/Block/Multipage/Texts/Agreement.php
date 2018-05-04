<?php
class Egovs_Checkout_Block_Multipage_Texts_Agreement extends Mage_Core_Block_Template
{
	public function getItems()
	{
		$res = array();

		$texts = Mage::getModel('mpcheckout/cmsblock')->loadAgreementTexts($this->__getItems(), Mage::app()->getStore()->getId());
		$data=array();
		$data['texts'] = $texts;
		Mage::dispatchEvent('Agreement_Texts_Load_After',$data);
		
		$texts = $data['texts'];
		foreach($texts as $text)
		{
			$res[] = array('value'=>$text,'content'=> $this->__getText($text));
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