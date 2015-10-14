<?php

class Dwd_Stationen_Model_Resource_Stationen_Collection extends Mage_Eav_Model_Entity_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('stationen/stationen');
    }
    protected function _initSelect()
    {        
        $this->getSelect()->from(array('e' => $this->getEntity()->getEntityTable()));

        if ($this->getEntity()->getTypeId()) {
            /**
             * We override the Mage_Eav_Model_Entity_Collection_Abstract->_initSelect() 
             * because we want to remove the call to addAttributeToFilter for 'entity_type_id' 
             * as it is causing invalid SQL select, thus making the User model load failing.
             */
            //$this->addAttributeToFilter('entity_type_id', $this->getEntity()->getTypeId());
        }
     
        return $this;
    } 

    public function getOptionAssoArray()
    {
    	$res = array();
    	foreach ($this->getItems() as $item)
    	{
    		$res[] = array('value'=>$item->getId(),'label' => $item->getStationskennung());
    	}
    	return $res;
    }
    
    public function getOptionArray()
    {
    	$res = array();
    	foreach ($this->getItems() as $item)
    	{
    		$res[$item->getId()] = $item->getStationskennung();
    	}
    	return $res;
    }
}