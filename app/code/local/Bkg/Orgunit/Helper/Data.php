<?php
 /**
  *
  * @category   	Bkg Orgunit
  * @package    	Bkg_Orgunit
  * @name       	Bkg_Orgunit_Helper_Data
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */
class Bkg_Orgunit_Helper_Data extends Mage_Core_Helper_Abstract
{

    public function getUserByOrganisation($id) {
        $allIds = array($id);
        $newIds = array($id);
        
        // need to find all customers recrusive to update their address objects if needed
        while(!empty($newIds)) {
            /**
             * @var Bkg_Orgunit_Model_Resource_Unit_Collection $unitCollection
             */
            $unitCollection = Mage::getModel('bkg_orgunit/unit')->getCollection();
            $unitCollection->addFieldToFilter('parent_id', array('in' => $newIds));
            $unitCollection->addFieldToSelect('id');
            
            $newIds = $unitCollection->getAllIds();
            $allIds = array_merge($allIds, $newIds);
        }
        
        /**
         * @var Mage_Customer_Model_Resource_Customer_Collection $collection
         */
        $collection = Mage::getModel('customer/customer')->getCollection();
        // get customer by org_unit attribute
        $collection->addAttributeToFilter('org_unit', array('in' => $allIds));
        return $collection->getItems();
    }
    
    /**
     * 
     * @param Mage_Customer_Model_Customer|int $user
     * @return array
     */
    public function getOrganisationByCustomer($customer) {
        if (is_numeric($customer)) {
            $customer = Mage::getModel('customer/customer')->load($customer);
        }
        $result = array();
        $orgId = $customer->getData('org_unit');
        while($orgId !== null) {
            $result[] = $orgId;
            /**
             * @var Bkg_Orgunit_Model_Unit $org
             */
            $org = Mage::getModel('bkg_orgunit/unit')->load($orgId);
            $orgId = $org->getData('parent_id');
        }
        return $result;
    }
}
