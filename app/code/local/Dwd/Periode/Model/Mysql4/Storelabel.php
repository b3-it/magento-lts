<?php

class Dwd_Periode_Model_Mysql4_Storelabel extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the periode_periode_id refers to the key field in your database table.
        $this->_init('periode/store_label', 'periode_label_id');
    }
    
    public function loadByPeriode($object, $periodeId, $storeid  = 0){
    	
        $read = $this->_getReadAdapter();
        if ($read && !is_null($periodeId)) {
            $select = $this->_getLoadSelect('periode_id', $periodeId, $object);
            $select->where('store_id = '.intval($storeid));
            $data = $read->fetchRow($select);

            if ($data) {
                $object->setData($data);
            }
        }

        $this->unserializeFields($object);
        $this->_afterLoad($object);

        return $this;
    }
}