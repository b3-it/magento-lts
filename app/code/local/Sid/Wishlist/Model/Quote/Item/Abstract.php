<?php
/**
 * Abstraktes Model für Merzettel - Items
 * 
 * !Achtung bei get-Funktionen:!
 * <p><strong>Nicht definierte get-Funktionen werden an das korrespondierende Sales Quote Item weitergeleitet!</strong></p>
 * 
 * @category   	Sid
 * @package    	Sid_Wishlist
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2012 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2012 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 * @method decimal setQtyGranted Setzt die freigegebene Anzahl
 */
abstract class Sid_Wishlist_Model_Quote_Item_Abstract extends Sid_Wishlist_Model_Abstract
	implements Mage_Catalog_Model_Product_Configuration_Item_Interface
{
	const STATUS_REVIEW = 4;
	const STATUS_ACCEPTED = 1;
	const STATUS_DENIED = 2;
	const STATUS_BACKORDER = 3;
	const STATUS_EDITABLE = 0;
	
	/**
	 * Parent Item
	 * 
	 * @var Sid_Wishlist_Model_Quote_Item
	 */
	protected $_parentItem  	= null;
	
	/**
	 * Children
	 * 
	 * @var array
	 */
	protected $_children    	= array();
	
	/**
	 * Sales Quote Item
	 * 
	 * @var Mage_Sales_Model_Quote_Item
	 */
	protected $_salesQuoteItem 	= null;
	
	protected $_allowedStatusForBi = array(self::STATUS_EDITABLE, self::STATUS_REVIEW);
	
	protected $_messages    	= array();
	
	/**
	 * Liefert Quoteinstanz
	 *
	 * @return Mage_Sales_Model_Quote
	 */
	public abstract function getQuote();
	
	/**
	 * Quote Model Object setzen
	 *
	 * @param Sid_Wishlist_Model_Quote $quote Merkliste
	 *
	 * @return Sid_Wishlist_Model_Quote_Item
	 */
	public abstract function setQuote(Sid_Wishlist_Model_Quote $quote);
	
	/**
	 * Assoziiertes Produkt ausgeben
	 *
	 * @return Mage_Catalog_Model_Product
	 */
	public function getProduct() {
		if (!$this->_getSalesQuoteItem()) {
			return null;
		}
		
		return $this->_getSalesQuoteItem()->getProduct();
	}
	
	/**
	 * Liefert Quote ID
	 *
	 * @return int
	 */
	public function getQuoteId() {
		return $this->getData('quote_id');
	}
	
	/**
	 * Liefert Store ID
	 *
	 * @return int
	 */
	public function getStoreId() {
		return $this->getData('store_id');
	}
	
	/**
     * Prüft ob das Item das Produkt repräsentiert
     *
     * @param Mage_Catalog_Model_Product $product Produkt
     * 
     * @return bool
     */
    public function representProduct($product) {
    	if (!$this->_getSalesQuoteItem()) {
    		return false;
    	}

        $itemProduct = $this->_getSalesQuoteItem()->getProduct();
    	if (!($product instanceof Varien_Object)) {
    	    Mage::log(
    	        sprintf(
    	            "representProduct: No product set!\nproduct:%s",
                    var_export($product, true)
                ),
                 Zend_Log::ERR
            );
    	    return false;
        }
        if (!($itemProduct instanceof Varien_Object)) {
            Mage::log(
                sprintf(
                    "representProduct: No product set!\nitemProduct:%s",
                    var_export($itemProduct, true)
                ),
                Zend_Log::ERR
            );
            return false;
        }
        if (!$product || !$itemProduct || $itemProduct->getId() != $product->getId()) {
            return false;
        }
    	
    	return $this->_getSalesQuoteItem()->representProduct($product);
    }
	
	public function __call($method, $args) {
		if (!method_exists($this, $method) && substr($method, 0, 3) == 'get' && $this->_getSalesQuoteItem()) {
			return call_user_func_array(array($this->_getSalesQuoteItem(), $method), $args);
		}
		return parent::__call($method, $args);
	}
	
	/**
	 * Liefert die angeforderte Anzahl
	 * 
	 * @return float
	 */
	public function getQty() {
		return $this->getData('qty_requested')*1;
	}
	
	/**
	 * Liefert die bestätigte Anzahl
	 *
	 * @return float
	 */
	public function getQtyGranted() {
		return $this->getData('qty_granted')*1;
	}
	
	/**
	 * Liefert die bestellte Anzahl
	 *
	 * @return float
	 */
	public function getQtyOrdered() {
		return $this->getData('qty_ordered')*1;
	}
	
	/**
	 * Prüft ob es eine genehmigte Menge gibt
	 * 
	 * @return boolean
	 */
	public function hasQtyGranted() {
		if ($this->getQtyGranted() < 0.01 && $this->getStatus() == self::STATUS_DENIED) {
			return true;
		}
		
		if ($this->getQtyGranted() > 0) {
			return true;
		}
		
		return false;
	}
		
	public function getStatusOptionArray() {
		return array(
				self::STATUS_ACCEPTED    => Mage::helper('sidwishlist')->__('Accepted'),
				self::STATUS_DENIED   => Mage::helper('sidwishlist')->__('Denied'),
				self::STATUS_BACKORDER => Mage::helper('sidwishlist')->__('Backorder'),
				self::STATUS_REVIEW  => Mage::helper('sidwishlist')->__('Review'),
				self::STATUS_EDITABLE  => Mage::helper('sidwishlist')->__('Editable'),
		);
	}
	
	/**
	 * Prüft ob der aktuelle Nutzer Berechtigter Interessent (BI) oder Besteller (BB) ist.
	 *
	 * @return bool
	 */
	public function isAuthorizedOrderer() {
		return Mage::helper('sidwishlist')->isAuthorizedOrderer();
	}
	
	public function getStatus() {
		return (int) $this->getData('status_id');
	}
	
	public function setStatus($status) {
		/*
		 * BI darf nur Status EDITABLE und REVIEW setzen, ist der Status ungleich EDITABLE oder REVIEW darf er nicht mehr manipuliert werden
		 */
		if (!$this->isAuthorizedOrderer()) {
			$currentStatus = $this->getStatus();
			if ((!empty($currentStatus) || $currentStatus === 0)
				&& $currentStatus != $status
				&& array_search($status, $this->_allowedStatusForBi) === false
			) {
				//Status wird nicht geändert
				return $this;
			}
			//Falls Status REVIEW bereits gesetzt ist, darf er nicht mehr geändert werden
			if ($currentStatus == self::STATUS_REVIEW) {
				//Status wird nicht geändert
				return $this;
			}
		}
		
		$this->setStatusId($status);
		
		switch ($status) {
			case self::STATUS_DENIED:
				//Erlaubte Menge zurücksetzen
				$this->setQtyGranted(0);
		}
		return $this;
	}
	
	public function setQtyRequested($qty) {
		$this->setData('qty_requested', $qty*1);
		
		if ($this->_getSalesQuoteItem() && $this->_getSalesQuoteItem()->getQty() != $qty) {
			$this->_getSalesQuoteItem()->setQty($qty);
		}
		
		if ($qty < 0.0001) {
			$this->delete();
		}
		return $this;
	}
	
	public function getFrameContract() {
		return $this->getData('frame_contract_title');
	}
		
	/**
	 * Liefert Item Option per Code
	 *
	 * @param string $code Code
	 * 
	 * @return  Mage_Catalog_Model_Product_Configuration_Item_Option_Interface
	 * @see Mage_Catalog_Model_Product_Configuration_Item_Option_Interface
	 */
	public function getOptionByCode($code) {
		if (!$this->_getSalesQuoteItem()) {
			return null;
		}
		
		return $this->_getSalesQuoteItem()->getOptionByCode($code);
	}
	
	/**
	 * Returns special download params (if needed) for custom option with type = 'file''
	 * Return null, if not special params needed'
	 * Or return Varien_Object with any of the following indexes:
	 *  - 'url' - url of controller to give the file
	 *  - 'urlParams' - additional parameters for url (custom option id, or item id, for example)
	 *
	 * @return null|Varien_Object
	 * @see Mage_Catalog_Model_Product_Configuration_Item_Option_Interface
	 */
	public function getFileDownloadParams() {
		if (!$this->_getSalesQuoteItem()) {
			return null;
		}
		
		return $this->_getSalesQuoteItem()->getFileDownloadParams();
	}
	
	public function getDescription() {
		$s = trim($this->getData('description'));
		if (empty($s)) {
			return Mage::helper('sidwishlist')->defaultCommentString();
		}
		
		return $s;
	}
	
	/**
	 * Parent-Item-Id vorm Speichern setzen
	 *
	 * @return  Sid_Wishlist_Model_Quote_Item_Abstract
	 */
	protected function _beforeSave() {
		parent::_beforeSave();
		if ($this->_getSalesQuoteItem()) {
			$this->_getSalesQuoteItem()->save();
			$this->setQuoteItemId($this->_getSalesQuoteItem()->getId());
		}
		
		if ($this->getParentItem()) {
			$this->setParentItemId($this->getParentItem()->getId());
		}
		
		return $this;
	}
	
	/**
	 * Lädt ein mögliches Mage Sales Quote Item
	 * 
	 * @return Sid_Wishlist_Model_Quote_Item_Abstract
	 * 
	 * @see Mage_Core_Model_Abstract::_afterLoad()
	 */
	protected function _afterLoad() {
		parent::_afterLoad();
		
		if ($this->hasQuoteItemId()) {
			$this->_getSalesQuoteItem();
		}
		
		if ($this->hasQuoteId()) {
			$quote = Mage::getModel('sidwishlist/quote')->load($this->getData('quote_id'));
			$this->setQuote($quote);
		}
		
		return $this;
	}
	
	/**
	 * Liefert Sales Quote Item
	 *
	 * @return Mage_Sales_Model_Quote_Item
	 */
	protected function _getSalesQuoteItem() {
		if (!$this->_salesQuoteItem && $this->hasQuoteItemId()) {
			$this->_salesQuoteItem = Mage::getModel('sales/quote_item')->load($this->getQuoteItemId());
			
			if ($this->_salesQuoteItem->isEmpty()) {
				$this->_salesQuoteItem = null;
			}
		}
					
		return $this->_salesQuoteItem;
	}
	
	public function getQuoteItemId() {
		return (int) $this->getData('quote_item_id');
	}
	
	/**
	 * Parent-Item setzen
	 *
	 * @param Sid_Wishlist_Model_Quote_Item $parentItem Parent
	 * 
	 * @return Sid_Wishlist_Model_Quote_Item
	 */
	public function setParentItem($parentItem) {
		if ($parentItem) {
			$this->_parentItem = $parentItem;
			$parentItem->addChild($this);
		}
		return $this;
	}
	
	/**
	 * Setzt das enstprechende Sales Quote Item für dieses Merkzettel-Item
	 * 
	 * @param Mage_Sales_Model_Quote_Item $salesItem Sales Quote Item
	 * 
	 * @return Sid_Wishlist_Model_Quote_Item
	 */
	public abstract function setSalesQuoteItem($salesItem);
	
	/**
	 * Update der Item-Werte
	 * 
	 * @param Mage_Sales_Model_Quote_Item $salesItem Sales Item
	 * 
	 * @return Sid_Wishlist_Model_Quote_Item_Abstract
	 */
	public function updateItem(Mage_Sales_Model_Quote_Item $salesItem) {
		if ($this->hasQuoteItemId() && $this->getQuoteItemId() != $salesItem->getId()) {
			Mage::throwException(Mage::helper('sidwishlist')->__("Collector list Item doesn't match sales quote item"));
		}
		
		if (!$this->hasQuoteItemId()) {
			$this->setQuoteItemId($salesItem->getId());
		}
		if (!$this->hasFrameContract) {
			$this->setFrameContract($salesItem->getProduct()->getFramecontractLos());
		}
		if (!$this->hasCustomerId()) {
			$this->setCustomerId($salesItem->getCustomerId());
		}
		if (!$this->hasIsQtyDecimal()) {
			$this->setIsQtyDecimal($salesItem->getIsQtyDecimal());
		}
		//Muss immer aktualisiert werden
		$this->setQtyRequested($salesItem->getQty());
		
		return $this;
	}
	
	/**
	 * Rahmenvertrag zuweisen
	 *
	 * @param int $frameContractId ID
	 *
	 * @return Sid_Wishlist_Model_Quote_Item_Abstract
	 */
	public function setFrameContract($frameContractLosId) {
		$frameContractLos = Mage::getModel('framecontract/los')->load($frameContractLosId);
	
		$frameContract = Mage::getModel('framecontract/contract')->load($frameContractLos->getData('framecontract_contract_id'));
		if (!$frameContract->isEmpty()) {
			$this->setFrameContractId($frameContract->getId());
			$this->setFrameContractTitle($frameContract->getTitle());
			$this->setFrameContractNumber($frameContract->getContractnumber());
		}
	
		return $this;
	}
	
	/**
	 * Liefert Parent Item
	 *
	 * @return Sid_Wishlist_Model_Quote_Item
	 */
	public function getParentItem() {
		return $this->_parentItem;
	}
	
	/**
	 * Liefert Parent Item ID
	 *
	 * @return int
	 */
	public function getParentItemId() {
		return $this->getData('parent_item_id');
	}
	
	/**
	 * Liefert Child Items
	 *
	 * @return array
	 */
	public function getChildren() {
		return $this->_children;
	}
	
	/**
	 * Child Item hinzufügen
	 *
	 * @param Sid_Wishlist_Model_Quote_Item_Abstract $child Child
	 * 
	 * @return Sid_Wishlist_Model_Quote_Item_Abstract
	 */
	public function addChild($child) {
		$this->setHasChildren(true);
		$this->_children[] = $child;
		return $this;
	}
	
	/**
	 * Addiert die übergebene Anzahl zur vorhandenen hinzu.
	 * 
	 * @param float $qty Anzahl
	 *  
	 * @return Sid_Wishlist_Model_Quote_Item_Abstract
	 */
	public function addQtyGranted($qty) {
		if (!is_numeric($qty)) {
			Mage::throwException(Mage::helper('sidwishlist')->__('Quantity must be a numeric value'));
		}
		if ($this->getQtyGranted()*1 + $this->getQtyOrdered()*1 + $qty > $this->getQty()) {
			Mage::throwException(Mage::helper('sidwishlist')->__("Qty granted can't be greater than qty requested"));
		}
		$this->setQtyGranted($this->getQtyGranted()*1 + $qty);
	
		return $this;
	}
	
	/**
	 * Adds message(s) for quote item. Duplicated messages are not added.
	 *
	 * @param mixed $messages Nachrichten
	 * 
	 * @return Mage_Sales_Model_Quote_Item_Abstract
	 */
	public function setMessage($messages)
	{
		$messagesExists = $this->getMessage(false);
		if (!is_array($messages)) {
			$messages = array($messages);
		}
		foreach ($messages as $message) {
			if (!in_array($message, $messagesExists)) {
				$this->addMessage($message);
			}
		}
		return $this;
	}
	
	/**
	 * Add message of quote item to array of messages
	 *
	 * @param string $message Nachricht
	 * 
	 * @return  Mage_Sales_Model_Quote_Item_Abstract
	 */
	public function addMessage($message)
	{
		$this->_messages[] = $message;
		return $this;
	}
	
	/**
	 * Get messages array of quote item
	 *
	 * @param bool $string flag for converting messages to string
	 * 
	 * @return array|string
	 */
	public function getMessage($string = true)
	{
	    $_salesMessages = array();
	    if ($this->_getSalesQuoteItem()) {
	        $_salesMessages = $this->_getSalesQuoteItem()->getMessage(false);
        }
        $_messages = array_merge($_salesMessages, $this->_messages);

		if ($string) {
			return join("\n", $_messages);
		}
		return $_messages;
	}
	
	/**
	 * Removes message by text
	 *
	 * @param string $text Nachricht
	 * 
	 * @return Mage_Sales_Model_Quote_Item_Abstract
	 */
	public function removeMessageByText($text)
	{
		foreach ($this->_messages as $key => $message) {
			if ($message == $text) {
				unset($this->_messages[$key]);
			}
		}
		return $this;
	}
	
	/**
	 * Clears all messages
	 *
	 * @return Mage_Sales_Model_Quote_Item_Abstract
	 */
	public function clearMessage()
	{
		$this->unsMessage(); // For older compatibility, when we kept message inside data array
		$this->_messages = array();
		return $this;
	}
	
	/**
	 * Liefert Store Model Object
	 *
	 * @return Mage_Core_Model_Store
	 */
	public function getStore() {
		return $this->getQuote()->getStore();
	}

	public function getHasError() {
	    if ($this->hasData('error')) {
	        return true;
        }

        if ($this->_getSalesQuoteItem()) {
	        return $this->_getSalesQuoteItem()->getHasError();
        }

        return false;
    }
}