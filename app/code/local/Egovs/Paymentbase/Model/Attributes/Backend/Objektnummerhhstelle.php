<?php
/**
 * Backend Model für Objektnummern
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2012 - 2013 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Model_Attributes_Backend_Objektnummerhhstelle
	extends Mage_Eav_Model_Entity_Attribute_Backend_Abstract
{

	/**
	 * Validierung
	 * 
	 * @param mixed $object Object
	 * 
	 * @return bool
	 * 
	 * @see Mage_Eav_Model_Entity_Attribute_Backend_Abstract::validate()
	 */
	public function validate($object) {
		$attrCode = $this->getAttribute()->getAttributeCode();
		$value = $object->getData($attrCode);
		$hhstelle = $object->getHaushaltsstelle();
		
		$type = Egovs_Paymentbase_Model_Haushaltsparameter_Type::OBJEKTNUMMER;
		if ($attrCode == 'objektnummer_mwst') {
			$type = Egovs_Paymentbase_Model_Haushaltsparameter_Type::OBJEKTNUMMER_MWST;
		}
		
		$collection = Mage::getModel('paymentbase/haushaltsparameter_objektnummerhhstelle')->getCollection();
		
		$collection->getSelect()
			->join(array('hh'=>'egovs_paymentbase_haushaltsparameter'), 'main_table.hhstelle=hh.paymentbase_haushaltsparameter_id AND hh.type='.Egovs_Paymentbase_Model_Haushaltsparameter_Type::HAUSHALTSTELLE)
			->join(array('ob'=>'egovs_paymentbase_haushaltsparameter'), 'main_table.objektnummer=ob.paymentbase_haushaltsparameter_id AND ob.type='.$type)
			->where('hh.paymentbase_haushaltsparameter_id=?', $hhstelle)
			->where('ob.paymentbase_haushaltsparameter_id=?', $value);
		//Mage::log($collection->getSelect()->__toString(), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);	
		
		if (count($collection) == 0) {
			//$label = $this->getAttribute()->getFrontend()->getLabel();
			Mage::throwException(Mage::helper('eav')->__('Wrong correlation to Haushaltsstelle.'));
		}
		return true;
	}
    
   

	
}
