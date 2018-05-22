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
    
    /**
     * (non-PHPdoc)
     * @see Sid_ExportOrder_Model_Transfer::send()
     */
    public function send($content, $order = null, $data = array(), $storeId = 0)
    {
    	$recipients = array();
    	$recipients[] = array('name' => $this->getEmail(), 'email' => $this->getEmail());
    	$data['content'] = $content;
    	$res = Mage::helper('exportorder')->sendEmail($this->getTemplate(),$recipients,$data,$storeId);
    	
    	if($res !== false){
    		$txt = "Die Email wurde versendet.";
    		$res = $txt;
    	}else{
    		$txt = "Fehler: Die Email wurde nicht versendet.";
    	}
    	Sid_ExportOrder_Model_History::createHistory($order->getId(), $txt);
    	return $res;
    }
    
    protected function _beforeSave()
    {
    	if(empty($this->getTemplate())){
    		$this->setTemplate('exportorder/email/vendor_order_plain');
    	}
    }
}
