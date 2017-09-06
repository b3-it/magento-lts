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
 * @copyright   Copyright (c) 2008 Irubin Consulting Inc. DBA Varien (http://www.varien.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Shoping cart model
 *
 * @category    Mage
 * @package     Mage_Checkout
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Slpb_Product_Model_Checkout_Cart extends Mage_Checkout_Model_Cart
{
 
    /**
     * Add product to shopping cart (quote)
     *
     * @param   int $productId
     * @param   int $qty
     * @return  Mage_Checkout_Model_Cart
     */
    public function addProduct($product, $info=null)
    {
    	
        $product = $this->_getProduct($product);
 
		$star = 0;
		$count = 0;
		
		if ($product->getSlpbLimit())
		{

			$request = $this->_getProductRequest($info);
			if ($product->getSternchen())
			{
				$star = $product->getSternchen() * $request->getQty();
			}
			else 
			{
				$count += $request->getQty();
			}
			//$count = $request->getQty();
	        foreach ($this->getQuote()->getAllVisibleItems() as $item) 
	        {
	            if ($item->getParentItem()) {
	                continue;
	            }

	            $p = $item->getProduct();
	        	if($p->getSlpbLimit()){
	            	if ($p->getSternchen())
	            	{
	            		$star += $p->getSternchen() * $item->getQty();
	            	}
	            	else
	            	{
	            		$count += $item->getQty();
	            	}
	            }
	        }    
       
	        $maxstar = intval(Mage::getStoreConfig('checkout/cart/slpb_stars', $this->getStore()));
	        $maxcount = intval(Mage::getStoreConfig('checkout/cart/slpb_count', $this->getStore()));
            if($star > $maxstar ){
            	Mage::throwException(Mage::helper('slpbproduct')->__('You have too much stars at your cart.'));
            }
            
        	if($count > $maxcount ){
            	Mage::throwException(Mage::helper('slpbproduct')->__('You have too much limited items at your cart.'));
            }
        
            Mage::dispatchEvent('checkout_cart_add_product_before',
            		array('product' => $product, 'request' =>$request, 'cart' => $this));
	        
	        
		}
		
		return parent::addProduct($product, $info);
		
    }
}