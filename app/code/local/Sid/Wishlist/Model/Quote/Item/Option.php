<?php
/**
 * Quote Item Option - Model
 *
 * @category   	Sid
 * @package    	Sid_Wishlist
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2012 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2012 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_Wishlist_Model_Quote_Item_Option extends Mage_Core_Model_Abstract
    implements Mage_Catalog_Model_Product_Configuration_Item_Option_Interface
{
    protected $_item;
    protected $_product;

    /**
     * Initialisiert Resource Model
     * 
     * @return void
     */
    protected function _construct() {
        $this->_init('sidwishlist/quote_item_option');
    }

    /**
     * Prüft ob dieses Item Option Model Änderungen hat
     *
     * @return boolean
     */
    protected function _hasModelChanged() {
        if (!$this->hasDataChanges()) {
            return false;
        }

        return $this->_getResource()->hasDataChanged($this);
    }

    /**
     * Merkzettel - Item setzen
     *
     * @param Sid_Wishlist_Model_Quote_Item $item Item
     * 
     * @return  Sid_Wishlist_Model_Quote_Item_Option
     */
    public function setItem($item) {
        $this->setItemId($item->getId());
        $this->_item = $item;
        return $this;
    }

    /**
     * Liefert Merkzettel - Item
     *
     * @return Sid_Wishlist_Model_Quote_Item
     */
    public function getItem() {
        return $this->_item;
    }

    /**
     * Produkt für Option zuweisen
     *
     * @param Mage_Catalog_Model_Product $product Produkt
     * 
     * @return  Sid_Wishlist_Model_Quote_Item_Option
     */
    public function setProduct($product) {
        $this->setProductId($product->getId());
        $this->_product = $product;
        return $this;
    }

    /**
     * Liefert Produkt zu Option
     *
     * @return Mage_Catalog_Model_Product
     */
    public function getProduct() {
        return $this->_product;
    }

    /**
     * Liefert Wert der Option
     *
     * @return mixed
     */
    public function getValue() {
        return $this->_getData('value');
    }

    /**
     * Initialisiert Item ID vorm Speichern
     *
     * @return Sid_Wishlist_Model_Quote_Item_Option
     */
    protected function _beforeSave() {
        if ($this->getItem()) {
            $this->setItemId($this->getItem()->getId());
        }
        return parent::_beforeSave();
    }

    /**
     * Clone option
     *
     * @return Sid_Wishlist_Model_Quote_Item_Option
     */
    public function __clone() {
        $this->setId(null);
        $this->_item    = null;
        return $this;
    }
}
