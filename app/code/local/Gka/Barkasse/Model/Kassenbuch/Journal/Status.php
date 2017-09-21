<?php
/**
 *
 * @category   	Gka Barkasse
 * @package    	Gka_Barkasse
 * @name       	Gka_Barkasse_Model_Kassenbuch_Journal_Status
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Gka_Barkasse_Model_Kassenbuch_Journal_Status extends Mage_Core_Model_Abstract
{
    //const STATUS_NEW	= 1;
    const STATUS_OPEN	= 2;
    const STATUS_CLOSED	= 3;

    static public function getOptionArray()
    {
        return array(
            self::STATUS_OPEN    => Mage::helper('gka_barkasse')->__('open'),
            self::STATUS_CLOSED   => Mage::helper('gka_barkasse')->__('closed')
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
