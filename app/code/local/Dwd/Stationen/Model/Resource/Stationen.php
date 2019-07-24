<?php

/**
 * Class Dwd_Stationen_Model_Resource_Stationen
 *
 * Nutzt catalog/resource_abstract für Store-Konfiguration
 *
 * @category  Dwd
 * @package   Dwd_Stationen
 * @author    Holger Kögel <h.koegel@b3-it.de>
 * @author    Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright Copyright (c) 2013-2019 B3 IT Systeme GmbH - https://www.b3-it.de
 * @license   http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Stationen_Model_Resource_Stationen extends Mage_Catalog_Model_Resource_Abstract
{
	
	/**
	 * Store id
	 *
	 * @var int
	 */
	protected $_storeId                  = 0;
	
	
    public function _construct()
    {    
        $resource = Mage::getSingleton('core/resource');
        $this->setType('stationen_stationen');
        $this->setConnection(
            $resource->getConnection('stationen_read'),
            $resource->getConnection('stationen_write')
        );
    }
    
    public function updateSetStationRelation($stationen_id, $new, $delete)
    {
     	if(count($delete)>0)
    	{
    		$delete = implode(',', $delete);
     		$this->_getWriteAdapter()->delete('stationen_set_relation',"stationen_id='" . $stationen_id ."' AND set_id in ($delete) ");
    	}
     	$data=array();
     	if(is_array($new) && (count($new) >0 ))
     	{
	     	foreach ($new as $set)
	     	{	
	     		$data[] = array('stationen_id'=>$stationen_id,'set_id'=>$set);
	     		
	     	}
	     	$this->_getWriteAdapter()->insertMultiple('stationen_set_relation', $data);
     	}
     	return $this;
     	
     	
    } 
    
    //muss nach dem speichern aufgerufen werden
    public function removeSetStationRelation($stationen_id)
    {
    	$collection = Mage::getModel('stationen/stationen')->getCollection();
    	$collection->getSelect()
    				->where("entity_id=?", intval($stationen_id))
    				->where('status = '.Dwd_Stationen_Model_Stationen_Status::STATUS_ACTIVE);
    	//die($collection->getSelect()->__toString());
    	if(count($collection->getItems()) == 0)
    	{
    		$this->_getWriteAdapter()->delete('stationen_set_relation',"stationen_id='" . $stationen_id ."'");
    	}
    	return $this;
    }
    
    /**
     * Set store Id
     *
     * @param integer $storeId
     * @return Mage_Catalog_Model_Resource_Category
     */
    public function setStoreId($storeId)
    {
    	$this->_storeId = $storeId;
    	return $this;
    }
    
    /**
     * Return store id
     *
     * @return integer
     */
    public function getStoreId()
    {
    	if ($this->_storeId === null) {
    		return Mage::app()->getStore()->getId();
    	}
    	return $this->_storeId;
    }
    
    /**
     * Return if attribute exists in original data array.
     * Checks also attribute's store scope:
     * We should insert on duplicate key update values if we unchecked 'STORE VIEW' checkbox in store view.
     *
     * @param Mage_Eav_Model_Entity_Attribute_Abstract $attribute
     * @param mixed $value New value of the attribute.
     * @param array $origData
     * @return bool
     */
    protected function _canUpdateAttribute(
    		Mage_Eav_Model_Entity_Attribute_Abstract $attribute,
    		$value,
    		array &$origData)
    {
    	$origStoreId = 0;
    	if(isset($origData['store_id'])){
    		$origStoreId = $origData['store_id'];
    	}
    	$result = Mage_Eav_Model_Entity_Abstract::_canUpdateAttribute($attribute, $value, $origData);
    	if ($result &&
    			!$this->_isAttributeValueEmpty($attribute, $value) &&
    			$value == $origData[$attribute->getAttributeCode()] &&
    			$origStoreId != $this->getStoreId()
    	) {
    		return false;
    	}
    
    	return $result;
    }
    
    /**
     * Save entity attribute value
     *
     * Collect for mass save
     *
     * @param Mage_Core_Model_Abstract $object
     * @param Mage_Eav_Model_Entity_Attribute_Abstract $attribute
     * @param mixed $value
     * @return Mage_Eav_Model_Entity_Abstract
     */
    protected function _saveAttribute($object, $attribute, $value)
    {
    	$table = $attribute->getBackend()->getTable();
    	if (!isset($this->_attributeValuesToSave[$table])) {
    		$this->_attributeValuesToSave[$table] = array();
    	}
    
    	$entityIdField = $attribute->getBackend()->getEntityIdField();
    
    	$data   = array(
    			'entity_type_id'    => $object->getEntityTypeId(),
    			$entityIdField      => $object->getId(),
    			'attribute_id'      => $attribute->getId(),
    			'value'             => $this->_prepareValueForSave($value, $attribute),
    			'store_id'			=> $this->getStoreId(),
    	);
    
    	$this->_attributeValuesToSave[$table][] = $data;
    
    	return $this;
    }
    
    
    protected function _loadModelAttributes($object)
    {
    	if (!$object->getId()) {
    		return $this;
    	}
    
    	Varien_Profiler::start('__EAV_LOAD_MODEL_ATTRIBUTES__');
    
    	$selects = array();
    	foreach (array_keys($this->getAttributesByTable()) as $table) {
    		$attribute = current($this->_attributesByTable[$table]);
    		$eavType = $attribute->getBackendType();
    		$select = $this->_getLoadAttributesSelect($object, $table);
    		$selects[$eavType][] = $this->_addLoadAttributesSelectFields($select, $table, $eavType);
    	}
    	$selectGroups = Mage::getResourceHelper('eav')->getLoadAttributesSelectGroups($selects);
    	foreach ($selectGroups as $selects) {
    		if (!empty($selects)) {
    			$select = $this->_prepareLoadSelect($selects);
    			$values = $this->_getReadAdapter()->fetchAll($select);
    			//erstmal setzen für default
    			foreach ($values as $valueRow) {
    				if($valueRow['store_id'] == 0){
    					$this->_setAttributeValue($object, $valueRow);
    				}
    			}
    			//jetzt falls vorhanden mit store value überschreiben
    			foreach ($values as $valueRow) {
    				if($valueRow['store_id'] == $this->getStoreId()){
    					$this->_setAttributeValue($object, $valueRow);
    				}
    			}
    		}
    	}
    
    	Varien_Profiler::stop('__EAV_LOAD_MODEL_ATTRIBUTES__');
    
    	return $this;
    }
    
    /**
     * Insert or Update attribute data
     *
     * @param Mage_Catalog_Model_Abstract $object
     * @param Mage_Eav_Model_Entity_Attribute_Abstract $attribute
     * @param mixed $value
     * @return Mage_Catalog_Model_Resource_Abstract
     */
    protected function _saveAttributeValue($object, $attribute, $value)
    {
    	$write   = $this->_getWriteAdapter();
    	$storeId = (int)Mage::app()->getStore($object->getStoreId())->getId();
    	$table   = $attribute->getBackend()->getTable();
    
    	/**
    	 * If we work in single store mode all values should be saved just
    	 * for default store id
    	 * In this case we clear all not default values
    	*/
    	if (Mage::app()->isSingleStoreMode()) {
    		$storeId = $this->getDefaultStoreId();
    		$write->delete($table, array(
    				'attribute_id = ?' => $attribute->getAttributeId(),
    				'entity_id = ?'    => $object->getEntityId(),
    				'store_id <> ?'    => $storeId
    		));
    	}
    
    	$data = new Varien_Object(array(
    			'entity_type_id'    => $attribute->getEntityTypeId(),
    			'attribute_id'      => $attribute->getAttributeId(),
    			'store_id'          => $storeId,
    			'entity_id'         => $object->getEntityId(),
    			'value'             => $this->_prepareValueForSave($value, $attribute)
    	));
    	$bind = $this->_prepareDataForTable($data, $table);
    
    	
    	$bind['store_id'] = $storeId;
    	$this->_attributeValuesToSave[$table][] = $bind;
    	
    	return $this;
    }

    protected function _afterSetConfig() {
        $this->getEntityType()->setAttributeModel($this->_getDefaultAttributeModel());
        return parent::_afterSetConfig(); // TODO: Change the autogenerated stub
    }
}