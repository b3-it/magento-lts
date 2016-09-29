<?php
/**
 * Sid ExportOrder_Transfer
 *
 *
 * @category   	Sid
 * @package    	Sid_ExportOrder_Transfer
 * @name       	Sid_ExportOrder_Transfer_Model_Email
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_ExportOrder_Model_Transfer_Email extends Sid_ExportOrder_Model_Transfer
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('exportorder/transfer_email');
    }
    
    public function send($content, $order = null)
    {
    	$recipients = array();
    	$recipients[] = array('name' => $this->getEmail(), 'email' => $this->getEmail());
    	Mage::helper('exportorder')->sendEmail($this->getTemplate(),$recipients,array('content' =>$content));
    	
    	Sid_ExportOrder_Model_History::createHistory($order->getId(), 'Email versendet');
    }
    
    protected function _beforeSave()
    {
    	if(empty($this->getTemplate())){
    		$this->setTemplate('exportorder/email/vendor_order_plain');
    	}
    }
}
