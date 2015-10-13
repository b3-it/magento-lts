<?php
/**
 * 
 *-- TODO:: kurze Beschreibung --
 *
 *
 *
 * @category        	Egovs
 * @package         	Egovs_Ready
 * @name            	Egovs_Ready_Helper_Data
 * @author 			Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright      	Copyright (c) 2010 - 2015 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license        	http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 */
class Egovs_Ready_Helper_Data extends Mage_Core_Helper_Data
{
	public function getShippingCostUrl() {
		/** @var $cmsPage Mage_Cms_Model_Page */
		$cmsPage = Mage::getModel('cms/page')
			->setStoreId(Mage::app()->getStore()->getId())
			->load(Mage::getStoreConfig('catalog/price/cms_page_shipping'))
		;
	
		if (!$cmsPage->getId() || !$cmsPage->getIsActive()) {
			return '';
		}
	
		return Mage::helper('cms/page')->getPageUrl($cmsPage->getId());
	}
}