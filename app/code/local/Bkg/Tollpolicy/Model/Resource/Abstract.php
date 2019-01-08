<?php
 /**
  * 
  *  Abstrakte Klasse zum verwalten der Store-Labels
  *  @category Bkg
  *  @package  Bkg_Tollpolicy_Model_Resource_Abstract
  *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
  *  @author Holger Kögel <​h.koegel@b3-it.de>
  *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
  *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */
abstract class  Bkg_Tollpolicy_Model_Resource_Abstract extends Mage_Core_Model_Resource_Db_Abstract
{

    
    public function getLabelTable()
    {
    	$table =  $this->getMainTable();
    	$table = str_replace('entity', 'label', $table);
    	return $table;
    }
    
    public function loadLabels($object, $entiyId, $storeId)
    {
    	$table = $this->getLabelTable();
    	    	
    	$read = $this->_getReadAdapter();
    	if ($read) {
    		$select = "SELECT * FROM {$table} WHERE entity_id={$entiyId} AND store_id={$storeId}";
    		$data = $read->fetchRow($select);
    	
    		if ($data) {
    			$object->setData($data);
    		}
    	}
    	
    	
    	
    	return $this;
    }
    
    public function saveLabel($object)
    {
    	if($object->getId())
    	{
    		$condition = "id=".intval($object->getId());
    		$this->_getWriteAdapter()->update($this->getLabelTable(), $object->getData(), $condition);
        } else {
           	$this->_getWriteAdapter()->insert($this->getLabelTable(), $this->_prepareLabelDataForSave($object));
        }
    }
    
    protected function _prepareLabelDataForSave($object)
    {
    	return $this->_prepareDataForTable($object, $this->getLabelTable());
    }
    
}
