<?php
/**
 * Observer für Tax-Erweiterung
 * 
 * - Anpassung des TaxRequests
 * - Prüfung von Warenkorbeinschränkungen
 *
 * @category	Egovs
 * @package		Egovs_GermanTax
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright	Copyright (c) 2014 - 2015 B3 IT Systeme GmbH <www.b3-it.de> 
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_GermanTax_Model_Tax_Observer
{
	public function onTaxRateDataFetch($observer) {
		/* @var $request Varien_Object */
		$request = $observer->getRequest();
		
		/*
		 * country_id, region_id und postcode ist für $request eigentlich für alle Items gleich!
		 * OrigData existiert nur wenn diese Funktion schon einmal aufgerufen wurde!
		 */
		if ($request->getOrigData()
			&& $request->getOrigData('product_class_id') == $request->getProductClassId()
			&& $request->getOrigData('customer_class_id') == $request->getCustomerClassId()
			&& $request->getOrigData('is_virtual') == $request->getIsVirtual()
		) {
			$request->setData($request->getOrigData());
		}
		if (!$request->getIsVirtual()) {
			return;
		}
		$customer = Mage::getSingleton('germantax/tax_calculation')->getCustomer();
		
		if ($customer instanceof Mage_Customer_Model_Customer && $customer->getId()) {
			$baseAddress = $customer->getAddressById($customer->getBaseAddress());
			if ($baseAddress && !$baseAddress->isEmpty()) {
				$request->setOrigData();
				$request
					->setCountryId($baseAddress->getCountryId())
					->setRegionId($baseAddress->getRegionId())
					->setPostcode($baseAddress->getPostcode())
				;
				if (Mage::helper('germantax')->hasValidVatId($baseAddress)) {
					$request->setTaxvat(1);
				} else {
					$request->unsetData('taxvat');
				}
			}
		}
	}
	
	/**
	 * Wird nach dem hinzufügen eines Items zu einer Quote aufgerufen.
	 * 
	 * Die Quote wurde noch nicht gespeichert!
	 * 
	 * @param Varien_Event_Observer $observer Observer-Daten
	 * 
	 * @return void
	 */
	public function onSalesQuoteAddItem($observer) {
		/* @var $item Mage_Sales_Model_Quote_Item */
		$item = $observer->getQuoteItem();
		if (!$item) {
			return;
		}
		
		$quote = $item->getQuote();
		if ($quote->hasVirtualItems() && !$quote->isVirtual()) {
			/* @var $quoteBaseAddress Mage_Sales_Model_Quote_Address */
			$quoteBaseAddress = $quote->getBaseAddress();
			$quoteShippingAddress = $quote->getShippingAddress();
			
			$customer = $quote->getCustomer();
			if (!$customer || $customer->isEmpty()) {
				$customer = Mage::getModel('customer/customer')->load($quote->getCustomerId());
			}
			if ($customer->isEmpty()) {
				return;
			}
			
			if (!$quoteShippingAddress->getCustomerAddressId()) {
				$quoteShippingAddress = $customer->getDefaultShippingAddress();
			}
			if (!$quoteBaseAddress->getCustomerAddressId()) {
				$quoteBaseAddress = $customer->getAddressById($customer->getBaseAddress());
			}
			if ($this->_addressesHaveSameTaxRateRequests($quoteShippingAddress, $quoteBaseAddress)) {
				return;
			}
			Mage::throwException(Mage::helper('germantax')->__('It is not possible to buy these items together. Please buy this item separately or remove all other items in your shopping cart.'));
		}
	}
	
	/**
	 * Prüfung Warenkorbeinschränkungen bei gemischten Warenkörben
	 * 
	 * @param Varien_Object $observer Observer
	 * 
	 * @return void
	 */
	public function onCopyFieldsetCustomerAddressToQuoteAddress($observer) {
		$address = $observer->getTarget();
		if (!$address || !($address instanceof Mage_Sales_Model_Quote_Address)
			|| !$address->getId() || $address->getAddressType() != Mage_Sales_Model_Quote_Address::TYPE_SHIPPING || !$address->getQuote()
		) {
			return;
		}
		
		$quote = $address->getQuote();
		if ($quote->hasVirtualItems() && !$quote->isVirtual()) {
			$baseAddress = $quote->getBaseAddress();
			if (!$baseAddress || $baseAddress->isEmpty()) {
				return;
			}
			
			if ($this->_addressesHaveSameTaxRateRequests($address, $baseAddress)) {
				return;
			}
			Mage::throwException(Mage::helper('germantax')->__('It is not possible to buy all the items in your shopping cart with this address combination together. Please split your order in shippable and non-shippable products or choose an shipping address which is equivalent to your base address.'));
		}
	}
	
	/**
	 * Vergleicht zwei Adressen um Steuerbehandlung zu schätzen.
	 * 
	 * Eine genaue Steuerbehandlung kann nicht vorausgesagt werden, da der Kontext
	 * der Steuerregeln unbekannt ist. daher werden alle Elemente mit Einfluss auf die Auswahl
	 * der entsprechenden Steuerbehandlung verglichen.
	 * 
	 * @param Mage_Sales_Model_Quote_Address $firstAddress  Adresse
	 * @param Mage_Sales_Model_Quote_Address $secondAddress Adresse
	 * 
	 * @return boolean
	 */
	protected function _addressesHaveSameTaxRateRequests($firstAddress, $secondAddress) {
		if ($firstAddress == false
			|| $secondAddress == false
			||	$firstAddress->getId() == $secondAddress->getId()
			|| ($firstAddress->getCustomerAddressId() && $secondAddress->getCustomerAddressId()
				&& $firstAddress->getCustomerAddressId() == $secondAddress->getCustomerAddressId())
		) {
			return true;
		}
		
		$defaultCountry = trim(Mage::getStoreConfig(Mage_Tax_Model_Config::CONFIG_XML_PATH_DEFAULT_COUNTRY));
		if (empty($defaultCountry)) {
			$defaultCountry = 'DE';
		}
		if ($defaultCountry == $firstAddress->getCountryId() && $defaultCountry == $secondAddress->getCountryId()) {
			return true;
		}
			
		if ($firstAddress->getCountryId() == $secondAddress->getCountryId()
			//&& $firstAddress->getPostcode() == $secondAddress->getPostcode()
			//&& $firstAddress->getRegionId() == $secondAddress->getRegionId()
			//&& $firstAddress->getCompany() == $secondAddress->getCompany()
			&& $firstAddress->getVatId() == $secondAddress->getVatId()
			//&& $firstAddress->getVatIsValid() == $secondAddress->getVatIsValid()
		) {
			return true;
		}
		
		return false;
	}
	
	/**
	 * Save order tax information
	 *
	 * @param Varien_Event_Observer $observer Observer
	 * 
	 * @return void
	 */
	public function salesEventOrderAfterSave(Varien_Event_Observer $observer) {
		$order = $observer->getEvent()->getOrder();
	
		if (!$order->getConvertingFromQuote() || $order->getAppliedTaxIsSaved()) {
			return;
		}
	
		$getTaxesForItems   = $order->getQuote()->getTaxesForItems();
		$taxes              = $order->getAppliedTaxes();
	
		$ratesIdQuoteItemId = array();
		if (!is_array($getTaxesForItems)) {
			$getTaxesForItems = array();
		}
		foreach ($getTaxesForItems as $quoteItemId => $taxesArray) {
			foreach ($taxesArray as $rates) {
				if (count($rates['rates']) == 1) {
					$ratesIdQuoteItemId[$rates['id']][] = array(
							'id'        => $quoteItemId,
							'percent'   => $rates['percent'],
							'code'      => $rates['rates'][0]['code']
					);
				} else {
					$percentDelta   = $rates['percent'];
					$percentSum     = 0;
					foreach ($rates['rates'] as $rate) {
						$ratesIdQuoteItemId[$rates['id']][] = array(
								'id'        => $quoteItemId,
								'percent'   => $rate['percent'],
								'code'      => $rate['code']
						);
						$percentSum += $rate['percent'];
					}
	
					if ($percentDelta != $percentSum) {
						$delta = $percentDelta - $percentSum;
						foreach ($ratesIdQuoteItemId[$rates['id']] as &$rateTax) {
							if ($rateTax['id'] == $quoteItemId) {
								$rateTax['percent'] = (($rateTax['percent'] / $percentSum) * $delta)
								+ $rateTax['percent'];
							}
						}
					}
				}
			}
		}
	
		foreach ($taxes as $id => $row) {
			foreach ($row['rates'] as $tax) {
				if (is_null($row['percent'])) {
					$baseRealAmount = $row['base_amount'];
				} else {
					if ($row['percent'] == 0 || $tax['percent'] == 0) {
						continue;
					}
					$baseRealAmount = $row['base_amount'] / $row['percent'] * $tax['percent'];
				}
				$hidden = (isset($row['hidden']) ? $row['hidden'] : 0);
				$data = array(
						'order_id'          => $order->getId(),
						'code'              => $tax['code'],
						'title'             => $tax['title'],
						'hidden'            => $hidden,
						'percent'           => $tax['percent'],
						'priority'          => $tax['priority'],
						'position'          => $tax['position'],
						'amount'            => $row['amount'],
						'base_amount'       => $row['base_amount'],
						'process'           => $row['process'],
						'base_real_amount'  => $baseRealAmount,
				);
	
				$result = Mage::getModel('tax/sales_order_tax')->setData($data)->save();
	
				if (isset($ratesIdQuoteItemId[$id])) {
					foreach ($ratesIdQuoteItemId[$id] as $quoteItemId) {
						if ($quoteItemId['code'] == $tax['code']) {
							$item = $order->getItemByQuoteItemId($quoteItemId['id']);
							if ($item) {
								$data = array(
										'item_id'       => $item->getId(),
										'tax_id'        => $result->getTaxId(),
										'tax_percent'   => $quoteItemId['percent'],
										'tax_key'		=> isset($tax['tax_key'])? $tax['tax_key'] : ""
								);
								Mage::getModel('tax/sales_order_tax_item')->setData($data)->save();
							}
						}
					}
				}
			}
		}
	
		$order->setAppliedTaxIsSaved(true);
	}
	
	/**
	 * Add tax percent values to product collection items
	 *
	 * @param Varien_Event_Observer $observer Observer
	 * 
	 * @return Mage_Tax_Model_Observer
	 */
	public function addTaxPercentToProductCollection($observer) {
		$helper = Mage::helper('tax');
		$collection = $observer->getEvent()->getCollection();
		$store = $collection->getStoreId();
		if (!$helper->needPriceConversion($store)) {
			return $this;
		}
	
		if ($collection->requireTaxPercent()) {
			$request = Mage::getSingleton('germantax/tax_calculation')->getRateRequest();
			foreach ($collection as $item) {
				if (null === $item->getTaxClassId()) {
					$item->setTaxClassId($item->getMinimalTaxClassId());
				}
				if (!isset($classToRate[$item->getTaxClassId()])) {
					$request->setProductClassId($item->getTaxClassId());
					$classToRate[$item->getTaxClassId()] = Mage::getSingleton('germantax/tax_calculation')->getRate($request);
				}
				$item->setTaxPercent($classToRate[$item->getTaxClassId()]);
			}
	
		}
		return $this;
	}
	


	/**
	 * Abfangen ob eine Steuerregel gefunden wurde
	 */
	public function onSalesOrderPlaceBefore($observer)
	{
		if(Mage::getStoreConfig('tax/calculation/deny_order_without_taxrule') == 1){
			$model = Mage::getResourceModel('germantax/tax_rulecount');
			$order = $observer->getOrder();
			if($model->getRulecount($order) == 0)
			{
				Mage::throwException(Mage::helper('germantax')->__("No Tax Rule found! Verify your Addresses."));
			}
		}
	}
	
}