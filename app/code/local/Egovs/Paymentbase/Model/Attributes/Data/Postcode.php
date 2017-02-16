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
		
		/** @var $helper Egovs_Base_Helper_Config */
		$helper = Mage::helper('egovsbase/config');
		if (!$helper->isFieldRequired('postcode', 'register') && empty($value)) {
			return $result;
		}
		
		/** @var $address Mage_Customer_Model_Address */
		$address = $this->getEntity();
		if ($address && $address->getPostcodeChecked()) {
			return $result;
		}
		
		$countryId      = $this->getExtractedData('country_id');
		$errors = Mage::helper('paymentbase/validation')->validatePostcode($value, $countryId);
		
		if ($address) {
			$address->setPostcodeChecked(true);
		}
		
		if (empty($errors)) {
			return $result;
		}
		
		if ($result !== true) {
			return array_merge($result, $errors);
		}
		
		return $errors;
	}
}