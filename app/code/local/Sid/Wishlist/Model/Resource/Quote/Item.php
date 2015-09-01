<?php
/**
 * Quote-Item Resource Model
 * 
 * @category   	Sid
 * @package    	Sid_Wishlist
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2012 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2012 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_Wishlist_Model_Resource_Quote_Item extends Sid_Wishlist_Model_Resource_Abstract
{
    /**
     * Main table und Field Initialisierung
     * 
     * @return @void
     */
    protected function _construct() {
        $this->_init('sidwishlist/quote_item', 'item_id');
    }
    
    /**
     * Lädt das Merzettel-Item anhand der Sales Quote Item Id
     * 
     * @param Sid_Wishlist_Model_Quote_Item $item Item
     * @param int $itemId ID
     * 
     * @return Sid_Wishlist_Model_Resource_Quote_Item
     */
    public function loadBySalesQuoteItemId($item, $itemId) {
    	$adapter = $this->_getReadAdapter();
    	$select  = $this->_getLoadSelect('quote_item_id', $itemId, $item)
	    	->order('updated_at ' . Varien_Db_Select::SQL_DESC)
	    	->limit(1)
    	;
    
    	$data = $adapter->fetchRow($select);
    
    	if ($data) {
    		$item->setData($data);
    	}
    
    	$this->_afterLoad($item);
    
    	return $this;
    }
}
