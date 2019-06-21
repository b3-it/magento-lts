<?php


class Egovs_Base_Model_Resource_Customer_LastOrder_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
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
        $countSelect->reset(Zend_Db_Select::COLUMNS);

        $countSelect->columns('COUNT(*)');

        $sql = $countSelect->__toString();
        return $countSelect;
    }


    protected function _initSelect() {
        $this->getSelect()->from(array('e' => $this->getTable('customer/entity')));
        $eav = Mage::getModel('eav/entity_attribute')->loadByCode('customer','email');

        $this->getSelect()
                ->where('e.entity_type_id = ? ', $eav->getEntityTypeId())
        ;

        $this->_addAttributeToSelect('lastname');
        $this->_addAttributeToSelect('company');
        $this->_addAttributeToSelect('firstname');

        $lastOrder = new Zend_Db_Expr('(select max(entity_id) as last_order_id ,count(entity_id) as order_count, max(created_at) as last_order, customer_id from '.$this->getTable('sales/order'). ' group by customer_id)');


        $select = $this->getSelect()
            ->joinleft(array("lastOrder" => $lastOrder),'lastOrder.customer_id = e.entity_id');


        $this->_select = new Varien_Db_Select($this->getConnection());
        $this->_select->from(array('t1' => $select));

        //die($this->_select->__toString());

        return $this;
    }


    protected function _addAttributeToSelect($attribute)
    {
        $eav = Mage::getResourceModel('eav/entity_attribute');
        $this->getSelect()->joinLeft(array('at_'.$attribute => $this->getTable('customer/entity').'_varchar'),
            'e.entity_id = at_'.$attribute.'.entity_id AND at_'.$attribute.'.attribute_id = '.$eav->getIdByCode('customer',$attribute)  ,
            array($attribute=>'value'));
        return $this;
    }



    public function getAllIds() {
        $idsSelect = clone $this->getSelect();
        $idsSelect->reset(Zend_Db_Select::ORDER);
        $idsSelect->reset(Zend_Db_Select::LIMIT_COUNT);
        $idsSelect->reset(Zend_Db_Select::LIMIT_OFFSET);
        $idsSelect->reset(Zend_Db_Select::COLUMNS);

        $idsSelect->columns($this->getResource()->getIdFieldName(), 't1');
        return $this->getConnection()->fetchCol($idsSelect);
    }

    protected function _getAllIdsSelect($limit = null, $offset = null)
    {
        $idsSelect = clone $this->getSelect();
        $idsSelect->reset(Zend_Db_Select::ORDER);
        $idsSelect->reset(Zend_Db_Select::LIMIT_COUNT);
        $idsSelect->reset(Zend_Db_Select::LIMIT_OFFSET);
       // $idsSelect->reset(Zend_Db_Select::COLUMNS);
       // $idsSelect->columns('e.' . $this->getEntity()->getIdFieldName());
        $idsSelect->limit($limit, $offset);

        return $idsSelect;
    }


}
