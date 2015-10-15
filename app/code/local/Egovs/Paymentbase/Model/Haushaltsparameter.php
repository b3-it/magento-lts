<?php
/**
 * Model für Haushaltsparameter.
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2012 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Model_Haushaltsparameter extends Mage_Core_Model_Abstract
{
	/**
	 * Konstruktor
	 * 
	 * @return void
	 * 
	 * @see Varien_Object::_construct()
	 */
    protected function _construct() {
        parent::_construct();
        $this->_init('paymentbase/haushaltsparameter');
    }
    
    /**
     * Haushaltsstellen speichern
     * 
     * @param array $hhstellen Haushaltsstellen
     * 
     * @return Egovs_Paymentbase_Model_Haushaltsparameter
     */
    public function saveHHStellen($hhstellen = array()) {
    	$this->getResource()->saveHHStellen($this->getId(), $hhstellen);
    	return $this;
    }
    
    protected function xxCR_afterSave()
    {
    	$oldValue = $this->_origData['value'];
    	$newValue = $this->getData('value');
    	if($oldValue != $newValue)
    	{
    		$attribute = Egovs_Paymentbase_Model_Haushaltsparameter_Type::getAttributeName($this->getType());
    		if($attribute)
    		{
    			/*@var $eav Mage_Eav_Model_Resource_Entity_Attribute*/
    			$eav = Mage::getResourceModel('eav/entity_attribute');
    			$attribute = $eav-> getIdByCode('catalog_product',$attribute);
    			$this->getResource()->updateProducte($attribute, $oldValue, $newValue);
    		}
    	}
    	return parent::_afterSave();
    }
    
    
}