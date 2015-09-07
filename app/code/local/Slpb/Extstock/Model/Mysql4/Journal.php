<?php

class Slpb_Extstock_Model_Mysql4_Journal extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
       $this->_init('extstock/journal', 'journal_id');
    }
    
   public function loadWithProductInfo(Mage_Core_Model_Abstract $object, $id)
    {
    	$read = $this->_getReadAdapter();
        if ($read) {
            $select = $this->_getLoadSelect('journal_id',$id, $object);
            $select	->join(array('e'=>(string)Mage::getConfig()->getTablePrefix().'catalog_product_entity'),'extstock2_stock_journal.product_id = e.entity_id',array('sku'))
				->join(array('att'=>(string)Mage::getConfig()->getTablePrefix().'catalog_product_entity_varchar'),'att.entity_id = extstock2_stock_journal.product_id',array('productname'=>'value'))
				->join(array('ea'=>$this->getTable('eav/attribute')),'att.attribute_id=ea.attribute_id',array())
				->join(array('et'=>$this->getTable('eav/entity_type')),'ea.entity_type_id = et.entity_type_id',array())
				->where("et.entity_type_code = 'catalog_product'")
				->where("ea.attribute_code = 'name'");
	//die($select->__toString());
            $data = $read->fetchRow($select);

            if ($data) {
                $object->setData($data);
            }
        }

        $this->_afterLoad($object);

        return $this;
    }
    
    
   
}