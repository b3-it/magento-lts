<?php
/**
 * Dwd Ibewi Reports
 *
 *
 * @category   	Dwd Ibewi
 * @package    	Dwd_Ibewi
 * @name        Dwd_Ibewi_Model_Observer
 * @author 		Holger Kögel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Ibewi_Model_Observer extends Varien_Object
{
 
   //kopieren des Ibewi Wertes vom Produkt in die bestellung
    public function onQuoteItemSetProduct($observer)
    {
    	$product = null;
    	$items = $observer->getItems();
    	
    	foreach ($items as $quoteItem)
    	{
	        if($quoteItem){
	        	$product = $quoteItem->getProduct();
	        }
	        
	
	        if($product && $quoteItem)
	        {
	        	if($product->getIbewiMaszeinheit()){
	        		$quoteItem->setIbewiMaszeinheit($product->getIbewiMaszeinheit());
	        	}
	        	//fallback für grupped Produkte
	        	else{
	        		$product = Mage::getModel('catalog/product')->load($product->getId());
	        		$quoteItem->setIbewiMaszeinheit($product->getIbewiMaszeinheit());
	        	}
	        }
    	}
        return $this;
    }
    
    
}
