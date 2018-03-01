<?php

class Bkg_Orgunit_Model_Rewrite_Observer extends Egovs_Base_Model_Adminhtml_Observer
{
    
    /**
     * Setzt das Template für Mage_Adminhtml_Block_Customer_Edit_Tab_Addresses
     *
     * @return Egovs_Base_Model_Adminhtml_Observer
     */
    protected function _processCustomerAddressesBlock() {
        
        if (!($this->_block instanceof Mage_Adminhtml_Block_Customer_Edit_Tab_Addresses)) {
            return $this;
        }
        
        $this->_block->setTemplate('bkg/orgunit/customer/tab/addresses.phtml');
        return $this;
    }
}