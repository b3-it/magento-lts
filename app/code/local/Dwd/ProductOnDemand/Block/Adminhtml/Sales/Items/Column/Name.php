<?php

class Dwd_ProductOnDemand_Block_Adminhtml_Sales_Items_Column_Name extends Mage_Adminhtml_Block_Sales_Items_Column_Name
{
	public function getStations() {
		return Mage::helper('prondemand')->getStations($this->getItem());
	}
	
	public function getProducts() {
		return Mage::helper('prondemand')->getProducts($this->getItem());
	}
	
	public function getFormats() {
		return Mage::helper('prondemand')->getFormats($this->getItem());
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
