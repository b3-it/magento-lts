<?php
/**
 * Bfr EventManager
 *
 *
 * @category   	Bfr
 * @package    	Bfr_EventManager
 * @name       	Bfr_EventManager_Model_Resource_Participant
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_EventManager_Model_Resource_Participant extends Mage_Core_Model_Resource_Db_Abstract
{
    public function _construct()
    {
        // Note that the eventmanager_participant_id refers to the key field in your database table.
        $this->_init('eventmanager/participant', 'participant_id');
    }
    
    
    
    public function deleteAttribute($id, $values)
    {
    	if(count($values)>0)
    	{
    		$delete = "'".implode("','", $values)."'";
    		$this->_getWriteAdapter()->delete($this->getTable('eventmanager/participant_attribute'),'participant_id=' . $id .' AND lookup_id in ('.$delete.')' );
    	}
    	return $this;
    }
    
    public function saveAttribute($id, $values)
    {
    	
    	$data=array();
    	if(is_array($values) && (count($values) >0 ))
    	{
    		foreach ($values as $value)
    		{
    			$data[] = array('participant_id'=>$id,'lookup_id'=>$value);
    		}
    		$this->_getWriteAdapter()->insertMultiple($this->getTable('eventmanager/participant_attribute'), $data);
    	}
    	return $this;
    }
    
    public function loadAttribute($object,$field,$key)
    {
    	if($object->getId()){
    		$object->setData($field,$this->getAttributeValues($object->getId(),$key));
    	}
    	return $this;
    }
    
    
    protected function _beforeSave(Mage_Core_Model_Abstract $object)
    {
    	$fields = array('job_id','role_id');
    	foreach($fields as $field)
    	{
    		if(!$object->getData($field)){
    			$object->setData($field,null);
    		}
    	}
    	return parent::_beforeSave($object);
    }
    
    public function getAttributeValues($id,$key)
    {
    	$values = array();
     	$read = $this->_getReadAdapter();
        if ($read) {
        	$select = new Zend_Db_Select($read);
            $select->from(array('main_table' => $this->getTable('eventmanager/participant_attribute'), array('lookup_id')));
            $select->join(array('lookup'=>$this->getTable('eventmanager/lookup')), 'main_table.lookup_id = lookup.lookup_id AND lookup.typ = '.intval($key),array());
            $select->where('participant_id = '.$id );
            $data = $read->fetchAll($select);
			
            if ($data) 
            {
	           	 $values = array();
	           	 foreach($data as $d){
	           	 	$values[] = $d['lookup_id'];
	        	}
           		
            }
        }
        
        return $values;
    }
    
}
