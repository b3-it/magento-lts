<?php
/**
 * Sid ExportOrder_Transfer
 *
 *
 * @category   	Sid
 * @package    	Sid_ExportOrder
 * @name       	Sid_ExportOrder_Model_History
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_ExportOrder_Model_History extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('exportorder/history');
    }
    
   
    public static function createHistory($orderId,$message,$status = 0)
    {
    	if(is_array($orderId))
    	{
    		Mage::getModel('exportorder/history')->getResource()->createHistory($orderId,$message,$status);
    	}
    	else
    	{
	    	$model = Mage::getModel('exportorder/history');
	    	$model->setOrderId($orderId)
	    		->setMessage($message)
	    		->setUpdateTime(now())
	    		->setStatus($status);
	    	$model->save();
    	}
    }
}
