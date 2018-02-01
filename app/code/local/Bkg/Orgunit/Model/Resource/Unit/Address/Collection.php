<?php
/**
 *
 * @category   	Bkg Orgunit
 * @package    	Bkg_Orgunit
 * @name       	Bkg_Orgunit_Model_Resource_Unit_Collection
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_Orgunit_Model_Resource_Unit_Address_Collection extends Mage_Eav_Model_Entity_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('bkg_orgunit/unit_address');
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
