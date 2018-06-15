<?php
/**
 *
 * @category   	B3it Ids
 * @package    	B3it_Ids
 * @name       	B3it_Ids_Model_Dos_Url
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Ids_Model_Dos_Action extends Mage_Core_Model_Abstract
{

    const ACTION_DIE	        = 0;
    const ACTION_THROTTLE_20	= 1;
    const ACTION_THROTTLE_40	= 2;
    const ACTION_THROTTLE_60	= 3;


    static public function getOptionArray()
    {
        return array(
            self::ACTION_DIE    => Mage::helper('b3it_ids')->__('die'),
            self::ACTION_THROTTLE_20   => Mage::helper('b3it_ids')->__('throttle 20s'),
            self::ACTION_THROTTLE_40   => Mage::helper('b3it_ids')->__('throttle 40s'),
            self::ACTION_THROTTLE_60   => Mage::helper('b3it_ids')->__('throttle 60s')
        );
    }



/**
 * Retrieve option array with empty value
 *
 * @return array
 */
static public function getAllOptions($addEmpty = true)
{
	
  $res = array();
  
  if($addEmpty){
	  	$res[] =  array(
	          'value' => '',
	          'label' => Mage::helper('gka_barkasse')->__('-- Please Select --')
	      );

  }
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
