<?php
/**
 * Kunden Freixemplare Attribute-Backend-Model
 *
 * @category   Stala
 * @package    Stala_Extcustomer
 * @author     Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Stala_Extcustomer_Model_Customer_Attribute_Backend_Freecopies extends Mage_Eav_Model_Entity_Attribute_Backend_Abstract
{
    /**
     * Wird nach dem Laden aufgerufen
     * 
     * Erzwingt int als Datentyp
     * 
     * @param Mage_Customer_Model_Customer $object Kunde
     * 
     * @return Stala_Extcustomer_Model_Customer_Attribute_Backend_Freecopies
     * 
     * @see Mage_Eav_Model_Entity_Attribute_Backend_Abstract::afterLoad()
     */
	public function afterLoad($object) {
		$value = $object->getData($this->getAttribute()->getAttributeCode());
		
		if ($note = $this->getAttribute()->getNote()) {
			$this->getAttribute()->setNote(Mage::helper('extcustomer')->__($note));
		}
		
		if ($object->isEmpty())
			return $this;
		
		//Wir erzwingen vorerst int
    	$object->setData($this->getAttribute()->getAttributeCode(), (int) $value);
				
		return $this;
    }
    
    /**
     * Wird vor dem Speichern aufgerufen
     *
     * Erzwingt int als Datentyp
     * 
     * @param Mage_Customer_Model_Customer $object Kunde
     * 
     * @return Stala_Extcustomer_Model_Customer_Attribute_Backend_Freecopies
     */
    public function beforeSave($object) {
    	$value = $object->getData($this->getAttribute()->getAttributeCode());
    	
    	//Falls Wert nicht gesetzt, Abbrechen -> sonst wird Wert vielleicht gelöscht
    	if (!isset($value)) {
    		return $this;
    	}
    	
    	//Wir erzwingen vorerst int
    	$object->setData((int) $value);
    	
    	return $this;
    }

    /**
     * Wird nach dem Speichern aufgerufen
     * 
     * @param Mage_Customer_Model_Customer $object Kunde
     * 
     * @return Stala_Extcustomer_Model_Customer_Attribute_Backend_Freecopies
     */
    public function afterSave($object)
    {
        return $this;
    }
}
