<?php

class Egovs_Checkout_Helper_Config extends Mage_Core_Helper_Abstract
{

    protected $_guestconfig;

    protected $_registerconfig;

    protected $_shippingconfig;

    protected $_shipping_required = array(
        'firstname',
        'lastname',
        'street',
        'city',
        'postcode',
        'country_id'
    );

    public function getConfig($key, $CheckoutMethod)
    {
        if ('shipping' == $CheckoutMethod) {
            if (in_array($key, $this->_shipping_required)) {
                return 'req';
            }
        } else {
            if (($key == 'email') && ($CheckoutMethod != 'login_in'))
                return 'req';
        }

        $data = $this->getAllConfig($CheckoutMethod);

        return isset($data[$key]) ? $data[$key] : '';
    }

    public function isFieldRequired($key, $CheckoutMethod)
    {
        return ($this->getConfig($key, $CheckoutMethod) == 'req');
    }

    public function getAllConfig($CheckoutMethod)
    {
        $store = Mage::app()->getStore();
        if (Mage_Sales_Model_Quote::CHECKOUT_METHOD_GUEST == $CheckoutMethod) {
            if (is_null($this->_guestconfig)) {
                $this->_guestconfig = Mage::getStoreConfig('customer/guestrequired', $store->getId());
            }
            return $this->_guestconfig;
        } elseif ('shipping' == $CheckoutMethod) {
            if (is_null($this->_shippingconfig)) {
                $this->_shippingconfig = Mage::getStoreConfig('customer/shippingrequired', $store->getId());
            }
            return $this->_shippingconfig;
        } else {
            if (is_null($this->_registerconfig)) {
                $this->_registerconfig = Mage::getStoreConfig('customer/registerrequired', $store->getId());
            }
            return $this->_registerconfig;
        }
    }
}