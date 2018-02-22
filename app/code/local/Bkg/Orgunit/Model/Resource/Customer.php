<?php 


class Bkg_Orgunit_Model_Resource_Customer extends Mage_Customer_Model_Resource_Customer
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
             */
            // Addresses inside Customer with org_address_id should not be deleted that way
            if ($addr->getData('org_address_id') !== null) {
                $addr->setData("_deleted", false);
            }
        }
        return parent::_saveAddresses($customer);
    }
}