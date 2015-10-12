<?php
/**
 * Configurable Downloadable Products Observer
 *
 * @category    Dwd
 * @package     Dwd_ConfigurableDownloadable
 * @author     	Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @author     	Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2012 - 2013 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_ConfigurableDownloadable_Model_Product_Observer extends Varien_Object
{
	/**
	 * Daten für Configurable Downloadable für spätere Bearbeitung setzen
	 *
	 * @param Varien_Object $observer Observer
	 * 
	 * @return void
	 */
	public function prepareProductSave($observer) {
		$request = $observer->getEvent()->getRequest();
		$product = $observer->getEvent()->getProduct();
		
		if ($configdownloadable = $request->getPost('configdownloadable')) {
			$product->setConfigdownloadableData($configdownloadable);
		}
	}
	
	/**
	 * Daten von Order nach Purchased Links speichern
	 *
	 * @param Varien_Object $observer Observer
	 * 
	 * @return Dwd_ConfigurableDownloadable_Model_Product_Observer
	 */
	public function saveDownloadableOrderItem($observer)
	{
		$orderItem = $observer->getEvent()->getItem();
		if (!$orderItem->getId()) {
			//order not saved in the database
			return $this;
		}
		$product = $orderItem->getProduct();
		if ($product && $product->getTypeId() != Dwd_ConfigurableDownloadable_Model_Product_Type_Configurable::TYPE_CONFIGURABLE_DOWNLOADABLE) {
			return $this;
		}
		if (Mage::getModel('downloadable/link_purchased')->load($orderItem->getId(), 'order_item_id')->getId()) {
			return $this;
		}
		if (!$product) {
			$product = Mage::getModel('catalog/product')
				->setStoreId($orderItem->getOrder()->getStoreId())
				->load($orderItem->getProductId()
			);
		}
		if ($product->getTypeId() != Dwd_ConfigurableDownloadable_Model_Product_Type_Configurable::TYPE_CONFIGURABLE_DOWNLOADABLE) {
			return $this;
		}
		
		$links = $product->getTypeInstance(true)->getLinks($product);
		if ($linkIds = $orderItem->getProductOptionByCode('links')) {
			$linkPurchased = Mage::getModel('downloadable/link_purchased');
			Mage::helper('core')->copyFieldset(
				'configdownloadable_sales_copy_order',
				'to_configdownloadable',
				$orderItem->getOrder(),
				$linkPurchased
			);
			Mage::helper('core')->copyFieldset(
				'configdownloadable_sales_copy_order_item',
				'to_configdownloadable',
				$orderItem,
				$linkPurchased
			);
			$linkSectionTitle = (
					$product->getLinksTitle()?
					$product->getLinksTitle():Mage::getStoreConfig(Mage_Downloadable_Model_Link::XML_PATH_LINKS_TITLE)
			);
			$linkPurchased->setLinkSectionTitle($linkSectionTitle)
				->save()
			;
			foreach ($linkIds as $linkId) {
				if (isset($links[$linkId])) {
					$linkPurchasedItem = Mage::getModel('downloadable/link_purchased_item')
						->setPurchasedId($linkPurchased->getId())
						->setOrderItemId($orderItem->getId()
					);

					Mage::helper('core')->copyFieldset(
						'downloadable_sales_copy_link',
						'to_purchased',
						$links[$linkId],
						$linkPurchasedItem
					);
					$linkHash = strtr(
						base64_encode(microtime() . $linkPurchased->getId() . $orderItem->getId() . $product->getId()), '+/=', '-_,'
					);
					$numberOfDownloads = $links[$linkId]->getNumberOfDownloads()*$orderItem->getQtyOrdered();
					$linkPurchasedItem->setLinkHash($linkHash)
						->setNumberOfDownloadsBought($numberOfDownloads)
						->setStatus(Mage_Downloadable_Model_Link_Purchased_Item::LINK_STATUS_PENDING)
						->setCreatedAt($orderItem->getCreatedAt())
						->setUpdatedAt($orderItem->getUpdatedAt())
						->save()
					;
				}
			}
		}
	
		return $this;
	}    
    
	/**
	 * Bevor Order gespeichert wird
	 * 
	 * @param Varien_Event_Observer $observer Observer
	 * 
	 * @return Dwd_ConfigurableDownloadable_Model_Product_Observer
	 */
 	public function onBeforeSaveOrderItem($observer)
    {
    	$orderItem = $observer->getItem();
    	if ($orderItem->getProductType() != Dwd_ConfigurableDownloadable_Model_Product_Type_Configurable::TYPE_CONFIGURABLE_DOWNLOADABLE) {
    		return $this;
    	}
    	$options = $orderItem->getBuyRequest();
    	
    	
    	if ($options->getPeriode()) {
    		$periode = Mage::getModel('periode/periode')->load($options->getPeriode());
    		if ($periode->getId()) {
    			$orderItem->setPeriodType($periode->getType());
    			$orderItem->setPeriodStart($periode->getStartDate());
    			$orderItem->setPeriodEnd($periode->getEndDate());
    			$orderItem->setPeriodId($periode->getId());
    		}
    	}
    	
    	if ($options->getStation()) {
    		$orderItem->setStationId($options->getStation());
    	}
    }
    
    /**
     * Wenn Produkt in Quote gesetzt wird
     *
     * @param Varien_Event_Observer $observer Observer
     *
     * @return Dwd_ConfigurableDownloadable_Model_Product_Observer
     */
	public function onSalesQuoteItemSetProduct($observer) {
		$orderItem = $observer->getQuoteItem();
		$product = $observer->getProduct();
	 	if ($product && $product->getTypeId() != Dwd_ConfigurableDownloadable_Model_Product_Type_Configurable::TYPE_CONFIGURABLE_DOWNLOADABLE) {
            return $this;
        }
        
        
	    $stationId = $orderItem->getOptionByCode('station_id');
	    if ($stationId) {
	    	$orderItem->setStationId($stationId->getValue());
	    }
        
	   
	    $periodeId = $orderItem->getOptionByCode('periode_id');
	    if ($periodeId) {
	    	$periodeId = $periodeId->getValue();
	    	
	        $orderItem->setPeriodId($periodeId);
	        
	        
	    	$periode = Mage::getModel('periode/periode')->load($periodeId);
		    	if ($periode->getId() == 0) {
		    		Mage::throwException('Periode not found');
		    	}
		    	$orderItem->setPeriodId($periode->getId());
		    	
		    	$specialPrice = $periode->getPrice() + $product->getPrice();
		
			    // Make sure we don't have a negative
			    if ($specialPrice > 0) {
			        $orderItem->setCustomPrice($specialPrice);
			        $orderItem->setOriginalCustomPrice($specialPrice);
			        $orderItem->getProduct()->setIsSuperMode(true);
			    }
	    }
	    
	}
}