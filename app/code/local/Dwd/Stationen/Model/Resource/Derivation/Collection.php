<?php

class Dwd_Stationen_Model_Resource_Derivation_Collection extends Mage_Eav_Model_Entity_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('stationen/derivation');
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
}