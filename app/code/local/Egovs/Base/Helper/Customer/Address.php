<?php
/**
 * @category   Egovs
 * @package    Egovs_Base
 * @author     Frank Rochlitzer
 */

class Egovs_Base_Helper_Customer_Address extends Mage_Core_Helper_Abstract
{
    /**
     * @param Mage_Customer_Model_Address $address
     * @param Mage_Core_Block_Abstract    $block
     *
     * @return bool
     */
    public function rejectAddressEditing(Mage_Customer_Model_Address $address = null, $block=NULL) {
        if(is_null($address)) {
            return false;
        }
        $_res = false;
        $address_id = $address->getId();
        if (!is_null($block)) {
            $data = array('block' => $block, "address" => $address, "address_id" => $address_id);
            Mage::dispatchEvent('egovs_base_frontend_customer_reject_address_editing', $data);

            $_res = $block->getAddressEditingIsDenied();
            $block->setAddressEditingIsDenied(false);
        }

        //für stammadresse
        if (!$_res) {
            $customer = Mage::getSingleton('customer/session')->getCustomer();
            $baseAddress = $customer->getBaseAddress();
            if ($address_id != $baseAddress) {
                return false;
            } else {
                // Ist die automatische Kundengruppenzuordnung eingeschalten?
                if (Mage::getStoreConfigFlag('catalog/price/display_tax_below_price')
                    && !Mage::helper('customer/address')->isVatValidationEnabled()) {
                    return true;
                }
                if ($customer->getData('disable_auto_group_change') == 1) {
                    return true;
                }
            }
        }

        return $_res;
    }

    /**
     * @param Mage_Customer_Model_Address $addr
     * @return boolean
     */
    public function isAddressReadOnly(Mage_Customer_Model_Address $addr = null) {
        if ($addr === null) {
            return false;
        }

        $result = new Varien_Object();
        $data = array('result' => $result, "addr" => $addr, "address_id" => $addr->getId());
        Mage::dispatchEvent('egovs_base_customer_address_readonly', $data);
        return $result->getIsReadOnly() === true;
    }
}
