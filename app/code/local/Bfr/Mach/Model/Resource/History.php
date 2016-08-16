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
    public function saveHistory($orderIds, $user, $ExportType, $Lauf)
    {
    	$this->_getWriteAdapter()->update('mach_history', array('deprecated' => '1'), 'order_id IN ('.implode(',',$orderIds).') AND export_type ='. $ExportType);
    	
    	foreach ($orderIds as $order)
    	{
    		$data[] = array('user'=>$user,'order_id'=>$order, 'export_type' => $ExportType, 'created_time' => now(), 'update_time' => now(),'lauf'=>$Lauf);
    	}
    	
    	$this->_getWriteAdapter()->insertMultiple('mach_history', $data);
    }
    
    //alle gleichzeitig einfügen
    public function getLastLauf()
    {
    	$read = $this->_getReadAdapter();
        if ($read) 
        {
	    	$select = $this->_getReadAdapter()->select()
	            ->from($this->getTable('bfr_mach/history'))
	            ->columns(new Zend_Db_Expr('max(lauf) as max_lauf'))
	            //->where( 'export_type ='. $ExportType)
	            ;
	            
	     	$data = $read->fetchRow($select);
			return intval($data['max_lauf']);
        }
        
    	return 0;
    	
    }
    
    //download Time setzten
    public function updateHistory($ExportType, $Lauf)
    {
    	$this->_getWriteAdapter()->update('mach_history', array('download_time' => now()), 'lauf = '.intval($Lauf).' AND export_type ='. $ExportType);
    }
    
    
    
}
