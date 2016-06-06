<?php
/**
 * 
 *  Für Produkte mit Zulassungsbeschränkung muss 
 *  der Button zur Kassen ersetzt werden
 *  @category Egovs
 *  @package  Egovs_Checkout_Block_Cart_Cart
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_EventRequest_Block_Checkout_Cart extends Egovs_Checkout_Block_Cart_Cart
{
	
    
 	public function isEventRequest(){
 		$customer = Mage::getSingleton('customer/session')->getCustomer();
 		$customer_id = 0;
    	if ($customer && $customer->getId()) {
    		$customer_id = $customer->getId();
    	}
 		foreach($this->getItems() as $item){
 			if($item->getProduct()->getEventrequest())
 			{
 				$request = Mage::getModel('eventrequest/request')->loadByCustomerAndProduct($customer_id, $item->getProduct()->getId());
 				if($request->isAccepted()){
 					return false;
 				}
 				return true;
 			}
 		}
 		
 		return false;
 	}
 
 	public function getRegistrationUrl()
 	{
 		return $this->getUrl('eventrequest/index');
 	}
 	
    
}
