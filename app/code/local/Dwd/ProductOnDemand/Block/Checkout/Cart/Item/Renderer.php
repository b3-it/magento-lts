<?php
/**
 * Renderer für Warenkorb Einträge
 *
 * @category	Dwd
 * @package		Dwd_ProductOnDemand
 * @author 		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @author 		Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2012 - 2013 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_ProductOnDemand_Block_Checkout_Cart_Item_Renderer extends Mage_Checkout_Block_Cart_Item_Renderer
{
	public function getStations($item) {
		return Mage::helper('prondemand')->getStations($item);
	}
	
	public function getProducts($item) {
		return Mage::helper('prondemand')->getProducts($item);
	}
	
	public function getFormats($item) {
		return Mage::helper('prondemand')->getFormats($item);
	}
	
	/**
	 * Erzeuft aus einem Array einen String
	 * 
	 * @param string $label Label, wird in Funktion übersetzt
	 * @param array  $list  Liste
	 * 
	 * @return string
	 */
	public function getListAsHtml($label, $list) {
		return Mage::helper('prondemand')->getListAsHtml($label, $list);
	}
}
