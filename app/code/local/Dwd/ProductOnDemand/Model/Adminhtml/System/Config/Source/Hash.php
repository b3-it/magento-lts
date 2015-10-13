<?php
class Dwd_ProductOnDemand_Model_Adminhtml_System_Config_Source_Hash
{
	public function toOptionArray() {
		$availableHashs = hash_algos();
		
		$options = array(
				array('value'=>'md5', 'label'=>Mage::helper('adminhtml')->__('MD5')),
				array('value'=>'sha1', 'label'=>Mage::helper('adminhtml')->__('SHA-1')),
				array('value'=>'sha256', 'label'=>Mage::helper('adminhtml')->__('SHA-2 (SHA-256)')),
		);
		
		foreach ($options as $i => $pair) {
			if (array_search($pair['value'], $availableHashs) !== false) {
				continue;
			}
			
			unset($options[$i]);
		}
		
		return $options;
	}
}