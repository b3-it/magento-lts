<?php

/**
 * Class Egovs_Base_Helper_Config
 *
 * @category  Egovs
 * @package   Egovs_Base
 * @author    Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright Copyright (c) 2009 - 2019 B3 IT Systeme GmbH - https://www.b3-it.de
 * @license   http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Base_Helper_Config extends Mage_Core_Helper_Abstract
{
    protected $_guestConfig;
    protected $_shippingConfig;
    protected $_registerConfig;

    protected $_arrShippingReq = array(
        'firstname', 'lastname', 'street',
        'city', 'postcode', 'country_id',
    );

    protected $_store = NULL;

    /**
     * Config-Status für ein bestimmtes Feld innerhalb der Kundenkonfiguration
     *
     * @param string                     $key            Feldname
     * @param string                     $CheckoutMethod Methode
     * @param int|\Mage_Core_Model_Store $store          ID oder Store-Instance
     *
     * @return string
     * @throws \Mage_Core_Model_Store_Exception
     */
    public function getConfig($key, $CheckoutMethod, $store = NULL) {
        if ($store instanceof Mage_Core_Model_Store || is_int($store)) {
            $store = Mage::app()->getStore($store);
        } else {
            $store = Mage::app()->getStore();
        }

        // Gast
        if (Mage_Sales_Model_Quote::CHECKOUT_METHOD_GUEST === $CheckoutMethod) {
            if ($this->_guestConfig === NULL) {
                $this->_guestConfig = Mage::getStoreConfig('customer/guestrequired', $store);
            }
            return isset($this->_guestConfig[$key]) ? $this->_guestConfig[$key] : '';
        }
        // Versand
        if ('shipping' === $CheckoutMethod) {
            if (in_array($key, $this->_arrShippingReq)) {
                return true;
            }

            if ($this->_shippingConfig === NULL) {
                $this->_shippingConfig = Mage::getStoreConfig('customer/shippingrequired', $store);
            }
            return isset($this->_shippingConfig[$key]) ? $this->_shippingConfig[$key] : '';
        }
        // Anmeldung
        if ($this->_registerConfig === NULL) {
            $this->_registerConfig = Mage::getStoreConfig('customer/registerrequired', $store);
        }
        return isset($this->_registerConfig[$key]) ? $this->_registerConfig[$key] : '';
    }

    /**
     * Abfrage, ob ein bestimmtes Feld für Benutzerdaten ein Pflicht-Feld ist
     *
     * @param string                     $key            Feldname
     * @param string                     $checkoutMethod Methode
     * @param int|\Mage_Core_Model_Store $store          ID oder Store-Instance
     *
     * @return bool
     * @throws \Mage_Core_Model_Store_Exception
     */
    public function isFieldRequired($key, $checkoutMethod = NULL, $store = NULL) {
        return ($this->getConfig($key, $checkoutMethod, $store) === 'req');
    }

    /**
     * Abfrage, ob ein bestimmtes Feld für Benutzerdaten sichtbar ist
     *
     * @param string                     $key            Feldname
     * @param string                     $checkoutMethod Methode
     * @param int|\Mage_Core_Model_Store $store          ID oder Store-Instance
     *
     * @return bool
     * @throws \Mage_Core_Model_Store_Exception
     */
    public function isFieldVisible($key, $checkoutMethod = NULL, $store = NULL) {
        return $this->getConfig($key, $checkoutMethod, $store) !== '';
    }

    /**
     * HTML-Code je nach dem, ob ein bestimmtes Feld für Benutzerdaten ein Pflicht-Feld ist
     *
     * @param string                     $key            Feldname
     * @param string                     $checkoutMethod Methode
     * @param int|\Mage_Core_Model_Store $store          ID oder Store-Instance
     *
     * @return bool
     * @throws \Mage_Core_Model_Store_Exception
     */
    public function getFieldRequiredHtml($key, $checkoutMethod = NULL, $store = NULL) {
        return $this->isFieldRequired($key, $checkoutMethod, $store) ? '<span class="required">*</span>' : '';
    }
}