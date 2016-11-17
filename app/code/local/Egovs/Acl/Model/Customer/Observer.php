<?php

/**
 * Catalog product model
 *
 * @category   Egovs
 * @package    Egovs_Acl
 */
class Egovs_Acl_Model_Customer_Observer 
{

	
   public function onCustomerTabCanShow($observer)
   {
   		$tab = $observer->getEventdata()->getTab();
   		if($tab){
	   		$canShow = Mage::getSingleton('admin/session')->isAllowed('admin/customer/tabs/'.$tab->getId());
	   		$observer->getEventdata()->setCanShow($canShow);
   		}
   		
   }
   

   
   
	
}
