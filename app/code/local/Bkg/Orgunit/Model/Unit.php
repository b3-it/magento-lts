<?php
/**
 *
 * @category   	Bkg Orgunit
 * @package    	Bkg_Orgunit
 * @name       	Bkg_Orgunit_Model_Unit
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_Orgunit_Model_Unit extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('bkg_orgunit/unit');
    }
    
    /**
     * über Event feststellen ob Organisation benutzt wird
     * EVENT: bkg_orgunit_is_used
     * @return boolean
     */
    public function isOrganisationUsed()
    {
    	$data = array();
    	$data['object'] = $this;
    	$data['used_by'] = new Varien_Object();
    	Mage::dispatchEvent('bkg_orgunit_is_used',$data);
    	
    	$used_by = $data['used_by']->getData();
    	
    	if(count($used_by) > 0){
    		return $used_by;
    	}
    	return false;
    }
    
    protected function _afterDelete()
    {
    	$this->getResource()->deleteCustomerAttribute($this);
    }


    protected function _beforeDelete() {
        $collection = Mage::getModel("bkg_orgunit/unit_address")->getCollection();

         foreach($collection->getItemsByColumnValue('unit_id', intval($this->getId())) as $adr) {
            $adr->delete();

        }
        return parent::_beforeDelete();
    }

}
