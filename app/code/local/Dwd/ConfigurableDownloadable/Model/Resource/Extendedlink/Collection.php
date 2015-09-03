<?php
/**
 * Configurable Downloadable Products resource model
 *
 * @category    Dwd
 * @package     Dwd_ConfigurableDownloadable
 * @author     	Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2012 - 2013 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_ConfigurableDownloadable_Model_Resource_Extendedlink_Collection extends Mage_Downloadable_Model_Resource_Link_Collection
{
	/**
     * Initialize connection and define resource
     *
     * @return void
     */
    protected function _construct() {
        $this->_init('configdownloadable/extendedlink', 'link_id');
    }
    
    /**
     * Retrieve title for for current store
     *
     * @param integer $storeId   Store ID
     * @param integer $productId Product ID
     * 
     * @return Mage_Downloadable_Model_Resource_Link_Collection
     */
    public function addTitleByProductToResult($storeId = 0, $productId = 0) {
    	$ifNullDefaultTitle = $this->getConnection()
    		->getIfNullSql('st.title', 'd.title')
    	;
    	$ifProduct = '';
    	if ($productId > 0) {
    		$ifProduct = "AND main_table.product_id = $productId";
    	}
    	
    	$this->getSelect()
	    	->joinLeft(array('d' => $this->getTable('downloadable/link_title')),
	    			"d.link_id=main_table.link_id AND d.store_id = 0 $ifProduct",
	    			array('default_title' => 'title')
	    	)->joinLeft(array('st' => $this->getTable('downloadable/link_title')),
    				'st.link_id=main_table.link_id AND st.store_id = ' . (int)$storeId . " $ifProduct",
    				array('store_title' => 'title','title' => $ifNullDefaultTitle))
    				->order('main_table.sort_order ASC')
    				->order('title ASC')
	    ;
    
    	return $this;
    }
    
    /**
     * Retrieve price for for current website
     *
     * @param integer $websiteId Website ID
     * @param integer $productId Product ID
     * 
     * @return Mage_Downloadable_Model_Resource_Link_Collection
     */
    public function addPriceByProductToResult($websiteId, $productId) {
    	$ifNullDefaultPrice = $this->getConnection()
    		->getIfNullSql('stp.price', 'dp.price')
    	;
    	$ifProduct = '';
    	if ($productId > 0) {
    		$ifProduct = "AND main_table.product_id = $productId";
    	}
    	
    	$this->getSelect()
    		->joinLeft(array('dp' => $this->getTable('downloadable/link_price')),
    			"dp.link_id=main_table.link_id AND dp.website_id = 0 $ifProduct",
    			array('default_price' => 'price')
    		)->joinLeft(array('stp' => $this->getTable('downloadable/link_price')),
    					'stp.link_id=main_table.link_id AND stp.website_id = ' . (int)$websiteId . " $ifProduct",
    					array('website_price' => 'price','price' => $ifNullDefaultPrice)
    	);
    
    	return $this;
    }
    
    /**
     * Liefert SQL für Gesamtsumme
     * 
     * @return Zend_Db_Select
     * 
     * @see Varien_Data_Collection_Db::getSelectCountSql()
     */
    public function getSelectCountSql() {
    	$this->_renderFilters();

        $countSelect = clone $this->getSelect();
        $countSelect->reset(Zend_Db_Select::ORDER);
        $countSelect->reset(Zend_Db_Select::LIMIT_COUNT);
        $countSelect->reset(Zend_Db_Select::LIMIT_OFFSET);
        
        $havingPart = $countSelect->getPart(Zend_Db_Select::HAVING);
        if (!empty($havingPart)) {
        	$countSelectMain = new Zend_Db_Select($countSelect->getAdapter());
        	$countSelectMain->from(new Zend_Db_Expr("({$countSelect->assemble()})"), 'COUNT(*)');
        	$countSelect = $countSelectMain;
        } else {
        	$countSelect->reset(Zend_Db_Select::COLUMNS);
        	$countSelect->columns('COUNT(*)');
        }
        //echo $countSelect->assemble().'<br/>';
        return $countSelect;
    }
    
    /**
     * Retrieve all ids for collection
     *
     * @return array
     */
    public function getAllIds()
    {
    	$idsSelect = clone $this->getSelect();
    	$idsSelect->reset(Zend_Db_Select::ORDER);
    	$idsSelect->reset(Zend_Db_Select::LIMIT_COUNT);
    	$idsSelect->reset(Zend_Db_Select::LIMIT_OFFSET);
    	//$idsSelect->reset(Zend_Db_Select::COLUMNS);
    
//     	$idsSelect->columns($this->getResource()->getIdFieldName(), 'main_table');
    	return $this->getConnection()->fetchCol($idsSelect);
    }
}
