<?php

class Sid_Wishlist_Model_Status extends Varien_Object
{
    const STATUS_ENABLED	= 1;
    const STATUS_DISABLED	= 2;
    const STATUS_SHARED		= 3;
    const STATUS_REVIEW		= 4;
    const STATUS_COMPLETE		= 5;

    static public function getOptionArray()
    {
        return array(
            self::STATUS_ENABLED    => Mage::helper('sidwishlist')->__('Enabled'),
            self::STATUS_DISABLED   => Mage::helper('sidwishlist')->__('Disabled'),
        	self::STATUS_SHARED   => Mage::helper('sidwishlist')->__('Shared'),
        	self::STATUS_REVIEW   => Mage::helper('sidwishlist')->__('Review'),
        	self::STATUS_COMPLETE   => Mage::helper('sidwishlist')->__('Complete'),
        );
    }
}