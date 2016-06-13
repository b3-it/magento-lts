<?php
/**
 * Bfr EventManager
 *
 *
 * @category   	Bfr
 * @package    	Bfr_EventManager
 * @name       	Bfr_EventManager_Model_Status
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_EventManager_Model_Event_Lang extends Varien_Object
{
    const de_DE	= 'de_DE';
    const en_US	= 'en_US';

    static public function getOptionArray()
    {
        return array(
            self::de_DE    => Mage::helper('eventmanager')->__('Deutsch'),
            self::en_US   => Mage::helper('eventmanager')->__('Englisch')
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
          'label' => Mage::helper('eventmanager')->__('-- Please Select --')
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
