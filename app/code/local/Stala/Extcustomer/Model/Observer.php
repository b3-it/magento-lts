<?php

/**
 * Oberserver zur Behandlung von Rabatten
 * 
 * @category   	Stala
 * @package    	Stala_Extcustomer
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Stala_Extcustomer_Model_Observer extends Mage_Core_Model_Abstract
{
	/**
	 * Behandelt das Entfernen eines QuoteItems aus einer Quote 
	 * 
	 * @param Varien_Event_Observer $observer Observer
	 * 
	 * @return Stala_Extcustomer_Model_Observer
	 * 
	 * @see Mage_Sales_Model_Quote_Item
	 */	
	public function onSalesQuoteRemoveItem($observer) {
		Mage::log("extcustomer::sales_quote_remove_item event raised", Zend_Log::DEBUG, Stala_Helper::LOG_FILE);
		
		/* @var $quoteItem Mage_Sales_Model_Quote_Item */
		$quoteItem = $observer->getItem();
		//Item ist noch nicht gepeichert!
		if (is_null($quoteItem) || $quoteItem->getId() < 1)
			return $this;
		
		$salesDiscount = Mage::getModel('extcustomer/salesdiscount');
		$freecopies = Mage::getModel('extcustomer/freecopies');
		Mage::log("extcustomer::Quote item id: {$quoteItem->getId()}", Zend_Log::DEBUG, Stala_Helper::LOG_FILE);
		$freecopies->updateFreecopiesOnQuoteItemDelete($quoteItem);
		$salesDiscount->updateCustomerDiscountQuota($quoteItem->getId());
		
		return $this;
	}
	
	/**
	 * Behandelt das Löschen einer Quote
	 * 
	 * @param Varien_Event_Observer $observer Observer
	 * 
	 * @return Stala_Extcustomer_Model_Observer
	 * 
	 * @see Mage_Sales_Model_Quote
	 */
	public function onSalesQuoteDelete($observer) {
		Mage::log("extcustomer::sales_quote_delete event raised", Zend_Log::DEBUG, Stala_Helper::LOG_FILE);
		
		/* @var $quote Mage_Sales_Model_Quote */
		$quote = $observer->getQuote();
		//Item ist noch nicht gepeichert bzw gelöscht
		//20111006::Frank Rochlitzer
		//$quote->isActive() == 0 --> heißt nicht zwangsläufig geordert -> Abweichung im Adminbereich
		
		//Funktioniert so nicht, da sich Autoincrement der Quotetabelle immer zurücksetzt
		/* @var $orderModel Mage_Sales_Model_Entity_Order_Collection */
		/*$orderModel = Mage::getModel('sales/order')->getCollection();
		$orderModel->addAttributeToFilter('quote_id', $quote->getId());
		$isOrdered = count($orderModel->getAllIds(1)) > 0 ? true : false;*/
		
		if (is_null($quote) || $quote->getId() < 1 || $quote->isDeleted() || ($quote->getReservedOrderId() > 0)) {
			return $this;
		}
		
		/* @var $quoteItem Mage_Sales_Model_Quote */
		$salesDiscount = Mage::getModel('extcustomer/salesdiscount');
		$freecopies = Mage::getModel('extcustomer/freecopies');
		foreach ($quote->getAllItems() as $quoteItem) {
			if (is_null($quoteItem) || $quoteItem->isDeleted())
				continue;		
			Mage::log("extcustomer::Quote item id: {$quoteItem->getId()}", Zend_Log::DEBUG, Stala_Helper::LOG_FILE);
			$salesDiscount->updateCustomerDiscountQuota($quoteItem->getId());
			$freecopies->updateFreecopiesOnQuoteItemDelete($quoteItem);
		}
		return $this;
	}
	
	/**
	 * Behandelt die Rabattzuweisung
	 * 
	 * Wird auch bei Änderung der Anzahl der Elemente aufgerufen!
	 * 
	 * @param Varien_Event_Observer $observer Observer
	 * 
	 * @return Stala_Extcustomer_Model_Observer
	 */	
	public function onQuoteAddressDiscountItem($observer) {
		Mage::log("extcustomer::quote_address_discount_item event raised", Zend_Log::DEBUG, Stala_Helper::LOG_FILE);
		
		/*
		 * Beim Eintritt in diese Funktion enthält das quoteItem immer nur den regulären Magento discount!
		 * Der Kundenrabatt muss jedes Mal neu berechnet werden!
		 */
		
		/* @var $quoteItem Mage_Sales_Model_Quote_Item */
		$quoteItem = $observer->getItem();
		
		/* @var $customer Mage_Customer_Model_Customer*/
		$customer = $quoteItem->getQuote()->getCustomer();
		if ($customer instanceof Mage_Customer_Model_Customer) {
			if ($customer->getId() < 1)
				return $this;
		} else {
			return $this;
		}
		
		//Item ist noch nicht gepeichert
		//Es muss gepseichert werden, um BE-Bestellungen zu ermöglichen
		if ($quoteItem->getId() < 1) {
			
			if ($quoteItem->getQuote()->getId() > 0) {
				try {
					$quoteItem->save();
				} catch (Exception $e) {
				}
			}
			if ($quoteItem->getId() < 1)
				return $this;
		}			
			
		///Freiexemplare Berechnen
		//===================================================================
		$freecopiesDiscountAmount = Mage::getModel('extcustomer/freecopies')->getAvailableFreecopiesAmount($quoteItem);
		//===================================================================
		
		///Rabattguthaben einbeziehen
		//=====================================================================================================================================
		$quote = $quoteItem->getQuote();
		//Code ist nur für gleiche Währung implementiert
		if ($quote && $quote->getBaseCurrencyCode() == $quote->getQuoteCurrencyCode()) {
			$magentoDiscount = $quoteItem->getDiscountAmount();
			$magentoBaseDiscount = $quoteItem->getBaseDiscountAmount();
			
			/* #689
			*  Der Konfigurationspunkt "Katalogpreise enthalten Steuern" hat Auswirkungen auf die Berechnungen der Beträge, da die Reihenfolge
			*  der Rundungen sich negativ auf die Steuerberechnung auswirken kann.
			*  "Reihenfolge der Gesamtbeträge des Bezahlvorgangs" verursacht ebenfalls negative Effekte.
			*/
			//Preis ohne MwSt.
			$calcPrice = $quoteItem->getRowTotal();
			$calcBasePrice = $quoteItem->getBaseRowTotal();
			
			if (!Mage::helper('tax')->applyTaxAfterDiscount($quoteItem->getStore()) && Mage::helper('tax')->discountTax($quoteItem->getStore())) {
				$calcPrice = round($calcPrice + Mage::helper('extcustomer')->getCalcTaxAmount($quoteItem), 2);
				$calcBasePrice = round($calcBasePrice + Mage::helper('extcustomer')->getCalcBaseTaxAmount($quoteItem), 2);
			}
			
			$calcPrice = round($calcPrice - $magentoDiscount, 2);
			$calcBasePrice = round($calcBasePrice - $magentoBaseDiscount, 2);			
			
			/* @var $salesDiscount Stala_Extcustomer_Model_Salesdiscount */
			$salesDiscount = Mage::getModel('extcustomer/salesdiscount');
			//TODO : Funktion muss noch für BasePrice implementiert werden
			$discount = $salesDiscount->getAvailableDiscountAmount($quoteItem, $customer, $calcPrice);
			
			$quoteItem->setDiscountAmount(round($discount + $magentoDiscount,2));
			$quoteItem->setBaseDiscountAmount(round($discount + $magentoBaseDiscount,2));
		} else {
			Mage::log('No quote set or currency codes not equal for discount quota!', Zend_Log::WARN, Stala_Helper::LOG_FILE);
		}
		//=====================================================================================================================================
		
		return $this;
	}
	
	/**
	 * Wird ausgeführt wenn eine Bestellung storniert wird.
	 * 
	 * @param Varien_Event_Observer $observer Observer
	 * 
	 * @return Stala_Extcustomer_Model_Observer
	 */
	public function onSalesOrderItemCancel($observer) {
		Mage::log("extcustomer::sales_order_item_cancel event raised", Zend_Log::DEBUG, Stala_Helper::LOG_FILE);
		
		if(!$observer)
			return $this;
		
		if ($observer->getEvent()->getName() != "sales_order_item_cancel")
			return $this;
		
		$orderItem = $observer->getEvent()->getItem();
		
		$this->__salesOrderItemCancelRefund($orderItem);
		
		return $this;
	}
	
	/**
     * Wird bei Erstellung einer Gutschrift ausgeführt
     * 
     * @param Varien_Event_Observer $observer Observer
     * 
     * @return  Stala_Extcustomer_Model_Observer
     */
    public function refundOrderItem($observer) {
    	Mage::log("extcustomer::sales_creditmemo_item_save_after event raised", Zend_Log::DEBUG, Stala_Helper::LOG_FILE);
        
    	$item = $observer->getEvent()->getCreditmemoItem();
        if ($item->getId()) {
        	$orderItem = $item->getOrderItem();
			
			$this->__salesOrderItemCancelRefund($orderItem, true);
        }
        return $this;
    }
	
	/**
	 * Wird bei Stornierung oder Gutschrifterstellung ausgeführt
	 * 
	 * @param Mage_Sales_Model_Order_Item $orderItem Einzelnes Bestellelement
	 * @param boolean                     $isRefund  Ist es eine Gutschrift?
	 * 
	 * @return Stala_Extcustomer_Model_Observer
	 */
	private function __salesOrderItemCancelRefund($orderItem, $isRefund = false) {
		if (!$orderItem || !($orderItem instanceof Mage_Sales_Model_Order_Item))
			return $this;
		
		//Kunden-Gutschriften behandeln
		$model = Mage::getModel("extcustomer/salesdiscount");
		$model->updateCustomerDiscountQuota($orderItem->getQuoteItemId());
		
		//Kunden-Freiexemplare behandeln
		/* @var $model Stala_Extcustomer_Model_Freecopies */
		$model = Mage::getModel("extcustomer/freecopies");
		/* @var $orderItem Mage_Sales_Model_Order_Item */
		$model->updateFreecopiesOnCancelRefund($orderItem, $isRefund);
				
		return $this;
	}
	
	/**
	 * Wird vor dem Speichern eines Kunden im BE aufgerufen
	 * 
	 * @param Varien_Object $observer Observer
	 * 
	 * @return void
	 */
	public function onCustomerPrepareSave($observer) {
		/* @var $customer Mage_Customer_Model_Customer */
		$customer = $observer->getCustomer();
		
		if (is_null($customer))
			return $this;
		
		$value = Mage::app()->getLocale()->getNumber($customer->getDiscountQuota());
		$origValue = Mage::app()->getLocale()->getNumber($customer->getOrigData('discount_quota'));
		if ($value >= 0 && $value != $origValue) {
			Mage::getModel('extcustomer/salesdiscount')->resetAssignedDiscountsByCustomer($customer);
        	$customer->setData('discount_quota_init', $value);	
        }
	}
	
	/**
	 * Wird vor dem Speichern eines Kunden aufgerufen
	 * 
	 * @param Varien_Object $observer Observer
	 * 
	 * @return void
	 */
	public function onCustomerSave($observer) {
		$customer = $observer->getCustomer();
		if ($customer != null) {
			$store_id = $customer->getStoreId();
			if ($store_id == null) {
				return;
			}
			$website = $customer->getWebsiteId();
			$store = Mage::getModel('core/store')->load($store_id);
			if ($website != $store->getWebsiteId()) {
				Mage::log("WebsiteId= $website; StoreId=$store_id");
				Mage::throwException(Mage::helper('extcustomer')->__("Selected store and website are not associated!"));				
			}
			
			$this->_processCustomerFreecopiesSave($customer);
			
			$request = Mage::app()->getRequest();
			//Notwendig für 1.6 Portierung -> tabs über XML eingebunden
			//$request = $observer['request'];
			if ($request === null) return ;
			
			$request = $request->getParam('account');
			if (isset($request['parent_customer_id2'])) {
				$parentid = intval($request['parent_customer_id2']);
				if ($parentid != null) {
					$customer->setParentCustomerId($parentid);
				} else {
					$customer->setParentCustomerId(null);
				}
			}
			
		}
		return $this;
	}
	
	/**
	 * Speichert die Freiexemplare für einen Kunden
	 * 
	 * @param Mage_Customer_Model_Customer $customer Kunde
	 * 
	 * @return Stala_Extcustomer_Model_Observer
	 */
	protected function _processCustomerFreecopiesSave($customer) {
		/*
		 * Post-Variable muss mit <hidden_input_name>indie_freecopies</hidden_input_name> Wert des Serializers
		 * in der entsprechenden Layout XML übereinstimmen!
		 * 
		 * Data enthält immer alle angewählten Produkte -> Alle abgewählten müssen also zu global freecopies werden!
		 * Type:
		 * array(id=>array(freecopies=>value))
		 */
		/*
		 * 20110706 Frank Rochlitzer
		 * Customer wird auch bei Warenkorbaktionen gespeichert,
		 * in diesem Fall müssen die Anweisungen mit $data übersprungen werden!
		 */
		$data = Mage::app()->getRequest()->getPost('indie_freecopies');
		if (isset($data)) {
			$data = Mage::helper('adminhtml/js')->decodeGridSerializedInput($data);
			/* @var $freecopies Stala_Extcustomer_Model_Freecopies */
			$freecopies = Mage::getModel('extcustomer/freecopies');
				
			if (!$freecopies)
				return $this;
	
			/*
			 * 20110829: Frank Rochlitzer
			 * Ticket #765
			* Einheitliches Löschen ist somit möglich
			*/
			//preprocess array
			/*
			 * ZVM421 löschen von globalen FE mit -1 in Listenansicht
			 */
			$postProcess = array();
			foreach ($data as $key => $value) {
				if (is_array($value) && $value['freecopies'] < 0) {
					$postProcess[$key] = $value;
					unset($data[$key]);
				}
			}
			$keys = array_keys($data);
				
			if (is_array($data) && count($data) > 0) {
				/*
				 * 20111028::Frank Rochlitzer
				 * Die Verwendung von cross freecopies macht das Betrachten der original Daten notwendig.
				 * Im Grid sind die original Werte noch gespeichert und die würden die neuen Daten wieder überschreiben
				 */
				$originalFreecopyItems = array();
				foreach ($data as $key=>$value) {
					$freecopies->loadByProductCustomerId($key, $customer->getId());
					//Original Daten speichern
					
					if ($freecopies->isEmpty())
						continue;
					
					$originalFreecopyItems[$freecopies->getId()] = clone $freecopies;
				}
				
				foreach ($data as $key=>$value) {
					//Ticket #717 Comment1 Test 2 Punkt 8
					//http://www.kawatest.de:8080/trac/ticket/717#comment:2
					//Einzelexemplare sollte nur beim Abwählen gelöscht werden.
					//20110915::Frank Rochlitzer
					//Die Änderung beim Speichern wird bei 20110830 abgefangen
					if ($value['freecopies'] < 0) {
						$value['freecopies'] = 0;
					}
					$freecopies->loadByProductCustomerId($key, $customer->getId());
					
					/*
					 * 20110830::Frank Rochlitzer
					 * Falls sich die Werte nicht ändern, sollen Sie auch nicht reinitialisiert werden, außer bei Neuzuordnungen
					 */
					if (array_key_exists($freecopies->getId(), $originalFreecopyItems) && $originalFreecopyItems[$freecopies->getId()]->getFreecopies(false) == $value['freecopies'] &&
						$freecopies->getOption() == Stala_Extcustomer_Helper_Data::OPTION_INDIVIDUAL)
						continue;
						
					$freecopies->setFreecopiesForProduct(
								$key,
								$value['freecopies'],
								$customer
					);
				}
			}
			
			//Abgewählte Items wieder auf globale Werte setzen
			//Am Ende ausführen, damit Abhängigkeiten der Cross-Freecopies behandelt werden
			/* @var $freecopies Stala_Extcustomer_Model_Freecopies */
			$freecopies = Mage::getModel('extcustomer/freecopies');
			
			/* @var $collection Stala_Extcustomer_Model_Mysql4_Freecopies_Collection */
			$collection = Mage::getResourceModel('extcustomer/freecopies_collection')
								->addFieldToFilter('product_id', array('nin' => count($keys) > 0 ? $keys : array(-1)))
								->addFieldToFilter('customer_id', $customer->getId())
								->addFieldToFilter('option', Stala_Extcustomer_Helper_Data::OPTION_INDIVIDUAL)
			;
			
			foreach ($collection->getItems() as $item) {
				//ZVM421: Individuelle herauslöschen
				unset($postProcess[$item->getProductId()]);
				
				$freecopies->setFreecopiesForProduct(
					$item->getProductId(),
					$customer->getStalaBaseFreecopies() < 1 ? 0 : $customer->getStalaBaseFreecopies(),
					$customer,
					Stala_Extcustomer_Helper_Data::OPTION_GLOBAL
				);
			}
			
			/*
			 * ZVM421:: löschen von globalen FE mit -1 in Listenansicht
			 */
			$keys = array_keys($postProcess);
			if (count($keys) > 0) {
				$collection = Mage::getResourceModel('extcustomer/freecopies_collection')
									->addFieldToFilter('product_id', array('in' => count($keys) > 0 ? $keys : array(-1)))
									->addFieldToFilter('customer_id', $customer->getId())
									->addFieldToFilter('option', Stala_Extcustomer_Helper_Data::OPTION_GLOBAL)
				;
				
				$collection->walk('delete');
			}
		}
		
		$freecopies_count = Mage::app()->getRequest()->getPost(Stala_Extcustomer_Helper_Data::FREECOPIES_FIELD);
		if ((isset($freecopies_count) && !empty($freecopies_count)) || (is_numeric($freecopies_count) && $freecopies_count == 0)) {
			$freecopies = Mage::getModel('extcustomer/freecopies');
			
			if (!$freecopies)
				return $this;
			
			$freecopies->setFreecopiesForAllProducts($freecopies_count, $customer);			
		}
		
		return $this;
	}
	
	/**
	 * Löscht die Parent-Beziehung in allen Kindelementen falls der Parent gelöscht wird.
	 * Die Abhängigen Discounts werden ebenfalls entfernt!
	 * 
	 * @param Varien_Event_Observer $observer Observer
	 * 
	 * @return Stala_Extcustomer_Model_Observer
	 */
	public function onCustomerDeleteBefore($observer) {
		$customer = $observer->getCustomer();
		
		if (is_null($customer))
			return $this;
		
		/* @var $collection Stala_Extcustomer_Model_Mysql4_Salesdiscount_Collection */
		$collection = Mage::getModel('extcustomer/salesdiscount')->getCollection();
		$collection->addFilterByCustomerId($customer->getId());
		
		foreach ($collection->getItems() as $discount) {
			$discount->delete();
		}
		
		return $this;
	}
	
	/**
	 * Wird nach dem löschen eines Kunden aufgerufen.
	 * 
	 * @param Varien_Object $observer Observer
	 * 
	 * @return void
	 */
	public function onCustomerDeleteAfter($observer) {
		$customer = $observer->getCustomer();
		
		if (is_null($customer)) {
			return;
		}
		
		/* @var $collection Mage_Customer_Model_Entity_Customer_Collection */
		$collection = Mage::getModel('customer/customer')->getCollection();
		$attribute = 'parent_customer_id';
		$collection->addAttributeToFilter($attribute, $customer->getId());
 		$liteCustomers = $collection->getAllIds();
 		
		$columns = array ($attribute);
		
		//da Resource Singleton ist und schon ein Customer mit allen Attributen geladen ist, müssen wir die Attribute resetten
		//=> Wir wollen nur einen Partiellen Kunden laden
		$resource = Mage::getModel('customer/customer')->getResource()->unsetAttributes();
		//$resource->isPartialLoad(true);
		foreach ($liteCustomers as $customer) {
			$customer = Mage::getModel('customer/customer')->load($customer, $columns);
			$customer->setParentCustomerId(null);
			$customer->save();
		}
	}
}