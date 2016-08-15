<?php
/**
 * Bfr Mach
 *
 *
 * @category   	Bfr
 * @package    	Bfr_Mach
 * @name       	Bfr_Mach_Model_Resource_History
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_Mach_Model_Resource_History extends Mage_Core_Model_Resource_Db_Abstract
{
    public function _construct()
    {
        // Note that the mach_history_id refers to the key field in your database table.
        $this->_init('bfr_mach/history', 'mach_history_id');
    }
    
    
    //alle gleichzeitig einfügen
    public function saveHistory($orderIds, $user, $ExportType)
    {
    	$this->_getWriteAdapter()->update('mach_history', array('deprecated' => '1'), 'order_id IN ('.implode(',',$orderIds).') AND export_type ='. $ExportType);
    	
    	foreach ($orderIds as $order)
    	{
    		$data[] = array('user'=>$user,'order_id'=>$order, 'export_type' => $ExportType, 'created_time' => now(), 'update_time' => now());
    	}
    	
    	$this->_getWriteAdapter()->insertMultiple('mach_history', $data);
    }
}
