<?php 

class Egovs_Import_Model_Sourcetype extends Varien_Object
{
    const MODUS_MAGENTO13	= 1;
    const MODUS_MAGENTO16	= 2;
    

    static public function getOptionArray()
    {
        return array(
            self::MODUS_MAGENTO13    => 'Magento 1.3',
            self::MODUS_MAGENTO16   => 'Magento 1.6',
        );
    }

}