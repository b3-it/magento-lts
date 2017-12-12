<?php
/**
 * Merkzettel - Model
 *
 * @category   	Sid
 * @package    	Sid_Wishlist
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2012 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2012 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_Wishlist_Model_Quote extends Sid_Wishlist_Model_Abstract
{
	protected $_eventPrefix = 'sid_wishlist_quote';
	protected $_eventObject = 'quote';

	/**
	 * Quote Kunden-Model-Object
	 *
	 * @var Mage_Customer_Model_Customer
	 */
	protected $_customer;

	/**
	 * Quote Items-Collection
	 *
	 * @var Mage_Eav_Model_Entity_Collection_Abstract
	 */
	protected $_items = null;

	/**
	 * Verschiedene Gruppen für Fehler-Infos
	 *
	 * @var array
	 */
	protected $_errorInfoGroups = array();
	
	/**
	 * Magento Sales Quote
	 * 
	 * @var Mage_Sales_Model_Quote
	 */
	protected $_salesQuote = null;
	
	/**
	 * ACLs für Kunden
	 * 
	 * @var Varien_Object
	 */
	protected $_acls = null;
	
	/**
	 * Währung
	 * 
	 * @var string
	 */
	protected $_orderCurrency = null;  

	/**
	 * Konstruktor -
	 *
	 * @return void
	 *
	 * @see Varien_Object::_construct()
	 */
	protected function _construct() {
		parent::_construct();
		$this->_init('sidwishlist/quote');
	}

	/**
	 * Init mapping array of short fields to
	 * its full names
	 *
	 * @return Varien_Object
	 */
	protected function _initOldFieldsMap() {
		$this->_oldFieldsMap = Mage::helper('sidwishlist')->getOldFieldMap('quote');
		return $this;
	}
	
	protected function _getSalesQuote() {
		if (!$this->_salesQuote) {
			if ($this->hasQuoteEntityId()) {
				$this->_salesQuote = Mage::getModel('sales/quote')->load($this->getQuoteEntityId());
				if ($this->_salesQuote->isEmpty()) {
					Mage::throwException(Mage::helper('sidwishlist')->__('Error while loading data'));
				}
				/*
				 * If current currency code of quote is not equal current currency code of store,
				 * need recalculate totals of quote. It is possible if customer use currency switcher or
				 * store switcher.
				 */
				if ($this->_salesQuote->getQuoteCurrencyCode() != Mage::app()->getStore()->getCurrentCurrencyCode()) {
					$this->_salesQuote->setStore(Mage::app()->getStore());
					$this->_salesQuote->collectTotals()->save();
					/*
					 * We mast to create new quote object, because collectTotals()
					 * can to create links with other objects.
					 */
					$this->_salesQuote = Mage::getModel('sales/quote')->setStoreId(Mage::app()->getStore()->getId());
					$this->_salesQuote->load($this->getQuoteEntityId());
				}
			} else {
				$salesQuote = Mage::getModel('sales/quote');
				$salesQuote->setStore(Mage::app()->getStore());
				$salesQuote->setIsActive(false);
				$salesQuote->setIsPersistent(true);
				$this->_setSalesQuote($salesQuote);
			}
		}
		
		return $this->_salesQuote;
	}
	
	/**
	 * Liefert einen Sharing-Code (random string)
	 *
	 * @return string
	 */
	protected function _getSharingRandomCode() {
		return Mage::helper('core')->uniqHash();
	}
	
	/**
	 * Setzt die Magento Sales Quote für diese Merkliste
	 * 
	 * @param Mage_Sales_Model_Quote $salesQuote Magento Quote
	 * 
	 * @return Sid_Wishlist_Model_Quote
	 */
	protected function _setSalesQuote($salesQuote) {
		if ($this->hasQuoteEntityId()) {
			if (!$this->_salesQuote) {
				$this->_salesQuote = $this->_getSalesQuote();
			}
			return $this;
		}
		
		$this->_salesQuote = $salesQuote;
		
		if ($this->hasCustomerId() && $this->_salesQuote->getCustomerId() != $this->getCustomerId()) {
			$this->_salesQuote->assignCustomer($this->getCustomer());
		}

		$this->setQuoteEntityId($this->_salesQuote->getId());
		$this->setItemsCount($this->_salesQuote->getItemsCount());
		$this->setItemsQty($this->_salesQuote->getItemsQty());
		$this->setStore($this->_salesQuote->getStore());
		
		return $this;
	}
	
	protected function _updateData(Sid_Wishlist_Model_Quote_Item $item) {
		
	}

	/**
	 * Get quote store identifier
	 *
	 * @return int
	 */
	public function getStoreId() {
		if (!$this->hasStoreId()) {
			return Mage::app()->getStore()->getId();
		}
		return $this->_getData('store_id');
	}

	/**
	 * Get quote store model object
	 *
	 * @return  Mage_Core_Model_Store
	 */
	public function getStore() {
		return Mage::app()->getStore($this->getStoreId());
	}

	/**
	 * Declare quote store model
	 *
	 * @param Mage_Core_Model_Store $store Store
	 * 
	 * @return Sid_Wishlist_Model_Quote
	 */
	public function setStore(Mage_Core_Model_Store $store) {
		$this->setStoreId($store->getId());
		return $this;
	}

	/**
	 * Get all available store ids for quote
	 *
	 * @return array
	 */
	public function getSharedStoreIds() {
		$ids = $this->_getData('shared_store_ids');
		if (is_null($ids) || !is_array($ids)) {
			if ($website = $this->getWebsite()) {
				return $website->getStoreIds();
			}
			return $this->getStore()->getWebsite()->getStoreIds();
		}
		return $ids;
	}

	/**
	 * Prepare data before save
	 *
	 * @return Sid_Wishlist_Model_Quote
	 */
	protected function _beforeSave() {
		//TODO : Gespeicherte Quote auf Änderungen überprüfen!!
		
		if (!$this->getIsPartialSave()) {
			$this->_setSalesQuote($this->_getSalesQuote()->save());
		}
		
		if (!$this->hasChangedFlag() || $this->getChangedFlag() == true) {
			$this->setIsChanged(1);
		} else {
			$this->setIsChanged(0);
		}

		if ($this->_customer) {
			$this->setCustomerId($this->_customer->getId());
		}
		if ($this->_acls) {
			$this->setCustomerAcls($this->_acls);
		}

		parent::_beforeSave();
	}
	
	protected function _beforeDelete() {
		if ($this->getIsDefault()) {
			$item = $this->getCollection()
				->loadByCustomerId(Mage::getSingleton('customer/session')->getCustomerId())
				->getFirstItem()
			;

			if (!$item->isEmpty()) {
				$item->setIsDefault(true);
			}
		}
		
		parent::_beforeDelete();

        $currentQuote = Mage::getSingleton('checkout/session')->getQuote();
        $_customers = array(Mage::getSingleton('customer/session')->getCustomerId());

        foreach ($this->getCustomerAcls()->getData() as $id => $role) {
            if ($role !== 'O') {
                continue;
            }
            $_customers[] = $id;
        }

        $quoteCollection = Mage::getModel('sales/quote')->getCollection();
        $quoteCollection->addFieldToFilter('customer_id', array('in' => $_customers));
        $quoteCollection->addFieldToFilter('is_active', 1);
        $quoteCollection->addFieldToFilter('items_qty', array('gt' => 0));
        foreach ($quoteCollection->getItems() as $quote) {
            /** @var Sid_Wishlist_Model_Quote_Item $item */
            foreach ($this->getAllVisibleItems() as $item) {
                /** @var Mage_Sales_Model_Quote_Item $salesItem */
                foreach ($quote->getAllVisibleItems() as $salesItem) {
                    if ($item->getQtyGranted() > 0 && $item->representProduct($salesItem->getProduct())) {
                        $qty = max($salesItem->getQty() - $item->getQtyGranted(), 0);
                        if ($qty > 0) {
                            $salesItem->setQty($qty);
                        } else {
                            $salesItem->delete();
                        }
                    }
                }
            }
            if ($currentQuote->getId() == $quote->getId()) {
                $currentQuote->setTriggerRecollect(true)->collectTotals();
            }
            $quote->save();
        }

        return $this;
	}

	/**
	 * Save related items
	 *
	 * @return Sid_Wishlist_Model_Quote
	 */
	protected function _afterSave() {
		parent::_afterSave();

		if (null !== $this->_items) {
			$this->getItemsCollection()->save();
		}
		
		return $this;
	}

	/**
	 * Quote-Daten über Kunden laden
	 * 
	 * @param Mage_Customer_Model_Customer|int $customer Kunde
	 *
	 * @return Sid_Wishlist_Model_Quote
	 */
	public function loadByCustomer($customer) {
		if ($customer instanceof Mage_Customer_Model_Customer) {
			$customerId = $customer->getId();
		} else {
			$customerId = (int) $customer;
		}
		$this->_getResource()->loadByCustomerId($this, $customerId);
		$this->_afterLoad();
		
		return $this;
	}

	/**
	 * Nur aktive Merkzettel laden
	 *
	 * @param int $quoteId Quote ID
	 * 
	 * @return Sid_Wishlist_Model_Quote
	 */
	public function loadActive($quoteId) {
		$this->_getResource()->loadActive($this, $quoteId);
		$this->_afterLoad();
		
		return $this;
	}
	
	/**
	 * Merkzettel über Share-Code laden
	 * 
	 * @param string $share
	 * 
	 * @return Sid_Wishlist_Model_Quote
	 */
	public function loadByShareCode($share) {
		$this->_getResource()->loadByShareCode($this, $share);
		$this->_afterLoad();
	
		return $this;
	}

	/**
	 * Quote über ID laden
	 *
	 * @param int $quoteId Quote ID
	 * 
	 * @return Sid_Wishlist_Model_Quote
	 */
	public function loadByIdWithoutStore($quoteId) {
		$this->_getResource()->loadByIdWithoutStore($this, $quoteId);
		$this->_afterLoad();
		
		return $this;
	}

	/**
	 * Kunden-Model-Object der Quote zuweisen
	 *
	 * @param Mage_Customer_Model_Customer $customer Kunde
	 * 
	 * @return Sid_Wishlist_Model_Quote
	 */
	public function assignCustomer(Mage_Customer_Model_Customer $customer) {
		if ($customer->getId()) {
			if (!$this->hasCustomerId()) {
            	$this->setCustomer($customer);
			}
			$acls = $this->getCustomerAcls();
			if (!$acls->hasData($customer->getId())) {
				if (Mage::helper('sidwishlist')->isAuthorizedOrderer($customer)) {
					$acls->setData($customer->getId(), 'O');
				} else {
					$acls->setData($customer->getId(), 'W');
				}
			} else {
				if (Mage::helper('sidwishlist')->isAuthorizedOrderer($customer) && $acls->getData($customer->getId()) != 'O') {
					$acls->setData($customer->getId(), 'O');
				}
			}
		}
		
		return $this;
	}
	
	/**
	 * Liefert die ACLs für Kunden
	 *
	 * ACLs haben die Form:<br/>
	 *  { customer_id => W|R|O }
     *
     * <dl>
     *  <dt>O</dt>
     *  <dd>Berechtigter Besteller</dd>
     *  <dt>W</dt>
     *  <dd>Interessent</dd>
     * </dl>
	 *  
	 * @return Varien_Object
	 */
	public function getCustomerAcls() {
		if ($this->_acls instanceof Varien_Object) {
			return $this->_acls;
		}
		
		$seralizedAcls = $this->getData('customer_acls');
		$this->_acls = new Varien_Object($seralizedAcls ? unserialize($seralizedAcls) : null);
	
		return $this->_acls;
	}
	
	/**
	 * Setzt die ACLs für Kunden
	 * 
	 * ACLs haben die Form:<br/>
	 *  { customer_id => W|R|O }
	 * <ul>
	 * 	<li>R = Lesezugriff</li>
	 * 	<li>W = Schreibzugriff</li>
	 * 	<li>O = Ordererzugriff</li>
	 * </ul>
	 *  
	 * @param array|Varien_Object|null $acls ACLs
	 * 
	 * @return Sid_Wishlist_Model_Quote
	 */
	public function setCustomerAcls($acls) {
		if (is_null($acls)) {
			$acls = new Varien_Object();
			//Der Eigentümer muss immer drin stehen!
			$customer = $this->getCustomer();
			if (Mage::helper('sidwishlist')->isAuthorizedOrderer($customer)) {
				$acls->setData($customer->getId(), 'O');
			} else {
				$acls->setData($customer->getId(), 'W');
			}
		}
		if (is_array($acls)) {
			$acls = new Varien_Object($acls);
		}
		if (!($acls instanceof Varien_Object)) {
			return $this;
		}
		
		if ($acls instanceof Varien_Object) {
			$serialized = serialize($acls->getData());
			$this->setData('customer_acls', $serialized);
			$this->_acls = $acls;
			
			return $this;
		}		
		
		Mage::throwException("Serialization error: Can't serialize ACLs");
	}
	
	/**
	 * Entfernt einen Kunden von der ACL
	 * 
	 * Falls es sich um den letzten Kunden handelt,
	 * so wird der Merkzettel gelöscht.
	 * 
	 * @param int|Mage_Customer_Model_Customer $customer Kunde
	 * 
	 * @return Sid_Wishlist_Model_Quote
	 * @see Sid_Wishlist_Model_Quote::_delete()
	 */
	public function removeCustomerFromAcls($customer) {
		if ($customer instanceof Mage_Customer_Model_Customer) {
			$customer = $customer->getId();
		}
		
		if (!is_numeric($customer)) {
			return $this;
		}
		
		$this->checkAcl();
		
		$this->getCustomerAcls()->unsetData($customer);

		if ($this->getCustomerAcls()->isEmpty()) {
			$this->_delete();
			return $this;
		}

		$this->setCustomerAcls($this->getCustomerAcls());
				
		return $this;
	}
	
	/**
	 * Prüft die Rechte
	 * 
	 * Falls kein Kunde übergeben wird, wird der aktuelle Kunde genommen.
	 * 
	 * @param int|Mage_Customer_Model_Customer $customer Kunde oder null
	 * 
	 * @return void
	 */
	public function checkAcl($customer = null) {
		if ($customer instanceof Mage_Customer_Model_Customer) {
			$customer = $customer->getId();
		}
		
		if (!is_numeric($customer)) {
			$customer = Mage::getSingleton('customer/session')->getCustomerId();
		}
		
		//Hat der aktuelle Nutzer die notwendigen Rechte!
		if (!$this->getCustomerAcls()->hasData($customer)
				|| (	$this->getCustomerAcls()->getData($customer) != 'W'
						&& $this->getCustomerAcls()->getData($customer) != 'O'
						&& $this->getCustomerId() != $customer)
		) {
			Mage::throwException(Mage::helper('sidwishlist')->__('Operation not allowed!'));
		}
	}
	
	/**
	 * Prüft ob diese Merkliste mindestens einen Berechtigten Besteller besitzt
	 *
	 * In den ACLs muss mindestens ein Kunde mit dem recht 'O' stehen.
	 * 
	 * @return bool
	 */
	public function hasAuthorizedOrderer() {
		foreach ($this->getCustomerAcls()->getData() as $key => $value) {
			if ($value == 'O') {
				return true;
			}
		}
		/** @var $customerSession Mage_Customer_Model_Session */
		$customerSession = Mage::getSingleton('customer/session');
		if ($customerSession->isLoggedIn() && $customerSession->getCustomer()->getCheckoutAuthority() == Sid_Roles_Model_Customer_Authority::AUTHORIZED_ORDERER) {
			$this->getCustomerAcls()->setData($customerSession->getCustomerId(), 'W');
			return true;
		}
		
		return false;
	}
	
	/**
	 * Liefert ein Array mit Informationen über die Mitglieder dieser Liste
	 * 
	 * Das Array kann leer sein oder einen oder beide der folgenden Keys enthalten: <br />
	 * <ul>
	 * 	<li>'specials' => string</li>
	 *  <li>'commons' => string</li>
	 * </ul>
	 * 
	 * @return array
	 */
	public function getAssignedCustomersInformation () {
		$collection = Mage::getModel('customer/customer')->getCollection();
		/* @var $collection Mage_Customer_Model_Resource_Customer_Collection */
		$collection->addAttributeToSelect('customer/firstname')
			->addAttributeToSelect('customer/middlename')
			->addAttributeToSelect('customer/lastname')
			->addAttributeToSelect('customer/email')
			->addNameToSelect()
			->addFieldToFilter($collection->getRowIdFieldName(), array('in' => array_keys($this->getCustomerAcls()->getData())))
		;
		$specials = '';
		$commons = '';
		$orderers = 0;
		$members = 0;
		foreach ($collection->getItems() as $customer) {
			$t = sprintf("%s (%s)", $customer->getName(), $customer->getEmail());
			if ($this->getCustomerAcls()->getData($customer->getId()) == 'O') {
				$specials .= $t.', ';
				$orderers++;
				continue;
			}
			$commons .= $t.', ';
			$members++;
		}
		$specials = trim($specials, ', ');
		$res = array();
		if (!empty($specials)) {
			$specials = Mage::helper('sidwishlist')->__('Authorized Orderers (%s)', $orderers).': '.$specials;
			$res['specials'] = $specials;
		}
		$commons = trim($commons, ', ');
		if (!empty($commons) && count($this->getCustomerAcls()->getData()) > 1) {
			$res['commons'] = Mage::helper('sidwishlist')->__('Members (%s)', $members).': '.$commons;
		}
		return $res;
	}
	
	public function getIsDefault() {
		if ($this->getData('is_default') == 1) {
			return true;
		}
		
		return false;
	}
	
	public function setIsDefault($default = false) {
		if ($this->getData('is_default') == $this->getOrigData('is_default')) {
			return $this;
		}
		
		if ($default) {
			$resource = $this->getResource();
			$adapter = $resource->getReadConnection();
			$bind    = array(
					'customer_id' => Mage::getSingleton('customer/session')->getCustomerId(),
					'id' => $this->getId() ? $this->getId() : -1,
			);
			$columns = array($resource->getIdFieldName(), 'is_default');
			$select  = $adapter->select()
				->from($resource->getMainTable(), $columns)
				->where('customer_id = (:customer_id)')
				->where('is_default = 1')
				->where("{$resource->getIdFieldName()} != (:id)")
			;
			
			$lightCollections = $adapter->fetchAll($select, $bind);
			foreach ($lightCollections as $quote) {
				$quote = Mage::getModel('sidwishlist/quote', $quote);
				$quote->setIsPartialSave(true);
				$quote->setData('is_default', false);
				$quote->save();
			}
			
			
		}
		$this->setData('is_default', $default);
		return $this->save();
	}
	/**
	 * Setzt Customer-Object
	 *
	 * @param Mage_Customer_Model_Customer $customer Kunde
	 * 
	 * @return Sid_Wishlist_Model_Quote
	 */
	public function setCustomer(Mage_Customer_Model_Customer $customer)	{
		$this->_customer = $customer;
		$this->setCustomerId($customer->getId());
		Mage::helper('core')->copyFieldset('customer_account', 'to_quote', $customer, $this);
		
		return $this;
	}

	/**
	 * Retrieve customer model object
	 *
	 * @return Mage_Customer_Model_Customer
	 */
	public function getCustomer() {
		if (is_null($this->_customer)) {
			$this->_customer = Mage::getModel('customer/customer');
			if ($customerId = $this->getCustomerId()) {
				$this->_customer->load($customerId);
				if (!$this->_customer->getId()) {
					$this->_customer->setCustomerId(null);
				}
			}
		}
		return $this->_customer;
	}
	
	public function getOwner() {
		if (!$this->getCustomer()->isEmpty()) {
			return $this->getCustomer()->getName();
		}
		
		return sprintf('%s %s', $this->getCustomerFirstname, $this->getCustomerLastname);
	}
	
	public function getStatusLabel() {
		if ($this->getIsActive()) {
			return Mage::helper('sidwishlist')->__('Active');
		}
		
		return Mage::helper('sidwishlist')->__('Inactive');
	}
	
	public function getDefaultLabel() {
		if ($this->getIsDefault() && $this->isOwner(Mage::getSingleton('customer/session')->getCustomerId())) {
			return Mage::helper('sidwishlist')->__('Yes');
		}
	
		return Mage::helper('sidwishlist')->__('No');
	}
	
	public function getGrandTotal() {
		$data = $this->getData('grand_total');
		if (!is_numeric($data ) || $data < 0.0) {
			//return $this->_getSalesQuote()->getGrandTotal();
			return 0.0;
		}
		
		return $data;
	}

	/**
	 * Retrieve customer group id
	 *
	 * @return int
	 */
	public function getCustomerGroupId() {
		if ($this->getCustomerId()) {
			return ($this->getData('customer_group_id')) ? $this->getData('customer_group_id')
			: $this->getCustomer()->getGroupId();
		} else {
			return Mage_Customer_Model_Group::NOT_LOGGED_IN_ID;
		}
	}
	
	public function initFirstDefaultQuote($name = "Default") {
		$customer = Mage::getSingleton('customer/session')->getCustomer();
		$this->assignCustomer($customer);
		$this->setIsDefault(true);
		$this->setQuoteName($this->__($name));
		$this->save();

		return $this;
	}
		
	/**
	 * Retrieve quote items collection
	 *
	 * @param   bool $loaded
	 * @return  Mage_Eav_Model_Entity_Collection_Abstract
	 */
	public function getItemsCollection($useCache = true) {
		if (is_null($this->_items)) {
			$this->_items = Mage::getModel('sidwishlist/quote_item')->getCollection();
			$this->_items->setSalesQuote($this->_salesQuote);
			$this->_items->setQuote($this);			
		}
		return $this->_items;
	}

	/**
	 * Retrieve quote items array
	 *
	 * @return array
	 */
	public function getAllItems() {
		$items = array();
		foreach ($this->getItemsCollection() as $item) {
			if (!$item->isDeleted()) {
				$items[] =  $item;
			}
		}
		return $items;
	}

	/**
	 * Get array of all items what can be display directly
	 *
	 * @return array
	 */
	public function getAllVisibleItems() {
		$items = array();
		foreach ($this->getItemsCollection() as $item) {
			if (!$item->isDeleted() && !$item->getParentItemId()) {
				$items[] =  $item;
			}
		}
		return $items;
	}

	/**
	 * Checking items availability
	 *
	 * @return bool
	 */
	public function hasItems() {
		return sizeof($this->getAllItems())>0;
	}

	/**
	 * Checking availability of items with decimal qty
	 *
	 * @return bool
	 */
	public function hasItemsWithDecimalQty() {
		foreach ($this->getAllItems() as $item) {
			if ($item->getProduct()->getStockItem()
					&& $item->getProduct()->getStockItem()->getIsQtyDecimal()) {
				return true;
			}
		}
		return false;
	}

	/**
	 * Checking product exist in Quote
	 *
	 * @param int $productId
	 * 
	 * @return bool
	 */
	public function hasProductId($productId) {
		foreach ($this->getAllItems() as $item) {
			if ($item->getProductId() == $productId) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Merkzettel-Item per ID laden
	 *
	 * @param int $itemId Item ID
	 * 
	 * @return Sid_Wishlist_Model_Quote_Item
	 */
	public function getItemById($itemId) {
		return $this->getItemsCollection()->getItemById($itemId);
	}
	
	/**
	 * Merkzettel-Item per Sales Quote Item ID laden
	 *
	 * @param int $itemId Item ID
	 *
	 * @return Sid_Wishlist_Model_Quote_Item|false
	 */
	public function getItemBySalesQuoteItemId($itemId) {
		foreach ($this->getAllItems() as $item) {
			if ($item->representSalesQuoteItem($itemId)) {
				return $item;
			}
		}
		return false;
	}

	/**
	 * Remove quote item by item identifier
	 *
	 * @param int $itemId Item ID
	 * 
	 * @return Sid_Wishlist_Model_Quote
	 */
	public function removeItem($itemId) {
		$item = $this->getItemById($itemId);

		if ($item) {
			//TODO : Remove auf Mage Sales Quotes übertragen
			$item->setQuote($this);
			/**
			 * If we remove item from quote - we can't use multishipping mode
			 */
			$this->setIsMultiShipping(false);
			$item->isDeleted(true);
			if ($item->getHasChildren()) {
				foreach ($item->getChildren() as $child) {
					$child->isDeleted(true);
				}
			}

			$parent = $item->getParentItem();
			if ($parent) {
				$parent->isDeleted(true);
			}
			
			Mage::dispatchEvent("{$this->_eventPrefix}_remove_item", array('quote_item' => $item));
		}

		return $this;
	}

	/**
	 * Neues Item zu Quote hinzufügen
	 *
	 * @param Sid_Wishlist_Model_Quote_Item $item Item
	 * 
	 * @return Sid_Wishlist_Model_Quote
	 */
	public function addItem(Sid_Wishlist_Model_Quote_Item $item) {
		$item->setQuote($this);
		if (!$item->getId()) {
			$this->getItemsCollection()->addItem($item);
			
			Mage::dispatchEvent("{$this->_eventPrefix}_add_item", array('quote_item' => $item));
		}
		return $this;
	}

	/**
	 * Advanced func to add product to quote - processing mode can be specified there.
	 * Returns error message if product type instance can't prepare product.
	 *
	 * @param mixed $product
	 * @param null|float|Varien_Object $request
	 * @param null|string $processMode
	 * 
	 * @return Sid_Wishlist_Model_Quote_Item|string
	 */
	public function addProductAdvanced(Mage_Catalog_Model_Product $product, $request = null, $processMode = null) {
		if ($request === null) {
			$request = 1;
		}
		if (is_numeric($request)) {
			$request = new Varien_Object(array('qty'=>$request));
		}
		if (!($request instanceof Varien_Object)) {
			Mage::throwException(Mage::helper('sidwishlist')->__('Invalid request for adding product to quote.'));
		}

		$salesQuoteItem = $this->_getSalesQuote()->addProductAdvanced($product, $request, $processMode);
		
		/*
		 * Error message
		 */
		if (is_string($salesQuoteItem)) {
			return $salesQuoteItem;
		}
		
		if ($salesQuoteParentItem = $salesQuoteItem->getParentItem()) {
			$salesQuoteItem = $salesQuoteParentItem;
			$salesQuoteItems[] = $salesQuoteItem;
			$salesQuoteItems = array_merge($salesQuoteItems, $salesQuoteParentItem->getChildren());
		} else {
			$salesQuoteItems[] = $salesQuoteItem;
		}
		$item = null;
		$items = array();
		$parentItem = null;
		foreach ($salesQuoteItems as $salesQuoteItem) {
			if ($salesQuoteItem->getId()) {
				//Hat ID wurde also schon gespeichert!
				$item = $this->getItemBySalesQuoteItemId($salesQuoteItem->getId());
				
				if ($item == false) {
					$item = $this->_addSalesQuoteItem($salesQuoteItem);				
				}
			} elseif (!$salesQuoteItem->isEmpty()) {
				$item = $this->_addSalesQuoteItem($salesQuoteItem);
			} else {
				Mage::throwException(Mage::helper('sidwishlist')->__('Case not implemented yet!'));
			}
			
			if (!$parentItem) {
				$parentItem = $item;
			}
			
			if ($parentItem && $salesQuoteItem->getParentItem()) {
				$item->setParentItem($parentItem);
			}
			$item->updateItem($salesQuoteItem);
			$items[] = $item;
			
			$this->setTotalsCollectedFlag(false);
		}
		Mage::dispatchEvent("{$this->_eventPrefix}_product_add_after", array('items' => $items));
		
		return $item;
	}


	/**
	 * Fügt ein Produkt zum Merkzettel hinzu
	 *
	 * Gibt eine Fehlermeldung zurück, falls die Produkt-Type-Instanz das Produkt nicht aufbereiten kann.
	 * 
	 * @param mixed $product Produkt
	 * @param null|float|Varien_Object $request Request
	 * 
	 * @return Sid_Wishlist_Model_Quote_Item|string
	 */
	public function addProduct(Mage_Catalog_Model_Product $product, $request = null) {
		return $this->addProductAdvanced(
				$product,
				$request,
				Mage_Catalog_Model_Product_Type_Abstract::PROCESS_MODE_FULL
		);
	}

	/**
	 * Sales Quote Item hinzufügen
	 *
	 * @param Mage_Sales_Model_Quote_Item $salesItem Sales Quote Item
	 * 
	 * @return  Sid_Wishlist_Model_Quote_Item
	 */
	protected function _addSalesQuoteItem(Mage_Sales_Model_Quote_Item $salesItem) {
		$newItem = false;
		$item = $this->getItemBySalesQuoteItemId($salesItem->getId());
		if (!$item) {
			$item = Mage::getModel('sidwishlist/quote_item');
			$item->setQuote($this);
			if (Mage::app()->getStore()->isAdmin()) {
				$item->setStoreId($this->getStore()->getId());
			} else {
				$item->setStoreId(Mage::app()->getStore()->getId());
			}
			$newItem = true;
		}

		/**
		 * We can't modify existing child items
		 */
		if ($item->getId() && $salesItem->getId()) {
			return $item;
		}

		$item->setStatusId(Sid_Wishlist_Model_Quote_Item::STATUS_EDITABLE);
		$item->setSalesQuoteItem($salesItem);

		// Add only item that is not in quote already (there can be other new or already saved item
		if ($newItem) {
			$this->addItem($item);
		}

		return $item;
	}

	/**
	 * Updates quote item with new configuration
	 *
	 * $params sets how current item configuration must be taken into account and additional options.
	 * It's passed to Mage_Catalog_Helper_Product->addParamsToBuyRequest() to compose resulting buyRequest.
	 *
	 * Basically it can hold
	 * - 'current_config', Varien_Object or array - current buyRequest that configures product in this item,
	 *   used to restore currently attached files
	 * - 'files_prefix': string[a-z0-9_] - prefix that was added at frontend to names of file options (file inputs), so they won't
	 *   intersect with other submitted options
	 *
	 * For more options see Mage_Catalog_Helper_Product->addParamsToBuyRequest()
	 *
	 * @param int $itemId
	 * @param Varien_Object $buyRequest
	 * @param null|array|Varien_Object $params
	 * 
	 * @return Sid_Wishlist_Model_Quote_Item
	 *
	 * @see Mage_Catalog_Helper_Product::addParamsToBuyRequest()
	 */
	public function updateItem($itemId, $buyRequest, $params = null) {
		$item = $this->getItemById($itemId);
		if (!$item) {
			Mage::throwException(Mage::helper('sidwishlist')->__('Wrong quote item id to update configuration.'));
		}
		$productId = $item->getProduct()->getId();

		//We need to create new clear product instance with same $productId
		//to set new option values from $buyRequest
		$product = Mage::getModel('catalog/product')
		->setStoreId($this->getStore()->getId())
		->load($productId);

		if (!$params) {
			$params = new Varien_Object();
		} else if (is_array($params)) {
			$params = new Varien_Object($params);
		}
		$params->setCurrentConfig($item->getBuyRequest());
		$buyRequest = Mage::helper('catalog/product')->addParamsToBuyRequest($buyRequest, $params);

		$buyRequest->setResetCount(true);
		$resultItem = $this->addProduct($product, $buyRequest);

		if (is_string($resultItem)) {
			Mage::throwException($resultItem);
		}

		if ($resultItem->getParentItem()) {
			$resultItem = $resultItem->getParentItem();
		}

		if ($resultItem->getId() != $itemId) {
			/*
			 * Product configuration didn't stick to original quote item
			* It either has same configuration as some other quote item's product or completely new configuration
			*/
			$this->removeItem($itemId);

			$items = $this->getAllItems();
			foreach ($items as $item) {
				if (($item->getProductId() == $productId) && ($item->getId() != $resultItem->getId())) {
					if ($resultItem->compare($item)) {
						// Product configuration is same as in other quote item
						$resultItem->setQty($resultItem->getQty() + $item->getQty());
						$this->removeItem($item->getId());
						break;
					}
				}
			}
		} else {
			$resultItem->setQty($buyRequest->getQty());
		}

		return $resultItem;
	}

	/**
	 * Retrieve quote item by product id
	 *
	 * @param   Mage_Catalog_Model_Product $product
	 * 
	 * @return  Sid_Wishlist_Model_Quote_Item || false
	 */
	public function getItemByProduct($product) {
		foreach ($this->getAllItems() as $item) {
			if ($item->representProduct($product)) {
				return $item;
			}
		}
		return false;
	}

	public function getItemsSummaryQty() {
		$qty = $this->getData('all_items_qty');
		if (is_null($qty)) {
			$qty = 0;
			foreach ($this->getAllItems() as $item) {
				if ($item->getParentItem()) {
					continue;
				}

				if (($children = $item->getChildren()) && $item->isShipSeparately()) {
					foreach ($children as $child) {
						$qty+= $child->getQty()*$item->getQty();
					}
				} else {
					$qty+= $item->getQty();
				}
			}
			$this->setData('all_items_qty', $qty);
		}
		return $qty;
	}

	public function getItemVirtualQty() {
		$qty = $this->getData('virtual_items_qty');
		if (is_null($qty)) {
			$qty = 0;
			foreach ($this->getAllItems() as $item) {
				if ($item->getParentItem()) {
					continue;
				}

				if (($children = $item->getChildren()) && $item->isShipSeparately()) {
					foreach ($children as $child) {
						if ($child->getProduct()->getIsVirtual()) {
							$qty+= $child->getQty();
						}
					}
				} else {
					if ($item->getProduct()->getIsVirtual()) {
						$qty+= $item->getQty();
					}
				}
			}
			$this->setData('virtual_items_qty', $qty);
		}
		return $qty;
	}

	/**
	 * Totals berechnen
	 *
	 * @return Sid_Wishlist_Model_Quote
	 * 
	 * @see Mage_Sales_Model_Quote::collectTotals
	 */
	public function collectTotals() {
		/*
		 * Keine doppelte Ausführung
		 */
		if ($this->getTotalsCollectedFlag()) {
			return $this;
		}
		
		Mage::dispatchEvent(
				$this->_eventPrefix . '_collect_totals_before',
				array(
						$this->_eventObject=>$this
				)
		);
		
		if (Mage::getSingleton('sidwishlist/session')->getTriggerRecollect() == true) {
			$this->_salesQuote = null;
		}

		//Doppelte Ausführung wird von Merkliste verhindert
		$this->_getSalesQuote()->setTotalsCollectedFlag(false)->collectTotals();
		$this->setItemsCount($this->_getSalesQuote()->getItemsCount());
		$this->setItemsQty($this->_getSalesQuote()->getItemsQty());
		$this->setVirtualItemsQty($this->_getSalesQuote()->getVirtualItemsQty());
		$this->setIsVirtual($this->_getSalesQuote()->getIsVirtual());
		$this->setGrandTotal($this->_getSalesQuote()->getGrandTotal());
		$this->setBaseGrandTotal($this->_getSalesQuote()->getBaseGrandTotal());
		
		$this->setData('trigger_recollect', 0);
		
		Mage::dispatchEvent(
				$this->_eventPrefix . '_collect_totals_after',
				array($this->_eventObject => $this)
		);

		Mage::getSingleton('sidwishlist/session')->setTriggerRecollect(false);
		$this->setTotalsCollectedFlag(true);
		return $this;
	}
	
	/**
	 * Entfernt den aktuellen Kunden von der ACL
	 * 
	 * @return Sid_Wishlist_Model_Quote
	 * 
	 * @see Sid_Wishlist_Model_Quote::removeCustomerFromAcls()
	 */
	public function delete() {
		$customer = Mage::getSingleton('customer/session')->getCustomerId();
		$acls = $this->getCustomerAcls();
		$isOrderer = false;
		if ($acls->getData($customer) === 'O') {
		    $isOrderer = true;
        }
		$this->removeCustomerFromAcls($customer);

		if ($isOrderer) {
            $quote = Mage::getSingleton('checkout/session')->getQuote();

            /** @var Sid_Wishlist_Model_Quote_Item $item */
            foreach ($this->getAllVisibleItems() as $item) {
                /** @var Mage_Sales_Model_Quote_Item $salesItem */
                foreach ($quote->getAllVisibleItems() as $salesItem) {
                    if ($item->getQtyGranted() > 0 && $item->representProduct($salesItem->getProduct())) {
                        $qty = max($salesItem->getQty() - $item->getQtyGranted(), 0);
                        if ($qty > 0) {
                            $salesItem->setQty($qty);
                        } else {
                            $salesItem->delete();
                        }
                    }
                }
            }
            $quote->setTriggerRecollect(true)->collectTotals();
            $quote->save();
        }

		$this->save();
		
		return $this;
	}
	
	/**
	 * Löscht den gesamten Merkzettel
	 * 
	 * @return Sid_Wishlist_Model_Quote
	 * @see Mage_Core_Model_Abstract::delete()
	 */
	protected function _delete() {		
		$this->_getResource()->beginTransaction();
        try {
            $this->_beforeDelete();
            $this->_getSalesQuote()->delete();
            $this->_getResource()->delete($this);
            $this->_afterDelete();

            $this->_getResource()->commit();
            $this->_afterDeleteCommit();
        }
        catch (Exception $e){
            $this->_getResource()->rollBack();
            throw $e;
        }
        return $this;
	}

    /**
	 * Formatiert den Preis
	 *
	 * @param   float $price       Preis
	 * @param   bool  $addBrackets Klammern?
	 * 
	 * @return  string
	 */
	public function formatPrice($price, $addBrackets = false) {
		return $this->formatPricePrecision($price, 2, $addBrackets);
	}
	
	/**
	 * Formatiert den Preis
	 * 
	 * @param float $price       Preis
	 * @param int   $precision   Präzision
	 * @param bool  $addBrackets Klammern?
	 * 
	 * @return string
	 */
	public function formatPricePrecision($price, $precision, $addBrackets = false) {
		return $this->getOrderCurrency()->formatPrecision($price, $precision, array(), true, $addBrackets);
	}
	
	/**
	 * Get currency model instance. Will be used currency with which order placed
	 *
	 * @return Mage_Directory_Model_Currency
	 */
	public function getOrderCurrency()
	{
		if (is_null($this->_orderCurrency)) {
			$this->_orderCurrency = Mage::getModel('directory/currency')->load($this->getOrderCurrencyCode());
		}
		return $this->_orderCurrency;
	}

	/**
	 * Get all quote totals (sorted by priority)
	 * Method process quote states isVirtual and isMultiShipping
	 *
	 * @return array
	 */
	public function getTotals() {
		/**
		 * If quote is virtual we are using totals of billing address because
		 * all items assigned to it
		 */
		if ($this->isVirtual()) {
			return $this->_getSalesQuote()->getBillingAddress()->getTotals();
		}

		$shippingAddress = $this->_getSalesQuote()->getShippingAddress();
		$totals = $shippingAddress->getTotals();
		// Going through all quote addresses and merge their totals
		foreach ($this->_getSalesQuote()->getAddressesCollection() as $address) {
			if ($address->isDeleted() || $address === $shippingAddress) {
				continue;
			}
			foreach ($address->getTotals() as $code => $total) {
				if (isset($totals[$code])) {
					$totals[$code]->merge($total);
				} else {
					$totals[$code] = $total;
				}
			}
		}

		$sortedTotals = array();
		foreach ($this->_getSalesQuote()->getBillingAddress()->getTotalModels() as $total) {
			/* @var $total Mage_Sales_Model_Quote_Address_Total_Abstract */
			if (isset($totals[$total->getCode()])) {
				$sortedTotals[$total->getCode()] = $totals[$total->getCode()];
			}
		}
		return $sortedTotals;
	}
	
	public function getQuoteCurrencyCode() {
		if (!$this->_salesQuote) {
			return '';
		}
		
		return $this->_getSalesQuote()->getQuoteCurrencyCode();
	}

	public function addMessage($message, $index = 'error') {
		$messages = $this->getData('messages');
		if (is_null($messages)) {
			$messages = array();
		}

		if (isset($messages[$index])) {
			return $this;
		}

		if (is_string($message)) {
			$message = Mage::getSingleton('core/message')->error($message);
		}

		$messages[$index] = $message;
		$this->setData('messages', $messages);
		return $this;
	}

	public function getMessages() {
		$messages = $this->getData('messages');
		if (is_null($messages)) {
			$messages = array();
			$this->setData('messages', $messages);
		}
		return $messages;
	}

	/**
	 * Sets flag, whether this quote has some error associated with it.
	 *
	 * @param bool $flag
	 * 
	 * @return Sid_Wishlist_Model_Quote
	 */
	protected function _setHasError($flag) {
		return $this->setData('has_error', $flag);
	}

	/**
	 * Sets flag, whether this quote has some error associated with it.
	 * When TRUE - also adds 'unknown' error information to list of quote errors.
	 * When FALSE - clears whole list of quote errors.
	 * It's recommended to use addErrorInfo() instead - to be able to remove error statuses later.
	 *
	 * @param bool $flag
	 * 
	 * @return Sid_Wishlist_Model_Quote
	 * 
	 * @see addErrorInfo()
	 */
	public function setHasError($flag) {
		if ($flag) {
			$this->addErrorInfo();
		} else {
			$this->_clearErrorInfo();
		}
		return $this;
	}

	/**
	 * Clears list of errors, associated with this quote.
	 * Also automatically removes error-flag from oneself.
	 *
	 * @return Sid_Wishlist_Model_Quote
	 */
	protected function _clearErrorInfo() {
		$this->_errorInfoGroups = array();
		$this->_setHasError(false);
		return $this;
	}

	/**
	 * Adds error information to the quote.
	 * Automatically sets error flag.
	 *
	 * @param string $type An internal error type ('error', 'qty', etc.), passed then to adding messages routine
	 * @param string|null $origin Usually a name of module, that embeds error
	 * @param int|null $code Error code, unique for origin, that sets it
	 * @param string|null $message Error message
	 * @param Varien_Object|null $additionalData Any additional data, that caller would like to store
	 * 
	 * @return Sid_Wishlist_Model_Quote
	 */
	public function addErrorInfo($type = 'error', $origin = null, $code = null, $message = null, $additionalData = null) {
		if (!isset($this->_errorInfoGroups[$type])) {
			$this->_errorInfoGroups[$type] = Mage::getModel('sales/status_list');
		}

		$this->_errorInfoGroups[$type]->addItem($origin, $code, $message, $additionalData);

		if ($message !== null) {
			$this->addMessage($message, $type);
		}
		$this->_setHasError(true);

		return $this;
	}

	/**
	 * Removes error infos, that have parameters equal to passed in $params.
	 * $params can have following keys (if not set - then any item is good for this key):
	 *   'origin', 'code', 'message'
	 *
	 * @param string $type An internal error type ('error', 'qty', etc.), passed then to adding messages routine
	 * @param array $params
	 * 
	 * @return Sid_Wishlist_Model_Quote
	 */
	public function removeErrorInfosByParams($type = 'error', $params) {
		if ($type && !isset($this->_errorInfoGroups[$type])) {
			return $this;
		}

		$errorLists = array();
		if ($type) {
			$errorLists[] = $this->_errorInfoGroups[$type];
		} else {
			$errorLists = $this->_errorInfoGroups;
		}

		foreach ($errorLists as $type => $errorList) {
			$removedItems = $errorList->removeItemsByParams($params);
			foreach ($removedItems as $item) {
				if ($item['message'] !== null) {
					$this->removeMessageByText($type, $item['message']);
				}
			}
		}

		$errorsExist = false;
		foreach ($this->_errorInfoGroups as $errorListCheck) {
			if ($errorListCheck->getItems()) {
				$errorsExist = true;
				break;
			}
		}
		if (!$errorsExist) {
			$this->_setHasError(false);
		}

		return $this;
	}

	/**
	 * Removes message by text
	 *
	 * @param string $type
	 * @param string $text
	 * 
	 * @return Sid_Wishlist_Model_Quote
	 */
	public function removeMessageByText($type = 'error', $text) {
		$messages = $this->getData('messages');
		if (is_null($messages)) {
			$messages = array();
		}

		if (!isset($messages[$type])) {
			return $this;
		}

		$message = $messages[$type];
		if ($message instanceof Mage_Core_Model_Message_Abstract) {
			$message = $message->getText();
		} else if (!is_string($message)) {
			return $this;
		}
		if ($message == $text) {
			unset($messages[$type]);
			$this->setData('messages', $messages);
		}
		return $this;
	}

	public function validateMinimumAmount($multishipping = false) {
		$storeId = $this->getStoreId();
		$minOrderActive = Mage::getStoreConfigFlag('sales/minimum_order/active', $storeId);
		$minOrderMulti  = Mage::getStoreConfigFlag('sales/minimum_order/multi_address', $storeId);
		$minAmount      = Mage::getStoreConfig('sales/minimum_order/amount', $storeId);

		if (!$minOrderActive) {
			return true;
		}

		$addresses = $this->getAllAddresses();

		if ($multishipping) {
			if ($minOrderMulti) {
				foreach ($addresses as $address) {
					foreach ($address->getQuote()->getItemsCollection() as $item) {
						$amount = $item->getBaseRowTotal() - $item->getBaseDiscountAmount();
						if ($amount < $minAmount) {
							return false;
						}
					}
				}
			} else {
				$baseTotal = 0;
				foreach ($addresses as $address) {
					/* @var $address Mage_Sales_Model_Quote_Address */
					$baseTotal += $address->getBaseSubtotalWithDiscount();
				}
				if ($baseTotal < $minAmount) {
					return false;
				}
			}
		} else {
			foreach ($addresses as $address) {
				/* @var $address Mage_Sales_Model_Quote_Address */
				if (!$address->validateMinimumAmount()) {
					return false;
				}
			}
		}
		return true;
	}

	/**
	 * Check quote for virtual product only
	 *
	 * @return bool
	 */
	public function isVirtual() {
		$isVirtual = true;
		$countItems = 0;
		foreach ($this->getItemsCollection() as $_item) {
			/* @var $_item Mage_Sales_Model_Quote_Item */
			if ($_item->isDeleted() || $_item->getParentItemId()) {
				continue;
			}
			$countItems ++;
			if (!$_item->getProduct()->getIsVirtual()) {
				$isVirtual = false;
				break;
			}
		}
		return $countItems == 0 ? false : $isVirtual;
	}

	/**
	 * Check quote for virtual product only
	 *
	 * @return bool
	 */
	public function getIsVirtual() {
		return intval($this->isVirtual());
	}
	
	/**
	 * Prüft ob es Elemente mit einer akzeptierten Menge gibt
	 * 
	 * @return bool
	 */
	public function hasQtyGranted() {
		if ($this->hasData('qty_granted')) {
			return (bool) $this->getData('qty_granted');
		}
		
		$items = $this->getAllVisibleItems();
	
		if (empty($items)) {
			$this->setData('qty_granted', false);
			return $this->getData('qty_granted');
		}
	
		foreach ($items as $item) {
			/* @var $item Sid_Wishlist_Model_Quote_Item */
			if ($item->hasQtyGranted()) {
				$this->setData('qty_granted', true);
				return $this->getData('qty_granted');;
			}
		}
	
		$this->setData('qty_granted', false);
		return $this->getData('qty_granted');
	}

    /**
     * Prüft ob es Elemente mit einer bestellten Menge gibt
     *
     * @return bool
     */
    public function hasQtyOrdered() {
        if ($this->hasData('qty_ordered')) {
            return (bool) $this->getData('qty_ordered');
        }

        $items = $this->getAllVisibleItems();

        if (empty($items)) {
            $this->setData('qty_ordered', false);
            return $this->getData('qty_ordered');
        }

        foreach ($items as $item) {
            /* @var $item Sid_Wishlist_Model_Quote_Item */
            if ($item->getQtyOrdered() > 0) {
                $this->setData('qty_ordered', true);
                return $this->getData('qty_ordered');;
            }
        }

        $this->setData('qty_ordered', false);
        return $this->getData('qty_ordered');
    }

	/**
	 * Has a virtual products on quote
	 *
	 * @return bool
	 */
	public function hasVirtualItems() {
		$hasVirtual = false;
		foreach ($this->getItemsCollection() as $_item) {
			if ($_item->getParentItemId()) {
				continue;
			}
			if ($_item->getProduct()->isVirtual()) {
				$hasVirtual = true;
			}
		}
		return $hasVirtual;
	}

	/**
	 * Merge quotes
	 *
	 * @param   Sid_Wishlist_Model_Quote $quote
	 * @return  Sid_Wishlist_Model_Quote
	 */
	public function merge(Mage_Sales_Model_Quote $quote) {
		Mage::dispatchEvent(
				$this->_eventPrefix . '_merge_before',
				array(
						$this->_eventObject=>$this,
						'source'=>$quote
				)
		);

		foreach ($quote->getAllVisibleItems() as $item) {
			$found = false;
			foreach ($this->getAllItems() as $quoteItem) {
				if ($quoteItem->compare($item)) {
					$quoteItem->setQty($quoteItem->getQty() + $item->getQty());
					$found = true;
					break;
				}
			}

			if (!$found) {
				$newItem = clone $item;
				$this->addItem($newItem);
				if ($item->getHasChildren()) {
					foreach ($item->getChildren() as $child) {
						$newChild = clone $child;
						$newChild->setParentItem($newItem);
						$this->addItem($newChild);
					}
				}
			}
		}

		/**
		 * Init shipping and billing address if quote is new
		 */
		if (!$this->getId()) {
			$this->getShippingAddress();
			$this->getBillingAddress();
		}

		if ($quote->getCouponCode()) {
			$this->setCouponCode($quote->getCouponCode());
		}

		Mage::dispatchEvent(
				$this->_eventPrefix . '_merge_after',
				array(
						$this->_eventObject=>$this,
						'source'=>$quote
				)
		);

		return $this;
	}

	/**
	 * Whether there are recurring items
	 *
	 * @return bool
	 */
	public function hasRecurringItems() {
		foreach ($this->getAllVisibleItems() as $item) {
			if ($item->getProduct() && $item->getProduct()->isRecurring()) {
				return true;
			}
		}
		return false;
	}

	/**
	 * Getter whether quote has nominal items
	 * Can bypass treating virtual items as nominal
	 *
	 * @param bool $countVirtual
	 * @return bool
	 */
	public function hasNominalItems($countVirtual = true) {
		foreach ($this->getAllVisibleItems() as $item) {
			if ($item->isNominal()) {
				if ((!$countVirtual) && $item->getProduct()->isVirtual()) {
					continue;
				}
				return true;
			}
		}
		return false;
	}

	/**
	 * Whether quote has nominal items only
	 *
	 * @return bool
	 */
	public function isNominal() {
		foreach ($this->getAllVisibleItems() as $item) {
			if (!$item->isNominal()) {
				return false;
			}
		}
		return true;
	}
	
	/**
	 * Prüft ob die übergebene ID dem Besitzer entspricht
	 * 
	 * @param int $customerId Kunden ID
	 * 
	 * @return boolean
	 */
	public function isOwner($customerId) {
		if ($this->getCustomerId() == $customerId) {
			return true;
		}
		
		return false;
	}
	
	public function hasSaleableItems() {
		$items = $this->getAllVisibleItems();
				
		foreach ($items as $item) {
			if ($item->getQtyGranted() < $item->getQty()) {
				return true;
			}
		}
		
		return false;
	}

	/**
	 * Trigger collect totals after loading, if required
	 *
	 * @return Mage_Sales_Model_Quote
	 */
	protected function _afterLoad()	{
				
		// collect totals and save me, if required
		if (1 == $this->_getSalesQuote()->getData('trigger_recollect') || Mage::getSingleton('sidwishlist/session')->getTriggerRecollect() == true) {
			$this->collectTotals()->save();
		}
		
		if (!$this->hasSharingCode()) {
			$this->setSharingCode($this->_getSharingRandomCode());
		}
		
		return parent::_afterLoad();
	}

	/**
	 * Check is allow Guest Checkout
	 *
	 * @deprecated after 1.4 beta1 it is checkout module responsibility
	 * 
	 * @return bool
	 */
	public function isAllowedGuestCheckout() {
		return false;
	}
}