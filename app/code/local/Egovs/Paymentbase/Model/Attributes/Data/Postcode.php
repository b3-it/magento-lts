<?php
/**
 * Validierungsklasse für Postleitzahlen
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2013 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Model_Attributes_Data_Postcode extends Mage_Customer_Model_Attribute_Data_Postcode
{
	public function validateValue($value) {
		$result = parent::validateValue($value);
		
		$countryId      = $this->getExtractedData('country_id');
		$errors = Mage::helper('paymentbase/validation')->validatePostcode($value, $countryId);
		
		if (empty($errors)) {
			return $result;
		}
		
		if ($result !== true) {
			return array_merge($result, $errors);
		}
		
		return $errors;
	}
}