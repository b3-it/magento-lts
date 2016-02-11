<?php
/**
 * Tax
 *
 * @category	Egovs
 * @package		Egovs_GermanTax
 * @author		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright	Copyright (c) 2014 - 2015 B3 IT Systeme GmbH
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_GermanTax_Model_Calculation extends Mage_Core_Model_Abstract
{
	public function getShippingTaxClass($shippingTaxClass, $address) {
		if ($shippingTaxClass != -1 || !$address) {
			return (int)$shippingTaxClass;
		}		
	
		$addressItems = $address->getAllItems();
	
		$taxClasses = array();
		foreach ($addressItems as $item) {
			/* @var $item Mage_Sales_Model_Quote_Item */
				
			/**
			 * Child item's tax we calculate for parent
			 */
			if ($item->getParentItemId()) {
				continue;
			}
			/**
			 * We calculate parent tax amount as sum of children's tax amounts
			 */
				
			if ($item->getHasChildren() && $item->isChildrenCalculated()) {
				foreach ($item->getChildren() as $child) {
					//Virtuelle ignorieren
					if ($child->getIsVirtual()) {
						continue;
					}
						
					$rowTotalWithDiscount = $child->getBaseRowTotal() - $child->getBaseDiscountAmount();
					if (array_key_exists("{$child->getTaxPercent()}", $taxClasses)) {
						$taxClasses["{$child->getTaxPercent()}"]['total'] = $taxClasses["{$child->getTaxPercent()}"]['total'] + $rowTotalWithDiscount;
					} else {
						$taxClasses["{$child->getTaxPercent()}"] = array('total' => $rowTotalWithDiscount, 'tax_class_id' => $child->getTaxClassId());
					}
				}
				//Parent kann ignoriert werden, da Summe aus Childs gebildet wird
			} else {
				//Virtuelle ignorieren
				if ($item->getIsVirtual()) {
					continue;
				}
				$rowTotalWithDiscount = $item->getBaseRowTotal() - $item->getBaseDiscountAmount();
				if (array_key_exists("{$item->getTaxPercent()}", $taxClasses)) {
					$taxClasses["{$item->getTaxPercent()}"]['total'] = $taxClasses["{$item->getTaxPercent()}"]['total'] + $rowTotalWithDiscount;
				} else {
					$taxClasses["{$item->getTaxPercent()}"] = array('total' => $rowTotalWithDiscount, 'tax_class_id' => $item->getTaxClassId());
				}
			}
		}
	
		$taxRate = null;
		$taxClassId = 0;
		$maxTotal = 0;
		foreach ($taxClasses as $rate => $data) {
			$tmpMaxTotal = max($maxTotal, $data['total']);
			if ($tmpMaxTotal > $maxTotal) {
				$maxTotal = $tmpMaxTotal;
				$taxRate = $rate;
				$taxClassId = $data['tax_class_id'];
			} elseif ($data['total'] == $maxTotal && $rate > $taxRate) {
				//Falls die Werte identisch sind nehmen wir lieber die höhere
				$taxRate = $rate;
				$taxClassId = $data['tax_class_id'];
			}
		}
	
		if ($taxClassId > 0) {
			return $taxClassId;
		}
	
		return $shippingTaxClass;
	}
}