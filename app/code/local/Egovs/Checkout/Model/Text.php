<?php
class Egovs_Checkout_Model_Text extends Mage_Checkout_Model_Type_Abstract
{
	public function getDatenschutztext()
	{
		if(Mage::getConfig()->getNode('default/checkout/datenschutz/enable_text')!= 1) return '';
		
		$page = Mage::getStoreConfig('checkout/datenschutz/cms_page');
		$page =  Mage::getUrl($page);
		return Mage::helper('mpcheckout')->__("Please take note of our <a href='%s'>privacy statement!</a>",$page);
	
				
	}
	
 	public function getAllOptions()
    {
    	return $this->toOptionArray();
    }
	
  	public function toOptionArray()
    {
    	$res = array();
        $collection = Mage::getModel('cms/page')->getCollection();
        $collection->distinct('identifier');
        $collection->load();
        foreach($collection->getItems() as $item)
        {
        	$res[] = array('value'=>$item->getData('identifier'),'label'=>$item->getData('identifier'));
        }
    	
    	return $res;
    }
}