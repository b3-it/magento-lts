<?php

class Dwd_ProductOnDemand_Block_Sales_Email_Items_Order_Prondemand extends Mage_Sales_Block_Order_Email_Items_Order_Default
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
	
	public function getListAsHtml($list) {
		return implode(', ',$list);
	}
}
