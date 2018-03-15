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
class Bkg_Orgunit_Model_Resource_Unit_Address extends Mage_Eav_Model_Entity_Abstract
{
    public function _construct()
    {
        $resource = Mage::getSingleton('core/resource');
        $this->setType('bkg_orgunit')
            ->setConnection(
            $resource->getConnection('customer_read'),
            $resource->getConnection('customer_write')
        );
    }

    /**
     * Retrieve default entity attributes
     *
     * @return array
     */
    protected function _getDefaultAttributes()
    {
        return array('entity_type_id', 'name');
    }

    /**
     * Alle als Stammadresse benutzten KundenAdressen FK auf NULL setzen
     * @param $object Bkg_Orgunit_Model_Unit_Address
     */
    public function removeCustomerAddresses($object)
    {
        if(!$object->getId()){
            return $this;
        }
        $eav = Mage::getResourceModel('eav/entity_attribute');
        $attr_id = intval($eav->getIdByCode('customer','base_address'));
        $sql = "UPDATE {$this->getTable('customer/address_entity')} as cae  ";
        $sql .= "join customer_entity_int cei ON cei.entity_id = cae.parent_id AND cei.value=cae.entity_id AND cei.attribute_id= {$attr_id} ";
        $sql .= "SET org_address_id= NULL ";
        $sql .= "where org_address_id = {$object->getId()}";

        $this->_getWriteAdapter()->query($sql);
    }

}
