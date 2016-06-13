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
class Bfr_EventManager_Model_Lookup_Typ extends Varien_Object
{
    const TYPE_ROLE		= 1;
    const TYPE_JOB		= 2;
    const TYPE_LOBBY	= 3;
    const TYPE_INDUSTRY	= 4;

    static public function getOptionArray()
    {
        return array(
            self::TYPE_ROLE    => Mage::helper('eventmanager')->__('Role'),
            self::TYPE_JOB   => Mage::helper('eventmanager')->__('Job'),
            self::TYPE_LOBBY   => Mage::helper('eventmanager')->__('Lobby'),
            self::TYPE_INDUSTRY   => Mage::helper('eventmanager')->__('Industry')
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
