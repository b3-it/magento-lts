<?php
class Egovs_Extnewsletter_Block_Checkout_Selectproducts extends Mage_Core_Block_Template
{
	public function getProducts() {
		$res = array();
		$quoteitems = Mage::getSingleton('checkout/session')->getQuote()->getAllVisibleItems();
		
		foreach($quoteitems as $item) {
			//die Produkte suchen die eine newsletteroption haben
			$product = $item->getData('product');
			$product = Mage::getModel('catalog/product')->load($product->getId());	
			$news = $product->getData('extnewsletter');
			if ((isset($news)) && ($news == '1')) {
				$res[] = $product;
			}
		}
		return $res;
	}
	
	public function getIsAutoSubscribeProduct() {
		return Mage::getStoreConfig('newsletter/subscription/auto_subscribe_for_product');
	}
	
	public function getIsAutoSubscribeNewsletter() {
		return Mage::getStoreConfigFlag('newsletter/subscription/auto_subscribe_newsletter');
	}
}