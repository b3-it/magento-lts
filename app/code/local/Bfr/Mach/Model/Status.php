<?php
/**
 * Bfr Mach
 *
 *
 * @category   	Bfr
 * @package    	Bfr_Mach
 * @name       	Bfr_Mach_Model_Status
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_Mach_Model_Status extends Varien_Object
{
    const STATUS_ENABLED	= 1;
    const STATUS_DISABLED	= 2;

    static public function getOptionArray()
    {
        return array(
            self::STATUS_ENABLED    => Mage::helper('bfr_mach')->__('Enabled'),
            self::STATUS_DISABLED   => Mage::helper('bfr_mach')->__('Disabled')
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
          'label' => Mage::helper('bfr_mach')->__('-- Please Select --')
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
