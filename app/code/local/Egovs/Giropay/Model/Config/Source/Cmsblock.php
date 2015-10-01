<?php
class Egovs_Giropay_Model_Config_Source_Cmsblock
{
	public function toOptionArray() {
    	$res = array();
        $collection = Mage::getModel('cms/block')->getCollection();
        $collection->distinct('identifier');
        $collection->load();
        $res[] = array('value' => '', 'label' => Mage::helper('giropay')->__('No custom info'));
        $_config = Mage::getConfig()->getModuleConfig('Egovs_Giropay');
        if (version_compare($_config->version, '2.1', '>=')) {
	        foreach($collection->getItems() as $item) {
	        	$res[] = array('value'=>$item->getData('identifier'),'label'=>$item->getData('identifier'));
	        }
        }
    	
    	return $res;
    }
}