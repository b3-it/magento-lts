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
 * @category    Gka
 * @package     Gka_Checkout
 * @copyright   Copyright (c) 2011 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


class Gka_Checkout_Block_Singlepage_Success extends Mage_Core_Block_Template
{
    protected $_order = null;
    
    
    /**
     * aktuelle Bestellung
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
    
    /**
     * Get url for view order details
     *
     * @return string
     */
    public function getViewOrderUrl()
    {
    	return $this->getUrl('sales/order/view/', array('order_id'=> $this->getOrder()->getId(), '_secure' => true));
    }

    /**
     * alle Elemente der Bestellung
     *
     * @return array
     */
    public function getOrderItems()
    {
    	return $this->getOrder()->getAllItems();
    }

    /**
     * Kundenadresse in der Bestellung
     *
     * @return \Mage_Sales_Model_Order_Address
     */
    public function getBillingAddress()
    {
    	return $this->getOrder()->getBillingAddress();
    }

    /**
     * Logo aus der Konfiguration
     *
     * @return string|null
     */
    public function getLogoPath()
    {
    	$logo =  Mage::getStoreConfig('gka_checkout/invoice/logo_src');
    	if (!empty($logo)) {
    		 return Mage::getDesign()->getSkinBaseDir().DS.$logo;
    	}
    	
    	return null;
    }

    /**
     * Get current day of week and current date
     *
     * @return string
     */
    public function getOrderTime()
    {
        $date = Mage::app()->getLocale()->date( strtotime($this->getOrder()->getUpdatedAt() ), null, null, true);

        return Mage::helper('core')->formatDate($date, Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM, true );
    }
    
    /**
     * Name des Kunden der aktuellen Bestellung
     * 
     * @return string
     */
    public function getOrderCustomerName()
    {
        return $this->getOrder()->getCustomerFirstname() . ' ' . $this->getOrder()->getCustomerLastname();
    }

    /**
     * Kassenzeicher der aktuellen Bestellung
     * 
     * @return Egovs_Paymentbase_Model_Paymentbase
     */
    public function getKassenzeichen()
    {
        return $this->getOrder()->getPayment()->getData('kassenzeichen');
    }

    /**
     * der Name der Zahlart
     *
     * @return string    Mage_Payment_Model_Method_Abstract::Title
     * @throws \Mage_Core_Exception
     */
    public function getPaymentTitle()
    {
    	$info = $this->getOrder()->getPayment()->getMethodInstance();
    	
    	return $info->getTitle();
    }

    /**
     * URL für "Zurück-Link"
     *
     * @return string
     */
    public function getContinueUrl()
    {
    	return $this->getUrl('/');
    }
    
}
