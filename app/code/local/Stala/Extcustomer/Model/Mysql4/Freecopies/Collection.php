<?php

class Stala_Extcustomer_Model_Mysql4_Freecopies_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
	const PRODUCT_ID = "product_id";
	const CUSTOMER_ID = "customer_id";
	
	public function _construct()
	{
		parent::_construct();
		$this->_init('extcustomer/freecopies');
	}
	
	/**
	 * Alle Freiexemplare anhand der Produkt ID laden
	 * 
	 * @param int $productId
	 * @return $this
	 */
	public function loadByProductId($productId) {
		$this->addFilterByProductId($productId);
		$this->load();
		
		return $this;
	}
	
	/**
	 * Alle Freiexemplare anhand der Produkt und Kunden ID laden
	 * 
	 * @param int $productId Product ID
	 * @param int $customerId Customer ID
	 */
	public function loadByProductIdAndCustomerId($productId, $customerId) {
		$this->addFilterByProductId($productId);
		$this->addFilterByCustomerId($customerId);
		$this->load();
		
		return $this;
	}
	
	/**
	 * Fügt einen Filter für die entsprechende Produkt ID hinzu.
	 * 
	 * Es wird eine Where-Klausel mit der entsprechenden Tupel-Bezeichnung und der ID erzeugt.
	 * 
	 * @param int $productId
	 */
	public function addFilterByProductId($productId) {
		$this->getSelect()->where(self::PRODUCT_ID." = ?",$productId);
	}
	
	/**
	 * Fügt einen Filter für die entsprechende Kunden ID hinzu.
	 *
	 * Es wird eine Where-Klausel mit der entsprechenden Tupel-Bezeichnung und der ID erzeugt.
	 *
	 * @param int $customerId
	 */
	public function addFilterByCustomerId($customerId) {
		$this->getSelect()->where(self::CUSTOMER_ID." = ?",$customerId);
	}
	
	/**
	 * Fügt zusätzliche Produktfelder (Name,SKU etc.) zur Anzeige der Freiexemplare hinzu.
	 * 
	 * <p>
	 * !Nach dem Aufruf dieser Funktion darf keine programmatische Speicherung mehr im selben PHP-Aufruf erfolgen!
	 * Erst nach dem das Grid geladen wurde!
	 * </p>
	 * Über JOINS werden die zusätzlichen Produktfelder hinzugefügt:
	 * <ul>
	 * 	<li>Produkt ID</li>
	 * 	<li>Type ID</li>
	 * 	<li>SKU</li>
	 * 	<li>Price</li>
	 * 	<li>Produktname</li>
	 * 	<li>Stammartikel ID (optional)</li>
	 * 	<li>Artikelart</li>
	 * </ul>
	 * 
	 * @param int $customerID
	 */
	public function selectProductFields($customerID) {
		/* @var $model Mage_Catalog_Model_Resource_Eav_Mysql4_Product */
		$model = Mage::getResourceModel('catalog/product');
		
		/* Wichtig sonst wird Primärschlüssel als ID benutzt!
		 * Wir brauchen aber die Produkt ID
		 *!Wichtig!
		 * Mit diesem ID-Field dürfen keine direkten Speicheroperationen ausgeführt werden --> nur zur Anzeige verwenden.
		 */
		$this->_setIdFieldName('product_id');
		/* Neue Abfrage für alle Produkte
		 * SELECT `main_table`.*, `catalog/product`.`entity_id`, `catalog/product`.`type_id`, `catalog/product`.`sku`, `e`.`value` AS `price`, `e1`.`value` AS `name` FROM `extcustomer_freecopies` AS `main_table`
		 * RIGHT JOIN `catalog_product_entity` AS `catalog/product` ON `catalog/product`.`entity_id` >= 0 AND IF(product_id IS NULL , 1, entity_id = product_id ) and customer_id = CUSTOMER_ID
		 * INNER JOIN `catalog_product_entity_decimal` AS `e` ON `catalog/product`.`entity_id` = e.`entity_id` AND e.attribute_id = 60
		 * INNER JOIN `catalog_product_entity_varchar` AS `e1` ON `catalog/product`.`entity_id` = e1.`entity_id` AND e1.attribute_id = 56
		 * LEFT JOIN `catalog_product_entity_int` AS `e2` ON e2.entity_id=`catalog/product`.entity_id AND e2.attribute_id = 536
		 * WHERE (`e2`.`value` is null OR `e2`.value = 0)                        
		 */
		
		/*
		 * 20120104::Frank Rochlitzer
		 * Abfrage ist zu langsam mit:
		 * "entity_id >= 0 AND IF(product_id is null, 1, entity_id = product_id) and ".self::CUSTOMER_ID." = $customerID",
		 * wird geändert auf:
		 * "entity_id = product_id and ".self::CUSTOMER_ID." = $customerID",
		 */
		$wherePart = $this->getSelect()->getPart(Zend_Db_Select::WHERE);
		if (is_array($wherePart) && count($wherePart) > 0) {
			foreach ($wherePart as $part) {
				if (strpos($part, self::CUSTOMER_ID) >= 0) {
					$wherePart = true;
					break;
				}
			}
			if (is_array($wherePart))
				$wherePart = false;
		}
		if (!$wherePart) {
			$expr = new Zend_Db_Expr("({$this->getSelect()->where(self::CUSTOMER_ID." = ?",$customerID)->assemble()})");
		} else {
			$expr = new Zend_Db_Expr("({$this->getSelect()->assemble()})");
		}
		$this->getSelect()->reset(Zend_Db_Select::FROM)
			->reset(Zend_Db_Select::COLUMNS)
			->from(array('main_table' => $expr))
		;
		
		$this->getSelect()->joinRight(array('catalog/product' => $this->getTable('catalog/product')), //name ist auch alias
                "entity_id = product_id and ".self::CUSTOMER_ID." = $customerID",
                array('product_entity_id' => 'entity_id', 'type_id', 'sku')
        );
        $attribute = $model->getAttribute('price');
        $this->getSelect()->join(array('e' => $attribute->getBackendTable()),
        		"e.entity_id=`catalog/product`.entity_id AND e.attribute_id = {$attribute->getAttributeId()} AND e.value > 0.0",
                array('price' => 'value')
        );
        $attribute = $model->getAttribute('name');
        $this->getSelect()->join(array('e1' => $attribute->getBackendTable()),
        		"e1.entity_id=`catalog/product`.entity_id AND e1.attribute_id = {$attribute->getAttributeId()}",
                array('name' => 'value')
        );
        $attribute = $model->getAttribute('abo_parent_product');
        if (!empty($attribute)) {
	        $this->getSelect()->joinLeft(
	        		array('e2' => $attribute->getBackendTable()),
	        		"e2.entity_id=`catalog/product`.entity_id AND e2.attribute_id = {$attribute->getAttributeId()}",
	                array('abo_parent_product' => 'value')
	        );
	        $this->getSelect()->where('e2.value = 0 OR e2.value is null');
        } else {
        	Mage::log("Attribute 'abo_parent_product' didn't exists, omitting...", Zend_Log::WARN, Stala_Helper::LOG_FILE);
        }
        $attribute = $model->getAttribute('artikel_art');
        if (!empty($attribute)) {
        	$this->getSelect()->joinLeft(
        			array('e3' => $attribute->getBackendTable()),
        	       	"e3.entity_id=`catalog/product`.entity_id AND e3.attribute_id = {$attribute->getAttributeId()}",
        			array('article_type' => 'value')
        	);
        } else {
        	Mage::log("Attribute 'artikel_art' didn't exists, omitting...", Zend_Log::WARN, Stala_Helper::LOG_FILE);
        }
        
        //$this->getSelect()->group(array('extcustomer_freecopies_id', 'catalog/product.entity_id'));
        
        /* ZVM 421
         * Produkte ohne Freiexemplare haben noch keine ID und werden daher vom System durchnummeriert (Magento-Core),
         * wird nun jedoch ein Produkt mit Freiexemplaren geladen, welches die selbe ID besitzt wie eines der durchnummerierten neuen Exemplare,
         * wirft das System eine Exception.
         * 
         * !Wichtig!
         * Mit diesem ID-Field dürfen keine direkten Speicheroperationen ausgeführt werden --> nur zur Anzeige verwenden.
         */
        $this->_setIdFieldName('catalog/product.entity_id');
        
//      	Mage::log($this->getSelect()->assemble(), Zend_Log::DEBUG, Stala_Helper::LOG_FILE);
	}
	
	/**
	 * Fügt zusätzliche Produktfelder (Name,SKU etc.) zur Anzeige der Freiexemplare für ABO-Produkte (Ableitungen) hinzu.
	 *
	 * <p>
	 * !Nach dem Aufruf dieser Funktion darf keine programmatische Speicherung mehr im selben PHP-Aufruf erfolgen!
	 * Erst nach dem das Grid geladen wurde!
	 * </p>
	 * Über JOINS werden die zusätzlichen Produktfelder hinzugefügt:
	 * <ul>
	 * 	<li>Produkt ID</li>
	 * 	<li>Type ID</li>
	 * 	<li>SKU</li>
	 * 	<li>Price</li>
	 * 	<li>Produktname</li>
	 * 	<li>Stammartikel ID (optional)</li>
	 * 	<li>Artikelart</li>
	 * </ul>
	 *
	 * @param int $customerID
	 */
	public function selectProductFieldsAboReport($customerID) {
		/* @var $model Mage_Catalog_Model_Resource_Eav_Mysql4_Product */
		$model = Mage::getResourceModel('catalog/product');
		
		/* Wichtig sonst wird Primärschlüssel als ID benutzt!
		 * Wir brauchen aber die Produkt ID
		 *!Wichtig!
		 * Mit diesem ID-Field dürfen keine direkten Speicheroperationen ausgeführt werden --> nur zur Anzeige verwenden.
		 */
		$this->_setIdFieldName('product_id');
		/* Neue Abfrage für alle Produkte
		 * SELECT `main_table`.*, `catalog/product`.`entity_id`, `catalog/product`.`type_id`, `catalog/product`.`sku`, `e`.`value` AS `price`, `e1`.`value` AS `name` FROM `extcustomer_freecopies` AS `main_table`
		 * RIGHT JOIN `catalog_product_entity` AS `catalog/product` ON `catalog/product`.`entity_id` >= 0 AND IF(product_id IS NULL , 1, entity_id = product_id ) and customer_id = CUSTOMER_ID
		 * INNER JOIN `catalog_product_entity_decimal` AS `e` ON `catalog/product`.`entity_id` = e.`entity_id` AND e.attribute_id = 60
		 * INNER JOIN `catalog_product_entity_varchar` AS `e1` ON `catalog/product`.`entity_id` = e1.`entity_id` AND e1.attribute_id = 56
		 * LEFT JOIN `catalog_product_entity_int` AS `e2` ON e2.entity_id=`catalog/product`.entity_id AND e2.attribute_id = 536
		 * WHERE (`e2`.`value` is null OR `e2`.value = 0)                        
		 */
		
		/*
		 * 20120104::Frank Rochlitzer
		 * Abfrage ist zu langsam mit:
		 * "entity_id >= 0 AND IF(product_id is null, 1, entity_id = product_id) and ".self::CUSTOMER_ID." = $customerID",
		 * wird geändert auf:
		 * "entity_id = product_id and ".self::CUSTOMER_ID." = $customerID",
		 */
		$wherePart = $this->getSelect()->getPart(Zend_Db_Select::WHERE);
		if (is_array($wherePart) && count($wherePart) > 0) {
			foreach ($wherePart as $part) {
				if (strpos($part, self::CUSTOMER_ID) >= 0) {
					$wherePart = true;
					break;
				}
			}
			if (is_array($wherePart))
				$wherePart = false;
		}
		if (!$wherePart) {
			$expr = new Zend_Db_Expr("({$this->getSelect()->where(self::CUSTOMER_ID." = ?",$customerID)->assemble()})");
		} else {
			$expr = new Zend_Db_Expr("({$this->getSelect()->assemble()})");
		}
		$this->getSelect()->reset(Zend_Db_Select::FROM)
			->reset(Zend_Db_Select::COLUMNS)
			->from(array('main_table' => $expr))
		;
		
		$this->getSelect()->joinRight(array('catalog/product' => $this->getTable('catalog/product')), //name ist auch alias
                "entity_id = product_id and ".self::CUSTOMER_ID." = $customerID",
                array('product_entity_id' => 'entity_id', 'type_id', 'sku')
        );
        $attribute = $model->getAttribute('price');
        $this->getSelect()->join(array('e' => $attribute->getBackendTable()),
        		"e.entity_id=`catalog/product`.entity_id AND e.attribute_id = {$attribute->getAttributeId()}",
                array('price' => 'value')
        );
        $attribute = $model->getAttribute('name');
        $this->getSelect()->join(array('e1' => $attribute->getBackendTable()),
        		"e1.entity_id=`catalog/product`.entity_id AND e1.attribute_id = {$attribute->getAttributeId()}",
                array('name' => 'value')
        );
        $attribute = $model->getAttribute('abo_parent_product');
        if (!empty($attribute)) {
	        $this->getSelect()->joinLeft(array('e2' => $attribute->getBackendTable()),
	        		"e2.entity_id=`catalog/product`.entity_id AND e2.attribute_id = {$attribute->getAttributeId()}",
	                array('abo_parent_product' => 'value')
	        );
	        $this->getSelect()->where('e2.value > 0');
        } else {
        	Mage::log("Attribute 'abo_parent_product' didn't exists, omitting...", Zend_Log::WARN, Stala_Helper::LOG_FILE);
        }
        $attribute = $model->getAttribute('artikel_art');
        if (!empty($attribute)) {
        	$this->getSelect()->joinLeft(
        	array('e3' => $attribute->getBackendTable()),
                	       	"e3.entity_id=`catalog/product`.entity_id AND e3.attribute_id = {$attribute->getAttributeId()}",
        	array('article_type' => 'value')
        	);
        } else {
        	Mage::log("Attribute 'artikel_art' didn't exists, omitting...", Zend_Log::WARN, Stala_Helper::LOG_FILE);
        }
        
        //$this->getSelect()->group(array('extcustomer_freecopies_id', 'catalog/product.entity_id'));
        
        /* ZVM 421
         * Produkte ohne Freiexemplare haben noch keine ID und werden daher vom System durchnummeriert (Magento-Core),
         * wird nun jedoch ein Produkt mit Freiexemplaren geladen, welches die selbe ID besitzt wie eines der durchnummerierten neuen Exemplare,
         * wirft das System eine Exception.
         * 
         * !Wichtig!
         * Mit diesem ID-Field dürfen keine direkten Speicheroperationen ausgeführt werden --> nur zur Anzeige verwenden.
         */
        $this->_setIdFieldName('catalog/product.entity_id');
//      	Mage::log($this->getSelect()->assemble(), Zend_Log::DEBUG, Stala_Helper::LOG_FILE);
	}
}