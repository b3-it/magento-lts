<?php
class Egovs_Informationservice_Model_Customer_Observer
{
	public function rejectAddressEditing($observer) {
		$block = $observer ['block'];
		$address_id = intval ( $observer ['address_id'] );
		if ($address_id == 0)
			return;
		
		if ($block instanceof Mage_Core_Block_Abstract) {
			if (! $block->getAddressEditingIsDenied()) {
				$collection = Mage::getModel ( 'informationservice/request' )->getCollection ();
				$collection->getSelect ()->where ( 'address_id= ?', intval($address_id));
				// echo ($collection->getSelect()->__toString());
				if (count ( $collection->getItems () ) > 0) {
					$block->setAddressEditingIsDenied(true);
				}
			}
		}
	}
}