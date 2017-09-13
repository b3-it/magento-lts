<?php
class Sid_Wishlist_Block_View_Quote_Item_Renderer extends Mage_Core_Block_Template
{
    /** @var Mage_Checkout_Model_Session */
    protected $_checkoutSession;
    protected $_item;
    protected $_productUrl = null;
    protected $_productThumbnail = null;

    /**
     * Set item for render
     *
     * @param   Sid_Wishlist_Model_Quote_Item $item
     * @return  Mage_Checkout_Block_Cart_Item_Renderer
     */
    public function setItem(Sid_Wishlist_Model_Quote_Item_Abstract $item)
    {
        $this->_item = $item;
        return $this;
    }

    /**
     * Get quote item
     *
     * @return Sid_Wishlist_Model_Quote_Item
     */
    public function getItem()
    {
        return $this->_item;
    }

    /**
     * Get item product
     *
     * @return Mage_Catalog_Model_Product
     */
    public function getProduct()
    {
        return $this->getItem()->getProduct();
    }

    public function overrideProductThumbnail($productThumbnail)
    {
        $this->_productThumbnail = $productThumbnail;
        return $this;
    }

    /**
     * Get product thumbnail image
     *
     * @return Mage_Catalog_Model_Product_Image
     */
    public function getProductThumbnail()
    {
        if (!is_null($this->_productThumbnail)) {
            return $this->_productThumbnail;
        }
        return $this->helper('catalog/image')->init($this->getProduct(), 'thumbnail');
    }

    public function overrideProductUrl($productUrl)
    {
        $this->_productUrl = $productUrl;
        return $this;
    }

