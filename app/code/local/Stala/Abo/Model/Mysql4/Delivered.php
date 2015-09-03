<?php

class Stala_Abo_Model_Mysql4_Delivered extends Mage_Core_Model_Mysql4_Abstract
{
	private $_addDownloadInfo = false;
	private $_addContractInfo = false;
    public function _construct()
    {    
        // Note that the abo_delivered_id refers to the key field in your database table.
        $this->_init('stalaabo/delivered', 'abo_deliver_id');
    }
    
    public function addDownloadInfo()
    {
    	$this->_addDownloadInfo = true;
    	return $this;
    }
    
    public function addContractInfo()
    {
    	$this->_addContractInfo = true;
    	return $this;
    }

    public function load(Mage_Core_Model_Abstract $object, $value, $field=null)
    {
        if (is_null($field)) {
            $field = $this->getIdFieldName();
        }

        $read = $this->_getReadAdapter();
        if ($read && !is_null($value)) {
            $select = $this->_getLoadSelect($field, $value, $object);
            if($this->_addDownloadInfo)
            {
            	$select->join(array('download'=>'downloadable_link'),'download.product_id='.$this->getMainTable().'.product_id',array('link_type','link_url','link_file'));
            }
        	if($this->_addContractInfo)
            {
            	$select->join(array('contract'=>$this->getTable('stalaabo/contract')),$this->getMainTable().'.abo_contract_id=contract.abo_contract_id');
            }
            $data = $read->fetchRow($select);

            if ($data) {
                $object->setData($data);
            }
        }

        $this->_afterLoad($object);

        return $this;
    }

}