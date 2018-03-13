<?php
 /**
  *
  * @category   	Bkg Orgunit
  * @package    	Bkg_Orgunit
  * @name       	Bkg_Orgunit_Model_Resource_Unit
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */
class Bkg_Orgunit_Model_Resource_Unit extends Mage_Core_Model_Resource_Db_Abstract
{
    public function _construct()
    {
        // Note that the id refers to the key field in your database table.
        $this->_init('bkg_orgunit/unit', 'id');
    }

    public function deleteCustomerAttribute($object)
    {
    	$eav = Mage::getResourceModel('eav/entity_attribute');
    	$eav_id =  $eav->getIdByCode('customer', 'org_unit');
    	
    	$this->_getWriteAdapter()->delete($this->getTable('customer/entity').'_int',"attribute_id = {$eav_id} AND value = {$object->getId()}" );
    	
    	return $this;
    }

}
