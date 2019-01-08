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

        // Default response
        $gatewayResponse = new Varien_Object(array(
            'is_valid' => false,
            'request_date' => '',
            'request_identifier' => '',
            'request_success' => false
        ));

        if (!extension_loaded('soap')) {
            Mage::logException(Mage::exception('Mage_Core',
                Mage::helper('core')->__('PHP SOAP extension is required.')));
            return $gatewayResponse;
        }

        if (!$this->canCheckVatNumber($countryCode, $vatNumber, $requesterCountryCode, $requesterVatNumber)) {
            return $gatewayResponse;
        }

        try {
            $soapClient = $this->_createVatNumberValidationSoapClient();

            $requestParams = array();
            $requestParams['countryCode'] = $countryCode;
            $requestParams['vatNumber'] = str_replace(array(' ', '-'), array('', ''), $vatNumber);
            $requestParams['requesterCountryCode'] = $requesterCountryCode;
            $requestParams['requesterVatNumber'] = str_replace(array(' ', '-'), array('', ''), $requesterVatNumber);

            // Send request to service
            $result = $soapClient->checkVatApprox($requestParams);

            $gatewayResponse->setIsValid((boolean) $result->valid);
            $gatewayResponse->setRequestDate((string) $result->requestDate);
            $gatewayResponse->setRequestIdentifier((string) $result->requestIdentifier);
            $gatewayResponse->setRequestSuccess(true);
        } catch (Exception $exception) {
            Mage::logException($exception);
            $gatewayResponse->setIsValid(false);
            $gatewayResponse->setRequestDate('');
            $gatewayResponse->setRequestIdentifier('');
        }

        return $gatewayResponse;
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
     * Get customer password creation timestamp or customer account creation timestamp
     *
     * @param $customerId
     * @return int
     */
    public function getPasswordTimestamp($customerId)
    {
        /** @var $customer Mage_Customer_Model_Customer */
        $customer = Mage::getModel('customer/customer')
            ->setWebsiteId(Mage::app()->getStore()->getWebsiteId())
        ;
        $customer->getResource()
            ->load($customer, (int)$customerId, array('password_created_at'));
        $passwordCreatedAt = $customer->getPasswordCreatedAt();

        return is_null($passwordCreatedAt) ? $customer->getCreatedAtTimestamp() : $passwordCreatedAt;
    }

}