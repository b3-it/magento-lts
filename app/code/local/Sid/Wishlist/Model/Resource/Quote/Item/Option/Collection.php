<?php
/**
 * Item Option - Collection Model
 *
 * @category   	Sid
 * @package    	Sid_Wishlist
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2012 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2012 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_Wishlist_Model_Resource_Quote_Item_Option_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * Array von Option-IDs gruppiert nach Item ID
     *
     * @var array
     */
    protected $_optionsByItem        = array();

    /**
     * Array von Option-IDs gruppiert nach Product ID
     *
     * @var array
     */
    protected $_optionsByProduct     = array();

    /**
     * Resource Model für Collection definieren
     * 
     * @return void
     */
    protected function _construct()
    {
        $this->_init('sidwishlist/quote_item_option');
    }

    /**
     * Fill array of options by item and product
     *
     * @return Sid_Wishlist_Model_Resource_Quote_Item_Option_Collection
     */
    protected function _afterLoad()
    {
        parent::_afterLoad();

        foreach ($this as $option) {
            $optionId   = $option->getId();
            $itemId     = $option->getItemId();
            $productId  = $option->getProductId();
            if (isset($this->_optionsByItem[$itemId])) {
                $this->_optionsByItem[$itemId][] = $optionId;
            } else {
                $this->_optionsByItem[$itemId] = array($optionId);
            }
            if (isset($this->_optionsByProduct[$productId])) {
                $this->_optionsByProduct[$productId][] = $optionId;
            } else {
                $this->_optionsByProduct[$productId] = array($optionId);
            }
        }

        return $this;
    }

    /**
     * Apply quote item(s) filter to collection
     *
     * @param int|array $item Element
     * 
     * @return Sid_Wishlist_Model_Resource_Quote_Item_Option_Collection
     */
    public function addItemFilter($item)
    {
        if (empty($item)) {
            $this->_totalRecords = 0;
            $this->_setIsLoaded(true);
            //$this->addFieldToFilter('item_id', '');
        } elseif (is_array($item)) {
            $this->addFieldToFilter('item_id', array('in' => $item));
        } elseif ($item instanceof Sid_Wishlist_Model_Quote_Item) {
            $this->addFieldToFilter('item_id', $item->getId());
        } else {
            $this->addFieldToFilter('item_id', $item);
        }

        return $this;
    }

    /**
     * Get array of all product ids
     *
     * @return array
     */
    public function getProductIds()
    {
        $this->load();
        
        return array_keys($this->_optionsByProduct);
    }

    /**
     * Get all option for item
     *
     * @param mixed $item Element
     * 
     * @return array
     */
    public function getOptionsByItem($item)
    {
        if ($item instanceof Sid_Wishlist_Model_Quote_Item) {
            $itemId = $item->getId();
        } else {
            $itemId = $item;
        }

        $this->load();

        $options = array();
        if (isset($this->_optionsByItem[$itemId])) {
            foreach ($this->_optionsByItem[$itemId] as $optionId) {
                $options[] = $this->_items[$optionId];
            }
        }

        return $options;
    }

    /**
     * Get all option for item
     *
     * @param int|Mage_Catalog_Model_Product $product Produkt
     * 
     * @return array
     */
    public function getOptionsByProduct($product)
    {
        if ($product instanceof Mage_Catalog_Model_Product) {
            $productId = $product->getId();
        } else {
            $productId = $product;
        }

        $this->load();

        $options = array();
        if (isset($this->_optionsByProduct[$productId])) {
            foreach ($this->_optionsByProduct[$productId] as $optionId) {
                $options[] = $this->_items[$optionId];
            }
        }

        return $options;
    }
}