    /**
     * Check Product has URL
     *
     * @return bool
     */
    public function hasProductUrl()
    {
        if ($this->_productUrl || $this->getItem()->getRedirectUrl()) {
            return true;
        }

        $product = $this->getProduct();
        $option  = $this->getItem()->getOptionByCode('product_type');
        if ($option) {
            $product = $option->getProduct();
        }

        if ($product->isVisibleInSiteVisibility()) {
            return true;
        }
        else {
            if ($product->hasUrlDataObject()) {
                $data = $product->getUrlDataObject();
                if (in_array($data->getVisibility(), $product->getVisibleInSiteVisibilities())) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Retrieve URL to item Product
     *
     * @return string
     */
    public function getProductUrl()
    {
        if (!is_null($this->_productUrl)) {
            return $this->_productUrl;
        }
        if ($this->getItem()->getRedirectUrl()) {
            return $this->getItem()->getRedirectUrl();
        }

        $product = $this->getProduct();
        $option  = $this->getItem()->getOptionByCode('product_type');
        if ($option) {
            $product = $option->getProduct();
        }

        return $product->getUrlModel()->getUrl($product);
    }

    /**
     * Get item product name
     *
     * @return string
     */
    public function getProductName()
    {
        return $this->getProduct()->getName();
    }

    /**
     * Get product customize options
     *
     * @return array || false
     */
    public function getProductOptions()
    {
        /* @var $helper Mage_Catalog_Helper_Product_Configuration */
        $helper = Mage::helper('catalog/product_configuration');
        return $helper->getCustomOptions($this->getItem());
    }
    
    public function isEditableForRequester() {
    	if (!$this->isAuthorizedOrderer() && $this->getItem()->getStatus() != Sid_Wishlist_Model_Quote_Item::STATUS_EDITABLE) {
    		return false;
    	}
    	
    	return true;
    }
    
    public function getStatusOptionsHtml() {
    	$html = '';
    	if (!$this->getItem()->hasStatusId()) {
    		$this->getItem()->setStatus(Sid_Wishlist_Model_Quote_Item::STATUS_EDITABLE);
    	}
    	
    	$editable = $this->isEditableForRequester();
    	$authorized = $this->isAuthorizedOrderer();
    	
    	foreach ($this->getItem()->getStatusOptionArray() as $key => $value) {
    		if (!$authorized && $editable && $key != Sid_Wishlist_Model_Quote_Item::STATUS_EDITABLE && $key != Sid_Wishlist_Model_Quote_Item::STATUS_REVIEW) {
    			continue;
    		}
    		if ($this->getItem()->getStatus() == $key) {
    			$html .= sprintf('<option selected="selected" value="%s">%s</option>', $key, $value);
    		} else {
    			$html .= sprintf('<option value="%s">%s</option>', $key, $value);
    		} 
    	}
    	
    	return $html;
    }
    
    public function getStatusHtml() {

    	if (!$this->getItem()->hasStatusId()) {
    		$this->getItem()->setStatus(Sid_Wishlist_Model_Quote_Item::STATUS_EDITABLE);
    	}
    	
    	
    	$tmp = $this->getItem()->getStatusOptionArray();
    	return $tmp[$this->getItem()->getStatus()];
    }

    /**
     * Get list of all otions for product
     *
     * @return array
     */
    public function getOptionList()
    {
        return $this->getProductOptions();
    }

    /**
     * Get item configure url
     *
     * @return string
     */
    public function getConfigureUrl()
    {
        return $this->getUrl(
            'checkout/cart/configure',
            array('id' => $this->getItem()->getId())
        );
    }

    /**
     * Get item delete url
     *
     * @return string
     */
    public function getDeleteUrl()
    {
        return $this->getUrl(
            'sidwishlist/quote_item/delete',
            array(
                'id'=>$this->getItem()->getId(),
                Mage_Core_Controller_Varien_Action::PARAM_NAME_URL_ENCODED => $this->helper('core/url')->getEncodedUrl()
            )
        );
    }

    /**
     * Liefert angeforderte Anzahl der Items
     *
     * @return float
     */
    public function getQty() {
        return $this->getItem()->getQty()*1;
    }
    /**
     * Liefert die noch verfügbare bestellbare Menge
     * 
     * @return float
     */
    public function getAvailableQty() {
    	return max($this->getQty() - $this->getQtyGranted() - $this->getQtyOrdered(), 0);
    }
    
    /**
     * Liefert die genehmigte Anzahl der Items
     *
     * @return float
     */
    public function getQtyGranted() {
    	return $this->getItem()->getQtyGranted()*1;
    }
    
    /**
     * Liefert die bereits bestellte Anzahl der Items
     *
     * @return float
     */
    public function getQtyOrdered() {
    	return $this->getItem()->getQtyOrdered()*1;
    }
    
    /**
     * Prüft ob das Item bereits eine genehmigte Menge besitzt
     */
    public function hasQtyGranted() {
    	return $this->getItem()->hasQtyGranted();
    }

    /**
     * Check item is in stock
     *
     * @deprecated after 1.4.2.0-beta1
     * @return bool
     */
    public function getIsInStock()
    {
        if ($this->getItem()->getProduct()->isSaleable()) {
            if ($this->getItem()->getProduct()->getStockItem()->getQty() >= $this->getItem()->getQty()) {
                return true;
            }
        }
        return false;
    }
    
    /**
	 * Liefert URL um Item zum Einkaufswagen hinzuzufügen
	 *
	 * @param string|Mage_Catalog_Model_Product|Sid_Wishlist_Model_Quote_Item $item Item
	 * 
	 * @return  string
	 * 
	 * @see Sid_Wishlist_Helper_Data::getItemAddToCartUrl
	 */
    public function getItemAddToCartUrl($item) {
    	return Mage::helper('sidwishlist')->getAddToCartUrl($item);
    }
    
    public function isAuthorizedOrderer() {
    	return Mage::helper('sidwishlist')->isAuthorizedOrderer();
    }

    /**
     * Get checkout session
     *
     * @return Mage_Checkout_Model_Session
     */
    public function getCheckoutSession()
    {
        if (null === $this->_checkoutSession) {
            $this->_checkoutSession = Mage::getSingleton('checkout/session');
        }
        return $this->_checkoutSession;
    }

    /**
     * Retrieve item messages
     * Return array with keys
     *
     * text => the message text
     * type => type of a message
     *
     * @return array
     */
    public function getMessages()
    {
        $messages = array();
        $quoteItem = $this->getItem();

        // Add basic messages occuring during this page load
        $baseMessages = $quoteItem->getMessage(false);
        if ($baseMessages) {
            foreach ($baseMessages as $message) {
                $messages[] = array(
                    'text' => $message,
                    'type' => $quoteItem->getHasError() ? 'error' : 'notice'
                );
            }
        }

        // Add messages saved previously in checkout session
        $checkoutSession = $this->getCheckoutSession();
        if ($checkoutSession) {
            /* @var $collection Mage_Core_Model_Message_Collection */
            $collection = $checkoutSession->getQuoteItemMessages($quoteItem->getId(), true);
            if ($collection) {
                $additionalMessages = $collection->getItems();
                foreach ($additionalMessages as $message) {
                    /* @var $message Mage_Core_Model_Message_Abstract */
                    $messages[] = array(
                        'text' => $message->getCode(),
                        'type' => ($message->getType() == Mage_Core_Model_Message::ERROR) ? 'error' : 'notice'
                    );
                }
            }
        }

        return $messages;
    }

    /**
     * Accept option value and return its formatted view
     *
     * @param mixed $optionValue
     * Method works well with these $optionValue format:
     *      1. String
     *      2. Indexed array e.g. array(val1, val2, ...)
     *      3. Associative array, containing additional option info, including option value, e.g.
     *          array
     *          (
     *              [label] => ...,
     *              [value] => ...,
     *              [print_value] => ...,
     *              [option_id] => ...,
     *              [option_type] => ...,
     *              [custom_view] =>...,
     *          )
     *
     * @return array
     */
    public function getFormatedOptionValue($optionValue)
    {
        /* @var $helper Mage_Catalog_Helper_Product_Configuration */
        $helper = Mage::helper('catalog/product_configuration');
        $params = array(
            'max_length' => 55,
            'cut_replacer' => ' <a href="#" class="dots" onclick="return false">...</a>'
        );
        return $helper->getFormattedOptionValue($optionValue, $params);
    }

    /**
     * Check whether Product is visible in site
     *
     * @return bool
     */
    public function isProductVisible()
    {
        return $this->getProduct()->isVisibleInSiteVisibility();
    }

    /**
     * Return product additional information block
     *
     * @return Mage_Core_Block_Abstract
     */
    public function getProductAdditionalInformationBlock()
    {
        return $this->getLayout()->getBlock('additional.product.info');
    }

    /**
     * Get html for MAP product enabled
     *
     * @param Sid_Wishlist_Model_Quote_Item $item
     * @return string
     */
    public function getMsrpHtml($item)
    {
        return $this->getLayout()->createBlock('catalog/product_price')
            ->setTemplate('catalog/product/price_msrp_item.phtml')
            ->setProduct($item->getProduct())
            ->toHtml();
    }
}
