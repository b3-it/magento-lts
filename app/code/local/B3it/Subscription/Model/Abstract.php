<?php

class B3it_Subscription_Model_Abstract extends Mage_Core_Model_Abstract
{
    public function saveField($field)
    {
        if ($this->getId() && !empty($field))
        {
            $table = $this->getMainTable();
            $data = array($field => $this->getData($field));
            $this->_getWriteAdapter()->update($table, $data, 'id ='. intval($this->getId()));
        }

        return $this;
    }
}