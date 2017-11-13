<?php
/**
 * 
 *-- TODO:: kurze Beschreibung --
 *
 *
 *
 * @category		Egovs
 * @package			Egovs_Ready
 * @name			Egovs_Ready_Model_Observer
 * @author			Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright		Copyright (c) 2010 - 2015 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license			http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 * @version			0.1.0.0
 * @since			0.1.0.0
 *
 */
class Egovs_Ready_Model_Observer
{
	/**
	 * Liefert alle Namen von Kategorien anhand des Pfades einer Kategorie
	 *
	 * @param  array $categories Category IDs
	 *
	 * @return array Kategorien
	 */
	protected function _getCategoryNames($categories) {
		$return = array(
			'processed' => array(),
			'path'	=> array(),
		);
	
		foreach ($categories as $categoryId) {
			// Prüfen ob vorhanden
			if (isset($return['processed'][$categoryId]) || isset($return['path'][$categoryId])) {
				return;
			}
	
			/* @var $category Mage_Catalog_Model_Category */
			$category = Mage::getModel('catalog/category')->load($categoryId);
			$return['processed'][$categoryId] = $category->getName();
	
			// base and root Kategorie entfernen
			$path = $category->getPath();
			$pathIds = explode('/', $path);
			array_shift($pathIds);
			array_shift($pathIds);
	
			// Weitere Kategorienamen anhand des Pfades ermitteln
			if (count($pathIds) > 0) {
				foreach ($pathIds as $pathId) {
					if (!isset($return['processed'][$pathId]) && !isset($return['path'][$pathId])) {
						/* @var $pathCategory Mage_Catalog_Model_Category */
						$pathCategory = Mage::getModel('catalog/category')->load($pathId);
						$return['path'][$pathId] = $pathCategory->getName();
					}
				}
			}
		}
	
		return $return;
	}
	
	/**
	 * Erstellt aus Kategorien einen String
	 *
	 * @param  array $categoryNames Kategorien
	 *
	 * @return string Keywords
	 */
	protected function _buildKeywords($categoryNames) {
		if (!$categoryNames) {
			return '';
		}
	
		$keywords = array();
		foreach ($categoryNames as $categories) {
			$keywords[] = implode(', ', $categories);
		}
	
		return implode(', ', $keywords);
	}
	
	/**
	 * Erstellt aus Kategorie-Namen Keywords
	 *
	 * @param  Mage_Catalog_Model_Product $product Product
	 * 
	 * @return string Keywords
	 */
	protected function _getCategoryKeywords($product) {
		$categories = $product->getCategoryIds();
		$categoryNames = $this->_getCategoryNames($categories);
		$keywords = $this->_buildKeywords($categoryNames);
	
		return $keywords;
	}
	
	/**
	 * Auto-Generiert Meta-Informationen für Produkte
	 *
	 * @param  Varien_Event_Observer $observer Observer
	 * 
	 * @return Varien_Event_Observer Observer
	 */
	public function onCatalogProductSaveBefore(Varien_Event_Observer $observer)
	{
		/* @var $product Mage_Catalog_Model_Product */
		$product = $observer->getProduct();
	
		if ($product->getMetaAutogenerate() == 1) {
			//Meta Title
			$product->setMetaTitle($product->getName());
	
			// Meta Keywords
			$keywords = $this->_getCategoryKeywords($product);
			if (!empty($keywords)) {
				if (mb_strlen($keywords) > 255) {
					$remainder = '';
					$keywords = Mage::helper('core/string')->truncate($keywords, 255, '', $remainder, false);
				}
				$product->setMetaKeyword($keywords);
			}
	
			// Meta Description
			$description = $product->getShortDescription();
			if (empty($description)) {
				$description = $product->getDescription();
			}
			if (empty($description)) {
				$description = $keywords;
			}
			if (mb_strlen($description) > 255) {
				$remainder = '';
				$description = Mage::helper('core/string')->truncate($description, 255, '...', $remainder, false);
			}
			$product->setMetaDescription($description);
		}
	
		return $this;
	}
}