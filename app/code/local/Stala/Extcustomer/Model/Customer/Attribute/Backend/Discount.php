<?php
/**
 * Kunden-Rabattguthaben Attribute-Backend-Model
 *
 * @category   	Stala
 * @package    	Stala_Extcustomer
 * @author     	Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Stala_Extcustomer_Model_Customer_Attribute_Backend_Discount extends Mage_Eav_Model_Entity_Attribute_Backend_Abstract
{
    protected static $_isrunning = false;

    /**
     * Wird nach dem Laden aufgerufen
     * 
     * Formatiert den Wert in einen Preis und ermittelt das gebundene Guthaben
     * 
     * @param Mage_Customer_Model_Customer $object Kunde
     * 
     * @return Stala_Extcustomer_Model_Customer_Attribute_Backend_Discount
     * 
     * @see Mage_Eav_Model_Entity_Attribute_Backend_Abstract::afterLoad()
     */
	public function afterLoad($object) {
	    if (self::$_isrunning) {
	        return $this;
        }

	    self::$_isrunning = true;
		$value = $object->getData($this->getAttribute()->getAttributeCode());
		
		/*
		 * Übersetzungen funktionieren in Magento 1.6 nicht mehr so
		 * siehe 'extcustomer/adminhtml_customer_edit_renderer_initialdiscount'
		 */
		if ($note = $this->getAttribute()->getNote()) {
			$this->getAttribute()->setNote(Mage::helper('extcustomer')->__($note));
		} elseif ($this->getAttribute()->getAttributeCode() == 'discount_quota') {
			/*
			 * siehe 'extcustomer/adminhtml_customer_edit_renderer_discount'
			 */
			
			/* @var $salesDiscount Stala_Extcustomer_Model_Salesdiscount */
			$salesDiscount = Mage::getModel('extcustomer/salesdiscount');
			$abandoned = $salesDiscount->getAbandonedDiscountQuota($object);
			$abandoned = Mage_Core_Helper_Data::currency($abandoned, true, false);
			$this->getAttribute()->setNote(Mage::helper('extcustomer')->__('Current abandoned discount quota: %s', $abandoned));			
		}
		
		if ($object->isEmpty()) {
            self::$_isrunning = false;
            return $this;
        }
		
		//Float in Preis formatieren
		$object->setData(
				$this->getAttribute()->getAttributeCode(),
				//Mage::helper('core')->formatCurrency($value, false),
				Mage_Core_Helper_Data::currency($value, true, false)
		);

        self::$_isrunning = false;
		return $this;
    }
    
    /**
     * Wird vor dem Speichern aufgerufen
     *
     * Wir müssen hier noch den initialen Wert von Discount setzen, damit wir bei Rückbuchungen dann auch den
     * Haupt/Unterkunden updaten können
     * 
     * @param Mage_Customer_Model_Customer $object Kunde
     * 
     * @return Stala_Extcustomer_Model_Customer_Attribute_Backend_Discount
     */
    public function beforeSave($object) {
    	$value = $object->getData($this->getAttribute()->getAttributeCode());
    	
    	//Preis wieder in float umwandeln
    	$value = Mage::app()->getLocale()->getNumber($value);
    	
    	//Falls Wert nicht gesetzt, Abbrechen -> sonst wird Wert immer gelöscht
    	if (!isset($value)) {
    		return $this;
    	}
    	//Auf 2 Nachkommastellen setzen
    	$value = Mage::app()->getStore()->roundPrice($value);
    	
		$object->setData($this->getAttribute()->getAttributeCode(), $value);
		
        /**
         * Orig value is only for existing objects
         */
        $origValue= $object->getOrigData($this->getAttribute()->getAttributeCode());
        
        if ($value < 0) {
        	Mage::throwException(Mage::helper('extcustomer')->__("Discount can't be less than 0!"));
        }
        
        //Darf nur im Adminbereich aktualisiert werden.
        /*if ($value >= 0 && $value != $origValue) {
        	$object->setData('discount_quota_init', $value);       	
        }*/       

        return $this;
    }

    /**
     * Wird nach dem Speichern aufgerufen
     * 
     * @param Mage_Customer_Model_Customer $object Kunde
     * 
     * @return Stala_Extcustomer_Model_Customer_Attribute_Backend_Discount
     */
    public function afterSave($object)
    {
        return $this;
    }
}
