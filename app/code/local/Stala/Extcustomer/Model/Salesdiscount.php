<?php

/**
 * Model zur Behandlung von Rabattguthaben
 * 
 * @category   	Stala
 * @package    	Stala_Extcustomer
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2012 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2012 TRW-NET - http://www.trw-net.de *
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Stala_Extcustomer_Model_Salesdiscount extends Mage_Core_Model_Abstract
{
	/**
	 * @var Mage_Sales_Model_Quote_Item
	 */
	private $__quoteItem = null;
	
	protected $_newDiscountItems = array();
	
	/**
	 * Temporären Rabatt speichern
	 * 
	 * @param Mage_Customer_Model_Customer $customer Kunde
	 * @param float                        $discount Rabatt
	 * 
	 * @return Stala_Extcustomer_Model_Salesdiscount
	 */
	protected function _addTmpDiscount($customer, $discount) {
		//Wenn es keinen Rabatt gibt, brauchen wir das Item auch nicht mehr
		if ($discount <= 0) {
			return $this;
		}
		
		$quoteItemId = $this->_getQuoteItemId();
		
		if (!$this->_isCustomerValid($customer)) {
			return $this;
		}
		
		$customerId = $customer->getId();
		
		//Pro durchlauf ist $quoteItemId immer gleich!!
		if (isset($this->_newDiscountItems[$customerId])) {
			//update
			$item = $this->_newDiscountItems[$customerId];
			$item->setDiscount($item->getDiscount()+$discount);
			
			return $this;
		}
		
		//Neues Item
		/* @var $col Stala_Extcustomer_Model_Mysql4_Salesdiscount_Collection */
		$col = $this->getCollection();
		
		$item = $col->getNewEmptyItem();
		$item->setSalesQuoteItemId((int)$quoteItemId);
		$item->setCustomerId($customerId);
		$item->setDiscount($discount);
		
		$this->_newDiscountItems[$item->getCustomerId()] = $item;
		
		return $this;
	}
	
	/**
	 * Konstruktor
	 * 
	 * @return void
	 * 
	 * @see Varien_Object::_construct()
	 */
	protected function _construct() {
        parent::_construct();
        
        //Sollte damit auf Stala_Extcustomer_Model_Mysql4_SalesOrder zeigen
        $this->_init('extcustomer/salesdiscount');
    }
    
    /**
     * Liefert Quote Item Instanz
     * 
     * @return Mage_Sales_Model_Quote_Item
     */
	protected function _getQuoteItem() {
    	return $this->__quoteItem;
    }
    
    /**
     * Liefert Quote Item ID
     * 
     * @return int
     */
    protected function _getQuoteItemId() {
    	return $this->__quoteItem->getId();
    }
    
    /**
     * Setzt Quote Item
     * 
     * @param Mage_Sales_Model_Quote_Item $item Item
     * 
     * @return void
     */
	protected function _setQuoteItem($item) {
    	$this->__quoteItem = $item;
    }
    
    /**
     * Speichert das Objekt
     * 
     * @return Stala_Extcustomer_Model_Salesdiscount
     */
    public function save() {
    	/*
    	 * Omit Zero discounts
    	 */
    	if ($this->getDiscount() <= 0.00001)
    		return $this;
    		
    	parent::save();
    	
    	return $this;
    }
    
    /**
     * Übersetzungsfunktion
     * 
     * @param string $text Text
     * 
     * @return string
     */
    public function __($text = '') {
    	return Mage::helper('extcustomer')->__($text);
    }
    
    /**
     * Wandelt eine Währung in einen Float-wert um.
     * 
     * @param string $value Wert
     * 
     * @return float Float-Wert des Währungsstrings
     */
    public static function currencyToFloat($value) {
    	//Preis wieder in float umwandeln
    	$value = Mage::app()->getLocale()->getNumber($value);
    	//Auf 2 Nachkommastellen setzen
    	$value = Mage::app()->getStore()->roundPrice($value);
    	
    	return $value;
    }
    
	/**
     * Get the available discount quota.
     *  
     * @param mixed $customer The customer or the customers id
     * 
     * @return float Available discount quota
     */
    public function getAvailableDiscountQuota($customer = null) {
    	if (is_numeric($customer)) {
    		$id = $customer;
    		$customer = Mage::getModel('customer/customer')->load($id);
    	} elseif ($customer instanceof Mage_Customer_Model_Customer) {
    		$id = $customer->getId();
    	}
    	
    	$availableDisc = 0.0;
    	if ($id) {
    		$availableDisc += self::currencyToFloat($customer->getDiscountQuota());
        	//Mögliche Hauptkunden ermitteln
        	/* @var $parentCustomer Mage_Customer_Model_Customer */
        	$parentCustomer = $customer;        	
        	while ($parentID = $parentCustomer->getData('parent_customer_id')) {
        		$parentCustomer = Mage::getModel('customer/customer')->load($parentID);
        		$availableDisc += self::currencyToFloat($parentCustomer->getDiscountQuota());
        	}        	    		
    	}
    	 
    	return $availableDisc;
    }
    
    /**
     * Liefert alle IDs der aktiven Warenkörbe die in Abhängigkeit zum angebenen Kunden stehen.
     * 
     * Falls kein Kunde angegeben wird, werden alle Warenkörbe ermittelt.
     * Diese Funktion berücksichtigt die Abhängigkeiten von Haupt- und Nebenkunden.
     * 
     * @param Mage_Customer_Model_Customer $customer Kunde
     * 
     * @return array IDs der Warenkörbe
     */
    protected function _getQuoteIds($customer) {
    	if (!($customer instanceof Mage_Customer_Model_Customer)) {
    		Mage::throwException('The argument must be of type Mage_Customer_Model_Customer');
    	}
    	$id = $customer->getId();
    	
    	/* @var $quoteCol Mage_Sales_Model_Mysql4_Quote_Collection */
    	$quoteCol = Mage::getResourceSingleton('sales/quote_collection');
    	$quoteCol->addFieldToFilter('items_count', array('neq' => '0'))
			    	->addFieldToFilter('main_table.is_active', '1')
			    	->setOrder('updated_at')
    	;
    	 
    	if ($id) {
    		$ids = array();
    		//Mögliche Unterkunden ermitteln
    		if ($customer->getData('is_parent_customer')) {
    			/* @var $childCustomers Mage_Customer_Model_Entity_Customer_Collection */
    			$childCustomers = $customer->getCollection();
    			$childCustomers->addAttributeToFilter('parent_customer_id', $id);
    			$ids = $childCustomers->getAllIds();
    		}
    		$ids[] = $id;
    		$quoteCol->addFieldToFilter('customer_id', array('in' => $ids));
    		//Join auf wirklichen Verbrauch des aktuellen Kunden
    		  		
    	}
    	
    	return $quoteCol->getAllIds();
    }
    
    /**
     * Get the abandoned discount quota.
     * 
     * If no customer is specified the global abandoned discount quota is calculated.
     * It's not possible to pass only the customers id, because it's not possible to load the customer (infinite loop).
     * 
     * @param Mage_Customer_Model_Customer $customer The customer
     * 
     * @return float Abandoned discount quota
     */
    public function getAbandonedDiscountQuota($customer = null) {
    	if (!($customer instanceof Mage_Customer_Model_Customer)) {
    		Mage::throwException('The argument must be of type Mage_Customer_Model_Customer');
    	}
    	$id = $customer->getId();
    	    	
    	$abandonedDisc = 0.0;
    	
    	/*
    	 * $quote->getAllItems() oder derivate funktionieren im Frontend nicht --> unendliche Schleife!
    	 */
    	/* @var $quoteColItems Mage_Sales_Model_Mysql4_Quote_Item_Collection */
    	$quoteColItems = Mage::getResourceSingleton('sales/quote_item_collection');
    	 
    	$quoteColItems->addFieldToFilter('quote_id', array('in' => $this->_getQuoteIds($customer)));
    	$quoteIds = $quoteColItems->getAllIds();
    	foreach ($quoteIds as $qid) {
    		$abandonedDisc += $this->getCurrentDiscount($qid, $id);
    	}
    	 
    	return $abandonedDisc;
    }
    
    /**
     * Get the current discount of the quote item.
     *
     * @param Mage_Sales_Model_Quote_Item $quoteItem  Item
     * @param int                         $customerId Kunden ID
     * 
     * @return float 0.0 or the current discount value
     */
    public function getCurrentDiscount($quoteItem = null, $customerId = false) {
    	//Alte Discounts holen
		$discountItems = null;
		
		try {
			/* @var $discountItems Stala_Extcustomer_Model_Mysql4_Salesdiscount_Collection */
			if ($quoteItem instanceof Mage_Sales_Model_Quote_Item) {
				$discountItems = $this->getCollection()
										->addFilterByQuoteItemId($quoteItem->getId())
				;
			} else {
				//$quoteItem is ID
				$discountItems = $this->getCollection()
										->addFilterByQuoteItemId($quoteItem)
				;
			}
			if ($customerId !== false) {
				$discountItems->addFilterByCustomerId($customerId);
			}
			
		} catch (Exception $e) {			
		}
					
		$discount = 0.0;
		foreach ($discountItems->getItems() as $oldItem) {
			$discount += $oldItem->getDiscount();
		}
		
		return $discount;
    }
    
	/**
	 * Rabattguthaben am Kunden aktualisieren
	 * 
	 * @param int $quoteItemId Quote Item ID
	 * 
	 * @return Stala_Extcustomer_Model_Salesdiscount
	 */
	public function updateCustomerDiscountQuota($quoteItemId) {		
		/* @var $col Stala_Extcustomer_Model_Mysql4_Salesdiscount_Collection */
		$col = $this->getCollection();
		$col->loadByQuoteItemId($quoteItemId);
		
		foreach ($col->getItems() as $item) {
			if (!Mage::getResourceSingleton('customer/customer')->checkCustomerId($item->getCustomerId())) {
				continue;
			}
			
			/* @var $customer Mage_Customer_Model_Customer */
			$customer = Mage::getModel('customer/customer')->load($item->getCustomerId());
			
			if (!$this->_isCustomerValid($customer)) {
				continue;
			}
			
			//Quota um alten discount erhöhen!
			$diQta = Mage::app()->getLocale()->getNumber($customer->getDiscountQuota());
			$diQta += $item->getDiscount();
			$initialQta = Mage::app()->getLocale()->getNumber($customer->getData('discount_quota_init'));
			if ($diQta > $initialQta) {
				Mage::log('New discount quota is greater than initial discount quota, using initial value!', Zend_Log::NOTICE, Stala_Helper::LOG_FILE);
			}
			$customer->setDiscountQuota(min($diQta, $initialQta));
			$customer->save();
		}
		
		//Diese Items werden jetzt nicht mehr benötigt.
		$col->walk('delete');
		
		return $this;
	}
	
	/**
	 * Gebundenes Rabattguthaben von Warenkörben löschen
	 * 
	 * @param int|Mage_Customer_Model_Customer $customer Kunde
	 * 
	 * @return void
	 */
	public function resetAssignedDiscountsByCustomer($customer) {
		if (is_numeric($customer)) {
			$id = $customer;
			$customer = Mage::getModel('customer/customer')->load($id);
		} elseif ($customer instanceof Mage_Customer_Model_Customer) {
			$id = $customer->getId();
		}
		
		if (!$id)
			return;
		
		/* @var $col Stala_Extcustomer_Model_Mysql4_Salesdiscount_Collection */
		$col = $this->getCollection();
		$col->addFilterByCustomerId($id);
		
		/*
		* $quote->getAllItems() oder derivate funktionieren im Frontend nicht --> unendliche Schleife!
		*/
		/* @var $quoteColItems Mage_Sales_Model_Mysql4_Quote_Item_Collection */
		$quoteColItems = Mage::getResourceSingleton('sales/quote_item_collection');		
		$quoteColItems->addFieldToFilter('quote_id', array('in' => $this->_getQuoteIds($customer)));
		
		$col->addFieldToFilter('sales_quote_item_id', array('in' => $quoteColItems->getAllIds()));
		$col->load();
		
		//Diese Items werden jetzt nicht mehr benötigt.
		$col->walk('delete');
	}
	
    /**
     * Errechnet den höchstmöglichen Rabattbetrag unter Einbezug
     * aller Kunden- und Hauptkundenbeziehungen.
     * 
     * @param int                          $quoteItem  Mage_Sales_Model_Quote_Item ID
     * @param Mage_Customer_Model_Customer $customer   Kunde
     * @param float                        $totalPrice Der Gesamtpreis des Artikels (Artikelanzahl * Preis)
     * 
     * @return float Höchstmöglicher Rabattbetrag
     */
    public function getAvailableDiscountAmount($quoteItem, $customer, $totalPrice) {
    	/*//Omit zero price
		if ($totalPrice <= 0) {
			return 0.0;
		}*/
		
		$this->_setQuoteItem($quoteItem);
		
    	if (!$this->_isCustomerValid($customer)) {
			return 0.0;
		}
    	
		$customer = Mage::getModel('customer/customer')->load($customer->getId());
		$discount = $this->_getAvailableDiscountAmount($customer, $totalPrice);
    	
		//Wenn sich nichts geändert hat, können wir DB-Ops auslassen
		if ($quoteItem->getQty() == $quoteItem->getOrigData('qty')
			&& $this->getCollection()->loadByQuoteItemId($this->_getQuoteItemId())->getSize() > 0
			//Magentorabattfunktion setzt Rabatt beim Aufruf immer auf 0
			//Falls der Wert also nicht 0 ist, existiert ein Magentorabatt und alles muss neu berechnet werden 
			&& $quoteItem->getDiscountAmount() == 0
			)
			return $discount;
		
		//Ungültige Items löschen
		//-------------------------------------------------------------------------------
		//Alte Discounts holen
		$discountItems = $this->getCollection()
								->loadByQuoteItemId($this->_getQuoteItemId())
								->getItems();
								
		foreach ($discountItems as $oldItem) {
			$isInvalid = true;
			foreach ($this->_newDiscountItems as $item) {
				if ($oldItem->getCustomerId() == $item->getCustomerId()) {
					$isInvalid = false;
					break;
				}				
			}
			
			if ($isInvalid) {
				//$oldItem ist nicht mehr Aktuell
				if (!Mage::getResourceSingleton('customer/customer')->checkCustomerId($oldItem->getCustomerId())) {
					$oldItem->delete();
					continue;
				}
				$customer = Mage::getModel('customer/customer')->load($oldItem->getCustomerId());
				
				if (!$this->_isCustomerValid($customer)) {
					$oldItem->delete();
					continue;
				}
				
				//Quota um alten discount erhöhen!
				$diQta = Mage::app()->getLocale()->getNumber($customer->getDiscountQuota());
				$diQta += $oldItem->getDiscount();
				
				if (Mage::app()->getLocale()->getNumber($customer->getDiscountQuota()) != $diQta) {
					$customer->setDiscountQuota($diQta);
					$customer->save();
				}
				// print_r($this->getCollection()->getItems());
				$oldItem->delete();
			}
		}
		$this->getCollection()->save();
		//-------------------------------------------------------------------------------
		
		//Ab hier sind es nur noch neue Items oder Item updates!
		foreach ($this->_newDiscountItems as $item) {
			$this->_insertUpdateDiscountItem($quoteItem->getId(), $item);
		}    	
    	
    	return $discount;
    }
	
    /**
     * Validiert den neuen Discount mit der verfügbaren Discount Quota
     * 
     * Es werden keine Speicheroperationen ausgeführt.
     * 
     * @param Mage_Customer_Model_Customer          &$customer Kunde
     * @param Stala_Extcustomer_Model_Salesdiscount &$item     Item
     * 
     * @return bool TRUE|FALSE Modified Customer?
     */
    protected static function _validateDiscountQuota(&$customer, &$item) {
    	$diQta = Mage::app()->getLocale()->getNumber($customer->getDiscountQuota());
    	$diQta = round($diQta - $item->getDiscount(),2);
    	if ($diQta >= 0) {
    		$customer->setDiscountQuota($diQta);
    		return true;	
    	} elseif ($diQta < 0) {
    		$discount = max(0.0, round($item->getDiscount() + $diQta,2));
    		$item->setDiscount($discount);
    		
    		if ($discount > 0) {
    			$diQta = Mage::app()->getLocale()->getNumber($customer->getDiscountQuota());
    			$diQta = round($diQta - $item->getDiscount(),2);
    			
	    		if ($diQta >= 0) {
		    		$customer->setDiscountQuota($diQta);
		    		return true;
		    	}
    		}
    	}
    	
    	return false;
    }
    
	protected function _insertUpdateDiscountItem($quoteItemId, $item) {
		$col = $this->getCollection();
		$col->loadByQuoteItemIdAndCustomerId($quoteItemId, $item->getCustomerId());
		
		if (!Mage::getResourceSingleton('customer/customer')->checkCustomerId($item->getCustomerId())) {
			return $this;
		}
		
		$customer = Mage::getModel('customer/customer')->load($item->getCustomerId());
		
		if (!$this->_isCustomerValid($customer)) {
    		return $this;
    	}
    	
    	//Ist es ein neues Item?
		if ($col->getSize() < 1) {			
			if (self::_validateDiscountQuota($customer, $item)) {
				$customer->save();
			}
			
			if ($item->getDiscount() > 0) {
				$col->addItem($item);
				$col->save();
			}
			return $this;
		}
		
		//Vorhandenes Item updaten
		foreach ($col->getItems() as $uItem) {
			if ($this->_getQuoteItem()->getOrigData('qty') > $this->_getQuoteItem()->getQty()) {
				//Anzahl wurde verringert
				//Quota um alten discount erhöhen!
				$diQta = Mage::app()->getLocale()->getNumber($customer->getDiscountQuota());
				$diQta += $uItem->getDiscount();
				
				$uItem->setDiscount($item->getDiscount());
				
				$customer->setDiscountQuota($diQta - $uItem->getDiscount());
				$customer->save();
			} elseif ($this->_getQuoteItem()->getOrigData('qty') < $this->_getQuoteItem()->getQty()) {
				//Anzahl wurde erhöht
				$diQta = Mage::app()->getLocale()->getNumber($customer->getDiscountQuota());
				
				//Alten Discount errechnen
				$diQta += $uItem->getDiscount();
				//Wird in validate benutzt
				$customer->setDiscountQuota($diQta);
				
				$modCustomer = self::_validateDiscountQuota($customer, $item);
				
				if ($item->getDiscount() > 0) {
					$uItem->setDiscount($item->getDiscount());
					$customer->setDiscountQuota($diQta - $uItem->getDiscount());
					$modCustomer = true;
				} else {
					$uItem->delete();
				}
				
				if ($modCustomer) {
					$customer->save();
				}
			} else {
				//nichts tun
			}
		}
		
		$col->save();
		
		return $this;
	}
    
    /**
     * Errechnet den höchstmöglichen Rabattbetrag unter Einbezug
     * aller Kunden- und Hauptkundenbeziehungen.
     * 
     * Die Funktion arbeitet rekursiv!
     * Die Daten werden temporär in einem Feld gespeichert.
     * 
     * @param Mage_Customer_Model_Customer $customer   Kunde
     * @param float                        $totalPrice Der Gesamtpreis des Artikels (Artikelanzahl * Preis)
     * 
     * @return float Höchstmöglicher Rabattbetrag
     */
    protected function _getAvailableDiscountAmount($customer, $totalPrice) {
    	if (!$this->_isCustomerValid($customer)) {
    		return 0.0;
    	}    		
    	
    	//Rundungsfehler eleminieren!
    	$totalPrice = round($totalPrice, 2);
    	
    	//Betrag (Preis) in float umwandeln
    	$diQuota = Mage::app()->getLocale()->getNumber($customer->getDiscountQuota());
    	
		if (is_null($diQuota) || $diQuota <= 0) {
    		$diQuota = 0;
		}
		
		//Bereits vorhandene Discounts auf aktuelle Quota anrechnen
		/* @var $col Stala_Extcustomer_Model_Mysql4_Salesdiscount_Collection */
		$col = $this->getCollection();
		$col->loadByQuoteItemIdAndCustomerId($this->_getQuoteItemId(), $customer->getId());
		
		$savedDiQuota = 0;
		foreach ($col->getItems() as $item) {
			//$this->_addTmpDiscount($customer, $item->getDiscount());				
			//alten discount einbeziehen
			$savedDiQuota += $item->getDiscount();
		}
		
    	$erg = round($totalPrice - ($diQuota + $savedDiQuota), 2);
		if ($erg <= 0) {
    		$min = min($totalPrice, ($diQuota + $savedDiQuota));
    		
    		//Brotkrumen anlegen
    		$this->_addTmpDiscount($customer, $min);
    		
    		return $min;
    	}
    	
    	//Discount Quota is ab hier kleiner als Preis
    	//$diQuota kann jetzt noch partiellen Teil enthalten
    	//bereits gespeicherte discounts müssen auch berücksichtigt werden
		if (($diQuota + $savedDiQuota) > 0) {
			//Brotkrumen anlegen
    		$this->_addTmpDiscount($customer, $diQuota + $savedDiQuota); 
		}
    	
    	$parentId = $customer->getParentCustomerId();
    	if ($parentId > 0 && Mage::getResourceSingleton('customer/customer')->checkCustomerId($parentId)) {
    		/* @var $parentCustomer Mage_Customer_Model_Customer */
    		$parentCustomer = Mage::getModel('customer/customer')->load($parentId);
    		
    		$diQuota += $this->_getAvailableDiscountAmount($parentCustomer, $totalPrice - ($diQuota + $savedDiQuota));    		
    	}
    	
    	if ($diQuota > $totalPrice) {
    		Mage::log("extcustomer::Discount [$diQuota] greater than total price [$totalPrice]", Zend_Log::WARN, Stala_Helper::LOG_FILE);
    	}
			
    	return $diQuota + $savedDiQuota;
    }
    
    /**
     * Prüft ob der Kunde noch existiert.
     * 
     * @param Mage_Customer_Model_Customer $customer Kunde
     * 
     * @return bool True if customer exists otherwise false.
     */
    protected function _isCustomerValid($customer) {
    	//Mage::getResourceSingleton('customer/customer')->checkCustomerId($parentId)
    	if (is_null($customer)
    		|| $customer->isDeleted()
    	) {
    			return false;
    	}
    	
    	return true;
    }
}