<?php
/**
 * Model für PDF Templates
 *
 * @category   	Egovs
 * @package    	Egovs_Pdftemplate
 * @author 		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @author 		Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2012 - 2014 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Pdftemplate_Model_Mysql4_Template extends Mage_Core_Model_Mysql4_Abstract
{
	/**
	 * Konstruktor
	 * 
	 * @return void
	 * 
	 * @see Mage_Core_Model_Resource_Abstract::_construct()
	 */
    protected function _construct() {
        // Note that the pdftemplate_template_id refers to the key field in your database table.
        $this->_init('pdftemplate/template', 'pdftemplate_template_id');
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
    	if ((!$object->getId() || $object->isObjectNew()) && !$object->getCreatedAt()) {
    		$object->setCreatedAt($currentTime);
    	}
    	$object->setUpdatedAt($currentTime);
    	$data = parent::_prepareDataForSave($object);
    	return $data;
    }
}