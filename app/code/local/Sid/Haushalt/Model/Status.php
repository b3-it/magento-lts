<?php
/**
 *  Statusklasse für Haushalt
 *  @category Sid
 *  @package  Sid_Haushalt
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */ 
class Sid_Haushalt_Model_Status extends Varien_Object
{
    const STATUS_ENABLED	= 1;
    const STATUS_DISABLED	= 2;

	/**
	 *	Optionen als Array Liste mit Bezeichner
	 */
    static public function getOptionArray()
    {
        return array(
            self::STATUS_ENABLED    => Mage::helper('haushalt')->__('Enabled'),
            self::STATUS_DISABLED   => Mage::helper('haushalt')->__('Disabled')
        );
    }
}