<?php


class Egovs_Base_Model_Resource_Customer_LastOrder_Collection extends Mage_Customer_Model_Resource_Customer_Collection
{



    /**
     * Get SQL for get record count
     *
     * @return Varien_Db_Select
     */
    public function getSelectCountSql()
    {
        $this->_renderFilters();

        $countSelect = clone $this->getSelect();
        $countSelect->reset(Zend_Db_Select::ORDER);
        $countSelect->reset(Zend_Db_Select::LIMIT_COUNT);
        $countSelect->reset(Zend_Db_Select::LIMIT_OFFSET);
        //$countSelect->reset(Zend_Db_Select::COLUMNS);

        $countSelect->columns('COUNT(*)');

        $sql = $countSelect->__toString();
        return $countSelect;
    }


    protected function _initSelect() {
        $this->getSelect()->from(array('e' => $this->getEntity()->getEntityTable()));
        if ($this->getEntity()->getTypeId()) {
            $this->addAttributeToFilter('entity_type_id', $this->getEntity()->getTypeId());
        }

        $lastOrder = new Zend_Db_Expr('(select max(entity_id) as last_order_id ,count(entity_id) as order_count, max(created_at) as last_order, customer_id from '.$this->getTable('sales/order'). ' group by customer_id)');

        $select = $this->getSelect()
            ->joinleft(array("lastOrder" => $lastOrder),'lastOrder.customer_id = e.entity_id');


        $this->_select = new Varien_Db_Select($this->getConnection());
        $this->_select->from(array('t1' => $select));


        return $this;
    }


    protected function xx_getAttributeConditionSql($attribute, $condition, $joinType = 'inner')
    {
        if (isset($this->_joinFields[$attribute])) {

            return $this->_getConditionSql($this->_getAttributeFieldName($attribute), $condition);
        }
        if (isset($this->_staticFields[$attribute])) {
            return $this->_getConditionSql($this->getConnection()->quoteIdentifier('e.' . $attribute), $condition);
        }
        // process linked attribute
        if (isset($this->_joinAttributes[$attribute])) {
            $entity      = $this->getAttribute($attribute)->getEntity();
            $entityTable = $entity->getEntityTable();
        } else {
            $entity      = $this->getEntity();
            $entityTable = 'e';
        }

        if ($entity->isAttributeStatic($attribute)) {
            $conditionSql = $this->_getConditionSql(
                $this->getConnection()->quoteIdentifier('e1.' . $attribute),
                $condition
            );
        } else {
            $this->_addAttributeJoin($attribute, $joinType);
            if (isset($this->_joinAttributes[$attribute]['condition_alias'])) {
                $field = $this->_joinAttributes[$attribute]['condition_alias'];
            } else {
                $field = $this->_getAttributeTableAlias($attribute) . '.value';

            }

            $conditionSql = $this->_getConditionSql($field, $condition);
        }

        return $conditionSql;
    }


    protected function _getAllIdsSelect($limit = null, $offset = null)
    {
        $idsSelect = clone $this->getSelect();
        $idsSelect->reset(Zend_Db_Select::ORDER);
        $idsSelect->reset(Zend_Db_Select::LIMIT_COUNT);
        $idsSelect->reset(Zend_Db_Select::LIMIT_OFFSET);
       // $idsSelect->reset(Zend_Db_Select::COLUMNS);
        $idsSelect->columns('e.' . $this->getEntity()->getIdFieldName());
        $idsSelect->limit($limit, $offset);

        return $idsSelect;
    }

    public function xxgetSize()
    {
        if (is_null($this->_totalRecords)) {

            $this->_totalRecords = count($this->getItems());
        }
        return intval($this->_totalRecords);
    }

}
