<?php
/**
 * 
 *  Renderer für die einzelenn Artikel Preis in der Bestellbestätigung
 *  @category Egovs
 *  @package  Bkg_VirtualGeo
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_VirtualGeo_Block_Sales_Order_Items_Renderer extends Mage_Bundle_Block_Sales_Order_Items_Renderer
{
   public function getSubItemPriceString($item, $order)
   { 		
   		$text = "";
   		//. ' ' . Mage::helper('core')->currency($this->getSelectionPrice($item, $bundleSelection))
   		if((Mage::getStoreConfig('eventbundle/display_prices/cart_sub_price_eq_null') == 1)  || (floatval($item->getPrice()) > 0.09)){
   			$text .=  ' ( ' . Mage::helper('core')->currency($item->getPrice());
   			if (Mage::getStoreConfig('tax/cart_display/zero_tax') == 1){
   				$text .= ' + ' . Mage::helper('core')->currency($item->getTaxAmount())
   				. ' (' . number_format($item->getTaxPercent(),2)."%)";
   			}
   			$text .= ")";
   		}
   		
   		
   		return $text;
   		
   }
   
   
   
   public function getSelectionAttributes($item) {
   	if ($item instanceof Mage_Sales_Model_Order_Item) {
   		$orderItem = $item;
   	} else {
   		$orderItem = $item->getOrderItem();
   	}

   	$options = $orderItem->getProductOptions();
   	if (isset($options['bundle_selection_attributes'])) {
   		$att = unserialize($options['bundle_selection_attributes']);
   		if($orderItem->getParentItemId())
   		{
   			$att['price'] = $this->getSubItemPriceString($orderItem,$orderItem->getOrder());
   		}
   		return $att;
   	}
   	return null;
   }
   
   public function getValueHtml($item)
   {
   	
	   	if ($item instanceof Mage_Sales_Model_Order_Item) {
	   		$orderItem = $item;
	   	} else {
	   		$orderItem = $item->getOrderItem();
	   	}
   	
	   	if($orderItem->getParentItemId())
	   	{
		   	if ($attributes = $this->getSelectionAttributes($item)) {
		   		return sprintf('%d', $attributes['qty']) . ' x ' .
		   				$this->htmlEscape($item->getName()) .
		   				//" " . $this->getOrder()->formatPrice($attributes['price']);
		   				" " . $attributes['price'];
		   	} else {
		   		return $this->htmlEscape($item->getName());
		   	}
	   	}
	   	else
	   	{
	   		if ($attributes = $this->getSelectionAttributes($item)) {
	   			return sprintf('%d', $attributes['qty']) . ' x ' .
	   					$this->htmlEscape($item->getName()) .
	   					" " . $this->getOrder()->formatPrice($attributes['price']);
	   			
	   		} else {
	   			return $this->htmlEscape($item->getName());
	   		}
	   	}
   }
   
   
   public function canShowPriceInfo($item)
   {
	   	if ($item->getOrderItem()->getParentItem()) 
	   	{
	   				return false;
	   	}
   		return true;
   }
}
