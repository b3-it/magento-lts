<?php
/**
 * Egovs EventBundle
 *
 *
 * @category   	Egovs
 * @package    	Egovs_EventBundle
 * @name       	Egovs_EventBundle_Model_PersonalOption
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_EventBundle_Model_Personal_Fields extends Mage_Core_Model_Abstract
{
	static $configFields = null;
	
	
	static public function getconfigFields()
	{
		if(self::$configFields == null){
			self::$configFields = Mage::getConfig()->getNode('global/eventbundle_personal/fields')->asArray();
		}
		return self::$configFields;
	}
	static public function getOptionArray()
	{
		$res = array();
		
		foreach(self::getconfigFields() as $key => $field){
			$res[$key] = $field['label'];
		}
		
		return $res;
	}
	
	/**
	 * Retrieve option array with empty value
	 *
	 * @return array
	 */
	static public function getAllOption()
	{
		$options = self::getOptionArray();
		array_unshift($options, array('value'=>'', 'label'=>''));
		return $options;
	}
	
	/**
	 * Retrieve option array with empty value
	 *
	 * @return array
	 */
	static public function getAllOptions()
	{
		$res = array(
				array(
						'value' => '',
						'label' => Mage::helper('eventrequest')->__('-- Please Select --')
				)
		);
		foreach (self::getOptionArray() as $index => $value) {
			$res[] = array(
					'value' => $index,
					'label' => $value
			);
		}
		return $res;
	}
	
	/**
	 * Retrieve option text by option value
	 *
	 * @param string $optionId
	 * @return string
	 */
	static public function getOptionText($optionId)
	{
		$options = self::getOptionArray();
		return isset($options[$optionId]) ? $options[$optionId] : null;
	}
}
