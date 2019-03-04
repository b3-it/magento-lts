<?php
/**
 * Base-Sales Observer-Model
 *
 * Führt für registrierte Events definierte Funktionen aus
 *
 * @category   	Egovs
 * @package    	Egovs_base
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2012 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2012 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Base_Model_Sales_Observer extends Mage_Sales_Model_Observer
{
    /**
     * Clean expired quotes (cron process)
     *
     * @param Mage_Cron_Model_Schedule $schedule
     * @return Mage_Sales_Model_Observer
     */
    public function cleanExpiredQuotes($schedule)
    {
        Mage::dispatchEvent('clear_expired_quotes_before', array('sales_observer' => $this));

        $lifetimes = Mage::getConfig()->getStoresConfigByPath('checkout/cart/delete_quote_after');
        foreach ($lifetimes as $storeId=>$lifetime) {
            /** @noinspection SummerTimeUnsafeTimeManipulationInspection */
            $lifetime *= 86400;

            /* @var $quotes Mage_Sales_Model_Mysql4_Quote_Collection */
            $quotes = Mage::getModel('sales/quote')->getCollection();

            $quotes->addFieldToFilter('store_id', $storeId);
            $quotes->addFieldToFilter('updated_at', array('to'=>date("Y-m-d H:i:s", time()-$lifetime)));
//             $quotes->addFieldToFilter('is_active', 0);
            $quotes->addFieldToFilter('reserved_order_id', array('null'=>true));

            foreach ($this->getExpireQuotesAdditionalFilterFields() as $field => $condition) {
                $quotes->addFieldToFilter($field, $condition);
            }
            
            $sidWishlistNode = Mage::getConfig()->getModuleConfig('Sid_Wishlist');
            if ($sidWishlistNode->is('active')) {
	            $sidWishlistModel = Mage::getModel('sidwishlist/quote');
	            if ($sidWishlistModel) {
	            	/* @var $wishlistCollection Sid_Wishlist_Model_Resource_Quote_Collection */
	            	$wishlistCollection = $sidWishlistModel->getCollection();
	            	$idsSelect = clone $wishlistCollection->getSelect();
			        $idsSelect->reset(Zend_Db_Select::ORDER);
			        $idsSelect->reset(Zend_Db_Select::LIMIT_COUNT);
			        $idsSelect->reset(Zend_Db_Select::LIMIT_OFFSET);
			        $idsSelect->reset(Zend_Db_Select::COLUMNS);
			
			        $idsSelect->columns('quote_entity_id', 'main_table');
			        $reservedIds = $wishlistCollection->getConnection()->fetchCol($idsSelect);
			        $quotes->addFieldToFilter('entity_id', array('nin' => $reservedIds));
	            }
            }
            Mage::log("egovsbase::Clean expired quotes for store $storeId", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
            Mage::log(sprintf("egovsbase::SQL: %s", $quotes->getSelect()->assemble()), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
            $quotes->walk('delete');
        }
        return $this;
    }
}

