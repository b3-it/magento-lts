<?php
class Bkg_RegionAllocation_Helper_Data extends Mage_Core_Helper_Data
{
	/**
	 * ein oder zwei Regionallocation Produkte 
	 * @param int $rapId
	 * @param int $rapIdTax
	 * @param float $price
	 * @param boolean $KstId Id des Königsteiner-Schlüssels, falls null wird der gegenwärtig Aktive verwendet
	 * @return Bkg_RegionAllocation_Model_Product_Type_Regionallocation[] mit 
	 */
	public function getRapProducts($rapId, $rapIdTax, $price, $fee, $usage, $KstId = null)
	{
		$res = array();
		if(!$rapId && !$rapIdTax){
			return $res;
		}
		
		/** @var $kst Bkg_Regionallocation_Model_Koenigsteinerschluessel_Kst */
		$kst = Mage::getModel('regionallocation/koenigsteinerschluessel_kst');
		if($KstId){
			$kst->load($KstId);
		}else{
			$kst->loadCurrent();
		}
		
		$sum = 0; //kontrolle
		
		$tax = array();
		$notax = array();
		
		foreach($kst->getPortions() as $portion)
		{
			$d = $price * $portion->getPortion();
			$d /= 100.0;
			$portion->setPrice($d);
			$sum += $d;
			//Beträge aufspalten falls mehrere Produkte Rap's konfiguriert wurden
			if($portion->getHasTax())
			{
				if($rapIdTax){
					$tax[$portion->getRegion()] = $d;
				}else{
					$notax[$portion->getRegion()] = $d;
				}
			}else{
				$notax[$portion->getRegion()] = $d;
			}
		}
		
		if(abs($sum - $price) > 0.01){
			//was nu?
		}
		
		if($rapId){
			$product = $rapProduct = Mage::getModel('catalog/product')->load($rapId);
			$product->setStoreId(Mage::app()->getStore()->getId())
				->setKst($kst)
				->setPortions($notax)
				->setFee($fee)
				->setUsage($usage);
			$res[] = $product;
		}
		if($rapIdTax){
			$product = $rapProduct = Mage::getModel('catalog/product')->load($rapIdTax);
			$product->setStoreId(Mage::app()->getStore()->getId())
				->setKst($kst)
				->setPortions($tax)
				->setFee($fee)
				->setUsage($usage.'_tax');
			$res[] = $product;
		}
		
		return $res;
		
	}
}