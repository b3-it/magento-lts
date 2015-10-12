<?php
/**
 * Falls Magento die Link-Types statisch vergibt (obwohl DB autoincrement enthält) muss dieses Modul
 * möglichst am Ende der Installtion ausgeführt werden.
 * 
 * @author Frank Rochlitzer <f.rochlitzer@trw-net.de>
 *
 */
class Stala_Extcustomer_Model_Product_Link extends Mage_Catalog_Model_Product_Link {
	const LINK_TYPE_CROSSFREECOPIES = 'cross_freecopies';
	private $__link_type_id = null;
	protected $_artikel_arten = array(
								'Print',
								'PDF',
								'Excel',
								'DV', //deprecated
								'DWL' //deprecated
	);

	/**
	 * Initialisiert die Link-Instanz für Cross-Freecopies
	 * 
	 * @return Stala_Extcustomer_Model_Product_Link
	 */
	public function useCrossFreecopiesLinks()
	{
		$this->setLinkTypeId($this->_getCrossFreecopiesLinkTypeId());
		return $this;
	}
	
	protected function _getCrossFreecopiesLinkTypeId() {
		if (!$this->__link_type_id) {
			/* @var $resource Mage_Core_Model_Mysql4_Abstract */
			$resource = $this->getResource();
			$select = $resource->getReadConnection()->select()
				->from($resource->getTable('catalog/product_link_type'), array(
	                'id'    => 'link_type_id',
	                'code'  => 'code',
	            ))
	            ->where('code=?', self::LINK_TYPE_CROSSFREECOPIES);
			$this->__link_type_id = $resource->getReadConnection()->fetchOne($select);
		}
		
		return $this->__link_type_id;
	}
	
	public function saveProductRelations($product) {
		parent::saveProductRelations($product);
		
		$data = $product->getCrossFreecopiesLinkData();
		if (!is_null($data)) {
			$this->_getResource()->saveProductLinks($product, $data, $this->_getCrossFreecopiesLinkTypeId());
			$this->_getResource()->saveProductLinks($product, $data, self::LINK_TYPE_UPSELL);
		}
		return $this;
	}
	
