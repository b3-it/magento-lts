<?php
/**
 * 
 *  @category Egovs
 *  @package  Bkg_VirtualGeo
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_VirtualGeo_Helper_Rap extends Mage_Core_Helper_Abstract
{
	/**
	 * Eine Relation eines RegionallocationProdukt aus einer Liste finden
	 * @param array $items
	 * @param Bkg_RegionAllocation_Model_Product_Observer $rapId RegionallocationProductId
	 * @param string $FeeIdent Entgelt
	 * @param string $usage Nutzung
	 * @param boolean $returnNewObject soll ein neues Object zurückgegeben werden
	 * @return Bkg_VirtualGeo_Model_Components_Regionallocation|NULL
	 */
	public function findRap($items, $rapId, $FeeIdent, $usage, $returnNewObject = true)
	{
		foreach($items as $item)
		{
			if(($item->getRapId() == $rapId)
					&&($item->getFee() == $FeeIdent)
					&&($item->getUsage() == $usage)){
						return $item;
			}
		}
		 
		if($returnNewObject)
		{
			$item = Mage::getModel('virtualgeo/components_regionallocation');
			$item->setFee($FeeIdent)
			->setUsage($usage)
			->setRapId($rapId);
			return $item;
		}
		return null;
	}
	
	/**
	 * Die Konfiguration der Entgelte
	 * @return string
	 */
	public function getFeesSections()
	{
		$sect = Mage::getConfig()->getNode('virtualgeo/fees/sections')->asArray();
		return $sect;
	}
	
	/**
	 * Die Konfiguration der Nutzungsarten
	 * @return string
	 */
	public function getUsageSections()
	{
		$sect = Mage::getConfig()->getNode('virtualgeo/usage/sections')->asArray();
		return $sect;
	}
	

	public function getLabelForFees($ident)
	{
		$sect = $this->getFeesSections();
		if(isset($sect[$ident])){
			return $sect[$ident]['label'];
		}
		return '';
	}
	
	public function getLabelForUsage($ident)
	{
		$ident = explode('_', $ident);
		$sect = $this->getUsageSections();
		if(isset($sect[$ident[0]])){
			if((isset($ident[1])) && ($ident[1] == 'tax')){
				return $sect[$ident[0]]['tax_label'];
			}else{
				return $sect[$ident[0]]['taxfree_label'];
			}
		}
		return '';
	}
	
	
}