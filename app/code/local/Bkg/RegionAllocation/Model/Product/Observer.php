<?php
class Bkg_RegionAllocation_Model_Product_Observer extends Varien_Object
{
	


	/**
	 * Daten für Configurable Virtual für spätere Bearbeitung setzen
	 *
	 * @param Varien_Object $observer
	 *
	 * @return void
	 */
	public function prepareProductSave($observer) {
		$request = $observer->getEvent()->getRequest();
		$product = $observer->getEvent()->getProduct();

		if ($regionallocation = $request->getPost('regionallocation')) {
			$product->setRegionallocationData($regionallocation);
		}


	}

	public function prepareProductEdit($observer) {
		/* @var $product Mage_Catalog_Model_Product */
		$product = $observer->getProduct();
		if (!$product || $product->getTypeId() != Bkg_RegionAllocation_Model_Product_Type_Regionallocation::TYPE_CODE) {
			return;
		}

		$product->getTypeInstance()->limitMaxSaleQty($product);
	}


	public function onSalesQuoteItemSetProduct($observer)
	{
		/* @var $orderItem Mage_Sales_Model_Quote_Item  */
		$orderItem = $observer->getQuoteItem();
		$product = $observer->getProduct();
	 	if ($product && $product->getTypeId() != Bkg_RegionAllocation_Model_Product_Type_Regionallocation::TYPE_CODE) {
            return $this;
        }

        $specialPrice = 0.0;
        
        $portions = $product->getCustomOption('kst_portions');
        if($portions)
        {
        	$portions = unserialize($portions->getValue());
        }
        if(is_array($portions))
        {
	        foreach($portions as $portion=>$price)
	        {
	        	$specialPrice += $price;
	        }
        }
        
        
        
        if ($specialPrice > 0) {
        	$orderItem->setCustomPrice($specialPrice);
        	$orderItem->setOriginalCustomPrice($specialPrice);
        	//$orderItem->getProduct()->setIsSuperMode(true);
        }

	    
	    
	}









}