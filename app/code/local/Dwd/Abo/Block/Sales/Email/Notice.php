<?php
/**
 * Infoblock für Mails bei Bestellungen mit Abos
 *
 * Dieser Block muss wie folgt in ein Mail-Template eingefügt werden:
 * <pre>
 * {{block type="dwd_abo/sales_email_notice" order=$order}}
 * </pre>
 *
 * @category   	Dwd
 * @package    	Dwd_Abo
 * @author 		Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2013 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 */
class Dwd_Abo_Block_Sales_Email_Notice extends Mage_Core_Block_Template
{
	protected $_notices = null;
	
	protected function _toHtml() {
// 		$template = Mage::getStoreConfig('dwd_icd/email/sales_order_email_template');
		
		if (!$this->hasOrder()) {
			/* Für Vorschau */
			$this->_notices = array('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac lacus viverra, dapibus sem vel, eleifend nunc. Proin egestas mollis turpis. Nunc eu gravida sem.');
			return $this->_getBlockContent();
		}
		
		$notice = array();
		$productIds = array();
		foreach ($this->getOrder()->getAllItems() as $item ) {
			/* @var $item Mage_Sales_Model_Order_Item */
			if ($item->getProductType() == Dwd_ConfigurableVirtual_Model_Product_Type_Configurable::TYPE_CONFIGURABLE_VIRTUAL
				&& $item->getPeriodType() == Dwd_Periode_Model_Periode_Type::PERIOD_DURATION_ABO
			) {
				$productIds[] = $item->getProductId();
			}
		}
		/* @var $productCollection Mage_Catalog_Model_Resource_Product_Collection */
		if (!empty($productIds)) {
			$productCollection = Mage::getModel('catalog/product')->getCollection();
			$productCollection->addAttributeToSelect('infotext_block');
			$productCollection->addIdFilter($productIds);
			$productCollection->distinct(true);
// 			echo $productCollection->getSelectSql(true);
			foreach ($productCollection->getColumnValues('infotext_block') as $blockId) {
				if (empty($blockId)) {
					continue;
				}
				$block = Mage::getModel('cms/block')->load($blockId);
				if ($block->isEmpty() || !$block->getIsActive()) {
					continue;
				}
				
				$notices[] = $block->getContent();
			}
			$this->_notices = $notices;
			return $this->_getBlockContent();
		}
		return '';
	}
	
	/**
	 * Ersetzt die Platzhalter im Content
	 * 
	 * @return string
	 */
	protected function _getBlockContent() {
		/* @var $helper Mage_Cms_Helper_Data */
		$helper = Mage::helper('cms');
		$processor = $helper->getBlockTemplateProcessor();
		$html = '';
		foreach ($this->_notices as $notice) {
			$html .= $processor->filter($notice);
		}
		return $html;
	}
}