<?php

class Dwd_Stationen_Model_Resource_Stationen_Collection extends Mage_Catalog_Model_Resource_Collection_Abstract//Mage_Eav_Model_Entity_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('stationen/stationen');
    }
    protected function _initSelect()
    {        
        $this->getSelect()->from(array('e' => $this->getEntity()->getEntityTable()));

        if ($this->getEntity()->getTypeId()) {
            /**
             * We override the Mage_Eav_Model_Entity_Collection_Abstract->_initSelect() 
             * because we want to remove the call to addAttributeToFilter for 'entity_type_id' 
             * as it is causing invalid SQL select, thus making the User model load failing.
             */
            //$this->addAttributeToFilter('entity_type_id', $this->getEntity()->getTypeId());
        }
        
        return $this;
    } 

    public function getOptionAssoArray()
    {
    	$res = array();
    	foreach ($this->getItems() as $item)
    	{
    		$res[] = array('value'=>$item->getId(),'label' => $item->getStationskennung());
    	}
    	return $res;
    }
    
    public function getOptionArray()
    {
    	$res = array();
    	foreach ($this->getItems() as $item)
    	{
    		$res[$item->getId()] = $item->getStationskennung();
    	}
    	return $res;
    }
    
    /**
     * Add store availability filter. Include availability product
     * for store website
     *
     * @param mixed $store
     * @return Mage_Catalog_Model_Resource_Product_Collection
     */
    public function addStoreFilter($store = null)
    {
    	if ($store === null) {
    		$store = $this->getStoreId();
    	}
    	$store = Mage::app()->getStore($store);
    
    	if (!$store->isAdmin()) {
    		$this->setStoreId($store);
    		
    	}
    
    	return $this;
    }
    
    /**
     * Current scope (store Id)
     *
     * @var int
     */
    protected $_storeId;
    
    /**
     * Set store scope
     *
     * @param int|string|Mage_Core_Model_Store $store
     * @return Mage_Catalog_Model_Resource_Collection_Abstract
     */
    public function setStore($store)
    {
    	$this->setStoreId(Mage::app()->getStore($store)->getId());
    	return $this;
    }
    
    /**
     * Set store scope
     *
     * @param int|string|Mage_Core_Model_Store $storeId
     * @return Mage_Catalog_Model_Resource_Collection_Abstract
     */
    public function setStoreId($storeId)
    {
    	if ($storeId instanceof Mage_Core_Model_Store) {
    		$storeId = $storeId->getId();
    	}
    	$this->_storeId = (int)$storeId;
    	return $this;
    }
    
    /**
     * Return current store id
     *
     * @return int
     */
    public function getStoreId()
    {
    	if (is_null($this->_storeId)) {
    		$this->setStoreId(Mage::app()->getStore()->getId());
    	}
    	return $this->_storeId;
    }
    
    /**
     * Retrieve default store id
     *
     * @return int
     */
    public function getDefaultStoreId()
    {
    	return Mage_Catalog_Model_Abstract::DEFAULT_STORE_ID;
    }
    
    /**
     * Retrieve attributes load select
     *
     * @param   string $table
     * @return  Mage_Eav_Model_Entity_Collection_Abstract
     */
    protected function x_getLoadAttributesSelect($table, $attributeIds = array())
    {
    	if (empty($attributeIds)) {
    		$attributeIds = $this->_selectAttributes;
    	}
    	$helper = Mage::getResourceHelper('eav');
    	$entityIdField = $this->getEntity()->getEntityIdField();
    	$select = $this->getConnection()->select()
    	->from($table, array($entityIdField, 'attribute_id'))
    	->where('entity_type_id =?', $this->getEntity()->getTypeId())
    	->where("$entityIdField IN (?)", array_keys($this->_itemsById))
    	->where('attribute_id IN (?)', $attributeIds);
    	
    	$storeId = $this->getStoreId();
    	
    	if ($storeId) {
    		$select->where('store_id= '.intval($storeId));
    	}
    	
    	return $select;
    }
    
    protected function _joinAttributeToSelect($method, $attribute, $tableAlias, $condition, $fieldCode, $fieldAlias)
    {
    	
    	if (isset($this->_joinAttributes[$fieldCode]['store_id'])) {
    		$store_id = $this->_joinAttributes[$fieldCode]['store_id'];
    	} else {
    		$store_id = $this->getStoreId();
    	}
    
    	$adapter = $this->getConnection();
    
    	if ($store_id != $this->getDefaultStoreId()) {
    		
    		$defCondition = '('.implode(') AND (', $condition).')';
    		$defAlias     = $tableAlias . '_default';
    		$defAlias     = $this->getConnection()->getTableName($defAlias);
    		$defFieldAlias= str_replace($tableAlias, $defAlias, $fieldAlias);
    		$tableAlias   = $this->getConnection()->getTableName($tableAlias);
    
    		$defCondition = str_replace($tableAlias, $defAlias, $defCondition);
    		$defCondition.= $adapter->quoteInto(
    				" AND " . $adapter->quoteColumnAs("$defAlias.store_id", null) . " = ?",
    				$this->getDefaultStoreId());
    
    		$this->getSelect()->$method(
    				array($defAlias => $attribute->getBackend()->getTable()),
    				$defCondition,
    				array()
    		);
    
    		$method = 'joinLeft';
    		$fieldAlias = $this->getConnection()->getCheckSql("{$tableAlias}.value_id > 0",
    		$fieldAlias, $defFieldAlias);
    		$this->_joinAttributes[$fieldCode]['condition_alias'] = $fieldAlias;
    		$this->_joinAttributes[$fieldCode]['attribute']       = $attribute;
    	} else {
    		$store_id = $this->getDefaultStoreId();
    	}
    	//$store_id = $this->_storeId;
    	$condition[] = $adapter->quoteInto(
    			$adapter->quoteColumnAs("$tableAlias.store_id", null) . ' = ?', $store_id);
    	return Mage_Eav_Model_Entity_Collection_Abstract::_joinAttributeToSelect($method, $attribute, $tableAlias, $condition, $fieldCode, $fieldAlias);
    }
}