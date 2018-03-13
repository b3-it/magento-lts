<?php 


class Egovs_Base_Model_Resource_Customer extends Mage_Customer_Model_Resource_Customer
{
    /**
     * {@inheritDoc}
     * @see Mage_Customer_Model_Resource_Customer::_saveAddresses()
     */
    protected function _saveAddresses(Mage_Customer_Model_Customer $customer)
    {
        foreach ($customer->getAddresses() as $addr) {
            /**
             * @var Mage_Customer_Model_Address $addr
             * @var Egovs_Base_Helper_Customer_Address $helper
             */
            $helper = Mage::helper('egovsbase/customer_address');
            if ($addr->getData("_deleted") === true && $helper->isAddressReadOnly($addr)) {
                $addr->setData("_deleted", false);
            }
        }
        return parent::_saveAddresses($customer);
    }
}