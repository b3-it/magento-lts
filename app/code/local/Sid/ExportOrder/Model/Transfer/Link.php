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
class Sid_ExportOrder_Model_Transfer_Link extends Sid_ExportOrder_Model_Transfer
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('exportorder/transfer_link');
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
    	$res = Mage::helper('exportorder')->sendEmail($this->getTemplate(),$recipients, $data, $storeId);
    	
    	if($res !== false){
    		$txt = "Der Link wurde versendet";
    		$res = $txt;
    	}else{
    		$txt = "Fehler: Der Link wurde nicht versendet";
    		
    	}
    	Sid_ExportOrder_Model_History::createHistory($order->getId(), $txt);
    	
    	return $res; 
    }
    
    
    public function sendOrders($content, $format = null, $orderIds, $vendor, $contract)
    {
    	if(is_object($vendor))
    	{
    		$vendorId = $vendor->getId();
    	}else{
    		$vendorId = $vendor;
    	}
    	
    	if ($format instanceof Sid_ExportOrder_Model_Format_Plain)
    	{
    		
    		$line_separator = $format->getLineSeparator() ? $format->getLineSeparator() : "\n";		 
    		$line_separator = $this->_fitEscape($line_separator);
    		$lines = implode($line_separator, $content);
    		$link = Sid_ExportOrder_Model_Link::create($vendorId);
    		$link->setFilename($link->getId().'.txt');
    		$link->setSendFilename('Orders_'.date('d-m-Y_H-i-s').'.txt');
    		$link->save();
    		file_put_contents($link->getDirectory().$link->getFilename(),$lines);
    		$link->saveOrderIds($orderIds);
    		$link->saveOrderStatus($orderIds, Sid_ExportOrder_Model_Syncstatus::SYNCSTATUS_SUCCESS);
    	}
    	
    	if ($format instanceof Sid_ExportOrder_Model_Format_Opentrans)
    	{
    		$link = Sid_ExportOrder_Model_Link::create($vendorId);
    		$link->setFilename($link->getId().'.zip');
    		$link->setSendFilename('Orders_'.date('d-m-Y_H-i-s').'.zip');
    		$link->save();
    		
    		$zip = new ZipArchive();
    		$res = $zip->open($link->getDirectory().$link->getFilename(), ZipArchive::CREATE);
    		if ($res === TRUE) {
    			foreach($content as $name => $xml)
    			{
    				$zip->addFromString($name.'.xml', $xml);
    			}
    			$zip->close();
    			
    		} 
    		
    		$link->saveOrderIds($orderIds);
    		
    	}
    	
    	$res = null;
    	
    	if($link)
    	{
    		$recipients = array();
    		$recipients[] = array('name' => $this->getEmail(), 'email' => $this->getEmail());
    		Sid_ExportOrder_Model_History::createHistory($orderIds, 'Link erzeugt');
    		$order= $contract->getOrder();
    		$storeId = 0;
    		if($order){
    			$storeId = $order->getStoreId();
    		}
    		$res = Mage::helper('exportorder')->sendEmail($this->getTemplate(),$recipients,array('link' =>$link->getUrl(),'contract'=>$contract),$storeId);
    		if($res === false){
    			$link->saveOrderStatus($orderIds, Sid_ExportOrder_Model_Syncstatus::SYNCSTATUS_ERROR, $res);
    			Sid_ExportOrder_Model_History::createHistory($orderIds, 'Email mit Link nicht versendet', Sid_ExportOrder_Model_Syncstatus::SYNCSTATUS_ERROR);
    		}else{
    			$res = 'Email mit Link versendet';
    			$link->saveOrderStatus($orderIds, Sid_ExportOrder_Model_Syncstatus::SYNCSTATUS_SUCCESS,$res);
    			Sid_ExportOrder_Model_History::createHistory($orderIds, 'Email mit Link versendet',  Sid_ExportOrder_Model_Syncstatus::SYNCSTATUS_SUCCESS);
    			
    		}
    	}
    	
    	return $res;
    
    }
    
    
    protected function _beforeSave()
    {
    	if(empty($this->getTemplate())){
    		$this->setTemplate('exportorder/email/vendor_order_plain');
    	}
    }
    
    public function canSend()
    {
    	return false;
    }
    

    private function _fitEscape($value)
    {
    	if($value == '\\t') return "\t";
    	if($value == '\\n') return "\n";
    	if($value == '\\r') return "\r";
    	 
    	return $value;
    }
   
}
