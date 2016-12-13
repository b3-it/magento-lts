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
 * @package    Mage_Adminhtml
 * @copyright  Copyright (c) 2008 Irubin Consulting Inc. DBA Varien (http://www.varien.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Adminhtml sales order create sidebar
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */

class Sid_Checkout_Block_Multishipping_Quoteitems extends Mage_Sales_Block_Items_Abstract
{
    public function __construct()
    {
        parent::__construct();

        $this->setTemplate('sid/checkout/multishipping/quoteitems.phtml');
    
    }

   public function getCheckout()
    {
        return Mage::getSingleton('sidcheckout/type_multishipping');
    }

   
    public function getQuoteItems($taken = false)
    {
    	if($taken)
    	{
        	$items = $this->getCheckout()->getQuoteShippingAddressesItemsAssigned();
    	}
    	else
    	{
    		$items = $this->getCheckout()->getQuoteShippingAddressesItemsUnAssigned();
    	}
        $itemsFilter = new Varien_Filter_Object_Grid();
        $itemsFilter->addFilter(new Varien_Filter_Sprintf('%d'), 'qty');
        return $itemsFilter->filter($items);
    }
    
    public function getAddressesHtmlSelect($item, $index)
    {
        $select = $this->getLayout()->createBlock('core/html_select')
            ->setName('ship['.$index.']['.$item->getQuoteItemId().'][address]')
            ->setId('adr_'.$item->getId())
            ->setValue($item->getCustomerAddressId())
            ->setOptions($this->getAddressOptions())
        	->setExtraParams('style="max-width:400px"');

        return $select->getHtml();
    }
    
    public function getAddressesHtml($id)
    {
     	foreach ($this->getCustomer()->getAddresses() as $address) {
               if($address->getId() == $id){
                    return $address->format('oneline');
            }
     	}
     	return "";
    }
    
  	public function getCustomer()
    {
        return $this->getCheckout()->getCustomerSession()->getCustomer();
    }
    
    public function getAddressOptions()
    {
        $options = $this->getData('address_options');
        if (is_null($options)) {
            $options = array();
            foreach ($this->getCustomer()->getAddresses() as $address) {
                $options[] = array(
                    'value' => $address->getId(),
                    //'label' => $address->format('oneline')
               		'label' =>  $address->getName().' '. $address->getStreetFull()." ".  $address->getPostcode()." ". $address->getCity()." ". $address->getDap() , 
                );
            }
            $this->setData('address_options', $options);
        }

        return $options;
    }
    
    public function getItemTakeUrl()
    {
        return $this->getUrl('*/*/takeItem');
    }
    
    public function getItemPutbackUrl()
    {
        return $this->getUrl('*/*/putbackItem');
    }
    
    public function getBackUrl()
    {
    	return $this->getUrl('checkout/cart');
    }
    
}
