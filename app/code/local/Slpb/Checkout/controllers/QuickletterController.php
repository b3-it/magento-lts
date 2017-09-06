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
 * @category   Slpb
 * @package    Slpb_Checkout
 * @copyright  Copyright (c) 2008 Irubin Consulting Inc. DBA Varien (http://www.varien.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Shopping cart controller
 */
class Slpb_Checkout_QuickletterController extends Mage_Core_Controller_Front_Action//Mage_Checkout_CartController
{
 
	
    protected function _getCart()
    {
        return Mage::getSingleton('checkout/cart');
    }
	


    public function addAction()
    {
        $cart   = $this->_getCart();
        $params = $this->getRequest()->getParams();

 
        
        
        if(!isset($params['id']))
        {
        	$this->_redirect('checkout/cart/index');
        	return;
        }
        $id = intval($params['id']);
        $product= $this->_initProduct($id);
        
        $out = "";
        
		$this->loadLayout('checkout_cart_index');
        try {
        	if ($product) {
        		Mage::dispatchEvent('checkout_cart_add_product_before',
        				array('product' => $product, 'request' => new Varien_Object(array('qty'=>1)), 'cart' => $cart));
        		$cart->addProduct($product, $params);
	                    
        		$cart->save();
        		$this->_getSession()->setCartWasUpdated(true);
        		/*
        		Mage::dispatchEvent('checkout_cart_add_product_complete',
        		array('product' => $product, 'request' => $this->getRequest(), 'response' => $this->getResponse())
        		
        		);*/
        	}
 
        }
    	catch (Exception $e) 
        {
            	Mage::getSingleton('checkout/session')->addError($e->getMessage());
        }
        
               $adr = $cart->getQuote()->getShippingAddress();
        $adr->setCollectShippingRates(true)
        	->setShippingMethod('slpbshipping_slpbshipping')
        	->setCountryId('DE')
        	->setPostcode('0')
        	->collectShippingRates()
        	->save();
       $out = "";
       $this->_initLayoutMessages('customer/session');
       $this->_initLayoutMessages('checkout/session');
       $block = $this->getLayout()->getBlock('checkout.cart') ;
       $block->chooseTemplate();
       $out .= $block->toHtml();
       
        die($out);
    }
    
 
    
    
    protected function _initProduct($id)
    {
        
        if ($id) {
            $product = Mage::getModel('catalog/product')
                ->setStoreId(Mage::app()->getStore()->getId())
                ->load($id);
            if ($product->getId()) {
                return $product;
            }
        }
        return false;
    }
  
    protected function _getSession()
    {
        return Mage::getSingleton('checkout/session');
    }
    
}