<?php
class Dwd_ProductOnDemand_Block_Customer_Products_List extends Mage_Downloadable_Block_Customer_Products_List
{
	protected $_expiringProductIds = null;
	
	/**
	 * Return url to download link
	 *
	 * @param Mage_Downloadable_Model_Link_Purchased_Item $item Gekaufter Link
	 * 
	 * @return string
	 */
	public function getDownloadUrl($item) {
		return $this->getUrl('prondemand/download/link', array('id' => $item->getLinkHash(), '_secure' => true));
	}
	
	/**
	 * Return number of left downloads or unlimited
	 *
	 * @param Mage_Downloadable_Model_Link_Purchased_Item $item Gekaufter Link
	 * 
	 * @return string
	 */
	public function getRemainingDownloads($item) {
// 		if (is_null($this->_expiringProductIds)) {
// 			$expiring = array(Dwd_ProductOnDemand_Model_Product_Type_Ondemand::TYPE_DOWNLOAD_ON_DEMAND);
// 			/* @var $productCollection Mage_Catalog_Model_Resource_Product_Collection */
// 			$productCollection = Mage::getResourceModel('catalog/product_collection');
// 			$productCollection->addAttributeToFilter('type_id', array('in' => $expiring));
// 			$productCollection->addAttributeToFilter('entity_id', array('in' => $this->getItems()->getAllIds()));
// 			$this->_expiringProductIds = $productCollection->getAllIds();
// 		}
		
// 		if (!in_array($item->getProductId(), $this->_expiringProductIds) || !$item->hasValidTo()) {
// 			return parent::getRemainingDownloads($item);
// 		}
		
		if (!$item->hasValidTo() || !$item->getValidTo()) {
			return parent::getRemainingDownloads($item);
		}
		
		$format = Mage::app()->getLocale()->getDateTimeFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT);
		return (string) Mage::app()->getLocale()->date($item->getValidTo())->toString($format);
	}
}