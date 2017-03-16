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
class Sid_ExportOrder_Model_Resource_Link extends Mage_Core_Model_Resource_Db_Abstract
{
    public function _construct()
    {
        // Note that the exportorder_transfer_email_id refers to the key field in your database table.
        $this->_init('exportorder/link', 'id');
    }
    
    
    
    public function saveOrderIds($object, $orderIds)
    {
    	$write = $this->_getWriteAdapter();
    	$data = array();
    	foreach($orderIds as $id)
    	{
    		$data[] = array('link_id'=>$object->getId(),'order_id'=>$id);
    	}
    	$write->insertMultiple($this->getTable('exportorder/link_order'), $data);
    }
    
    public function saveOrderStatus($object, $orderIds, $status, $message)
    {
    	$read = $this->_getWriteAdapter();
    	$orderIds = implode(',', $orderIds);
    	$read->update($this->getTable('exportorder/order'), array('message'=>$message, 'status' => $status,'update_time'=>now()), 'order_id IN('.$orderIds.')' );
    }
    
   
}
