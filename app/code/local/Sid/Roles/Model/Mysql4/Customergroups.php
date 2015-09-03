<?php

class Sid_Roles_Model_Mysql4_Customergroups extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the roles_customergroups_id refers to the key field in your database table.
        $this->_init('sidroles/customergroups', 'sid_roles_customergroups_id');
    }
    
	public function loadByCustomerGroup_User($object,$CustomerGroupId, $UserId)
    {
 
        $read = $this->_getReadAdapter();
        if ($read) {
            $select = $this->_getLoadSelectByCustomerGroup_User($CustomerGroupId, $UserId);
            $data = $read->fetchRow($select);

            if ($data) {
                $object->setData($data);
            }
        }

        $this->unserializeFields($object);
        $this->_afterLoad($object);

        return $this;
    }
    
	protected function _getLoadSelectByCustomerGroup_User($CustomerGroupId, $UserId)
    {
        //$field  = $this->_getReadAdapter()->quoteIdentifier(sprintf('%s.%s', $this->getMainTable(), $field));
        $select = $this->_getReadAdapter()->select()
            ->from($this->getMainTable())
            ->where('user_id=?', $UserId)
            ->where('customer_group_id=?', $CustomerGroupId);
        return $select;
    }
}