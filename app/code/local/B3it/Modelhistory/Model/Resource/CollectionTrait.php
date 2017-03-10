<?php
trait B3it_Modelhistory_Model_Resource_CollectionTrait {

    public function addAttributeToFilter($attribute, $condition = null) {
        $conditionSql = $this->_getConditionSql($attribute, $condition);

        $this->getSelect()->where($conditionSql, null, Varien_Db_Select::TYPE_CONDITION);
        return $this;
    }
    
    /**
     * Add attribute to sort order
     *
     * @param string $attribute
     * @param string $dir
     * @return Mage_Catalog_Model_Resource_Category_Flat_Collection
     */
    public function addAttributeToSort($attribute, $dir = self::SORT_ORDER_ASC)
    {
        if (!is_string($attribute)) {
            return $this;
        }
        $this->setOrder($attribute, $dir);
        return $this;
    }
    
    /**
     * Set collection page start and records to show
     *
     * @param integer $pageNum
     * @param integer $pageSize
     * @return Mage_Catalog_Model_Resource_Category_Flat_Collection
     */
    public function setPage($pageNum, $pageSize)
    {
        $this->setCurPage($pageNum)
        ->setPageSize($pageSize);
        return $this;
    }
    
    
    /**
     * Join table to collection select
     *
     * @param string $table
     * @param string $cond
     * @param string $cols
     * @return Mage_Core_Model_Resource_Db_Collection_Abstract
     */
    public function joinLeft($table, $cond, $cols = '*')
    {
        if (is_array($table)) {
            foreach ($table as $k => $v) {
                $alias = $k;
                $table = $v;
                break;
            }
        } else {
            $alias = $table;
        }
    
        if (!isset($this->_joinedTables[$alias])) {
            $this->getSelect()->joinLeft(
                array($alias => $this->getTable($table)),
                $cond,
                $cols
                );
            $this->_joinedTables[$alias] = true;
        }
        return $this;
    }
    

    public function getSelectCountSql()
    {
        $countSelect = parent::getSelectCountSql();
        // Adding some custom features
        $countSelect->columns('rev');
        return $countSelect;
    }
}