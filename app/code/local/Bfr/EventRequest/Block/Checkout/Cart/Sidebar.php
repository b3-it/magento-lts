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
 * Wishlist sidebar block
 *
 * @category    Mage
 * @package     Mage_Checkout
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Bfr_EventRequest_Block_Checkout_Cart_Sidebar extends Mage_Checkout_Block_Cart_Sidebar
{
 
    /**
     * Get one page checkout page url
     *
     * @return bool
     */
    public function getCheckoutUrl()
    {
    	return Mage::helper('mpcheckout/url')->getCheckoutUrl();
        
    }
    
    public function isEventRequest(){
    	$customer = Mage::getSingleton('customer/session')->getCustomer();
    	$customer_id = 0;
    	if ($customer && $customer->getId()) {
    		$customer_id = $customer->getId();
    	}
    	foreach($this->getItems() as $item){
    		if($item->getProduct()->getEventrequest())
    		{
    			$request = Mage::getModel('eventrequest/request')->loadByCustomerAndProduct($customer_id, $item->getProduct()->getId());
    			if($request->isAccepted()){
    				return false;
    			}
    			return true;
    		}
    	}
    		
    	return false;
    }
    
    public function getRegistrationUrl()
    {
    	return $this->getUrl('eventrequest/index');
    }
    

}
