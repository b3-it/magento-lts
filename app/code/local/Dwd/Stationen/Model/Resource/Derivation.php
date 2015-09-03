<?php

class Dwd_Stationen_Model_Resource_Derivation extends Mage_Eav_Model_Entity_Abstract
{
    public function _construct()
    {    
        // Note that the stationen_stationen_id refers to the key field in your database table.
        //$this->_init('stationen/stationen', 'stationen_stationen_id');
        $resource = Mage::getSingleton('core/resource');
        $this->setType('stationen_derivation');
        $this->setConnection(
            $resource->getConnection('stationen_read'),
            $resource->getConnection('stationen_write')
        );
    }
    
    public function updateCategoryRelation($derivation_id,$categories)
    {
     	$this->_getWriteAdapter()->delete('stationen_derivation_category_relation','derivation_id=' . $derivation_id);
     	$data=array();
     	foreach ($categories as $category)
     	{
     		$data[] = array('derivation_id'=>$derivation_id,'category_id'=>$category);
     	}
     	$this->_getWriteAdapter()->insertMultiple('stationen_derivation_category_relation', $data);
     	return $this;
    }

    public function loadCategoryRelation($obj)
    {
    	$read = $this->_getReadAdapter();
        if ($read) 
        {
	    	$select = $this->_getReadAdapter()->select()
	            ->from('stationen_derivation_category_relation')
	            ->where('derivation_id=?', $obj->getId());
	            
	     	$data = $read->fetchRow($select);
	
	            if ($data) {
	                $obj->setData('category_id',$data['category_id']);
	            }
        }
        
        return $this;
    }
    
}