<?php
/**
 *  TODO:: -- DOKU -- kurze Beschreibung einfügen
 *  @category Sid
 *  @package  Sid_Haushalt
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */ 
class Sid_Haushalt_IndexController extends Mage_Core_Controller_Front_Action
{
    public function saveaddinfoAction()
    {
    	$customerId = $this->getCustomerId();
    	
    	$additional = $this->getRequest()->getParam('additional');
		if((isset($additional)) && (is_array($additional))){
	  		foreach($additional as $orderId => $text)
	  		{
	  			$order = Mage::getModel('sales/order')->load(intval($orderId));
	  			if($customerId == $order->getCustomerId()){
	  				$order_info = Mage::getModel('sidhaushalt/order_info')->load($order->getId(), 'order_id');
	  				$order_info
	  					->setOrderId($order->getId())
	  					->setAdditionalInfo($text)
	  					->save();
	  				
	  			}
	  		}
		}
		
		Mage::getSingleton('customer/session')->addSuccess($this->__('Additional data has been saved!'));
		$this->_redirect('');
		
		
    }
    
    private function getCustomerId()
    {
    	$customer = Mage::getSingleton('customer/session')->getCustomer();
    	return $customer->getId();
    }
}