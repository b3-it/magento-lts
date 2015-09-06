<?php
/**
 * Egovs Infoletter
 *
 *
 * @category   	Egovs
 * @package    	Egovs_Infoletter
 * @name       	Egovs_Infoletter_Model_Resource_Recipient
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Infoletter_Model_Resource_Recipient extends Mage_Core_Model_Resource_Db_Abstract
{
    public function _construct()
    {
        // Note that the infoletter_recipient_id refers to the key field in your database table.
        $this->_init('infoletter/recipient', 'recipient_id');
    }
}
