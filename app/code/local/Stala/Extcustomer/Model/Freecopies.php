<?php

/**
 * Model zur Behandlung von Freiexemplaren
 * 
 * @category   	Stala
 * @package    	Stala_Extcustomer
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 */
class Stala_Extcustomer_Model_Freecopies extends Mage_Core_Model_Abstract
{
	
	protected static $_processedProducts = array();
	protected static $_forAll = false;
	protected static $_isDebug = false;
	protected static $_processedFreecopies = 0;
	
	protected $_currentFreecopyParentItem = null;
	
	protected $_isReset = false;
	
	/**
     * Initialize resources
     * 
     * @return void
     */
    protected function _construct()
    {
//     	Mage::log("Freecopy constructor called", Zend_Log::DEBUG, Stala_Helper::LOG_FILE);
        $this->_init('extcustomer/freecopies');
    }
    
    /**
     * Set the customers freecopies for all products.
     * 
     * @param int $freecopies Freiexemplare
     * @param Mage_Customer_Model_Customer $customer Kunde
     * 
     * @return $this
     */
	public function setFreecopiesForAllProducts($freecopies, $customer) {
		if (!isset($freecopies))
			return $this;
		
		self::$_forAll = true;
		
		if (Mage::getStoreConfig('dev/log/log_level') == Zend_Log::DEBUG)
			self::$_isDebug = true;
		
		Mage::log('Setting freecopies for all products', Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
		
		/* @var $productModel Mage_Catalog_Model_Product */
		$productModel = Mage::getModel('catalog/product');
		
		if ($freecopies <= 0.00001) {
			//Bei werten kleiner 0.00001 werden alle Einträge gelöscht!
			/* @var $collection Stala_Extcustomer_Model_Mysql4_Freecopies_Collection */
			$collection = $this->getCollection();
			
			$customerId = 0;
			if ($customer instanceof Mage_Customer_Model_Customer) {
				$customerId = $customer->getId();
			} else {
				Mage::throwException(Mage::helper('extcustomer')->__('Customer was not set!'));
			}
			
			$collection->addFilterByCustomerId($customerId);
			
			$freecopies = 0;
			//Derivate führen beim löschen keine Prüfung auf Abhängigkeiten durch!
			$collection->walk('delete', array(false));
		} else {
			/* @var $products Mage_Catalog_Model_Resource_Eav_Mysql4_Product_Collection */
			$products = $productModel->getCollection();
			$products->addAttributeToSelect('price');
			$products->addAttributeToSelect('special_price');
			$products->addAttributeToSelect('tier_price');
			$products->addAttributeToSelect('special_from_date');
			$products->addAttributeToSelect('special_to_date');
			$products->addAttributeToSelect('filter_price_range');
			
			//Abhängigkeit von Abo entfernt => Derivate entfallen damit
			if (Mage::getModel('eav/entity_attribute')->getIdByCode('catalog_product', 'abo_parent_product')) {
				$products->addAttributeToSelect('abo_parent_product');
				
				$products->addAttributeToFilter(
					array(
						array('attribute' => 'abo_parent_product', 0), //oder Verknüpft
						/* @see Varien_Data_Collection_Db-> _getConditionSql() */
						array('attribute' => 'abo_parent_product', 'null' => true) //steht für is null (Null muss links stehen, der rechte Teil wird ignoriert, muss aber gesetzt sein!)
					),
					'',
					'left'
				);
			}
			
			//langsam
			//$productIds = $products->getAllIds();
//			Mage::log($products->getSelect()->assemble(), Zend_Log::DEBUG, Stala_Helper::LOG_FILE);			
			/* @var $product Mage_Catalog_Model_Product */
			foreach ($products->getItems() as $product) {
				//langsam				
				//$product = Mage::getModel('catalog/product')->load($productId, array('abo_parent_product'));
				$this->_setFreecopiesForProduct($product, $freecopies, $customer, Stala_Extcustomer_Helper_Data::OPTION_GLOBAL);
				/* if ($product instanceof Egovs_Acl_Model_Product && is_callable(array($product, '__releaseMemory'))) {
					if ($tmp) {
						Mage::log('Release memory', Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
					}
					$product->__releaseMemory();
				}
				unset($product); */
			}
		}
		$customer->setStalaBaseFreecopies($freecopies);
		
		return $this;
	}
	
	/**
	 * Prüft ob das Produkt kostenlos ist.
	 * 
	 * @param Mage_Catalog_Model_Product $product Produkt
	 * 
	 * @return boolean
	 */
	public function isProductForFree(&$product) {
		if (!($product instanceof Mage_Catalog_Model_Product)) {
			return true;
		}
		
		$price = $product->getPrice();
		$price = Mage::app()->getLocale()->getNumber($price);
		if (is_numeric($price) && $price > 0.0) {
			return false;
		} elseif (is_numeric($price) && $price < 0.001) {
			return true;
		}
		
		//Falls kein Preis verfügbar
		return false;
	}
	
	/**
	 * Setzt die Freiexemplare für ein abgeleitetes Produkt
	 *  
	 * Die Freiexemplare kommen vom Parent-Produkt
	 * 
	 * @param Mage_Catalog_Model_Product &$product Produkt
	 * @param mixed                      $customer Customer ID or Mage_Customer_Model_Customer Kunde
	 * 
	 * @return Stala_Extcustomer_Model_Freecopies
	 */
	protected function _setFreecopiesForDerivate(&$product = null, $customer = null) {
		//Das Produkt muss pro Kunde behandelt werden
		if (is_null($product))
			return $this;
		
		if (is_numeric($customer)) {
			if (!Mage::getResourceSingleton('customer/customer')->checkCustomerId($customer)) {
				Mage::throwException(Mage::helper('extcustomer')->__('Invalid customer specified!'));
			}	
		} elseif ($customer instanceof Mage_Customer_Model_Customer) {
			$customer = $customer->getId();
		} else {
			Mage::throwException(Mage::helper('extcustomer')->__('Customer was not set!'));
		}
		
		$aboParentProductId = $product->getAboParentProduct();
		if ($aboParentProductId < 1)
			Mage::throwException("This product (ID: {$product->getId()}) was no derivate!");
		
		
		/* 
		 * Basefreecopies von Parent holen
		 * 
		 * @var $collection Stala_Extcustomer_Model_Mysql4_Freecopies_Collection
		 * */
		if (!$this->_currentFreecopyParentItem
			|| $this->_currentFreecopyParentItem->getProductId() != $aboParentProductId
			|| $this->_currentFreecopyParentItem->getCustomerId() != $customer
		) {
			Mage::log('freecopies::No parent item cached loading...', Zend_Log::DEBUG, Stala_Helper::LOG_FILE);
			$collection = $this->getCollection();
			$collection->loadByProductIdAndCustomerId($aboParentProductId, $customer);
			$freecopies = 0;
			//Die Attribute des parent items holen
			//Es darf eigentlich nur ein Item enthalten sein!
			if ($collection->count() > 1) {
				Mage::throwException('Can´t set freecopies, ambiguous products for customer (ID %s) found!', array($customer));
			}
			
			$this->_currentFreecopyParentItem = $collection->getFirstItem();			
		}
		
		if ($this->_currentFreecopyParentItem && !$this->_currentFreecopyParentItem->isEmpty()) {
			$baseFreecopies = $this->_currentFreecopyParentItem->getBaseFreecopies();
			$freecopies = isset($baseFreecopies) && ((int)$baseFreecopies) >= 0 ? $baseFreecopies : 0;
		} else {
			$freecopies = 0;
		}
		//Nicht benötigt da collection mit gleichem Kunden geladen!
		//$customer = Mage::getModel('customer/customer')->load($item->getCustomerId());
		//Derivate haben immer Stala_Extcustomer_Helper_Data::OPTION_DERIVATE als Option
		//$option = $item->getOption();
					
		$collection = $this->getCollection();
		$productId = $product->getId();
		$collection->loadByProductIdAndCustomerId($productId, $customer);
		if ($collection->count() < 1 && $freecopies > 0.00001) {
			if (!$this->isProductForFree($product)) {
				//Neue Items werden nur bei Werten > 0 angelegt!
				$item = $collection->getNewEmptyItem();
				
				$item->setProductId($productId);
				$item->setCustomerId($customer);
				//Muss vor setFreecopies stehen ->Cross-Freecopies
				$item->setOption(Stala_Extcustomer_Helper_Data::OPTION_DERIVATE);
				$item->setBaseFreecopies($freecopies);
							
				$collection->addItem($item);
			}
		} elseif ($collection->count() >= 1) {
			if ($collection->count() > 1) {
				Mage::throwException('Can´t set freecopies, ambiguous products for customer (ID %s) found!', array($customer->getId()));
			}
			/* @var $item Stala_Extcustomer_Model_Freecopies */
			$item = $collection->getFirstItem();
							
			if ($freecopies > 0.00001) {
				//Alte Ableitungen sollen mit eingebunden werden, aber nur falls initiale Freiexemplare == Freiexemplare
				if ($item->getBaseFreecopies() == $item->getFreecopies(false) && !$this->isProductForFree($product)) {
					$this->_resetQuoteItem($item, $product);
					$item->setBaseFreecopies($freecopies);
				}
				//else omit				
			} else {
				$this->_resetQuoteItem($item, $product);
				$item->delete();
			}
		} else {
			//Item existiert noch nicht und Freecopies < 1
// 			Mage::log('freecopies::Upps, that could not happen! There is no case defined!', Zend_Log::INFO, Stala_Helper::LOG_FILE);
		}
		
		$collection->save();
		
		return $this;
	}
	
	/**
	 * Calls _setFreecopiesForDerivate() from the corresponding parent item.
	 * 
	 * @param mixed $mixed    Item or Array of Mage_Catalog_Model_Product
	 * @param mixed $customer Customer ID or Mage_Customer_Model_Customer
	 * 
	 * @return $this
	 * @see $this->_setFreecopiesForDerivate($product);
	 */
	protected function _processDerivatesFromParent($mixed, $customer) {
		$items = array();
		if (!is_array($mixed) && $mixed instanceof Mage_Catalog_Model_Product) {
			$items[] = $mixed;
		} elseif (is_array($mixed)) {
			$items = $mixed;
		} else return $this;
		
		if (is_numeric($customer)) {
			if (!Mage::getResourceSingleton('customer/customer')->checkCustomerId($customer)) {
				Mage::throwException(Mage::helper('extcustomer')->__('Invalid customer specified!'));
			}	
		} elseif ($customer instanceof Mage_Customer_Model_Customer) {
			$customer = $customer->getId();
		} else {
			Mage::throwException(Mage::helper('extcustomer')->__('Customer was not set!'));
		}
		
		//Abhängigkeit von Abo entfernt => Derivate entfallen damit
		if (!Mage::getModel('eav/entity_attribute')->getIdByCode('catalog_product', 'abo_parent_product')) {
			return $this;
		}
		
		foreach ($items as $item) {
			/* @var $productModel Mage_Catalog_Model_Product */
			$productModel = Mage::getModel('catalog/product');
			
// 			//Gilt für alle heute erstellten
// 			$todayDate  = Mage::app()->getLocale()->date()->toString(Varien_Date::DATE_INTERNAL_FORMAT);			
// 			//Gilt nur für zukünftige Ableitungen
// 			//$todayDate  = Mage::app()->getLocale()->date()->toString(Varien_Date::DATETIME_INTERNAL_FORMAT);
			/*
			 * Abgeleitete Produkte ermitteln
			 */
			/* @var $products Mage_Catalog_Model_Resource_Eav_Mysql4_Product_Collection */
			$products = $productModel->getCollection();
			$products->addAttributeToSelect('abo_parent_product');
			$products->addAttributeToFilter('abo_parent_product', $item->getId());
			$products->addAttributeToFilter('abo_parent_product', array('gt' => 0));
			
			//Alte Ableitungen sollen mit eingebunden werden, aber nur falls initiale Freiexemplare == Freiexemplare
			//$products->addAttributeToFilter('created_at', array('gteq' => $todayDate));
			
			//zu langsam
			//$productIds = $products->getAllIds();
			
			foreach ($products->getItems() as $derivate) {
				//zu langsam
				//$derivate = Mage::getModel('catalog/product')->load($productId, array('abo_parent_product'));
				$this->_setFreecopiesForDerivate($derivate, $customer);

				/* if ($derivate instanceof Egovs_Acl_Model_Product && is_callable(array($derivate, '__releaseMemory'))) {
					$derivate->__releaseMemory();
				}
				unset($derivate); */				
			}
		}
		
		return $this;
	}
	
	/**
	 * Set the customers freecopies for a single product
	 *  
	 * @param Mage_Catalog_Model_Product	   &$product   Produkt
	 * @param int 						 	   $freecopies Freiexmplaranzahl
	 * @param int|Mage_Customer_Model_Customer $customer   Kunden ID
	 * @param int 						 	   $option	   Option
	 * 
	 * @return Stala_Extcustomer_Model_Freecopies
	 */
	protected function _setFreecopiesForProduct(&$product, $freecopies, $customer, $option = Stala_Extcustomer_Helper_Data::OPTION_INDIVIDUAL) {
		if (is_null($freecopies) && !isset($customer) && (!isset($product) || is_null($product) || !($product instanceof Mage_Catalog_Model_Product)))
			return $this;
		
		//Abgeleitete Produkte werden von ihrem Parent aus behandelt -> wichtig bei setFreecopiesForAllProducts(...)
		if ($product->getAboParentProduct() > 0) {			
//			$this->_setFreecopiesForDerivate($product, $customer);
			return $this;
		}
		
		if ($customer instanceof Mage_Customer_Model_Customer && !$customer->isEmpty()) {
			$customer = $customer->getId();
		}
		
		if (is_null($freecopies) || !is_numeric($customer) || !Mage::getResourceSingleton('customer/customer')->checkCustomerId($customer)) {
			Mage::log("stala::freecopies::_setFreecopiesForProduct(): Freecopies was null or customer id ($customer) was invalid!", Zend_Log::WARN, Stala_Helper::LOG_FILE);
			return $this;
		}
		
		/* @var $collection Stala_Extcustomer_Model_Mysql4_Freecopies_Collection */
		$collection = $this->getCollection();
		$collection->loadByProductIdAndCustomerId($product->getId(), $customer);
		if (($count = $collection->count()) > 0) {
			//Es darf eigentlich nur ein Item enthalten sein!
			if ($count > 1) {
				Mage::throwException('Can´t set freecopies, ambiguous products for customer (ID %s) found!', array($customer));
			}
			$item = $collection->getFirstItem();
			
			if ($freecopies > 0.00001) {
				$this->_resetQuoteItem($item, $product);
				//Muss vor setFreecopies stehen ->Cross-Freecopies
				//Preserve Individuals -> nur in For All Action
				if (!(self::$_forAll && $item->getOption() == Stala_Extcustomer_Helper_Data::OPTION_INDIVIDUAL))
					$item->setOption($option);
				$item->setBaseFreecopies($freecopies);
			} else {
				$this->_resetQuoteItem($item, $product);
				$item->delete();
			}
			//20120403 Frank Rochlitzer
			//siehe delete()
// 			if (!$item->isDeleted()) {
// 				$this->_currentFreecopyParentItem = $item;
// 			}
			$this->_currentFreecopyParentItem = $item;
		} else {
			if ($freecopies > 0.00001 && !$this->isProductForFree($product)) {
				//Neue Items werden nur bei Werten > 0 angelegt!
				$item = $collection->getNewEmptyItem();
				
				$item->setProductId($product->getId());
				$item->setCustomerId($customer);
				//Muss vor setFreecopies stehen ->Cross-Freecopies
				$item->setOption($option);
				$item->setBaseFreecopies($freecopies);
				
				$collection->addItem($item);
				$this->_currentFreecopyParentItem = $item;
			}
		}		
		$collection->save();
		
		//Ableitungen behandeln
		$this->_processDerivatesFromParent($product, $customer);		
		
		$this->_currentFreecopyParentItem = null;
		
		return $this;
	}
	
	/**
	 * Macht einen Reset der Freiexemplare in der aktuellen Quote des Kunden
	 * 
	 * @param Stala_Extcustomer_Model_Freecopies &$item    Freiexemplarinstanz
	 * @param Mage_Catalog_Model_Product 		 &$product Produktinstanz
	 * 
	 * @return Stala_Extcustomer_Model_Freecopies
	 */
	protected function _resetQuoteItem(&$item, &$product = null) {
		if (!$item || !($item instanceof Stala_Extcustomer_Model_Freecopies)) {
			return $this;
		}
		
		if ($item->isReset()) {
			return $this;
		}
		
		/* @var $quote Mage_Sales_Model_Quote */
		$quote = Mage::getModel('sales/quote')->loadByCustomer(
			//Leere Quote kann nur mit Object Customer geladen werden,
			//sonst muss Store manuell gesetzt werden
			Mage::getModel('customer/customer')->load($item->getCustomerId(), array('store_id', 'website_id'))
		);
		
		if (!$quote) {
			return $this;
		}
		
		if (!$product || !($product instanceof Mage_Catalog_Model_Product)) {
			$product = Mage::getModel('catalog/product')->load($item->getProductId());
		}
		$quoteItem = $quote->getItemByProduct($product);
		if (!$quoteItem) {
			return $this;
		}
		/*
		 * 20110829:: Frank Rochlitzer: Ticket #765 (ZVM 261)
		 * Wir setzen die Freiexemplare hier einfach zurück auf 0, bei einer Warenkorbaktualisierung
		 * werden sie dann automatisch neu berechnet!
		 */
		$quoteItem->setStalaFreecopies(0);
		$quoteItem->save();
		
		$item->_isReset = true;
		
		return $this;
	}
	
	/**
	 * Calculates the real tax amount without any discount
	 * 
	 * @param Mage_Sales_Model_Quote_Item $quoteItem Quoteinstanz
	 * 
	 * @return float
	 * 
	 * @see Mage_Sales_Model_Quote_Item_Abstract::calcTaxAmount
	 */
	protected function _getCalcTaxAmount($quoteItem) {
		return Mage::helper('extcustomer')->getCalcTaxAmount($quoteItem);
	}
	
	/**
	 * Calculates the real base tax amount without any discount
	 * 
	 * @param Mage_Sales_Model_Quote_Item $quoteItem Quoteinstanz
	 * 
	 * @return float
	 * 
	 * @see Mage_Sales_Model_Quote_Item_Abstract::calcTaxAmount
	 */
	protected function _getCalcBaseTaxAmount($quoteItem) {
		return Mage::helper('extcustomer')->getCalcBaseTaxAmount($quoteItem);
	}
	
	/**
	 * Gibt die erste geladene nicht leere Collection unter Berücksichtigung möglicher Hauptkunden zurück.
	 * 
	 * Es wird unter Berücksichtigung möglicher Hauptkunden versucht eine nicht leere Collection mit Freiexemplaren zu finden und zu laden.
	 * Falls es keine Freiexemplare in der Kundenkette gibt, wird eine leere Collection zurück geliefert.
	 *  
	 * @param int 							   $productId Produkt ID
	 * @param Mage_Customer_Model_Customer|int $customer  Kunden ID
	 * 
	 * @return Stala_Extcustomer_Model_Mysql4_Freecopies_Collection Geladene erste nicht leere Collection oder eine leere Collection
	 */
	public function loadCollectionIncludeParents($productId, $customer) {
// 		Mage::log("freecopies::loadCollectionIncludeParents called...", Zend_Log::DEBUG, Stala_Helper::LOG_FILE);
		if (is_numeric($customer)) {
			$customer = Mage::getModel('customer/customer')->load($customer);
		}
		
		if (!is_numeric($productId) || $productId < 1) {
			return $this->getCollection()->loadByProductIdAndCustomerId(
				0,
				0
			);
		}
		
		if (!($customer instanceof Mage_Customer_Model_Customer)) {
			return $this->getCollection()->loadByProductIdAndCustomerId(
				$productId,
				0
			);
		}
		
		$collection = null;
		do {
// 			Mage::log("freecopies::Looking for customers with freecopies including parent customers...", Zend_Log::DEBUG, Stala_Helper::LOG_FILE);
			/* @var $collection Stala_Extcustomer_Model_Mysql4_Freecopies_Collection */
			$collection = $this->getCollection()->loadByProductIdAndCustomerId(
				$productId,
				$customer->getId()
			);
				
			$customer = Mage::getModel('customer/customer')->load($customer->getParentCustomerId());
			
// 			Mage::log(sprintf("freecopies::customer ID: %d", var_export($customer->getId(), true)), Zend_Log::DEBUG, Stala_Helper::LOG_FILE);
// 			Mage::log(sprintf("freecopies::customer data array: %s", var_export($customer->getData(), true)), Zend_Log::DEBUG, Stala_Helper::LOG_FILE);
// 			Mage::log(sprintf("freecopies::customer is empty: %s", var_export($customer->isEmpty(), true)), Zend_Log::DEBUG, Stala_Helper::LOG_FILE);
// 			Mage::log(sprintf("freecopies::collection size is: %d", var_export($collection->count(), true)), Zend_Log::DEBUG, Stala_Helper::LOG_FILE);
			/*
			 * 20111101::Frank Rochlitzer
			 * $customer->isEmpty() liefert bei einem leeren Kunden trotzdem:
			 * 2011-11-01T15:09:01+00:00 DEBUG (7): freecopies::customer data array: array (
  			 *		0 => NULL,
			 * )
			 * 
			 * Problem lag an Attributen die nach dem laden eines Kunden Daten gesetzt haben!
			 * siehe [2373] & [2375]
			 */
		} while ($collection->count() < 1 && !$customer->isEmpty() && $customer->getId() > 0);
		
		return $collection;
	}
	
	/**
	 * Set the amount of freecopies for a product per customer 
	 * 
	 * @param mixed $product    Product ID or Mage_Catalog_Model_Product
	 * @param int   $freecopies Amount of freecopies
	 * @param mixed $customer   Customer ID or Mage_Customer_Model_Customer
	 * @param int   $option     Option
	 * 
	 * @return Stala_Extcustomer_Model_Freecopies
	 */
	public function setFreecopiesForProduct($product, $freecopies = null, $customer = null, $option = Stala_Extcustomer_Helper_Data::OPTION_INDIVIDUAL) {
		if (is_numeric($product) && $product > 0) {
			$product = Mage::getModel('catalog/product')->load($product, array('abo_parent_product', 'price', 'special_price', 'special_from_date', 'special_to_date', 'filter_price_range', 'tier_price'));
			if (is_null($product)) {
				return $this;
			}
		} elseif (!($product instanceof Mage_Catalog_Model_Product)) {
			return $this;
		}
		
		self::$_forAll = false;
		
		if (is_null($freecopies)) {
			$freecopies = $this->getFreecopies(false);
			
			if (!isset($freecopies) || is_null($freecopies)) {
				Mage::throwException(Mage::helper('extcustomer')->__('Amount of freecopies not set!'));
			}
			
			$freecopies = $freecopies < 0 ? 0 : $freecopies;
		}
		
		if (is_null($customer)) {
			$customer = $this->getCustomerId();
		}
		
		if (is_numeric($customer)) {
			if (!Mage::getResourceSingleton('customer/customer')->checkCustomerId($customer)) {
				Mage::throwException(Mage::helper('extcustomer')->__('Invalid customer specified!'));
			}	
		} elseif ($customer instanceof Mage_Customer_Model_Customer) {
			$customer = $customer->getId();
		} else {
			Mage::throwException(Mage::helper('extcustomer')->__('Customer was not set!'));
		}
		
		return $this->_setFreecopiesForProduct($product, $freecopies, $customer, $option);
	}
	
	/**
	 * Set freecopies for derivate products.
	 * 
	 * The derivate is processed for all customers of the parent product.
	 *  
	 * @param mixed $product Product ID or Mage_Catalog_Model_Product
	 * 
	 * @return Stala_Extcustomer_Model_Freecopies
	 */
	public function setFreecopiesForDerivate($product) {
		if (is_numeric($product) && $product > 0) {
			$product = Mage::getModel('catalog/product')->load($product, array('abo_parent_product'));
			if (is_null($product)) {
				return $this;
			}
		} elseif (!($product instanceof Mage_Catalog_Model_Product)) {
			return $this;
		}
		
		//es werden nur abgeleitete Produkte behandelt
		if ($product->getAboParentProduct() < 1) {			
			Mage::log("stala::freecopies::setFreecopiesForDerivate: The product was no derivate!", Zend_Log::NOTICE, Stala_Helper::LOG_FILE);
			return $this;
		}
		
		$col = $this->getCollection()
					->loadByProductId($product->getAboParentProduct());
		
		foreach ($col->getItems() as $item) {
			$this->_setFreecopiesForDerivate($product, $item->getCustomerId());
		}
		
		return $this;
	}
	
	/**
	 * Ermittelt die verfügbaren Freiexemplare und berechnet den Rabatt
	 * 
	 * Die Änderungen sind nach dem Methodenaufruf permanent.
	 * Technik bedingt werden immer erst die Magentorabatte berechnet.
	 * 
	 * @param Mage_Sales_Model_Quote_Item $quoteItem Quoteinstanz
	 * 
	 * @return float Calculated discount amount
	 */
	public function getAvailableFreecopiesAmount($quoteItem) {
// 		Mage::log("freecopies::getAvailableFreecopiesAmount called...", Zend_Log::DEBUG, Stala_Helper::LOG_FILE);
		if (!($quoteItem instanceof Mage_Sales_Model_Quote_Item))
			return 0.0;
		
		if ($quoteItem->getIsQtyDecimal()) {
			Mage::log("The product with ID ({$quoteItem->getProduct()->getId()}) for Customer ID ({$quoteItem->getQuote()->getCustomer()->getId()}) has a decimal quantity, this is not supported.",
						Zend_Log::ERR, Stala_Helper::LOG_FILE);
			return 0.0;
		}
		
		$quoteItem = new Stala_Extcustomer_Model_Sales_Decorator($quoteItem);
		
		$currentFreecopies = $quoteItem->getFlatStalaFreecopies() > 0 ? $quoteItem->getFlatStalaFreecopies() : 0;
		
		$freecopiesAmount = 0;
		
		/*
		 * Aktuelle Rabatte beschaffen
		 */
		$magentoDiscount = $quoteItem->getDiscountAmount();
		if (!$magentoDiscount || $magentoDiscount < 0 || !is_numeric($magentoDiscount)) {
			$magentoDiscount = 0;
		}
		$magentoBaseDiscount = $quoteItem->getBaseDiscountAmount();
		if (!$magentoBaseDiscount || $magentoBaseDiscount < 0 || !is_numeric($magentoBaseDiscount)) {
			$magentoBaseDiscount = 0;
		}
		
		//Preis ohne MwSt.
		$calcPrice = $quoteItem->getRowTotal();
		$calcBasePrice = $quoteItem->getBaseRowTotal();
		
		if (!Mage::helper('tax')->applyTaxAfterDiscount($quoteItem->getStore()) && Mage::helper('tax')->discountTax($quoteItem->getStore())) {
			$calcPrice = round($calcPrice + $this->_getCalcTaxAmount($quoteItem), 2);
			$calcBasePrice = round($calcBasePrice + $this->_getCalcBaseTaxAmount($quoteItem), 2);
		}
		
		$calcPrice = round($calcPrice - $magentoDiscount, 2);
		$calcBasePrice = round($calcBasePrice - $magentoBaseDiscount, 2);
		$freecopiesRequired = 0;
		
		$stalaFreecopies = $quoteItem->getStalaFreecopies();
		
		$item = $this->loadByProductCustomerId(
			$quoteItem->getProduct()->getId(),
			$quoteItem->getQuote()->getCustomer(),
			true
		);
		
		/* @var $item Stala_Extcustomer_Model_Freecopies */
		if ($item->isEmpty()) {
			Mage::log("The product with ID ({$quoteItem->getProduct()->getId()}) for Customer ID ({$quoteItem->getQuote()->getCustomer()->getId()}) with parent relations has no freecopies.",
						Zend_Log::NOTICE, Stala_Helper::LOG_FILE);
			return 0.0;
		}
						
		$freecopies = $item->getFlatFreecopies();
		
		if ($freecopies > 0.00001 || $currentFreecopies > $quoteItem->getQty() ||
			//Muss berücksichtigt werden sobald Magentorabatte verwendet werden
			$quoteItem->getDiscountAmount() != 0) {
		
			//Eigentliche Berechnung der Freiexemplare
			//PHP hat Probleme bei der Subtraktion zweier gleich großer Zahlen!
			//######################################################################################################################
			//Wir benutzen die Währung des Kunden als Referenz
			$calcP = $quoteItem->getCalculationPrice();
			if (!$calcP) {
				$calcP = 1;
			}
			if ($calcP < 0.01) {
				$calcP = 1;	
			}
			 
			if ($quoteItem->getIsQtyDecimal()) {
				$freecopiesRequired = round($calcPrice / $calcP, 4);
			} else {
				$freecopiesRequired = ceil($calcPrice / $calcP);
			}
			
			if ($freecopiesRequired > $quoteItem->getQty()) {
				$freecopiesRequired = $quoteItem->getQty();
			}
			
			if (round(($freecopiesRequired - $currentFreecopies) - $freecopies, 4) <= 0) {
				$freecopiesAmount = round($freecopiesRequired - $currentFreecopies, 4);
			} else {
				$freecopiesAmount = $freecopies;
			}
			
			$usedFreecopies = array();
			if ($freecopiesAmount < 0) {
				$stalaFreecopies = $item->increaseFreecopies($stalaFreecopies, $freecopiesAmount * -1);
			} else {
				$usedFreecopies = $item->decreaseFreecopies($freecopiesAmount);
			}
			
			if ($quoteItem->getFlatStalaFreecopies() > 0) {
				$stalaFreecopies = self::mergeFreecopiesArray($stalaFreecopies, $usedFreecopies);
			} else {
				$stalaFreecopies = $usedFreecopies;
			}
		}
		$quoteItem->setStalaFreecopies($stalaFreecopies);
		
		/*
		 * Ticket #726 Magento-Rabatte funktionieren nicht mehr
		 * Da Discount von Magento im Event immer auf 0 gesetzt wird und somit immer neu berechnet werden muss,
		 * können wir die Discount-Berechnung bei 0 Freiexemplaren überspringen.
		 * Damit wird auch ein möglicher Magento Discount nicht überschrieben (auf 0 gesetzt)!
		 */
		if ($quoteItem->getFlatStalaFreecopies() < 1) {
			return 0.0;
		}
		
		$discount = 0.0;	//Währung des Kunden
		$baseDiscount = 0.0; //Währung des Shops
		
		if ($quoteItem->getFlatStalaFreecopies() >= $quoteItem->getQty()) {
			//Da hier 100% Rabatt gewährt werden, spielen andere Rabatte keine Rolle
			//TODO : In Magento >1.3 muss Tax vielleicht wieder raus
			$discount = round($calcPrice, 2);
			$baseDiscount = round($calcBasePrice, 2);
		} else {
			$singlePrice = round(($calcPrice + $magentoDiscount) / $quoteItem->getQty(), 2);
			$singleBasePrice = round(($calcBasePrice + $magentoBaseDiscount) / $quoteItem->getQty(), 2);
			
			$taxAmount = 0;
			$baseTaxAmount = 0;
			if (Mage::helper('tax')->priceIncludesTax($quoteItem->getStore())) {
				$taxAmount = round(
					round(
						$singlePrice * $quoteItem->getFlatStalaFreecopies() * ((100 + $quoteItem->getTaxPercent()) / 100),
						2
					) - $singlePrice * $quoteItem->getFlatStalaFreecopies(),
					2
				);

				$baseTaxAmount = round(
					round(
						$singleBasePrice * $quoteItem->getFlatStalaFreecopies() * ((100 + $quoteItem->getTaxPercent()) / 100),
						2
					) - $singleBasePrice * $quoteItem->getFlatStalaFreecopies(),
				2);
			} /*elseif (
					!Mage::helper('tax')->applyTaxAfterDiscount($quoteItem->getStore()) && Mage::helper('tax')->discountTax($quoteItem->getStore())
					//Wird ignoriert, wenn 'Steuer nach Rabatt berechnen' aktiv ist
					|| (Mage::helper('tax')->applyTaxAfterDiscount($quoteItem->getStore()) == false && Mage::helper('tax')->discountTax($quoteItem->getStore()))
				) {
				
				$taxAmount = round(round($singlePrice * ((100 + $quoteItem->getTaxPercent()) / 100), 2) - $singlePrice, 2);
				$taxAmount = round($taxAmount * $quoteItem->getFlatStalaFreecopies(), 2);
				
				$baseTaxAmount = round(round($singleBasePrice * ((100 + $quoteItem->getTaxPercent()) / 100), 2) - $singleBasePrice, 2);
				$baseTaxAmount = round($baseTaxAmount * $quoteItem->getFlatStalaFreecopies(), 2);
			}*/
			$price = round($singlePrice * $quoteItem->getFlatStalaFreecopies(), 2);
			$basePrice = round($singleBasePrice * $quoteItem->getFlatStalaFreecopies(), 2);
			
//			$price = round($singlePrice / (1+$quoteItem->getTaxPercent() / 100),2);
//			$basePrice = round($singleBasePrice / (1+$quoteItem->getTaxPercent() / 100),2);
			
			//TODO : In Magento >1.3 muss Tax vielleicht wieder raus
			$discount = round($price + $taxAmount, 2);
			$baseDiscount = round($basePrice + $baseTaxAmount, 2);
		}
		
		/*
		 * Siehe #747
		 * 20111205::Frank Rochlitzer
		 * Bei prozentualen Rabatten muss der Magentorabatt anteilig gerechnet werden
		 */
		if ($quoteItem->getDiscountPercent() > 0 && 
			$quoteItem->getQty() > 0 &&
			$quoteItem->getQty() > $quoteItem->getFlatStalaFreecopies()
			) {
			$unaffectedByFreecopies = $quoteItem->getQty() - $quoteItem->getFlatStalaFreecopies();
			if ($unaffectedByFreecopies <= 0.0001)
				$unaffectedByFreecopies = 0;
			 
			$magentoDiscount = round(($magentoDiscount / $quoteItem->getQty()) * $unaffectedByFreecopies, 2);
			$magentoBaseDiscount = round(($magentoBaseDiscount / $quoteItem->getQty()) * $unaffectedByFreecopies, 2);
		}
		$quoteItem->setDiscountAmount($discount+$magentoDiscount);
		$quoteItem->setBaseDiscountAmount($baseDiscount+$magentoBaseDiscount);
		
		return $discount;
	}
	
	/**
	 * Führt zwei Freecopy-Arrays zusammen
	 * 
	 * Dabei werden die Freecopies vorhandener Kunden aufaddiert.
	 * 
	 * @param array $array1 Array 
	 * @param array $array2 Array
	 * 
	 * @return array Zusammengeführtes array
	 */
	public static function mergeFreecopiesArray($array1, $array2) {
		$result = $array1;
		
		foreach ($array2 as $key => $value) {
			if (array_key_exists($key, $result)) {
				$result[$key] += $value;
			} else {
				$result[$key] = $value;
			}
		}
		
		return $result;
	}
	
	/**
	 * Updates the customers freecopies amount
	 * 
	 * @param Mage_Sales_Model_Quote_Item $quoteItem Quoteinstanz
	 * 
	 * @return Stala_Extcustomer_Model_Freecopies
	 */
	public function updateFreecopiesOnQuoteItemDelete($quoteItem) {
		if (is_null($quoteItem))
			return $this;
		
		$quoteItem = new Stala_Extcustomer_Model_Sales_Decorator($quoteItem);
		
		if ($quoteItem->getFlatStalaFreecopies() <= 0)
			return $this;
		
		$this->setProductId($quoteItem->getProduct()->getId());
		
		$this->increaseFreecopies($quoteItem->getStalaFreecopies());
				
		return $this;
	}
	
	/**
	 * Updates the customers freecopies amount on cancel or refund action.
	 * 
	 * @param Mage_Sales_Model_Order_Item $orderItem Orderinstanz
	 * @param boolean                     $isRefund  Gutschrift?
	 * 
	 * @return Stala_Extcustomer_Model_Freecopies
	 */
	public function updateFreecopiesOnCancelRefund($orderItem, $isRefund = false) {
		if (is_null($orderItem))
			return $this;

		$orderItem = new Stala_Extcustomer_Model_Sales_Decorator($orderItem);
		
		if ($orderItem->getFlatStalaFreecopies() <= 0)
			return $this;
		
		$this->setProductId($orderItem->getProductId());		
		
		if ($isRefund) {
			$qtyToCancelRefund = round($orderItem->getQtyRefunded() - $orderItem->getOrigData('qty_refunded'), 2);
		} else {
			$qtyToCancelRefund = $orderItem->getQtyToCancel();
		}
		
		if ($orderItem->getFlatStalaFreecopies() > $qtyToCancelRefund) {
			$rest = $this->increaseFreecopies($orderItem->getStalaFreecopies(), $qtyToCancelRefund);
			$orderItem->setStalaFreecopies($rest);
		} else {
			$this->increaseFreecopies($orderItem->getStalaFreecopies());
			$orderItem->unsStalaFreecopies();
		}
		
		return $this;
	}
	
	/**
	 * Abgeleitete Produkte können ebenfalls mit gelöscht werden
	 * 
	 * @param boolean $check Auf Ableitungen prüfen und auch löschen
	 * 
	 * @return Stala_Extcustomer_Model_Freecopies
	 * 
	 * @see Mage_Core_Model_Abstract::delete()
	 */
	public function delete($check = true) {
		if (is_array($check) && !empty($check) && $check[0] === false) {
			$check = false;
		}
			
		if ($this->getOption() != Stala_Extcustomer_Helper_Data::OPTION_DERIVATE
			&& $check === true
			&& Mage::getModel('eav/entity_attribute')->getIdByCode('catalog_product', 'abo_parent_product')
		) {
			/* @var $productModel Mage_Catalog_Model_Product */
			$productModel = Mage::getModel('catalog/product');
			
			/*
			 * Abgeleitete Produkte ermitteln
			 */
			/* @var $products Mage_Catalog_Model_Resource_Eav_Mysql4_Product_Collection */
			$products = $productModel->getCollection();
			//And-Verknüpft
			$products->addAttributeToFilter('abo_parent_product', $this->getProductId());
			$products->addAttributeToFilter('abo_parent_product', array('gt' => 0));
			
			if ($products->count() > 0) {
				$collection = $this->getCollection();
				$collection->addFieldToFilter('product_id', array('in' => $products->getAllIds()));
				$collection->addFilterByCustomerId($this->getCustomerId());
				$collection->walk('delete');
			}
		}
		
		if ($check) {
			$this->_processCrossFreecopies('delete');
		}
		
		$this->_resetQuoteItem($this);
		
		return parent::delete();
	}
	
	/**
	 * Wird nach dem Löschen aufgerufen
	 * 
	 * @return Stala_Extcustomer_Model_Freecopies
	 * 
	 * @see Mage_Core_Model_Abstract::_afterDelete()
	 */
	protected function _afterDelete() {
		parent::_afterDelete();
		
		$this->_isDeleted = true;
		/*
		 * Damit können wir weiter $this->_currentFreecopyParentItem nutzen
		 */
		$this->setData('base_freecopies', 0);
		$this->setData('freecopies', 0);
		
		return $this;
	}
	
	/**
	 * Liefert ein Array aller Freiexemplare unter Einbezug von Haupt-/Nebenkundenbeziehungen.
	 * 
	 * Struktur:<br>
	 * array(customer => freecopies)
	 * 
	 * @param boolean $withRelations Soll die Haupt-/Nebenkundenbeziehung berücksichtigt werden
	 * 
	 * @return array|int Freiexemplare mit Beziehungen oder nur Anzahl Freiexemplare ohne Beziehungen
	 */
	public function getFreecopies($withRelations = true) {
		$value = $this->getData('freecopies');
		
		if (!$withRelations) {
			return (int) $value;
		}
		
		$value = array($this->getCustomerId() => $value);
		
		$customer = Mage::getModel('customer/customer')->load($this->getCustomerId());
		
		if (!$customer || $customer->isEmpty() || $customer->getParentCustomerId() < 1) {
			return $value;
		}
		
		//Ab hier existiert ein Hauptkunde
		//Besitzt die Kette von Hauptkunden Freiexemplare für dieses Produkt?		
		do {
			$customer = Mage::getModel('customer/customer')->load($customer->getParentCustomerId());
			if (!$customer || $customer->isEmpty() || $customer->getId() < 1) {
				return $value;
			}
			
			//Ab hier existiert ein Hauptkunde
			//Besitzt der Hauptkunde Freiexemplare für dieses Produkt?
			$parentCustomerFreecopies = Mage::getModel('extcustomer/freecopies')->loadByProductCustomerId($this->getProductId(), $customer->getId());
			if ($parentCustomerFreecopies && $parentCustomerFreecopies->getData('freecopies') > 0) {
				$value = self::mergeFreecopiesArray($value, $parentCustomerFreecopies->getFreecopies());
				return $value;
			}
		} while (
			$customer->getParentCustomerId() > 0			
		);
		
		return $value;
	}
	
	/**
	 * Liefert die Gesamtanzahl aller Freiexemplare mit Haupt-/Nebenkundenbeziehung 
	 * 
	 * @param array $freecopies Cached array an Freiexemplaren sonst wird getFreecopies() aufgerufen
	 * @return int Freiexemplaranzahl
	 */
	public function getFlatFreecopies($freecopies = null) {
// 		Mage::log("freecopies::getFlatFreecopies called...", Zend_Log::DEBUG, Stala_Helper::LOG_FILE);
		if (!is_array($freecopies)) {
			$freecopies = $this->getFreecopies();
		}
		
		$value = 0;
		
		foreach ($freecopies as $customer => $amount) {
			$value += $amount;
		}
		
		return (int) $value;
	}
	
	/**
	 * Verringert die Anzahl der Freiexemplare des Kunden um die entsprechende Anzahl
	 * 
	 * Falls keine Produkt und Kunden ID angegeben wird, wird die aktuelle Instanz genutzt.
	 * Die Haupt-/Nebenkundenbeziehungen werden unterstützt.
	 * <p><strong>Das herunterzählen von Stammartikeln wird explizit verhindert!</strong></p>
	 * 
	 * @param int $amount Anzahl der Exemplare
	 * @param int $productId Produkt ID (optional)
	 * @param int $customerId Kunden ID (optional)
	 * 
	 * @return array Leeres Array, bei Verringerung Array mit Kunden und deren verwendete Exemplare. 
	 */
	public function decreaseFreecopies($amount, $productId = null, $customerId = null) {
		if ($productId > 0 && $customerId > 0) {
			$this->loadByProductCustomerId($productId, $customerId, true);
		}
		
		if ($this->isEmpty() || empty($amount)) {
			return array();
		}
		
		$productId = $this->getProductId();
		$result = array();
		
		if (is_numeric($productId) && $productId > 0) {
			$product = Mage::getModel('catalog/product')->load($productId, array('is_abo_base_product'));
			if ($product && ($product->isEmpty() || $product->getIsAboBaseProduct() == 1)) {
				return $result;
			}
		}
		/*
		 * Das array beginnt mit den Freiexemplaren des aktuellen Kunden (array[0]).
		 * An Index 1 steht der erste Hauptkunde usw.
		 * In der Regel besteht das Array nur aus maximal einem Hauptkunden.
		 */
		$freecopies = $this->getFreecopies();
		
		if ($amount > 0) {
			$amount *= -1;
		}
		//Verringern der Freiexemplare
        /** @noinspection SuspiciousLoopInspection */
        foreach ($freecopies as $customerId => $value) {
			$x = min($value, -1 * $amount);
			
			if ($x > 0) {
				$result[$customerId] = $x;
				
				$instance = Mage::getModel('extcustomer/freecopies')->loadByProductCustomerId($productId, $customerId);
				
				$instance->setFreecopies(round($value - $x, 4))
					->save()
				;
			}
			
			$amount += $x;
			if ($amount >= 0)
				break;				
		}
		//force reload
		$this->load($this->getId());
		self::$_processedProducts = array();
		
		return $result;
	}
	
	/**
	 * Gibt an ob schon ein Reset der Quote durchgeführt wurde
	 * 
	 * @return boolean
	 */
	public function isReset() {
		return $this->_isReset;
	}
	
	/**
	 * Erhöht die Freiexemplare um den entsprechenden Betrag bzw. um die Werte im Array.
	 * 
	 * @param array $usedFreecopies Array mit den bereits verwendeten Daten
	 * @param int $amount Positive Anzahl um die erhöht werden soll oder falls nicht angegeben, werden alle Werte aus dem Array benutzt.
	 * @param int $productId Produkt ID
	 * @param int $customerId Kunden ID
	 * 
	 * @see Stala_Extcustomer_Model_Freecopies::modifyFreecopiesAmount
	 * 
	 * @return array Leeres Array oder Array mit den weiterhin verwendeten Daten
	 */
	public function increaseFreecopies($usedFreecopies, $amount = null, $productId = null, $customerId = null) {
		if ($productId > 0 && $customerId > 0) {
			$this->loadByProductCustomerId($productId, $customerId, true);
		}
				
		if ($this->isEmpty() || ($amount != null && $amount < 0) || !is_array($usedFreecopies)) {
			return $usedFreecopies;
		}
		
		if ($amount == null) {
			$amount = $this->getFlatFreecopies($usedFreecopies);
		}
		
		$productId = $this->getProductId();
		
		$masterId = $this->getId();
		$usedFreecopies = array_reverse($usedFreecopies, true);

        /** @noinspection SuspiciousLoopInspection */
        foreach ($usedFreecopies as $customerId => $value) {
			//sonst wird nicht korrekt hoch gezählt
			self::$_processedProducts = array();
			
			if (empty($customerId) || empty($productId)) {
				//Muss gelöscht werden
				unset($usedFreecopies[$customerId]);
				continue;
			}
			
			/* @var $instance Stala_Extcustomer_Model_Freecopies */
			$instance = Mage::getModel('extcustomer/freecopies')->loadByProductCustomerId($productId, $customerId);
				
			if ($instance->isEmpty()) {
				//enthält weder Produkt- oder Kunden-ID noch Freecopies
				//Muss gelöscht werden
				unset($usedFreecopies[$customerId]);
				continue;
			}
			
			$data = $instance->getData('freecopies') > 0 ? $instance->getData('freecopies') : 0;
			
			$x = min($value, $amount);
			if ($data+$x > $instance->getBaseFreecopies()) {
				$message = sprintf(
						"New freecopies value (%d) (customer: %d, product: %d) can't be greater than initial value (%d), setting it to max initial value!",
						$data+$x,
						$instance->getCustomerId(),
						$instance->getProductId(),
						$instance->getBaseFreecopies()
				);
				Mage::log($message, Zend_Log::ERR, Stala_Helper::EXCEPTION_LOG_FILE);
				
				$x = $instance->getBaseFreecopies() - $data;
				//Muss gelöscht werden
				unset($usedFreecopies[$customerId]);
			}
			
			$instance->setFreecopies($data+$x)
				->save()
			;
			
			//Key könnte weg sein!
			if (array_key_exists($customerId, $usedFreecopies)) {
				$usedFreecopies[$customerId] = round($usedFreecopies[$customerId] - $x, 4);
				
				if ($usedFreecopies[$customerId] <= 0) {
					unset($usedFreecopies[$customerId]);
				}
			}
			
			$amount = round($amount - $x, 4);
			
			//Das Basiselement (in der Regel, falls Freiexemplare vorhanden, der eigentliche Kunde) steht immer am Ende!
			$masterId = $instance->getId();
			
			if ($amount <= 0)
				break;
		}
		
		//force reload
		if ($this->getId() < 1) {
			$this->load($masterId);
		} else {
			$this->load($this->getId());
		}
		//sonst wird bei Abo-Rechnungserstellungen nicht korrekt gezählt
		self::$_processedProducts = array();
		
		if (!$usedFreecopies)
			return array();
		
		return array_reverse($usedFreecopies, true);
	}
	
	/**
	 * Setzt die Freiexemplaranzahl eines einzelnen Freecopy-Items
	 * 
	 * Haupt-/Nebenkundenbeziehungen werden nicht berücksichtigt!
	 * 
	 * @param int $freecopies Absolute Anzahl an Freiexemplaren
	 * 
	 * @return Stala_Extcustomer_Model_Freecopies
	 * 
	 * @see Stala_Extcustomer_Model_Freecopies::increaseFreecopies
	 * @see Stala_Extcustomer_Model_Freecopies::decreaseFreecopies
	 */
	public function setFreecopies($freecopies) {
		
		if ($freecopies < 0)
			$freecopies = 0;
			
        $this->setData('freecopies', $freecopies);
        
        $this->_processCrossFreecopies();
        
        return $this;
	}
	
	/**
	* Setzt die initiale Freiexemplaranzahl eines einzelnen Freecopy-Items
	*
	* Haupt-/Nebenkundenbeziehungen sind nicht von Bedeutung!
	*
	* @param int $freecopies Absolute Anzahl an initialen Freiexemplaren
	* 
	* @return Stala_Extcustomer_Model_Freecopies
	*/
	public function setBaseFreecopies($freecopies) {
		
		if ($freecopies < 0)
			$freecopies = 0;

		if (self::$_isDebug) {
			
			self::$_processedFreecopies++;
			
			if (self::$_processedFreecopies % 100 == 0 && self::$_processedFreecopies > 4999) {
				Mage::log('processed freecopies: '.self::$_processedFreecopies, Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
			}
		}
        $this->setData('base_freecopies', $freecopies);
        $this->setData('freecopies', $freecopies);
        
        $this->_processCrossFreecopies('base_freecopies');
        
        return $this;
	}
	
	protected function _processCrossFreecopies($dataType = 'freecopies') {
		
		if (self::$_forAll) {
			return $this;
		}
		
		if (($productId = $this->getProductId()) && $this->getCustomerId()) {
			if (array_key_exists($this->getCustomerId(), self::$_processedProducts)) {
				$pProducts = self::$_processedProducts[$this->getCustomerId()];
				if (array_key_exists($productId, $pProducts)) {
					//Das Produkt wurde schon behandelt
					$this->setOption($pProducts[$productId]);
					return $this;
				}
			} else {
				self::$_processedProducts[$this->getCustomerId()] = array($productId => $this->getOption());
			}
			$pProducts = self::$_processedProducts[$this->getCustomerId()];
			
			$collection = Mage::getModel('extcustomer/product_link')->useCrossFreecopiesLinks()
				->getLinkCollection()
				->addLinkTypeIdFilter()
			;
			/*
			 * Um nicht das Produkt laden zu müssen
			 * @see Mage_Catalog_Model_Resource_Eav_Mysql4_Product_Link_Collection::->addProductIdFilter()
			 */
			$collection->addFieldToFilter("product_id", $productId);
			  
	        /* Mage::log(
	        	sprintf('freecopies::%d cross linked products loaded for product ID %d', $collection->count(), $product->getId()),
	        	Zend_Log::DEBUG,
	        	Stala_Helper::LOG_FILE
	        ); */
	        						
	        foreach ($collection->getItems() as $item) {
	        	if ($productId == $item->getLinkedProductId())
	        		continue;
	        	/* @var $freecopyItem Stala_Extcustomer_Model_Freecopies */
	        	$freecopyItem = Mage::getModel('extcustomer/freecopies')
	        					->loadByProductCustomerId(
	        								$item->getLinkedProductId(),
	        								$this->getCustomerId()
	        					);
	        	
	        	if ($freecopyItem->isEmpty())
	        		continue;
	        	
	        	if ($dataType == 'delete') {
	        		$freecopyItem->delete(false);
	        	} else {
	        		$freecopyItem->setData($dataType, $this->getFreecopies(false));
	        		if ($dataType == 'base_freecopies') {
	        			$freecopyItem->setData('freecopies', $this->getFreecopies(false));
	        		}
		        	if ($dataType == 'freecopies' && $freecopyItem->getFreecopies(false) > $freecopyItem->getBaseFreecopies()) {
		        		$freecopyItem->setData('freecopies', $freecopyItem->getBaseFreecopies());
		        	}
		        	//Individuelle Optionen werden höher eingestuft
		        	if ($this->getOption() != $freecopyItem->getOption() &&
		        		$this->getOption() != Stala_Extcustomer_Helper_Data::OPTION_DERIVATE &&
		        		$freecopyItem->getOption() != Stala_Extcustomer_Helper_Data::OPTION_DERIVATE &&
		        		$this->getOrigData('option') != Stala_Extcustomer_Helper_Data::OPTION_INDIVIDUAL) {
		        		$freecopyItem->setOption(Stala_Extcustomer_Helper_Data::OPTION_INDIVIDUAL);
		        		$this->setOption(Stala_Extcustomer_Helper_Data::OPTION_INDIVIDUAL);
		        	} elseif ($this->getOrigData('option') == Stala_Extcustomer_Helper_Data::OPTION_INDIVIDUAL) {
		        		//Rücksetzen behandeln
		        		$freecopyItem->setOption($this->getOption());
		        	}
		        	
		        	$freecopyItem->save();
	        	}
	        	$pProducts[$freecopyItem->getProductId()] = $freecopyItem->getOption();
	        	self::$_processedProducts[$this->getCustomerId()] = $pProducts;
	        	
	        	//Das Produkt über $this wird über die normale Verarbeitung der Ableitungen abgedeckt.
	        	$product = Mage::getModel('catalog/product')->load($freecopyItem->getProductId(), array('is_abo_base_product', 'abo_parent_product'));
	        	if ($product && $product->getIsAboBaseProduct()) {
	        		$this->_processDerivatesFromParent($product, $this->getCustomerId());
	        	}
	        }	              
		}
		return $this;
	}
	
	/**
	 * Lädt das Freiexemplar anhand der Produkt- & Kunde-ID
	 * 
	 * @param int $productId Produkt ID
	 * @param int $customerId Kunden ID
	 * @param boolean $withRelations Hauptkunden berücksichtigen?
	 * @return $this
	 */
	public function loadByProductCustomerId($productId, $customerId, $withRelations = false) {
// 		Mage::log("freecopies::loadByProductCustomerId called...", Zend_Log::DEBUG, Stala_Helper::LOG_FILE);
        $this->_getResource()->loadByProductCustomerId($this, $productId, $customerId, $withRelations);
        return $this;
    }
}