	/**
	 * Sucht Automatisch nach Ausprägungen eines Produktes und verlinkt diese Untereinander.
	 * Als Referenz wird die SKU benutzt.
	 * 
	 * Voraussetzungen:
	 * Die Artikel-Art muss zwischen zwei Zeichenketten in der Sku stehen!
	 * 
	 * @param Mage_Catalog_Model_Product $product
	 */
	public function saveAutoProductRelations($product) {
		/*
		 * 1. Sku des QuellProduktes ermitteln
		 * 2. Mögliche Relations ermitteln
		 * 3. Vorhandene Relations prüfen
		 * 4. Falls Relation nicht vorhanden -> verlinken
		 */ 
		
		/* @var $product Mage_Catalog_Model_Product */		
		if (!($product instanceof Mage_Catalog_Model_Product) || $product->isEmpty() || $product->getId() < 1 || !$product->getSku()) {
			return $this;
		}
		
		$sku = $product->getSku();
		
		//Mögliche Relations ermitteln
		//################################################################################################
		$parts = array();
		foreach ($this->_artikel_arten as $art) {
			$parts =  preg_split("/^([^\.]+\.[^\.]+)\.$art\./i", $sku, null, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE); //Ergebnis: Teil1 und Rest
			
			if (count($parts) == 2)	
				break;
			else $parts = array();
		}
		$min = 1000;
		$max = 0;
		foreach ($this->_artikel_arten as $art) {
			//Längen für RegEx ermitteln
			$min = min($min, strlen($art));
			$max = max($max, strlen($art));
		}
		
		if (count($parts) < 2) {
			Mage::log("Sku doesn't consist as two parts! Omit auto processing of cross freecopy relations!", Zend_Log::INFO,  Stala_Helper::LOG_FILE);
			return $this;
		}
		
		/* @var $productCollection Mage_Catalog_Model_Resource_Eav_Mysql4_Product_Collection */
		$productCollection = $product->getCollection();
		//siehe Varien_Data_Collection_Db ab Zeile 375
		/*
		 * Note
		 * Because MySQL uses the C escape syntax in strings (for example, “\n” to represent the newline character),
		 * you must double any “\” that you use in your REGEXP strings.
		 */
		$productCollection->addAttributeToFilter('sku', array('rlike' => sprintf('%s\\.[A-Za-z]{%d,%d}\\.%s$',$parts[0], $min, $max, $parts[1])));
		Mage::log($productCollection->getSelect()->assemble(), Zend_Log::DEBUG, Stala_Helper::LOG_FILE);
		$keys = $productCollection->getAllIds();
		
		//Vorhandene Relationen prüfen
		//################################################################################################
		if (empty($keys)) {
			Mage::log("No items for auto cross freecopy relations found!", Zend_Log::INFO,  Stala_Helper::LOG_FILE);
			return $this;
		}
		
		//wichtig um getLinkTypeId nutzen zu können
		$this->useCrossFreecopiesLinks();
			
		//Wichtig falls Items abgewählt werden
		$linkCollection = $this->getLinkCollection()
						->addFieldToFilter('linked_product_id', array('in' => $keys))
						->addFieldToFilter('product_id', array('eq' => $product->getId()))
						->addFieldToFilter('link_type_id', array('eq' => $this->getLinkTypeId()))
		;
		$links = array();
		$merged = $keys; //Array kopieren
		foreach ($linkCollection->getItems() as $item) {
			$links[] = $item->getLinkedProductId();
			if (array_search($item->getLinkedProductId(), $merged) === false) {
				$merged[] = $item->getLinkedProductId();
			}
		}
		//Eigene Produkt-ID hinzufügen
		if (count($links) > 0) {
			$links[] = $product->getId();
		}
		
		if (count(array_diff($keys, $links)) < 1) {
			//keine Unterschiede vorhanden
			Mage::log("No differences between new and exisiting cross freecopy relations found!", Zend_Log::INFO,  Stala_Helper::LOG_FILE);
			return $this;
		}
		
		//Es gab eine Veränderung, die Daten müssen neu gesetzt werden (reset beim setzen)!
		//Elemente verlinken
		//################################################################################################
		Mage::log('New items for auto cross freecopies:'.var_export($merged, true), Zend_Log::DEBUG, Stala_Helper::LOG_FILE);
		$this->saveCrossRelations($merged);
						
		return $this;
	}
	
	/**
	 * Verlinkt alle Produkte deren Produkt-ID in $keys enthalten ist miteinander.
	 * 
	 * Beim Speichern von Produktlinks gehen alle existierenden Informationen verloren!
	 * Bei einer Änderung müssen also auch die alten Daten wieder eingepflegt werden!
	 * 
	 * @param array $keys
	 * @return $this
	 */
	public function saveCrossRelations($keys) {
		
		if (empty($keys) || count($keys) < 2) {
			Mage::log(sprintf('%s items selected to cross link with freecopies, exiting.', empty($keys) ? 'No' : 'There must be at least two'), Zend_Log::WARN, Stala_Helper::LOG_FILE);
			return $this;
		}
		
		//foreach arbeitet immer auf einer Kopie
		foreach($keys as $productId) {
			$relProduct = Mage::getModel('catalog/product')->load($productId);
		
			unset($keys[array_search($productId, $keys)]);
		
			//Links für aktuelles Produkt speichern.
			$crossFreecopiesLinkData = array();
			foreach ($keys as $linkedProductId) {
				$crossFreecopiesLinkData[$linkedProductId] = array(); //array() steht für leere LinkInfo (wir haben keine Attribute)
			}
			$relProduct->setCrossFreecopiesLinkData($crossFreecopiesLinkData);
		
			//!!!!Wichtig!!!!!
			//In saveProductRelations(...) werden alle bisherigen Relations gelöscht und durch die neuen ersetzt!!!!
			$this->saveProductRelations($relProduct);
		
			$keys[] = $productId;
		}
		
		return $this;
	}
}