<?php
/**
 * 
 *  @category Bkg
 *  @package  Bkg_License_Model_Copy_Doctype
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */

class Bkg_License_Model_Copy_Doctype extends Varien_Object
{
  	const TYPE_HIDDEN	= 1;
  	const TYPE_DRAFT	= 2;
    const TYPE_FINAL	= 3;
  

    /**
     * Options getter
     *
     * @return array
     */
    static public function getOptionArray()
    {
        return array(
            self::TYPE_HIDDEN    => Mage::helper('bkg_license')->__('Hidden'),
            self::TYPE_DRAFT    => Mage::helper('bkg_license')->__('Draft'),
            self::TYPE_FINAL   => Mage::helper('bkg_license')->__('Final'),
        );
    }
}