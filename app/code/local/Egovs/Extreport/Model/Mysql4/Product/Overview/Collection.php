<?php

/**
 * ResourceModel Collection für Produktüberblick
 *
 * @category   	Egovs
 * @package    	Egovs_Extreport
 * @author 		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Extreport_Model_Mysql4_Product_Overview_Collection extends Mage_Catalog_Model_Resource_Eav_Mysql4_Product_Collection
{
	private $_categoryfilter = null;
	
	protected $_storeIds;
    
	/**
	 * Liefert diese Collection als Report 
	 * 
	 * Von/Bis Datum wird ignoriert
	 * 
	 * @param string $from Von Datum
	 * @param string $to   Bis Datum
	 * 
	 * @return Egovs_Extreport_Model_Mysql4_Product_Overview_Collection
	 */
    public function getReportFull($from, $to)
    {
    	return $this;
    }
    
    /**
     * Setzt den Kategorienfilter
     * 
     * @param Mage_Catalog_Block_Layer_Filter_Category $filter Filter
     * 
     * @return void
     */
    public function setCategoryFilter($filter)
    {
    	$this->_categoryfilter = $filter;
    }
    
    /**
     * Get SQL for get record count
     *
     * @return Varien_Db_Select
     */
    public function getSelectCountSql()
    {
    	if (version_compare(Mage::getVersion(), '1.4.1', '>=')) {
	    	$this->_renderFilters();
	    	
	    	$select = clone $this->getSelect();
	    	$select->reset(Zend_Db_Select::ORDER);
	    	$select->reset(Zend_Db_Select::LIMIT_COUNT);
	    	$select->reset(Zend_Db_Select::LIMIT_OFFSET);
	    	
	    	$countSelect = new Varien_Db_Select($this->getConnection());
	    	$countSelect->from(new Zend_Db_Expr(sprintf('(%s)', $select->assemble())));
	    	$countSelect->reset(Zend_Db_Select::COLUMNS);
	    	$countSelect->columns('COUNT(DISTINCT entity_id)');
	    	
	    	return $countSelect;
    	}
    	
    	return parent::getSelectCountSql();
    }
    
    /**
     * Initialisiert das Select
     * 
     * @return Egovs_Extreport_Model_Mysql4_Product_Overview_Collection
     * 
     * @see Mage_Catalog_Model_Resource_Product_Collection::_construct()
     */
    protected function _initSelect() {
    	parent::_initSelect();
    	
    	$this->addAttributeToSelect('sku')
            ->addAttributeToSelect('name')
            ->addAttributeToSelect('attribute_set_id')
            ->addAttributeToSelect('type_id')
            ->addAttributeToSelect('tax_class_id')
            ->addAttributeToSelect('weight')
            //->joinAttribute('taxclass_name', 'tax_class/class_name', 'tax_class_id=class_id', null, 'inner', null)
            ->joinTable('cataloginventory/stock_item',
            		'product_id=entity_id',
            		array('qty' => 'qty',
            			'is_in_stock'=>'is_in_stock'),
            		'{{table}}.stock_id=1',
            		'left'
            )
    	;
        
        if (Mage::app()->getRequest()->getParam('store')) {
            $storeIds = array(Mage::app()->getRequest()->getParam('store'));
            $this->addStoreFilter($storeIds[0]); //Hier sollte es immer nur eine wählbare Variante geben?
        } elseif (Mage::app()->getRequest()->getParam('website')) {
            $storeIds = Mage::app()->getWebsite(Mage::app()->getRequest()->getParam('website'))->getStoreIds();
            $this->addWebsiteFilter($storeIds);
        } elseif (Mage::app()->getRequest()->getParam('group')) {
            $storeIds = Mage::app()->getGroup(Mage::app()->getRequest()->getParam('group'))->getStoreIds();
            $this->addWebsiteFilter($storeIds);
        } else {
            $storeIds = array('');
        }
        
        $this->setStoreIds($storeIds);
        
        if (version_compare(Mage::getVersion(), '1.4.1', '>=')) {
        	//Prüfen ob group by für unterschieldiche Options geeignet ist
        	$this->getSelect()
        		->joinLeft(
        			array('categories'=>$this->getTable('catalog/category_product')),
        			'entity_id = categories.product_id',
        			array('category_ids' => new Zend_Db_Expr("GROUP_CONCAT(DISTINCT CONCAT_WS(', ', category_id))"))
        		)->group('entity_id')
        	;
        }
        
        Mage::log(sprintf('sql: %s', $this->getSelect()->assemble()), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
        
        return $this;
    }
    
    /**
     * Wird vor dem Laden aufgerufen
     * 
     * @return Egovs_Extreport_Model_Mysql4_Product_Overview_Collection
     * 
     * @see Mage_Catalog_Model_Resource_Eav_Mysql4_Product_Collection::_beforeLoad()
     */
	protected function _beforeLoad()
    {	
        if (!empty($this->_categoryfilter)) {        	
        	if (version_compare(Mage::getVersion(), '1.4.1', '>=')) {
        		$this->getSelect()->having("FIND_IN_SET('".$this->_categoryfilter."',category_ids) > 0");
        	} else {
        		$this->getSelect()->where("FIND_IN_SET('".$this->_categoryfilter."',category_ids) > 0");
        	}
        }
        
        //die($this->getSelect()->__toString());
        return parent::_beforeLoad();
    }
   
 	/**
 	 * Wird nach dem Laden aufgerufen
 	 * 
 	 * @return Egovs_Extreport_Model_Mysql4_Product_Overview_Collection
 	 * 
 	 * @see Mage_Catalog_Model_Resource_Eav_Mysql4_Product_Collection::_afterLoad()
 	 */
    protected function _afterLoad()
    {    	
    	foreach ($this->getItems() as $item) {
    		$item->setData('category', $this->_getCategoryNames($item->getData('category_ids')));
    	}
    	
    	return parent::_afterLoad();
    }
   	
    /**
     * Liefert die Kategorienamen
     * 
     * @param array $catIds Katgorie-IDs
     * 
     * @return string
     */
   	protected function _getCategoryNames($catIds) {
   		return Mage::helper('extreport')->getCategoryNames($catIds);
   	}

   	/**
   	 * Liefert alle Kategorien außer (ROOT) als Option-Array (ID=>Name) zurück
   	 * 
   	 * @return array
   	 */
   	public function getCategorysAsOptionArray()
   	{
   		return Mage::helper('extreport')->getCategorysAsOptionArray();
   	}
   	
   	/**
   	 * Setzt die Store IDs
   	 *  
   	 * @param array $storeIds Store IDs
   	 * 
   	 * @return void
   	 */
	public function setStoreIds($storeIds) {
        $this->_storeIds = $storeIds;
    }

    /**
     * Liefert die Store IDs
     * 
     * @return array
     */
    public function getStoreIds()
    {
        return $this->_storeIds;
    }
}