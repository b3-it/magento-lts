<?php

class Stala_Abo_Model_Customer_Observer 
{


	
	
	//im BE warnen wenn eine Adresse verwendet wird
	public function testAddresses4Usage($customer_id, $block)
	{
		
		$collection = Mage::getModel('customer/address')->getCollection();
		$collection->addAttributeToSelect('company');
		$collection->addAttributeToSelect('company2');
		$collection->addAttributeToSelect('company3');
		$collection->addAttributeToSelect('firstname');
		$collection->addAttributeToSelect('lastname');
		$collection->addAttributeToSelect('street');
		$collection->addAttributeToSelect('city');
		$collection->addAttributeToSelect('postcode');
		
		$table = $collection->getTable('stalaabo/contract');
		$exp = new Zend_Db_Expr("select billing_address_id as address_id from $table WHERE is_deleted = 0 UNION select shipping_address_id as address_id from $table  WHERE is_deleted = 0");
		
	
		$collection->getSelect()
			->where('parent_id='.intval($customer_id))
			->where('(entity_id  in ('.$exp->__toString().' ))');
		
		//die($collection->getSelect()->__toString());
		
		foreach ($collection->getItems() as $item)
		{
			$street = $item->getStreet();
			if(is_array($street)) $street = implode(" ", $street);
			$text = Mage::helper('informationservice')->__('Following Address is used by subscribe contract:');
			$text .= " ". $item->getCompany()." ". $item->getCompany2()." ". $item->getCompany3()." ". $item->getFirstname()." ".$item->getLastname()." ".$street." ". $item->getCity()." ".$item->getPostcode();
			$block->getLayout()->getMessagesBlock()->addNotice($text);
		}
	}
	
	public function rejectAddressEditing($observer)
	{
		$block = $observer['block'];
		$address_id = intval($observer['address_id']);
		if ($address_id == 0)
		    return;

        if ($block instanceof Mage_Core_Block_Abstract)	{
			if (!$block->getAddressEditingIsDenied()) {
				$collection = Mage::getModel('stalaabo/contract')->getCollection();
				$collection->getSelect()->where('shipping_address_id='.$address_id .' OR billing_address_id='.$address_id);
				//echo ($collection->getSelect()->__toString());
				if (count($collection->getItems()) > 0) {
					$block->setAddressEditingIsDenied(true);
				}
			}	
		}
	}
}
