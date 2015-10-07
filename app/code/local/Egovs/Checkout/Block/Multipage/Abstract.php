<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Mage
 * @package    Mage_Checkout
 * @copyright  Copyright (c) 2008 Irubin Consulting Inc. DBA Varien (http://www.varien.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 *
 * @category   Mage
 * @package    Mage_Checkout
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Egovs_Checkout_Block_Multipage_Abstract extends Mage_Core_Block_Template
{
	protected $_customer;
    protected $_checkout;
    protected $_quote;
    protected $_countryCollection;
    protected $_regionCollection;
    protected $_addressesCollection;


    /**
     * Retrieve multishipping checkout model
     *
     * @return Mage_Checkout_Model_Type_Multishipping
     */
    public function getCheckout()
    {
        return Mage::getSingleton('mpcheckout/multipage');
    }


   public function getCountryHtmlSelect($type)
    {
        $countryId = $this->getAddress()->getCountryId();
        if (is_null($countryId)) {
            $countryId = Mage::getStoreConfig('general/country/default');
        }
        $select = $this->getLayout()->createBlock('core/html_select')
            ->setName($type.'[country_id]')
            ->setId($type.':country_id')
            ->setTitle(Mage::helper('checkout')->__('Country'))
            ->setClass('validate-select')
            ->setValue($countryId)
            ->setOptions($this->getCountryOptions());


        return $select->getHtml();
    }

   public function getCountryOptions()
    {
        $options    = false;
        $useCache   = Mage::app()->useCache('config');
        if ($useCache) {
            $cacheId    = 'DIRECTORY_COUNTRY_SELECT_STORE_' . Mage::app()->getStore()->getCode();
            $cacheTags  = array('config');
            if ($optionsCache = Mage::app()->loadCache($cacheId)) {
                $options = unserialize($optionsCache);
            }
        }

        if ($options == false) {
            $options = $this->getCountryCollection()->toOptionArray();
            if ($useCache) {
                Mage::app()->saveCache(serialize($options), $cacheId, $cacheTags);
            }
        }
        return $options;
    }

   public function getCountryCollection()
    {
        if (!$this->_countryCollection) {
            $this->_countryCollection = Mage::getSingleton('directory/country')->getResourceCollection()
                ->loadByStore();
        }
        return $this->_countryCollection;
    }

  public function customerHasAddresses()
    {
        return count($this->getCustomer()->getAddresses());
    }

    public function getRegionCollection()
    {
        if (!$this->_regionCollection) {
            $this->_regionCollection = Mage::getModel('directory/region')->getResourceCollection()
                ->addCountryFilter('DE') //$this->getAddress()->getCountryId()
                ->load();
        }
        return $this->_regionCollection;
    }

    public function getRegionCollectionAsOptionArray()
    {
    	$collection = $this->getRegionCollection();
    	$options = array();
        foreach ($collection->getItems() as $item) {
            $options[] = array(
               'value' => $item->getId(),
               'label' => $item->getName()
            );
        }
        if (count($options)>0) {
            array_unshift($options, array('title'=>null, 'value'=>'', 'label'=>Mage::helper('mpcheckout')->__('Out of Germany')));
        }
        return $options;
    }

    public function getRegionHtmlSelect($type)
    {
        $select = $this->getLayout()->createBlock('core/html_select')
            ->setName($type.'[region]')
            ->setId($type.':region')
            ->setTitle(Mage::helper('checkout')->__('State/Province'))
            ->setClass('required-entry validate-state')
            ->setValue($this->getAddress()->getRegionId())
            ->setOptions($this->getRegionCollectionAsOptionArray());

        return $select->getHtml();
    }





    public function isFieldRequired($key,$method = null)
    {
    	if($method == null) $method = $this->getQuote()->getCheckoutMethod();
    	return ($this->helper('mpcheckout/config')->isFieldRequired($key,$method));
    }

    /**
     * Liefert in Abhängigkeit des Pflicht-Flags das entsprechende HTML zurück
     *
     * @param string $name
     * @param string $method
     *
     * @return string
     */
 	public function getFieldRequiredHtml($name, $method = null) {
    	$html = '<span class="required">*</span>';
    	return $this->_getRequiredHtml($html, $name, $method);
    }

    /**
     * Liefert in Abhängigkeit des Pflicht-Flags die entsprechende CLASS zurück
     *
     * @param string $name
     * @param string $method
     *
     * @return string
     */
    public function getFieldRequiredClass($name, $method = null) {
    	$html = 'required-entry';
    	return $this->_getRequiredHtml($html, $name, $method);
    }

    /**
     * Prüft ob das Feld pflicht ist.
     *
     * @param string $html
     * @param string $name
     * @param string $method
     *
     * @return string
     */
    protected function _getRequiredHtml($html, $name, $method = null) {
    	if (!$html) {
    		$html = '';
    	}
    	if ($method == null) {
    		$method = $this->getQuote()->getCheckoutMethod();
    	}
    	if ($this->isFieldRequired($name, $method)) {
    		return $html;
    	}
    	return '';
    }

 	public function isFieldVisible($key,$method = null)
 	{
 		if($method == null) $method = $this->getQuote()->getCheckoutMethod();
 		return ($this->helper('mpcheckout/config')->getConfig($key,$method) != '');

 	}



    public function getPrefixOptions()
    {
        $options = trim($this->helper('customer/address')->getConfig('prefix_options'));
        if (!$options) {
            return array();
        }
        $options = explode(';', $options);
        foreach ($options as &$v) {
            $v = $this->htmlEscape(trim($v));
        }
        return $options;
    }

    public function getAddressesHtmlSelect($type)
    {

        if ($this->isCustomerLoggedIn()) {
            $options = array();
            $helper = Mage::helper('mpcheckout/Addressformat');
            foreach ($this->getCustomer()->getAddresses() as $address) {
                $options[] = array(
                    'value'=>$address->getId(),
                    //'label'=>$address->format('oneline')
                    'label'=>$helper->formatOneLine($address)
                );
            }

            //$addressId = $this->getAddress()->getId();
            //if (empty($addressId)) {
                if ($type=='billing') {
                    $address = $this->getCustomer()->getPrimaryBillingAddress();
                } else {
                    $address = $this->getCustomer()->getPrimaryShippingAddress();
                }
                if ($address) {
                    $addressId = $address->getId();
                } elseif (count($options) > 0) {
                	$addressId = $options[0]['value'];
                }
            //}

            $select = $this->getLayout()->createBlock('core/html_select')
                ->setName($type.'_address_id')
                ->setId($type.'-address-select')
                ->setClass('address-select');
                //->setExtraParams('onchange="'.$type.'.newAddress(!this.value)"')
            if(isset($addressId)){
            	$select->setValue($addressId)
                	->setOptions($options);
            }
            $select->addOption('add', Mage::helper('checkout')->__('New Address'));

            return $select->getHtml();
        }
        return '';
    }

    public function isCustomerLoggedIn()
    {
        return Mage::getSingleton('customer/session')->isLoggedIn();
    }

        /**
     * Get logged in customer
     *
     * @return Mage_Customer_Model_Customer
     */
    public function getCustomer()
    {
        if (empty($this->_customer)) {
            $this->_customer = Mage::getSingleton('customer/session')->getCustomer();
        }
        return $this->_customer;
    }

  /**
     * Retrieve sales quote model
     *
     * @return Mage_Sales_Model_Quote
     */
    public function getQuote()
    {
        if (empty($this->_quote)) {
            $this->_quote = $this->getCheckout()->getQuote();
        }
        return $this->_quote;
    }

    public function isUseBillingAddressForShipping()
    {
        if (($this->getQuote()->getIsVirtual())
            || !$this->getQuote()->getShippingAddress()->getSameAsBilling()) {
            return false;
        }
        return true;
    }


    public function isStorePickupAvailable()
    {
    	if (Mage::getStoreConfig('carriers/storepickup/active'))
	            return true;
	   return false;
    }
}
