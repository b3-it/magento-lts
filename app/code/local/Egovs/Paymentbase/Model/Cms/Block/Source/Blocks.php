<?php
/**
 * Source Model für CMS Blöcke
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2013 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Model_Cms_Block_Source_Blocks
{
	/**
	 * Erstellt ein Option Array
	 * 
	 * @return array
	 */
	public function toOptionArray() {
		$options = Mage::getResourceModel('cms/block_collection')->toOptionArray();
		
		$ea = array(
				array(
				'value' => 0,
				'label'	=> Mage::helper('paymentbase')->__('No custom block')
		));
		
		return array_merge($ea, $options);
	}
}