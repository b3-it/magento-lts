<?php
class Egovs_Base_Helper_Config extends Mage_Core_Helper_Abstract
{
    //protected $_guestconfig;
    //protected $_shippingconfig;

    protected $_registerconfig;
    protected $_arrShippingReq = array(
                                     'firstname', 'lastname', 'street',
                                     'city', 'postcode', 'country_id'
                                 );

    /**
     * Config-Status für ein bestimmtes Feld innerhalb der Kundenkonfiguration
     *
     * @param string $key               Feldname
     * @param string $CheckoutMethod    Methode
     *
     * @return string
     */
    public function getConfig($key, $CheckoutMethod)
    {
        $store = Mage::app()->getStore();

	    	// Gast
	    	if(Mage_Sales_Model_Quote::CHECKOUT_METHOD_GUEST == $CheckoutMethod) {
	    	    if (is_null($this->_guestconfig)) {
	    	        $this->_guestconfig = Mage::getStoreConfig('customer/guestrequired', $store->getId());
		        }
		        return isset($this->_guestconfig[$key]) ? $this->_guestconfig[$key] : '';
	    	}
	    	// Versand
	    	elseif ('shipping' == $CheckoutMethod) {
	    	    if( in_array($key, $this->_arrShippingReq) ) {
	    	        return true;
	    	    }

		        if (is_null($this->_shippingconfig)) {
		            $this->_shippingconfig = Mage::getStoreConfig('customer/shippingrequired', $store->getId());
		        }
		        return isset($this->_shippingconfig[$key]) ? $this->_shippingconfig[$key] : '';
	    	}
	    	// Anmeldung
	    	else {
		        if (is_null($this->_registerconfig)) {
		            $this->_registerconfig = Mage::getStoreConfig('customer/registerrequired', $store->getId());
		        }
		        return isset($this->_registerconfig[$key]) ? $this->_registerconfig[$key] : '';
	    	}
    }

    /**
     * Abfrage, ob ein bestimmtes Feld für Benutzerdaten ein Pflicht-Feld ist
     *
     * @param string $key               Feldname
     * @param string $CheckoutMethod    Methode
     *
     * @return bool
     */
    public function isFieldRequired($key, $CheckoutMethod = null)
    {
        return ($this->getConfig($key, $CheckoutMethod) == 'req');
    }

    /**
     * Abfrage, ob ein bestimmtes Feld für Benutzerdaten sichtbar ist
     *
     * @param string $key               Feldname
     * @param string $CheckoutMethod    Methode
     *
     * @return bool
     */
    public function isFieldVisible($key, $CheckoutMethod = null)
    {
        if ( $this->getConfig($key, $CheckoutMethod) == '' ) {
            return false;
        }
        else {
            return true;
        }
    }
    
    /**
     * HTML-Code je nach dem, ob ein bestimmtes Feld für Benutzerdaten ein Pflicht-Feld ist
     *
     * @param string $key               Feldname
     * @param string $CheckoutMethod    Methode
     *
     * @return bool
     */
    public function getFieldRequiredHtml($key, $CheckoutMethod = null)
    {
    	if ( $this->isFieldRequired($key, $CheckoutMethod) ) {
    		return '<span class="required">*</span>';
    	}
    	else {
    		return '';
    	}
    }
}