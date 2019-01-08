<?php

class Sid_Wishlist_Helper_Data extends Mage_Core_Helper_Abstract
{
	/**
	 * Ruft Item Store für URL ab
	 *
	 * @param Mage_Catalog_Model_Product|Mage_Wishlist_Model_Item $item Item
	 * 
	 * @return Mage_Core_Model_Store
	 */
	protected function _getUrlStore($item) {
		$storeId = null;
		$product = null;
		if ($item instanceof Sid_Wishlist_Model_Quote_Item) {
			$product = $item->getProduct();
		} elseif ($item instanceof Mage_Catalog_Model_Product) {
			$product = $item;
		}
		if ($product) {
			if ($product->isVisibleInSiteVisibility()) {
				$storeId = $product->getStoreId();
			} elseif ($product->hasUrlDataObject()) {
				$storeId = $product->getUrlDataObject()->getStoreId();
			}
		}
		return Mage::app()->getStore($storeId);
	}
	
	/**
	 * Prüfen ob Aktionen mit Merkzettel erlaubt sind
	 *
	 * @return bool
	 */
	public function isAllow() {
		if ($this->isModuleOutputEnabled() && Mage::getStoreConfig('sidwishlist/general/active')) {
			return true;
		}
		return false;
	}
	
	/**
	 * Liefert default Kommentar-String
	 *
	 * @return string
	 */
	public function defaultCommentString() {
		return $this->__('Please, enter your comments...');
	}

    /**
     * Ruft die URL zum Hinzufügen des Produktes ab
     *
     * @param Mage_Catalog_Model_Product|Mage_Wishlist_Model_Item $item Item
     *
     * @param array                                               $additional
     *
     * @return  string|bool
     */
	public function getAddUrl($item, $additional = array()) {
	    if (!isset($additional['_secure'])) {
            $_secure = Mage::app()->getFrontController()->getRequest()->isSecure();
        } else {
	        $_secure = $additional['_secure'];
        }
		$addUrlKey = Mage_Core_Controller_Front_Action::PARAM_NAME_URL_ENCODED;
		$addUrlValue = Mage::getUrl('*/*/*', array('_use_rewrite' => true, '_current' => true, '_secure' => $_secure));
		$additional[$addUrlKey] = Mage::helper('core')->urlEncode($addUrlValue);
		
		return $this->getAddUrlWithParams($item, $additional);
	}
	
	/**
	 * Gibt die URL der Merkliste des aktuellen Benutzers zurück
	 *
	 * @param string|int $id ID
	 * 
	 * @return string
	 */
	public function getListUrl($id) {
		$params = array('_secure'=>true);
		
		if (is_numeric($id)) {
			$params['id'] = $id;
		} elseif (is_string($id) && !empty($id)) {
			$params['share_code'] = $id;
		} else {
			return $this->_getUrl('sidwishlist');
		}
			
		return $this->_getUrl('sidwishlist/index/view', $params);
	}
	
	/**
	 * Ruft die URL unter Berücksichtigung der übergebenen Parameter zum Hinzufügen des Produktes ab
	 *
	 * @param Mage_Catalog_Model_Product|Mage_Wishlist_Model_Item $item   Item
	 * @param array 											  $params Parameter
	 *
	 * @return  string|bool
	 */
	public function getAddUrlWithParams($item, array $params = array())	{
		$productId = null;
		if ($item instanceof Mage_Catalog_Model_Product) {
			$productId = $item->getEntityId();
		}
		if ($item instanceof Sid_Wishlist_Model_Quote_Item) {
			$productId = $item->getProductId();
		}
	
		if ($productId) {
			$params['product'] = $productId;
			return $this->_getUrlStore($item)->getUrl('sidwishlist/index/add', $params);
		}
	
		return false;
	}
	
	/**
	 * Liefert URL um Item zum Einkaufswagen hinzuzufügen
	 *
	 * @param string|Mage_Catalog_Model_Product|Sid_Wishlist_Model_Quote_Item $item Item
	 * 
	 * @return  string
	 */
	public function getAddToCartUrl($item)
	{
		$urlParamName = Mage_Core_Controller_Front_Action::PARAM_NAME_URL_ENCODED;
		$continueUrl  = Mage::helper('core')->urlEncode(
				Mage::getUrl('*/*/*', array(
						'_current'      => true,
						'_use_rewrite'  => true,
						'_store_to_url' => true,
				))
		);
	
		$urlParamName = Mage_Core_Controller_Front_Action::PARAM_NAME_URL_ENCODED;
		$params = array(
				'item' => is_string($item) ? $item : $item->getId(),
				$urlParamName => $continueUrl
		);
		return $this->_getUrlStore($item)->getUrl('sidwishlist/quote_item/cart', $params);
	}
	
	/**
	 * Darf dieser Benutzer Bestellungen abgeben
	 *
	 * @param Mage_Customer_Model_Customer $customer Kunde
	 * 
	 * @return bool
	 */
	public function isAuthorizedOrderer($customer = null){
		try {
			if (!class_exists('Sid_Roles_Model_Customer_Authority')) {
				return true;
			}
		} catch (Exception $e) {
			return true;
		}
		
		if (!$customer) {
			$customer = Mage::getSingleton('customer/session')->getCustomer();
		}
		
		return Sid_Roles_Model_Customer_Authority::getIsAuthorizedOrderer($customer);
	}
	
	/**
	 * Get old field map
	 *
	 * @param string $entityId Entity ID
	 * 
	 * @return array
	 */
	public function getOldFieldMap($entityId)
	{
		$node = Mage::getConfig()->getNode('global/sales/old_fields_map/' . $entityId);
		if ($node === false) {
			return array();
		}
		return (array) $node;
	}
}