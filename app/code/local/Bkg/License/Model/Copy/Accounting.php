<?php
/**
 * 
 *  @category Egovs
 *  @package  Bkg_License_Model_Copy_Accounting
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_License_Model_Copy_Accounting extends Varien_Object
{
    const MODE_FLATRATE	= 0;
    const MODE_CONSUMPTION	= 1;




    static public function getOptionArray()
    {
        return array(
            self::MODE_FLATRATE	    => Mage::helper('bkg_license')->__('Flat-Rate'),
            self::MODE_CONSUMPTION		    => Mage::helper('bkg_license')->__('On Cunsumption'),

        );
    }
}