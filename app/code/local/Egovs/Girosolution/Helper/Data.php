<?php
/**
 * Girosolution Helper Data
 * 
 * Überschreibt hier nur Egovs_Paymentbase_Helper_Data
 *
 * @category   	Egovs
 * @package    	Egovs_Girosolution
 * @name       	Egovs_Girosolution_Helper_Data
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Girosolution_Helper_Data extends Egovs_Paymentbase_Helper_Data
{
	public function getLanguageCode() {
		$result = 'de';
		$languageCode = Mage::getStoreConfig('general/locale/code', Mage::app()->getStore()->getId());
		if(isset($languageCode)) {
			if(strlen($languageCode) > 2) {
				$languageCode = substr($languageCode, 0, 2);
				$result = strtolower($languageCode);
			}
		}
		return $result;
	}
}
