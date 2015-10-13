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
 * Shopping cart block
 *
 * @category    Slpb
 * @package     Slpb_Checkout
 */
class Slpb_Checkout_Block_Quick_Form extends Mage_Checkout_Block_Cart
{

	
    public function getCart()
    {
    	return $this->getChildHtml('checkout.cart');
    }
    
    public function getSuggestUrl()
    {
    	$url = $this->getUrl('slpb_checkout/quick/suggest');
        return $url;
    }
    
	public function getAddUrl()
    {
    	$url = $this->getUrl('slpb_checkout/quick/add');
	        return $url;
    	
    }
    
    public function getProducts()
    {
    	$res = "";

        $collection = Mage::getModel('catalog/product')->getCollection();
        
        $collection->addStoreFilter($this->getStore());
        $collection->addAttributeToSelect('*');
        $i = 0;
        foreach ($collection->getItems() as $item) 
        {
        	if($item->isSaleable() &&  $item->isVisibleInCatalog())
        	{
	        	$id = $item->getId();
	        	$sku = $item->getSku();
	        	$name = $item->getName();
	        	$res .= "products[$i] = new Product($id,'$sku','$name');";
	        	
	        	$i++;
        	}
        }
    	return $res;
    }
 
}
