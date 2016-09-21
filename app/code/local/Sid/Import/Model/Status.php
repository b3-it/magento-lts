<?php
/**
 * Sid Import
 *
 *
 * @category   	Sid
 * @package    	Sid_Import
 * @name       	Sid_Import_Model_Status
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_Import_Model_Status extends Varien_Object
{
    const STATUS_NEW	= 0;
    const STATUS_IMPORTED	= 1;

    static public function getOptionArray()
    {
        return array(
            self::STATUS_NEW    => Mage::helper('sidimport')->__('New'),
            self::STATUS_IMPORTED   => Mage::helper('sidimport')->__('Imported')
        );
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
          'label' => Mage::helper('sidimport')->__('-- Please Select --')
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
