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
class Egovs_Checkout_Block_Multipage_Addresses extends Egovs_Checkout_Block_Multipage_Abstract
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
            $headBlock->setTitle(Mage::helper('checkout')->__('Checkout Procedure'). " - " .Mage::helper('checkout')->__('Billing Address'));
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

    public function canShip()
    {
        return !$this->getQuote()->isVirtual();
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
        	$helper = Mage::helper('mpcheckout/Addressformat');
            $options = array();
            foreach ($this->getCustomer()->getAddresses() as $address) {
                $options[] = array(
                    'value'=>$address->getId(),
                    //'label'=>$address->format('oneline')
                    'label'=>$helper->formatOneLine($address)
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
