<?php
 /**
  *
  * @category   	Dwd Ibewi
  * @package    	Dwd_Ibewi
  * @name       	Dwd_Ibewi_Model_Resource_Kostentraeger_Attribute
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */
class Dwd_Ibewi_Model_Mysql4_Kostentraeger_Attribute extends Mage_Core_Model_Resource_Db_Abstract
{
    public function _construct()
    {
        // Note that the id refers to the key field in your database table.
        $this->_init('ibewi/kostentraeger_attribute', 'id');
    }
    
    public function removeStandard4All(){
    	$this->_getWriteAdapter()->update($this->getMainTable(), array('standard' => 0)); 
    	return $this;
    }
    
    public function isUsedByProduct($object)
    {
    	/** @var $eav Mage_Eav_Model_Attribute */
    	
    	$eav = Mage::getModel('eav/entity_attribute')->loadByCode(Mage_Catalog_Model_Product::ENTITY, 'kostentraeger');
    	
    	$table = $eav->getBackendTable();
    	$id = $eav->getId();
    	$value = $object->getValue();
    	
    	
    	$sql = "SELECT group_concat(entity_id) FROM {$table} WHERE attribute_id = {$id} AND value = '{$value}'";
    	
    	
    	$read = $this->_getReadAdapter();
    	$result = $read->fetchOne($sql);
    	
    	return $result;
    }
    
    public function updateProducts(Varien_Object $object)
    {
    	/** @var $eav Mage_Eav_Model_Attribute */
    	 
    	$eav = Mage::getModel('eav/entity_attribute')->loadByCode(Mage_Catalog_Model_Product::ENTITY, 'kostentraeger');
    	 
    	$table = $eav->getBackendTable();
    	$id = $eav->getId();
    	$valueOld = $object->getOrigData('value');
    	$value = $object->getValue();
    	 
    	 
    	$sql = "UPDATE {$table}  set value ='{$value}' WHERE attribute_id = {$id} AND value = '{$valueOld}'";
    	 
    	 
    	$write = $this->_getWriteAdapter();
    	$result = $write->query($sql);
    	 
    	return $result;
    }
}
