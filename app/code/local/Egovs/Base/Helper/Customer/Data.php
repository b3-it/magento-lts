<?php
class Egovs_Base_Helper_Customer_Data extends Mage_Customer_Helper_Data
{
	/**
	 * Send request to VAT validation service and return validation result
	 *
	 * @param string $countryCode
	 * @param string $vatNumber
	 * @param string $requesterCountryCode
	 * @param string $requesterVatNumber
	 *
	 * @return Varien_Object
	 */
	public function checkVatNumber($countryCode, $vatNumber, $requesterCountryCode = '', $requesterVatNumber = '') {
		$vatNumber = trim($vatNumber);
		$vatNumber = preg_replace( '/\s+/', '', $vatNumber);
		
		if (isset($countryCode)) {
			if (stripos($vatNumber, $countryCode) === 0) {
				$vatNumber = substr($vatNumber, 2);
			}
		}
		
		if (!empty($vatNumber) && preg_match('/^[0-9A-Za-z\+\*\.]{2,12}$/', $vatNumber) == 0) {
			Mage::throwException(Mage::helper('egovsbase')->__('VAT number must follow the pattern [0-9A-Za-z\+\*\.]{2,12}.'));
		}
		
		return parent::checkVatNumber($countryCode, $vatNumber, $requesterCountryCode, $requesterVatNumber);
	}
}