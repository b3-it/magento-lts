<?php
/**
 * Session für Merkzettelaktionen
 * 
 * @category   	Sid
 * @package    	Sid_Wishlist
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2012 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2012 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_Wishlist_Model_Session extends Mage_Core_Model_Session_Abstract
{
    /**
     * Merkzettel
     * 
     * @var Sid_Wishlist_Model_Quote
     */
    protected $_quote = null;

    /**
     * Kundeninstanz
     *
     * @var null|Mage_Customer_Model_Customer
     */
    protected $_customer = null;

    /**
     * Nur aktive Merkzettel laden?
     *
     * @var bool
     */
    protected $_loadInactive = false;

    /**
     * Konstruktor. Initialisiert Merkzettel-Session-Namespace
     * 
     * @return void
     */
    public function __construct() {
        $this->init('sidwishlist');
    }

    /**
     * Zurücksetzen aller Daten dieses Objektes
     * 
     * @return void
     */
    public function unsetAll() {
        parent::unsetAll();
        $this->_quote = null;
    }
    
    /**
     * Setzt die Params des Requests zurück
     * 
     * @return Sid_Wishlist_Model_Session
     */
    public function unsParams() {
    	$this->unsetData('params');
    	$this->unsProductToAdd();
    	
    	return $this;
    }

    /**
     * Setzt Kundeninstanz
     *
     * @param Mage_Customer_Model_Customer $customer Kunde
     * 
     * @return Sid_Wishlist_Model_Session
     */
    public function setCustomer($customer) {
        $this->_customer = $customer;
        $this->setData('customer', $this->_customer);
        
        return $this;
    }

    /**
     * Prüft ob die aktuelle Session einen Merkzettel besitzt
     *
     * @return bool
     */
    public function hasQuote() {
        return !(is_null($this->_quote));
    }

    /**
     * Sollen auch inaktive Merkzettel geladen werden
     *
     * @param bool $load Laden?
     * 
     * @return Sid_Wishlist_Model_Session
     */
    public function setLoadInactive($load = true) {
        $this->_loadInactive = $load;
        return $this;
    }

    /**
     * Merkzettel von aktuller Session holen
     *
     * @return Sid_Wishlist_Model_Quote
     */
    public function getQuote() {
        Mage::dispatchEvent('custom_quote_process', array('sidwishlist_session' => $this));

        if ($this->_quote === null) {
            $quote = Mage::getModel('sidwishlist/quote')
                ->setStoreId(Mage::app()->getStore()->getId());

            /* @var $quote Sid_Wishlist_Model_Quote */
            if ($this->getQuoteId()) {
                if ($this->_loadInactive) {
                    $quote->load($this->getQuoteId());
                } else {
                    $quote->loadActive($this->getQuoteId());
                }
                if ($quote->getId()) {
                    /**
                     * If current currency code of quote is not equal current currency code of store,
                     * need recalculate totals of quote. It is possible if customer use currency switcher or
                     * store switcher.
                     */
                    if ($quote->getQuoteCurrencyCode() != Mage::app()->getStore()->getCurrentCurrencyCode()) {
                        $quote->setStore(Mage::app()->getStore());
                        $quote->collectTotals()->save();
                        /*
                         * We mast to create new quote object, because collectTotals()
                         * can to create links with other objects.
                         */
                        $quote = Mage::getModel('sidwishlist/quote')->setStoreId(Mage::app()->getStore()->getId());
                        $quote->load($this->getQuoteId());
                    }
                } else {
                    $this->setQuoteId(null);
                }
            }

            $customerSession = Mage::getSingleton('customer/session');

            if (!$this->getQuoteId()) {
                if ($customerSession->isLoggedIn() || $this->_customer) {
                    $customer = ($this->_customer) ? $this->_customer : $customerSession->getCustomer();
                    $quote->loadByCustomer($customer);
                    $this->setQuoteId($quote->getId());
                } else {
                    $quote->setIsCheckoutCart(true);
                    Mage::dispatchEvent('sid_wishlist_quote_init', array('quote'=>$quote));
                }
            }

            if ($this->getQuoteId()) {
                if ($customerSession->isLoggedIn() || $this->_customer) {
                    $customer = ($this->_customer) ? $this->_customer : $customerSession->getCustomer();
                    if ($quote->getCustomer()->isEmpty()) {
                    	$quote->setCustomer($customer);
                    }
                }
            }

            $quote->setStore(Mage::app()->getStore());
            $this->_quote = $quote;
        }
        
        if ($remoteAddr = Mage::helper('core/http')->getRemoteAddr()) {
            $this->_quote->setRemoteIp($remoteAddr);
            $xForwardIp = Mage::app()->getRequest()->getServer('HTTP_X_FORWARDED_FOR');
            $this->_quote->setXForwardedFor($xForwardIp);
        }
                
        return $this->_quote;
    }

    /**
     * Liefert einen Key zur Identifizierung der aktuellen Quote pro Website
     * 
     * @return string
     */
    protected function _getQuoteIdKey() {
        return 'quote_id_' . Mage::app()->getStore()->getWebsiteId();
    }

    public function setQuoteId($quoteId) {
        $this->setData($this->_getQuoteIdKey(), $quoteId);
    }

    public function getQuoteId() {
        return $this->getData($this->_getQuoteIdKey());
    }
    
    public function hasQuoteId() {
    	return $this->hasData($this->_getQuoteIdKey());
    }

    /**
     * Setzt Session Step - Informationen
     * 
     * @param string       $step  Step Code
     * @param string|array $data  Daten
     * @param mixed        $value Wert
     * 
     * @return Sid_Wishlist_Model_Session
     */
    public function setStepData($step, $data, $value=null) {
        $steps = $this->getSteps();
        if (is_null($value)) {
            if (is_array($data)) {
                $steps[$step] = $data;
            }
        } else {
            if (!isset($steps[$step])) {
                $steps[$step] = array();
            }
            if (is_string($data)) {
                $steps[$step][$data] = $value;
            }
        }
        $this->setSteps($steps);

        return $this;
    }

    /**
     * Liefert Session Step Informationen
     * 
     * @param string $step Step Code
     * @param string $data Datenquelle
     * 
     * @return mixed
     */
    public function getStepData($step=null, $data=null) {
        $steps = $this->getSteps();
        if (is_null($step)) {
            return $steps;
        }
        if (!isset($steps[$step])) {
            return false;
        }
        if (is_null($data)) {
            return $steps[$step];
        }
        if (!is_string($data) || !isset($steps[$step][$data])) {
            return false;
        }
        return $steps[$step][$data];
    }
    
    /**
     * Liefert hinzuzufügendes Produkt aus Session
     * 
     * @return null|Mage_Catalog_Model_Product
     */
    public function getProductToAdd() {
    	$params = $this->getParams();
    	
    	if (!$params) {
    		return null;
    	}
    	
    	if (!is_array($params)) {
    		return null;
    	}
    	
    	if (!array_key_exists('product', $params) || !is_numeric($params['product'])) {
    		return null;
    	}
    	
    	if ($this->hasProductToAdd() && $this->getData('product_to_add')->getId() == $params['product']) {
    		return $this->getData('product_to_add');
    	}
    	
    	/* @var $product Mage_Catalog_Model_Product */
    	$this->setData('product_to_add', Mage::getModel('catalog/product')->load($params['product']));
    	switch ($this->getData('product_to_add')->getTypeId()) {
    		case Mage_Downloadable_Model_Product_Type::TYPE_DOWNLOADABLE:
    			if ($this->getData('product_to_add')->getLinksPurchasedSeparately()) {
    				$this->addNotice(Mage::helper('sidwishlist')->__('This product have separate links, all links have been selected'));
	    			//Wichtig sonst funktioniert hinzufügen zum Warenkorb nicht!
	    			/**
	    			 * @see Mage_Downloadable_Model_Product_Type::__prepareProduct
	    			 */
// 	    			$this->getData('product_to_add')->setSkipCheckRequiredOption(true);
	    			//Um weitere hinzufügen zu können
	    			$this->getData('product_to_add')->setLinksPurchasedSeparately(false);
	    			$links = $this->getData('product_to_add')->getTypeInstance(true)->getLinks($this->getData('product_to_add'));
	    			foreach ($links as $link) {
	    				$preparedLinks[] = $link->getId();
	    			}
	    			
	    			if ($preparedLinks) {
	    				$this->getData('product_to_add')->addCustomOption('downloadable_link_ids', implode(',', $preparedLinks));
	    			}
    			}
    			break;
    	}
    	return $this->getData('product_to_add');
    }

    /**
     * Retrieves list of all saved additional messages for different instances (e.g. quote items) in checkout session
     * Returned: array(itemKey => messageCollection, ...)
     * where itemKey is a unique hash (e.g 'quote_item17') to distinguish item messages among message collections
     *
     * @param bool $clear Daten nach Abruf leeren?
     *
     * @return array
     */
    public function getAdditionalMessages($clear = false) {
        $additionalMessages = $this->getData('additional_messages');
        if (!$additionalMessages) {
            return array();
        }
        if ($clear) {
            $this->setData('additional_messages', null);
        }
        return $additionalMessages;
    }

    /**
     * Retrieves list of item additional messages
     * itemKey is a unique hash (e.g 'quote_item17') to distinguish item messages among message collections
     *
     * @param string $itemKey Item Key
     * @param bool   $clear   Daten nach Abruf leeren?
     *
     * @return null|Mage_Core_Model_Message_Collection
     */
    public function getItemAdditionalMessages($itemKey, $clear = false) {
        $allMessages = $this->getAdditionalMessages();
        if (!isset($allMessages[$itemKey])) {
            return null;
        }

        $messages = $allMessages[$itemKey];
        if ($clear) {
            unset($allMessages[$itemKey]);
            $this->setAdditionalMessages($allMessages);
        }
        return $messages;
    }

    /**
     * Adds new message in this session to a list of additional messages for some item
     * itemKey is a unique hash (e.g 'quote_item17') to distinguish item messages among message collections
     *
     * @param string                  $itemKey Item Key
     * @param Mage_Core_Model_Message $message Nachricht
     *
     * @return Sid_Wishlist_Model_Session
     */
    public function addItemAdditionalMessage($itemKey, $message) {
        $allMessages = $this->getAdditionalMessages();
        if (!isset($allMessages[$itemKey])) {
            $allMessages[$itemKey] = Mage::getModel('core/message_collection');
        }
        $allMessages[$itemKey]->add($message);
        $this->setAdditionalMessages($allMessages);

        return $this;
    }

    /**
     * Retrieves list of quote item messages
     * 
     * @param int  $itemId Item ID
     * @param bool $clear  Daten nach Abruf leeren?
     *
     * @return null|Mage_Core_Model_Message_Collection
     */
    public function getQuoteItemMessages($itemId, $clear = false) {
        return $this->getItemAdditionalMessages('quote_item' . $itemId, $clear);
    }

    /**
     * Adds new message to a list of quote item messages, saved in this session
     *
     * @param int                     $itemId  Item ID
     * @param Mage_Core_Model_Message $message Nachricht
     *
     * @return Mage_Checkout_Model_Session
     */
    function addQuoteItemMessage($itemId, $message) {
        return $this->addItemAdditionalMessage('quote_item' . $itemId, $message);
    }

    public function clear() {
        Mage::dispatchEvent('sid_wishlist_quote_destroy', array('quote'=>$this->getQuote()));
        $this->_quote = null;
        $this->setQuoteId(null);
        $this->setLastSuccessQuoteId(null);
        $this->unsetAll();
    }

    /**
     * Clear misc checkout parameters
     * 
     * @return void
     */
    public function clearHelperData() {
        $this->setLastBillingAgreementId(null)
            ->setRedirectUrl(null)
            ->setLastOrderId(null)
            ->setLastRealOrderId(null)
            ->setLastRecurringProfileIds(null)
            ->setAdditionalMessages(null)
        ;
    }

    public function replaceQuote($quote) {
        $this->_quote = $quote;
        $this->setQuoteId($quote->getId());
        return $this;
    }
}
