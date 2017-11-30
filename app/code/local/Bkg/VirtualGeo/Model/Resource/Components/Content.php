<?php
 /**
  *
  * @category   	Bkg Virtualgeo
  * @package    	Bkg_Virtualgeo
  * @name       	Bkg_Virtualgeo_Model_Resource_Components_Contententity
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */
class Bkg_Virtualgeo_Model_Resource_Components_Content extends Mage_Core_Model_Resource_Db_Abstract
{
    public function _construct()
    {
        // Note that the id refers to the key field in your database table.
        $this->_init('virtualgeo/components_content_entity', 'id');
    }
    
    public function getLabelTable()
    {
    	return $this->getTable('virtualgeo/components_content_label');
    }
    
    public function loadLabels($object, $parentId, $storeId)
    {
    	$table = $this->getLabelTable();
    
    	$read = $this->_getReadAdapter();
    	if ($read) {
    		$select = "SELECT * FROM {$table} WHERE parent_id={$parentId} AND store_id={$storeId}";
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
