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
 * @category    Mage
 * @package     Mage_Checkout
 * @copyright   Copyright (c) 2011 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Multishipping checkout choose item addresses block
 *
 * @category   Mage
 * @package    Mage_Checkout
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Sid_Checkout_Block_Multishipping_Addresses extends Mage_Sales_Block_Items_Abstract
{
    /**
     * Retrieve multishipping checkout model
     *
     * @return Mage_Checkout_Model_Type_Multishipping
     */
    public function getCheckout()
    {
        return Mage::getSingleton('sidcheckout/type_multishipping');
    }

    protected function _prepareLayout()
    {
        if ($headBlock = $this->getLayout()->getBlock('head')) {
            $headBlock->setTitle(Mage::helper('checkout')->__('Ship to Multiple Addresses') . ' - ' . $headBlock->getDefaultTitle());
        }
        
        
        parent::_prepareLayout();
        
        $block = $this->getLayout()->createBlock('sidcheckout/multishipping_quoteitems');
        $this->setChild('items',$block); 
       
        
        return $this;
    }

   

    /**
     * Retrieve HTML for addresses dropdown
     *
     * @param  $item
     * @return string
     */
    public function getAddressesHtmlSelect($item, $index)
    {
        $select = $this->getLayout()->createBlock('core/html_select')
            ->setName('ship['.$index.']['.$item->getQuoteItemId().'][address]')
            ->setId('ship_'.$index.'_'.$item->getQuoteItemId().'_address')
            ->setValue($item->getCustomerAddressId())
            ->setOptions($this->getAddressOptions());

        return $select->getHtml();
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
                    'value' => $address->getId(),
                    'label' => $address->format('oneline')
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
        return $this->getUrl('catalog/product/view/id/'.$item->getProductId(),array('_secure'=>true));
    }

    public function getItemDeleteUrl($item)
    {
        return $this->getUrl('*/*/removeItem', array('address'=>$item->getQuoteAddressId(), 'id'=>$item->getId(),'_secure'=>true));
    }

    public function getPostActionUrl()
    {
        return $this->getUrl('*/*/addressesPost',array('_secure'=>true));
    }

    public function getNewAddressUrl()
    {
        return Mage::getUrl('*/multishipping_address/newShipping',array('_secure'=>true));
    }

    public function getBackUrl()
    {
        return Mage::getUrl('*/cart/');
    }

    public function isContinueDisabled()
    {
        return !$this->getCheckout()->validateMinimumAmount();
    }
}