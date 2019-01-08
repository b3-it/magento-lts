<?php
/**
 * 
 *  @category Egovs
 *  @package  Bkg_License_Model_Type
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_License_Model_Type extends Varien_Object
{
    const TYPE_OFFLINE	= 0;
    const TYPE_ONLINE	= 1;
 

    static public function getOptionArray()
    {
        return array(
            self::TYPE_OFFLINE    => Mage::helper('bkg_license')->__('Offline'),
            self::TYPE_ONLINE   => Mage::helper('bkg_license')->__('Online'),
        	
        );
    }
}