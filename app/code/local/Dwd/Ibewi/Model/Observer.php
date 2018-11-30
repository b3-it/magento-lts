<?php
/**
 * Dwd Ibewi Reports
 *
 *
 * @category   	Dwd Ibewi
 * @package    	Dwd_Ibewi
 * @name        Dwd_Ibewi_Model_Observer
 * @author 		Holger Kögel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2017 b3-it Systeme GmbH http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Ibewi_Model_Observer extends Varien_Object
{
 
   //kopieren der Ibewi Werte Maßeinheit und Kostenträger vom Produkt in die Bestellung
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
	        	
	        	if($product->getKostentraeger()){
	        		$quoteItem->setKostentraeger($product->getKostentraeger());
	        	}
	        	//fallback für grupped Produkte
	        	else{
	        		$product = Mage::getModel('catalog/product')->load($product->getId());
	        		$quoteItem->setKostentraeger($product->getKostentraeger());
	        	}
	        }
    	}
        return $this;
    }
    
    
    /**
     * Wird nach dem hinzufügen eines Items zu einer Quote aufgerufen.
     * Die Quote wurde noch nicht gespeichert!
     *
     * Abweisen von verschiedenen Steuersätzen für Lieferungen
     * @param Varien_Event_Observer $observer Observer-Daten
     *
     * @return void
     */
    public function onSalesQuoteAddItem($observer) {
    	/* @var $additem Mage_Sales_Model_Quote_Item */
    	$additem = $observer->getQuoteItem();
    	if (!$additem) {
    		return;
    	}
    	//nur für Lieferung
    	if($additem->getProduct()->isVirtual()){
    		return;
    	}
    	
    	$quote = $additem->getQuote();
    	//SteuerKlasse mit allen lieferfähigen Artikeln im Warenkorb vergleichen
    	foreach($quote->getAllItems() as $item)
    	{
    		if(!$item->getProduct()->isVirtual())
    		{
		    	if ($item->getTaxClassId() != $additem->getTaxClassId()) {
		    		Mage::throwException(Mage::helper('germantax')->__('It is not possible to buy these items together. Please buy this item separately or remove all other items in your shopping cart.'));
		    	}
    		}
    	}
    }
    
}
