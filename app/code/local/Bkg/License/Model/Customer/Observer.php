<?php
class Bkg_License_Model_Customer_Observer
{
	public function rejectAddressEditing($observer) {
		$block = $observer ['block'];

		/**
		 * @var Mage_Customer_Model_Address $address
		 */
		$address = $observer->getAddress();
		$address_id =  $address->getAddressId();
		if ($address_id == 0)
			return;
		
		if ($block instanceof Mage_Core_Block_Abstract) {
			if (! $block->getAddressEditingIsDenied()) {
				if ($this->isAddressLocked($address_id)) {
					$block->setAddressEditingIsDenied(true);
				}
			}
		}
	}

    public function rejectAddressDelete($observer) {
        $result = $observer ['result'];
        $address_id = intval ( $observer ['address_id'] );
        if ($address_id == 0)
            return;
        $result->setIsDenied($this->isAddressLocked($address_id));
    }

    public function rejectAddressEdit($observer) {
        $result = $observer ['result'];
        $address_id = intval ( $observer ['address_id'] );
        if ($address_id == 0)
            return;
        $result->setIsDenied($this->isAddressLocked($address_id));
    }


	protected function isAddressLocked($address_id)
    {
        $collection = Mage::getModel ( 'bkg_license/copy_address' )->getCollection ();
        $collection->getSelect ()->where ( 'customer_address_id= ?', intval($address_id));
        // echo ($collection->getSelect()->__toString());
        return (count ( $collection->getItems () ) > 0);
    }

}