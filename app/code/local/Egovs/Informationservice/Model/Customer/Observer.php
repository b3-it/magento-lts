<?php
class Egovs_Informationservice_Model_Customer_Observer
{
	public function rejectAddressEditing($observer) {
		$block = $observer ['block'];
		$address_id = intval ( $observer ['address_id'] );
		if ($address_id == 0)
			return;
		
		if (($block instanceof Egovs_Base_Block_Customer_Address_Book) || ($block instanceof Egovs_Base_Block_Customer_Account_Dashboard_Address)) {
			if (! $block->AddressEditingIsDenied) {
				$collection = Mage::getModel ( 'informationservice/request' )->getCollection ();
				$collection->getSelect ()->where ( 'address_id=' . $address_id );
				// echo ($collection->getSelect()->__toString());
				if (count ( $collection->getItems () ) > 0) {
					$block->AddressEditingIsDenied = true;
				}
			}
		}
	}
}