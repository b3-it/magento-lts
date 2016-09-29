<?php
/**
 * Sid ExportOrder_Transfer
 *
 *
 * @category   	Sid
 * @package    	Sid_ExportOrder_Transfer
 * @name       	Sid_ExportOrder_Transfer_Model_Resource_Email
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_ExportOrder_Model_Resource_History extends Mage_Core_Model_Resource_Db_Abstract
{
    public function _construct()
    {
        // Note that the exportorder_transfer_email_id refers to the key field in your database table.
        $this->_init('exportorder/history', 'id');
    }
    
    public function createHistory($orderIds,$message,$status = 0)
    {
    	if(count($orderIds) == 0){
    		return $this;
    	}
    	$write = $this->_getWriteAdapter();
    	$data = array();
    	foreach ($orderIds as $id){
    		$data[] = array('order_id'=>$id,'message'=>$message,'status'=>$status);
    	}
    	
    	$write->insertMultiple('exportorder/history', $data);
    	
    }

}
