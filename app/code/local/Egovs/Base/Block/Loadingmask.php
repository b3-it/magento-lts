<?php
class Egovs_Base_Block_Loadingmask extends Mage_Core_Block_Template {
	
	protected function _toHtml() {
		if (!Mage::getStoreConfig('dev/debug/security_filter')) {
			return '';
		}
		
		return parent::_toHtml();
	}
}