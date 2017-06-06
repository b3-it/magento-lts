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


class Gka_Checkout_Block_Singlepage_Success extends Mage_Core_Block_Template
{
    protected $_order = null;
    
    
    /**
     * 
     * @return Mage_Sales_Model_Order
     */
    protected function getOrder()
    {
    	if($this->_order == null){
    		$id = Mage::getSingleton('checkout/session')->getLastOrderId();
    		if($id){
    			$this->_order = Mage::getModel('sales/order')->load($id);
    		}else{
    			$this->_order = new Varien_Object();
    		}
    	}
    	return $this->_order;
    }
    
    
    /**
     * Retrieve identifier of created order
     *
     * @return string
     */
    public function getOrderId()
    {
        return $this->getOrder()->getId();
    }
    
    /**
     * Get url for order detale print
     *
     * @return string
     */
    public function getPrintUrl()
    {
    	return $this->getUrl('*/singlepage/PdfInvoice',array('_secure'=>true, 'order_id'=> $this->getOrder()->getId()));
    }
}
