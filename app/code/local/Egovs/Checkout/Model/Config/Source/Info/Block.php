<?php
class Egovs_Checkout_Model_Config_Source_Info_Block extends Mage_Checkout_Model_Type_Abstract
{
	public function getDatenschutztext()
	{
		if(Mage::getConfig()->getNode('default/checkout/datenschutz/enable_text')!= 1) return '';
		
		$page = Mage::getStoreConfig('checkout/datenschutz/cms_page');
		$page =  Mage::getUrl($page);
		return Mage::helper('mpcheckout')->__('Bitte beachten Sie die <a target="blank" href="%s">Bestimmungen zum Datenschutz!</a>',$page);
	
				
	}
	
 	public function getAllOptions()
    {
    	return $this->toOptionArray();
    }
	
  	public function toOptionArray()
    {
    	$res = array();
        $collection = Mage::getModel('cms/block')->getCollection();
        $collection->distinct('identifier');
        $collection->load();
        $res[] = array('value'=>'','label'=>'');
        foreach($collection->getItems() as $item)
        {
        	$res[] = array('value'=>$item->getData('identifier'),'label'=>$item->getData('identifier'));
        }
    	
        
    	return $res;
    }
}