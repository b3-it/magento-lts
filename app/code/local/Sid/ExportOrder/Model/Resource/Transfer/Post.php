<?php
/**
 * Sid ExportOrder_Transfer
 *
 *
 * @category   	Sid
 * @package    	Sid_ExportOrder_Transfer
 * @name       	Sid_ExportOrder_Transfer_Model_Resource_Post
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_ExportOrder_Model_Resource_Transfer_Post extends Mage_Core_Model_Resource_Db_Abstract
{
    public function _construct()
    {
        // Note that the exportorder_transfer_post_id refers to the key field in your database table.
        $this->_init('exportorder/transfer_post', 'id');
    }
}
