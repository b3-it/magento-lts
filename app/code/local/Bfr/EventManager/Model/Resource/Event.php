<?php
/**
 * Bfr EventManager
 *
 *
 * @category   	Bfr
 * @package    	Bfr_EventManager
 * @name       	Bfr_EventManager_Model_Resource_Event
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_EventManager_Model_Resource_Event extends Mage_Core_Model_Resource_Db_Abstract
{
    public function _construct()
    {
        // Note that the eventmanager_event_id refers to the key field in your database table.
        $this->_init('eventmanager/event', 'event_id');
    }


    public function removeQuoteItemOptions($product_id)
    {
        if(!$product_id) return;
        $write = $this->_getWriteAdapter();
        $table = $this->getTable('sales/quote_item_option');
        if($write)
        {
            $write->delete($table," product_id = $product_id and code like 'option_%'");
        }
    }
}
