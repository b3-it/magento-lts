<?php
/**
 * Bfr EventRequest Status
 *
 *
 * @category   	Bfr
 * @package    	Bfr_EventRequest
 * @name       	Bfr_EventRequest_Model_Status
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_EventRequest_Model_Status extends Varien_Object
{
    const STATUS_REQUESTED	= 1;
    const STATUS_ACCEPTED	= 2;
    const STATUS_REJECTED	= 3;
    const STATUS_ORDERED	= 4;
    //const STATUS_CANCELED	= 5;

    static public function getOptionArray()
    {
        return array(
            self::STATUS_REQUESTED    => Mage::helper('eventrequest')->__('Requested'),
            self::STATUS_ACCEPTED   => Mage::helper('eventrequest')->__('Accepted'),
            self::STATUS_REJECTED   => Mage::helper('eventrequest')->__('Rejected'),
            self::STATUS_ORDERED   => Mage::helper('eventrequest')->__('Ordered'),
        	//self::STATUS_CANCELED   => Mage::helper('eventrequest')->__('Canceled')
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
static public function getAllOptions($hideOrderStatus = false)
{
  $res = array(
      array(
          'value' => '',
          'label' => Mage::helper('eventrequest')->__('-- Please Select --')
      )
  );
  foreach (self::getOptionArray() as $index => $value) {
  	if(!$hideOrderStatus || ($index < self::STATUS_ORDERED))
  	{
	    $res[] = array(
	        'value' => $index,
	        'label' => $value
	    );
  	}
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
