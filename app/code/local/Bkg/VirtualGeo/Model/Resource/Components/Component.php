<?php
 /**
  *
  * @category   	Bkg
  * @package    	Bkg_VirtualGeo
  * @name       	Bkg_VirtualGeo_Model_Resource_Components_Component
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */
abstract class Bkg_VirtualGeo_Model_Resource_Components_Component extends Mage_Core_Model_Resource_Db_Abstract
{

    
    public function getLabelTable()
    {
    	return $this->getTable('virtualgeo/components_georef_label');
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
