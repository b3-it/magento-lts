<?php
class Egovs_Base_Block_Sales_Guest_Links extends Mage_Sales_Block_Guest_Links
{
	const XML_PATH_DISABLE_GUEST_CHECKOUT   = 'checkout/options/guest_checkout';
    /**
     * Set link title, label and url
     */
    public function __construct()
    {
        if (!Mage::getSingleton('customer/session')->isLoggedIn() && Mage::getStoreConfigFlag(self::XML_PATH_DISABLE_GUEST_CHECKOUT)) {
            $this->_label       = $this->__('Orders and Returns');
            $this->_title       = $this->__('Orders and Returns');
            $this->_url         = $this->getUrl('sales/guest/form');

            parent::__construct();
        }
    }
}
