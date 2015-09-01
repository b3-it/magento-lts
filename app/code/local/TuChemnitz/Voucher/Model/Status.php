<?php
/**
 * Tuc Status
 * 
 * 
 * @category   	TuC
 * @package    	Tuc_Voucher
 * @name       	Tuc_Voucher_Model_Status
 * @author 		Holger K�gel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class TuChemnitz_Voucher_Model_Status extends Varien_Object
{
    const STATUS_NEW		= 1;
    const STATUS_SOLD		= 2;
    //const STATUS_SALES		= 3;
   
    static public function getOptionArray()
    {
        return array(
            self::STATUS_NEW    => Mage::helper('tucvoucher')->__('New'),
            self::STATUS_SOLD   => Mage::helper('tucvoucher')->__('Sold'),
        	//self::STATUS_SALES   => Mage::helper('tucvoucher')->__('Sold')
        );
    }
}