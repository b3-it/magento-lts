<?php
/**
 * Dwd Icd
 * 
 * 
 * @category   	Dwd
 * @package    	Dwd_Icd
 * @name       	Dwd_Icd_Model_Mysql4_Connection
 * @author 		Holger K�gel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Icd_Model_Mysql4_Connection extends Mage_Core_Model_Mysql4_Abstract
{
	/**
	 * Konstruktor
	 * 
	 * @return void
	 * @see Mage_Core_Model_Resource_Abstract::_construct()
	 */
    public function _construct() {
        // Note that the icd_connection_id refers to the key field in your database table.
        $this->_init('dwd_icd/icd_connection', 'id');
    }
    
    /**
     * Prepare data for save
     *
     * @param Mage_Core_Model_Abstract $object Object
     *
     * @return array
     */
    protected function _prepareDataForSave(Mage_Core_Model_Abstract $object) {
    	$currentTime = Varien_Date::now();
    	if ((!$object->getId() || $object->isObjectNew()) && !$object->getCreatedTime()) {
    		$object->setCreatedTime($currentTime);
    	}
    	$object->setUpdatedTime($currentTime);
    	$data = parent::_prepareDataForSave($object);
    	return $data;
    }
}