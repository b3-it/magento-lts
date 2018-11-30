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
 * checkout choose item addresses block
 *
 * @category   Egovs
 * @package    Egovs_Checkout
 */
class Egovs_Checkout_Block_Multipage_Addresses extends Mage_Sales_Block_Items_Abstract
{
    /**
     * Retrieve multipage checkout model
     *
     * @return Egovs_Checkout_Model_Multipage
     */
    public function getCheckout()
    {
        return Mage::getSingleton('mpcheckout/multipage');
    }

    protected function _prepareLayout()
    {
    	
        if ($headBlock = $this->getLayout()->getBlock('head')) {
            $headBlock->setTitle(Mage::helper('checkout')->__('Checkout Procedure'). " - " .Mage::helper('checkout')->__('Ship to Address'));
        }
        return parent::_prepareLayout();
    }

    public function getItems()
    {
        $items = $this->getCheckout()->getQuoteShippingAddressesItems();
        $itemsFilter = new Varien_Filter_Object_Grid();
        $itemsFilter->addFilter(new Varien_Filter_Sprintf('%d'), 'qty');
        return $itemsFilter->filter($items);
    }
    
  	public function customerHasAddresses()
    {
        return count($this->getCustomer()->getAddresses());
    }
    
    
 
   public function isUseBillingAddressForShipping()
    {
        if (($this->getQuote()->getIsVirtual())
            || !$this->getQuote()->getShippingAddress()->getSameAsBilling()) {
            return false;
        }
        return true;
    }
    
   public function getFirstname()
    {
        $firstname = $this->getAddress()->getFirstname();
        if (empty($firstname) && $this->getQuote()->getCustomer()) {
            return $this->getQuote()->getCustomer()->getFirstname();
        }
        return $firstname;
    }

    public function getLastname()
    {
        $lastname = $this->getAddress()->getLastname();
        if (empty($lastname) && $this->getQuote()->getCustomer()) {
            return $this->getQuote()->getCustomer()->getLastname();
        }
        return $lastname;
    }

    public function canShip()
    {
        return !$this->getQuote()->isVirtual();
    }
    
 	public function getQuote()
    {
        if (empty($this->_quote)) {
            $this->_quote = $this->getCheckout()->getQuote();
        }
        return $this->_quote;
    }
    

   
    
 	public function getAddress()
    {
        $address = $this->getData('address');
        if (is_null($address)) {
            $address = Mage::getSingleton('mpcheckout/multipage')->getQuote()->getBillingAddress();
            $this->setData('address', $address);
        }
        return $address;
    }
    
    
 	public function getAddressesHtmlSelect($type)
    {
        if ($this->isCustomerLoggedIn()) {
            $options = array();
            $helper = Mage::helper('mpcheckout/Addressformat');
            foreach ($this->getCustomer()->getAddresses() as $address) {
                $options[] = array(
                    'value'=>$address->getId(),
                	'label'=>$helper->formatOneLine($address)
                    //'label'=>$address->format('oneline')
                );
            }

            $addressId = $this->getAddress()->getId();
            if (empty($addressId)) {
                if ($type=='billing') {
                    $address = $this->getCustomer()->getPrimaryBillingAddress();
                } else {
                    $address = $this->getCustomer()->getPrimaryShippingAddress();
                }
                if ($address) {
                    $addressId = $address->getId();
                }
            }

            $select = $this->getLayout()->createBlock('core/html_select')
                ->setName($type.'_address_id')
                ->setId($type.'-address-select')
                ->setClass('address-select')
                //->setExtraParams('onchange="'.$type.'.newAddress(!this.value)"')
                ->setValue($addressId)
                ->setOptions($options);

           // $select->addOption('', Mage::helper('checkout')->__('New Address'));

            return $select->getHtml();
        }
        return '';
    }
 	
    
    public function isCustomerLoggedIn()
    {
        return Mage::getSingleton('customer/session')->isLoggedIn();
    }
    
    /**
     * Retrieve options for addresses dropdown
     *
     * @return array
     */
    public function getAddressOptions()
    {
        $options = $this->getData('address_options');
        if (is_null($options)) {
            $options = array();
            foreach ($this->getCustomer()->getAddresses() as $address) {
                $options[] = array(
                    'value'=>$address->getId(),
                    'label'=>$address->format('oneline')
                );
            }
            $this->setData('address_options', $options);
        }
        return $options;
    }

    public function getCustomer()
    {
        return $this->getCheckout()->getCustomerSession()->getCustomer();
    }

    public function getItemUrl($item)
    {
        return $this->getUrl('catalog/product/view/id/'.$item->getProductId());
    }

    public function getItemDeleteUrl($item)
    {
        return $this->getUrl('*/*/removeItem', array('address'=>$item->getQuoteAddressId(), 'id'=>$item->getId()));
    }

    public function getPostActionUrl()
    {
        return $this->getUrl('*/*/addressesPost', array('_secure'=>true));
    }

    public function getNewAddressUrl()
    {
        return Mage::getUrl('*/edit/newShipping', array('_secure'=>true));
    }

    public function getBackUrl()
    {
        return Mage::getUrl('checkout/cart/', array('_secure'=>true));
    }

    public function isContinueDisabled()
    {
        return !$this->getCheckout()->validateMinimumAmount();
    }
}
