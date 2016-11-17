<?php
class Dwd_ProductOnDemand_Block_Sales_Item_Renderer_Pdf_Prondemand extends Egovs_Pdftemplate_Block_Sales_Item_Renderer_Abstract
{

	public function getStations() {
		return Mage::helper('prondemand')->getStations($this->getOrderItem());
	}

	public function getProducts() {
		return Mage::helper('prondemand')->getProducts($this->getOrderItem());
	}

	public function getFormats() {
		return Mage::helper('prondemand')->getFormats($this->getOrderItem());
	}

	public function getStartDate() {
		return Mage::helper('prondemand')->getStartDate($this->getOrderItem());
	}

	public function getListAsHtml($list) {
		return implode(', ',$list);
	}
}