<?php
class Egovs_Checkout_Model_Cmsblock extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('mpcheckout/cmsblock');
    }
    
    
    public function loadAgreementTexts($productIds, $storeId=1)
    {
    	return $this->getResource()->loadAgreementTexts($productIds,$storeId);
    }
    
    public function loadInfoTexts($productIds, $storeId=1)
    {
    	return $this->getResource()->loadInfoTexts($productIds,$storeId);
    }
    
    public function loadAgreementIdsFromQuote($quote)
    {
  		$productIds = array();
		$items = $quote->getAllVisibleItems();
		foreach($items as $item)
		{
			$productIds[] = $item->getData('product_id');
		}
		
		$res = array();
		$blocks = $this->getResource()->loadAgreementTexts($productIds,Mage::app()->getStore()->getId());
		foreach($blocks as $block)
		{
			$res[] = $block;
		}
		return $res;	
    }
    
}