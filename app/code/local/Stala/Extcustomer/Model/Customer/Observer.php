<?php

class Stala_Extcustomer_Model_Customer_Observer 
{



	public function copyParentAddress($observer)
	{
		try 
		{
			$customer = $observer['customer'];
			$request = $observer['request'];
			$post = $request->getParam('account');
			if($post === null) return ;
			
			if(!key_exists('parent_customer_copy_address', $post)) return;
			
			
			$parentid = $post['parent_customer_id'];
			if($parentid == null) 
			{
				//Mage::throwException(Mage::helper('extcustomer')->__('Can not copy Address without Parent Customer'));
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('extcustomer')->__('Can not copy Address without Parent Customer'));
				return;
			}
			
			$parent = Mage::getModel('customer/customer')->load($parentid);
			
			$parentadr = $parent->getDefaultBillingAddress();
			
			if(!$parentadr)
			{
				$adresses = $parent->getAddresses();
				if(count($adresses) > 0)
				{
					$parentadr = array_shift($adresses);
				}
				else 
				{
					Mage::getSingleton('adminhtml/session')->addError(Mage::helper('extcustomer')->__('No Parent Address found'));
					return;
				}
			}
			
			$parentadr->unsetData('entity_id');
			$parentadr->unsetData('parent_id');
			$customer->addAddress($parentadr);
		}
		
		catch (Exception $e)
		{
			Mage::log("extcustomer::".$e->getMessage(), Zend_Log::NOTICE, Egovs_Helper::EXCEPTION_LOG_FILE);
			Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			
		}
		
	}
}

?>