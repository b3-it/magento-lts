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
 * Multishipping checkout success information
 *
 * @category   Mage
 * @package    Mage_Checkout
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Sid_Checkout_Block_Multishipping_Success extends Mage_Checkout_Block_Multishipping_Abstract
{
	private $_order_ids = null;
	private $_orders = null;
    public function getOrderIds()
    {
    	if($this->_order_ids == null){
	        $this->_order_ids = Mage::getSingleton('core/session')->getOrderIds(true);
    	}
	//        Zend_Debug::dump(Mage::getSingleton('core/session')->getOrderIds());
	        if ($this->_order_ids && is_array($this->_order_ids)) {
	            return $this->_order_ids;
	            return implode(', ', $this->_order_ids);
	        }
        return false;
    }

    public function getViewOrderUrl($orderId)
    {
        return $this->getUrl('sales/order/view/', array('order_id' => $orderId, '_secure' => true));
    }

    public function getContinueUrl()
    {
        return Mage::getBaseUrl();
    }
    
    /**
     * anhand der Rechnungsadresse das Haushaltsystem ermitteln
     */
    public function getOrderHaushaltssysteme()
    {
    	if($this->_orders == null){
    		$this->_orders = array();
	    	foreach($this->_order_ids as $id => $increment){
	    		$order = Mage::getModel('sales/order')->load($id);
	    		$address = Mage::getModel('customer/address')->load($order->getBillingAddress()->getCustomerAddressId());
	    		
	    		if(!empty($address->getHaushaltsSystem())){
	    			
	    			$this->_orders[$id] = $order;
	    		}
	    		
	    	}
    	}
    	return $this->_orders;
    }
    
    public function getFrameContractText($orderId = null)
    {
    	if(isset($this->_orders[$orderId])){
    		$fc = Mage::getModel('framecontract/contract')->load($this->_orders[$orderId]->getFramecontract());
    		if($fc->getId()){
    			return "<td>".$fc->getTitle()."</td><td>".$fc->getVendor()->getCompany()."</td>";
    		}
    	}
    	
    	return "";
    }
    public function getAdditionalInfoUrl()
    {
    	 return $this->getUrl('sidhaushalt/index/saveaddinfo', array('_secure' => true));
    }
    
}
