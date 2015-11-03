<?php
class Dwd_ProductOnDemand_Model_Product_Observer extends Varien_Object
{
	/**
	 * Daten für PoD für spätere Bearbeitung setzen
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
	 * Save data from order to purchased links
	 *
	 * @param Varien_Object $observer
	 * 
	 * @return Dwd_ProductOnDemand_Model_Product_Observer
	 */
	public function saveDownloadableOrderItem($observer)
	{
		$orderItem = $observer->getEvent()->getItem();
		if (!$orderItem->getId()) {
			//order not saved in the database
			return $this;
		}
		$product = $orderItem->getProduct();
		if ($product && $product->getTypeId() != Dwd_ProductOnDemand_Model_Product_Type_Ondemand::TYPE_DOWNLOAD_ON_DEMAND) {
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
		if ($product->getTypeId() == Dwd_ProductOnDemand_Model_Product_Type_Ondemand::TYPE_DOWNLOAD_ON_DEMAND) {
			$links = $product->getTypeInstance(true)->getLinks($product);
			if ($linkIds = $orderItem->getProductOptionByCode('links')) {
				$linkPurchased = Mage::getModel('downloadable/link_purchased');
				Mage::helper('core')->copyFieldset(
					'prondemand_sales_copy_order',
					'to_prondemand',
					$orderItem->getOrder(),
					$linkPurchased
				);
				Mage::helper('core')->copyFieldset(
					'prondemand_sales_copy_order_item',
					'to_prondemand',
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
		}
	
		return $this;
	}    
    
	public function onSalesQuoteItemSetProduct($observer) {
		$orderItem = $observer->getQuoteItem();
		$product = $observer->getProduct();
	 	if ($product && $product->getTypeId() != Dwd_ProductOnDemand_Model_Product_Type_Ondemand::TYPE_DOWNLOAD_ON_DEMAND) {
            return $this;
        }
        
		$specialPrice = $this->_getPrice($orderItem);
		
		
	    // Make sure we don't have a negative
	    if ($specialPrice > 0) {
	        $orderItem->setCustomPrice($specialPrice);
	        $orderItem->setOriginalCustomPrice($specialPrice);
	        $orderItem->getProduct()->setIsSuperMode(true);
	    }
	    
	    return $this;
	}
	
	public function removeUniquePodData($observer) {
		/* @var $quoteItem Mage_Sales_Model_Quote_Item */
		$quoteItem = $observer->getItem();
		if (!$quoteItem) {
			return;
		}
		
		if ($quoteItem->getProductType() != Dwd_ProductOnDemand_Model_Product_Type_Ondemand::TYPE_DOWNLOAD_ON_DEMAND
			&& $quoteItem->getRealProductType() != Dwd_ProductOnDemand_Model_Product_Type_Ondemand::TYPE_DOWNLOAD_ON_DEMAND) {
			return;
		}
		
		$links = $quoteItem->getOptionByCode('downloadable_link_ids');
		if (!$links) {
			return;
		}
		
		$links = $links->getValue();
		
		if (!is_array($links)) {
			$links = array($links);
		}
		
		Mage::getResourceModel('downloadable/link')->deleteItems($links);
	}
	
	public function cleanUpLinkGarbage($observer) {
		Mage::log("pod::Sales order item cancel or refund event raised", Zend_Log::DEBUG, Egovs_Extstock_Helper_Data::LOG_FILE);
		
		if (!$observer) {
			return;
		}
		
		$links = null;
		/* @var $orderItem Mage_Sales_Model_Order_Item */
		$orderItem = null;
		if ($observer->getEvent()->getName() == "sales_order_item_cancel") {
			/* @var $orderItem Mage_Sales_Model_Order_Item */
			$orderItem = $observer->getItem();			
		} elseif ($observer->getEvent()->getName() == "sales_creditmemo_item_save_after") {
			/* @var $creditmemoItem Mage_Sales_Model_Order_Creditmemo_Item */
			$creditmemoItem = $observer->getCreditmemoItem();
			$orderItem = $creditmemoItem->getOrderItem();
		} else {
			return;
		}		
		if (!$orderItem) {
			return;
		}
		
		if ($orderItem->getProductType() != Dwd_ProductOnDemand_Model_Product_Type_Ondemand::TYPE_DOWNLOAD_ON_DEMAND
				&& $orderItem->getRealProductType() != Dwd_ProductOnDemand_Model_Product_Type_Ondemand::TYPE_DOWNLOAD_ON_DEMAND
		) {
			return;
		}
			
		$links = $orderItem->getProductOptionByCode('links');
		
		if (!is_array($links)) {
			return;
		}
		Mage::getResourceModel('downloadable/link')->deleteItems($links);
	}
	
	protected function _getPrice($orderItem) {
		 $option = $orderItem->getOptionByCode('info_buyRequest');
         $buyRequest = new Varien_Object($option ? unserialize($option->getValue()) : null);
         $specialPrice = 0;
		 if (($buyRequest)) {
		 	$productInfo = $buyRequest->getData('product_info');
			if (is_array($productInfo)) {
				if (isset($productInfo['netPrice'])) {
					//$specialPrice = trim(str_replace('€','',$productInfo['netPrice']));
					$specialPrice = Mage::app()->getLocale()->getNumber($productInfo['netPrice']);
				}
			}
		 }
		 
		 $store = Mage::app()->getStore();
		 $priceIncludesTax = Mage::helper('tax')->priceIncludesTax($store);
		 if ($priceIncludesTax) {
		 	$percent = $orderItem->getTaxPercent();
		 	$specialPrice = $specialPrice * (1.0 + $percent / 100.0);
		 }
  	 
		 return $specialPrice;
	}
}