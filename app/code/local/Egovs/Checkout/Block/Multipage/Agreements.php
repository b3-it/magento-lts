<?php

class Egovs_Checkout_Block_Multipage_Agreements extends Mage_Core_Block_Template
{
    public function getAgreements()
    {
        if (!$this->hasAgreements()) {
            if (!Mage::getStoreConfigFlag('checkout/options/enable_agreements')) {
                $agreements = array();
            } else {
                $agreements = Mage::getModel('checkout/agreement')->getCollection()
                    ->addStoreFilter(Mage::app()->getStore()->getId())
                    ->addFieldToFilter('is_active', 1);
            }
            $this->setAgreements($agreements);
        }
        return $this->getData('agreements');
    }
}