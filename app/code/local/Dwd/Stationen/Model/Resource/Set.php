<?php

class Dwd_Stationen_Model_Resource_Set extends Mage_Eav_Model_Entity_Abstract
{
    public function _construct()
    {    
        // Note that the stationen_stationen_id refers to the key field in your database table.
        //$this->_init('stationen/stationen', 'stationen_stationen_id');
        $resource = Mage::getSingleton('core/resource');
        $this->setType('stationen_set');
        $this->setConnection(
            $resource->getConnection('stationen_read'),
            $resource->getConnection('stationen_write')
        );
    }
    
   public function updateSetStationRelation($set_id, $stationen_ids, $deleteStations)
    {
    	if(count($deleteStations)>0)
    	{
    		$deleteStations = "'".implode("','", $deleteStations)."'";
     		$this->_getWriteAdapter()->delete('stationen_set_relation','set_id=' . $set_id .' AND stationen_id in ('.$deleteStations.')' );
    	}
     	$data=array();
     	if(is_array($stationen_ids) && (count($stationen_ids) >0 ))
     	{
	     	foreach ($stationen_ids as $station)
	     	{	
	     		if($station != 'on')
	     		{
	     			$data[] = array('set_id'=>$set_id,'stationen_id'=>$station);
	     		}
	     	}
	     	$this->_getWriteAdapter()->insertMultiple('stationen_set_relation', $data);
     	}
     	return $this;
    } 
    
    
 	
}