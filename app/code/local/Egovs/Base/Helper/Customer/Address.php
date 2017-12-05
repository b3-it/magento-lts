<?php
/**
 * @category   Egovs
 * @package    Egovs_Base
 * @author     Frank Rochlitzer
 */

class Egovs_Base_Helper_Customer_Address extends Mage_Core_Helper_Abstract
{
    /**
     * @param int                      $address_id
     * @param Mage_Core_Block_Abstract $block
     *
     * @return bool
     */
    public function rejectAddressEditing($address_id, $block=NULL) {

        $_res = false;
        if (!is_null($block)) {
            $data = array('block' => $block, "address_id" => $address_id);
            Mage::dispatchEvent('egovs_base_customer_reject_address_editing', $data);

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
}