<?php
class Dwd_Icd_Block_Sales_Email_Icd extends Mage_Core_Block_Template
{
	protected $_block = null;
	
	protected function _toHtml()
	{
		//$block = Mage::getModel('cms/block')->load('block_id','footer_links_backup');
		$template = Mage::getStoreConfig('dwd_icd/email/sales_order_email_template');
		
		$this->_block = Mage::getModel('cms/block')
			//->setStoreId($store_id)
			->load($template);
		
		if (!$this->_block->getIsActive()) {
			return '';
		}
		
		if (!$this->hasOrder()) {
			/* Für Vorschau */
			return $this->_getBlockContent();
		}
		
		foreach ($this->getOrder()->getAllItems() as $item ) {
			if ($item->getProductType() == Dwd_ConfigurableVirtual_Model_Product_Type_Configurable::TYPE_CONFIGURABLE_VIRTUAL) {
				if($item->getProduct()->getIcdUse())
				{
					return $this->_getBlockContent();
				}
			}
		}
		
		return '';
	}
	
	protected function _getBlockContent() {
		/* @var $helper Mage_Cms_Helper_Data */
		$helper = Mage::helper('cms');
		$processor = $helper->getBlockTemplateProcessor();
		$html = $processor->filter($this->_block->getContent());
		return $html;
	}
}