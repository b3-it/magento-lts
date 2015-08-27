<?php

class Dwd_Stationen_Model_Resource_Stationen extends Mage_Eav_Model_Entity_Abstract
{
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
    				->where("entity_id='" . $stationen_id ."'")
    				->where('status = '.Dwd_Stationen_Model_Stationen_Status::STATUS_ACTIVE);
    	//die($collection->getSelect()->__toString());
    	if(count($collection->getItems()) == 0)
    	{
    		$this->_getWriteAdapter()->delete('stationen_set_relation',"stationen_id='" . $stationen_id ."'");
    	}
    	return $this;
    }
}