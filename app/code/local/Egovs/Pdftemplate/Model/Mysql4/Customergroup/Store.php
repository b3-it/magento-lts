<?php
/**
 * Model für PDF Templates
 *
 * @category   	Egovs
 * @package    	Egovs_Pdftemplate
 * @author 		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @author 		Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2012 - 2014 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Pdftemplate_Model_Mysql4_Customergroup_Store extends Mage_Core_Model_Mysql4_Abstract
{
	/**
	 * Konstruktor
	 * 
	 * @return void
	 * 
	 * @see Mage_Core_Model_Resource_Abstract::_construct()
	 */
    protected function _construct() {
        // Note that the pdftemplate_template_id refers to the key field in your database table.
        $this->_init('pdftemplate/customergroup_store', 'id');
    }
    
    
    /**
     * laden der Template Id in Abhängigkeit von Store und KundenGruppe
     *
     * @param Mage_Core_Model_Abstract $object
     * @param mixed $value
     * @param string $field field to load by (defaults to model id)
     * @return Mage_Core_Model_Resource_Db_Abstract
     */
    public function loadByStore(Mage_Core_Model_Abstract $object, $customergroup, $store)
    {    
    	$read = $this->_getReadAdapter();
    	if ($read) {
    		$select = $this->_getLoadTemplateSelect($customergroup, $store);
    		$data = $read->fetchRow($select);
    
    		if ($data) {
    			$object->setData($data);
    		}
    		//Fallback auf Store 0
    		else
    		{
    			$select = $this->_getLoadTemplateSelect($customergroup, 0);
    			$data = $read->fetchRow($select);
    			if ($data) {
    				$object->setData($data);
    			}
    		}
    		$object->setStoreId($store);
    		$object->setCustomerGroupId($customergroup);
    	}
    
    	$this->unserializeFields($object);
    	$this->_afterLoad($object);
    
    	return $this;
    }
    
    protected function _getLoadTemplateSelect($customergroup, $store)
    {
    	$field1  = $this->_getReadAdapter()->quoteIdentifier(sprintf('%s.customer_group_id', $this->getMainTable()));
    	$field2  = $this->_getReadAdapter()->quoteIdentifier(sprintf('%s.store_id', $this->getMainTable()));
    	$select = $this->_getReadAdapter()->select()
    	->from($this->getMainTable())
    	->where($field1 . '=?', $customergroup)
    	->where($field2 . '=?', $store)
    	;
    	return $select;
    }
    
}