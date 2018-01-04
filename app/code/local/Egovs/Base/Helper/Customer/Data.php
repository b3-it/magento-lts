<?php
class Egovs_Base_Helper_Customer_Data extends Mage_Customer_Helper_Data
{
    /**
     * WSDL of VAT validation service
     *
     */
    const VAT_VALIDATION_WSDL_URL = 'https://ec.europa.eu/taxation_customs/vies/services/checkVatService?wsdl';

    /**
     * Send request to VAT validation service and return validation result
     *
     * @param string $countryCode
     * @param string $vatNumber
     * @param string $requesterCountryCode
     * @param string $requesterVatNumber
     *
     * @return Varien_Object
     * @throws \Mage_Core_Exception
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

    /**
     * Retrieve academic_titel dropdown options
     *
     * @return array|bool
     */
    public function getAcademicTitleOptions($store = null)
    {
        // Das sollte noch Falsch sein
        return $this->_prepareNamePrefixSuffixOptions(
            Mage::helper('customer/address')->getConfig('academic_titel_options', $store)
        );
    }

    /**
     * Create SOAP client based on VAT validation service WSDL
     *
     * @param boolean $trace
     * @return SoapClient
     */
    protected function _createVatNumberValidationSoapClient($trace = false)
    {
        return new SoapClient(static::VAT_VALIDATION_WSDL_URL, array('trace' => $trace));
    }
}