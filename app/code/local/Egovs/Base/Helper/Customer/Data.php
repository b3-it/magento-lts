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
            ->load((int)$customerId, array('password_created_at', 'created_at'));
        $passwordCreatedAt = $customer->getPasswordCreatedAt();

        return is_null($passwordCreatedAt) ? $customer->getCreatedAtTimestamp() : $passwordCreatedAt;
    }

}