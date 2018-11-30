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
            /**
             * @var Bkg_Orgunit_Helper_Data $helper
             */
            $helper = Mage::helper('bkg_orgunit');
            $orgs = $helper->getOrganisationByCustomer($customer);
            
            /**
             * @var Bkg_Orgunit_Model_Resource_Unit_Address_Collection $collection
             */
            $collection = Mage::getModel('bkg_orgunit/unit_address')->getCollection();
            $collection->addAttributeToFilter('unit_id', array('in' => $orgs));
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

                // try to get the company name from the organisation instead
                $unit_id = $address->getData('unit_id');
                if (intval($unit_id) > 0) {
                    $org = Mage::getModel('bkg_orgunit/unit')->load($unit_id);
                    $newData['company'] = $org->getData('company');
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
        }
    }

    public function address_block_edit(Varien_Event_Observer $observer)
    {
        /**
         * @var Mage_Core_Block_Abstract $block
         */
        $block = $observer->getBlock();
        /**
         * @var Mage_Customer_Model_Address $address
         */
        $address  = $observer->getParent()->getAddress();
        
        if ($block->getType() === "egovsbase/customer_widget_name") {
            if ($address->getData('org_address_id') !== null) {
                $block->setFieldParams('disabled="disabled" readonly="readonly"');
            }
        } else if ($block->getType() === "core/html_select") {
            if ($address->getData('org_address_id') !== null) {
                $block->setExtraParams('disabled="disabled" readonly="readonly"');
                $block->setClass('');
            }
        }
    }
    
    public function customer_address_readonly(Varien_Event_Observer $observer) {
        /**
         * @var Varien_Object $result
         * @var Mage_Customer_Model_Address $addr
         */
        $result = $observer->getResult();
        $addr = $observer->getAddr();
        if ($addr === null) {
            return;
        }
        if ($addr->getData('org_address_id') !== null) {
            $result->setIsReadOnly(true);
        }
    }
    
    public function customer_address_reject_address_delete(Varien_Event_Observer $observer) {
        /**
         * @var Varien_Object $result
         * @var Mage_Customer_Model_Address $addr
         */
        $result = $observer->getResult();
        $id = $observer->getAddressId();
        if ($id === null || $id === 0) {
            return;
        }
        $addr = Mage::getModel('customer/address')->load($id);
        if ($addr->getData('org_address_id') !== null) {
            $result->setIsDenied(true);
        }
    }
}