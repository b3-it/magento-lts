<?php
/**
 * Dwd Abo
 * 
 * 
 * @category   	Dwd
 * @package    	Dwd_Abo
 * @name       	Dwd_Abo_Model_Status
 * @author 		Holger K�gel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Abo_Model_Renewalstatus extends Varien_Object
{
    const STATUS_PAUSE		= 1;
    const STATUS_REORDERD	= 2;
    const STATUS_EMAIL_SEND	= 3;
    const STATUS_ORDER_PENDING	= 4;

    static public function getOptionArray()
    {
        return array(
            self::STATUS_PAUSE    		=> Mage::helper('dwd_abo')->__('Pause'),
            self::STATUS_REORDERD   	=> Mage::helper('dwd_abo')->__('Reorderd'),
        	self::STATUS_EMAIL_SEND 	=> Mage::helper('dwd_abo')->__('Email sent'),
        	self::STATUS_ORDER_PENDING=> Mage::helper('dwd_abo')->__('in Bestellung')
        );
    }
}