<?php
/**
 * Dwd Abo
 * 
 * 
 * @category   	Dwd
 * @package    	Dwd_Ibewi
 * @name       	Dwd_Ibewi_Model_Kostentraeger_Yesno
 * @author 		Holger K�gel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Ibewi_Model_Kostentraeger_Yesno extends Varien_Object
{
    const STATUS_YES	= 1;
    const STATUS_NO		= 0;
  

    static public function getOptionArray()
    {
        return array(
            self::STATUS_YES  => Mage::helper('adminhtml')->__('Yes'),
            self::STATUS_NO   => Mage::helper('adminhtml')->__('No'),
        );
    }
}