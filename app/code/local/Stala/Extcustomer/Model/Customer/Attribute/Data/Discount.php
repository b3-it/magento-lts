<?php
/**
 * Catalog product price attribute backend model
 *
 * @category   	Stala
 * @package    	Stala_Extcustomer
 * @author     	Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Stala_Extcustomer_Model_Customer_Attribute_Data_Discount extends Mage_Eav_Model_Attribute_Data_Text
{
	/**
	 * Validiert die Daten
	 *
	 * Gibt true oder ein Array mit Fehlern zurück.
	 *
	 * @param array|string $value Value
	 *
	 * @return boolean|array
	 */
	public function validateValue($value)
	{
		$errors     = array();
		$attribute  = $this->getAttribute();
		$label      = Mage::helper('eav')->__($attribute->getStoreLabel());

		if ($value === false) {
			// try to load original value and validate it
			$value = $this->getEntity()->getDataUsingMethod($attribute->getAttributeCode());
		}

		if ($attribute->getIsRequired() && (!isset($value) || null == $value || (is_array($value) &&  count($value) < 1) )) {
			$errors[] = Mage::helper('eav')->__('"%s" is a required value.', $label);
		}

		if (!$errors && !$attribute->getIsRequired() && empty($value)) {
			return true;
		}

		// validate length
		$length = Mage::helper('core/string')->strlen(trim($value));

		$validateRules = $attribute->getValidateRules();
		if (!empty($validateRules['min_text_length']) && $length < $validateRules['min_text_length']) {
			$v = $validateRules['min_text_length'];
			$errors[] = Mage::helper('eav')->__('"%s" length must be equal or greater than %s characters.', $label, $v);
		}
		if (!empty($validateRules['max_text_length']) && $length > $validateRules['max_text_length']) {
			$v = $validateRules['max_text_length'];
			$errors[] = Mage::helper('eav')->__('"%s" length must be equal or less than %s characters.', $label, $v);
		}

		$result = $this->_validateInputRule($value);
		if ($result !== true) {
			$errors = array_merge($errors, $result);
		}
		if (count($errors) == 0) {
			return true;
		}

		return $errors;
	}
}
