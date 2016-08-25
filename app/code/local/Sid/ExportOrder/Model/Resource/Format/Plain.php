<?php
/**
 * Sid ExportOrder_Format
 *
 *
 * @category   	Sid
 * @package    	Sid_ExportOrder_Format
 * @name       	Sid_ExportOrder_Format_Model_Resource_Plain
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_ExportOrder_Model_Resource_Format_Plain extends Mage_Core_Model_Resource_Db_Abstract
{
    public function _construct()
    {
        // Note that the exportorder_format_plain_id refers to the key field in your database table.
        $this->_init('exportorder/format_plain', 'id');
    }
}
