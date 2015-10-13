<?php

class Egovs_Informationservice_Model_Status extends Varien_Object
{
    const STATUS_NEW	= 1;
    const STATUS_OFFER	= 2;
    const STATUS_WAITIG	= 3;
    const STATUS_PROCESSING	= 4;
    const STATUS_CLOSED	= 5;
    const STATUS_CANCELED	= 6;

    static public function getOptionArray()
    {
        return array(
            self::STATUS_NEW    => Mage::helper('informationservice')->__('New'),
            self::STATUS_OFFER   => Mage::helper('informationservice')->__('Offer'),
            self::STATUS_WAITIG   => Mage::helper('informationservice')->__('Waiting'),
            self::STATUS_PROCESSING   => Mage::helper('informationservice')->__('Processing'),
            self::STATUS_CLOSED   => Mage::helper('informationservice')->__('Closed'),
            self::STATUS_CANCELED   => Mage::helper('informationservice')->__('Canceled'),
        );
    }
}