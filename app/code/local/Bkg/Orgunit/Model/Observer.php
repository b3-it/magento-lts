<?php
class Bkg_Orgunit_Model_Observer
{
    public function customer_save_before(Varien_Event_Observer $observer)
    {
        /**
         * @var Mage_Customer_Model_Customer $customer
         */
        $customer = $observer->getCustomer();
        $orig_unit = $customer->getOrigData('org_unit');
        $org_unit = $customer->getData('org_unit');

        // had org unit before
        if ($orig_unit != null) {
            // has different one now
            if ($org_unit !== $orig_unit) {
                Mage::throwException("Organisation can't be changed");
            }
        }
    }
    public function customer_save_after(Varien_Event_Observer $observer)
    {
        /**
         * @var Mage_Customer_Model_Customer $customer
         */
        $customer = $observer->getCustomer();
        $org_unit = $customer->getData('org_unit');
        $orig = $customer->getOrigData('org_unit');
        if (!empty($org_unit) && $org_unit !== $orig) {
            // org data is different than before
            while ($org_unit != null) {
                /**
                 * @var Bkg_Orgunit_Model_Resource_Unit_Address_Collection $collection
                 */
                $collection = Mage::getModel('bkg_orgunit/unit_address')->getCollection();
                $collection->addAttributeToFilter('unit_id', array('eq' => $org_unit));
                $collection->addAttributeToSelect('*');
                
                foreach ($collection as $address) {
                    /**
                     * @var Bkg_Orgunit_Model_Unit_Address $address
                     */
                    
                    $newData = array();
                    // Filter address attributes
                    foreach ($address->getAttributes() as $code => $attr) {
                        /**
                         * @var Mage_Eav_Model_Entity_Attribute $attr
                         */
                        if ($attr->getBackendType() != 'static') {
                            $newData[$code]=$address->getData($code);
                        }
                    }
                    try {
                        $customer_address = Mage::getModel('customer/address');
                        $customer_address->setData($newData);
                        $customer_address->setData('parent_id', $customer->getId());
                        $customer_address->setData('org_address_id', $address->getId());
                        $customer_address->save();
                    } catch (Exception $e) {
                        Mage::logException($e);
                        // TODO what do do with that exception?
                    }
                }
                /**
                 * @var Bkg_Orgunit_Model_Unit $org
                 */
                $org = Mage::getModel('bkg_orgunit/unit')->load($org_unit);
                $org_unit = $org->getData('parent_id');
            }
        }
    }
}