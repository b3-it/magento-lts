<?php
/**
 * Register Block für Customer
 *
 * @category	Egovs
 * @package		Egovs_Base
 * @author		Frank Fochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2012 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2012 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Base_Block_Customer_Form_Register extends Mage_Customer_Block_Form_Register
{
	public function isFieldRequired($key) {
		$helper = null;
		try {
			$helper = $this->helper('mpcheckout/config');
		} catch (Exception $e) {
		}
		
		if (is_null($helper)) {
			return false;
		}
		 
		return ($helper->isFieldRequired($key, 'register'));
	}
	
	public function getFieldRequiredHtml($name) {
		if($this->isFieldRequired($name)) {
			return '<span class="required">*</span>';
		}
		return '';
	}
	
	public function isFieldVisible($key) {
		$helper = null;
		try {
			$helper = $this->helper('mpcheckout/config');
		} catch (Exception $e) {
		}
		
		if (is_null($helper)) {
			return true;
		}
		
		return ($helper->getConfig($key, 'register') != '');
			
	}
	
	public function getCountryHtmlSelect($defValue=null, $name='country_id', $id='country', $title='Country') {
		Varien_Profiler::start('TEST: '.__METHOD__);
		if (is_null($defValue)) {
			$defValue = $this->getCountryId();
		}
		$cacheKey = 'DIRECTORY_COUNTRY_SELECT_STORE_'.Mage::app()->getStore()->getCode();
		if (Mage::app()->useCache('config') && $cache = Mage::app()->loadCache($cacheKey)) {
			$options = unserialize($cache);
		} else {
			$options = $this->getCountryCollection()->toOptionArray();
			if (Mage::app()->useCache('config')) {
				Mage::app()->saveCache(serialize($options), $cacheKey, array('config'));
			}
		}
		$html = $this->getLayout()->createBlock('core/html_select')
			->setName($name)
			->setId($id)
			->setTitle(Mage::helper('directory')->__($title))
			->setClass($this->isFieldRequired($name) ? 'validate-select' : '')
			->setValue($defValue)
			->setOptions($options)
			->getHtml();
	
		Varien_Profiler::stop('TEST: '.__METHOD__);
		return $html;
	}
}
