<?php
class Egovs_GermanTax_Model_Tax_Calculation extends Mage_Tax_Model_Calculation
{
	protected function _construct()
	{
		$this->_init('germantax/tax_calculation');
	}
	
	/**
	 * Get cache key value for specific tax rate request
	 *
	 * @param   $request
	 * @return  string
	 */
	protected function _getRequestCacheKey($request)
	{
		$key = $request->getStore() ? $request->getStore()->getId() . '|' : '';
		$key.= $request->getProductClassId() . '|' . $request->getCustomerClassId() . '|'
				. $request->getCountryId() . '|'. $request->getRegionId() . '|' . $request->getPostcode() . '|'
				. $request->getIsVirtual() . '|'. $request->getTaxvat();
		return $key;
	}
	
	/**
     * Get request object with information necessary for getting tax rate
     * Request object contain:
     *  country_id (->getCountryId())
     *  region_id (->getRegionId())
     *  postcode (->getPostcode())
     *  customer_class_id (->getCustomerClassId())
     *  store (->getStore())
     *
     * @param   null|false|Varien_Object $shippingAddress
     * @param   null|false|Varien_Object $billingAddress
     * @param   null|int $customerTaxClass
     * @param   null|int $store
     * @return  Varien_Object
     */
    public function getRateRequest(
        $shippingAddress = null,
        $billingAddress = null,
        $customerTaxClass = null,
        $store = null)
    {
        if ($shippingAddress === false && $billingAddress === false && $customerTaxClass === false) {
            return $this->getRateOriginRequest($store);
        }
        $address    = new Varien_Object();
        $customer   = $this->getCustomer();
        $basedOn    = Mage::getStoreConfig(Mage_Tax_Model_Config::CONFIG_XML_PATH_BASED_ON, $store);

        if (($shippingAddress === false && $basedOn == 'shipping')
            || ($billingAddress === false && $basedOn == 'billing')) {
            $basedOn = 'default';
        } else {
            if ((($billingAddress === false || is_null($billingAddress) || !$billingAddress->getCountryId())
                && $basedOn == 'billing')
                || (($shippingAddress === false || is_null($shippingAddress) || !$shippingAddress->getCountryId())
                && $basedOn == 'shipping')
            ){
                if ($customer) {
                    $defBilling = $customer->getDefaultBillingAddress();
                    $defShipping = $customer->getDefaultShippingAddress();

                    if ($basedOn == 'billing' && $defBilling && $defBilling->getCountryId()) {
                        $billingAddress = $defBilling;
                    } else if ($basedOn == 'shipping' && $defShipping && $defShipping->getCountryId()) {
                        $shippingAddress = $defShipping;
                    } else {
                        $basedOn = 'default';
                    }
                } else {
                    $basedOn = 'default';
                }
            }
        }

        switch ($basedOn) {
            case 'billing':
                $address = $billingAddress;
                break;
            case 'shipping':
                $address = $shippingAddress;
                break;
            case 'origin':
                $address = $this->getRateOriginRequest($store);
                break;
            case 'default':
                $address
                    ->setCountryId(Mage::getStoreConfig(
                        Mage_Tax_Model_Config::CONFIG_XML_PATH_DEFAULT_COUNTRY,
                        $store))
                    ->setRegionId(Mage::getStoreConfig(Mage_Tax_Model_Config::CONFIG_XML_PATH_DEFAULT_REGION, $store))
                    ->setPostcode(Mage::getStoreConfig(
                        Mage_Tax_Model_Config::CONFIG_XML_PATH_DEFAULT_POSTCODE,
                        $store));
                break;
        }

        if (is_null($customerTaxClass) && $customer) {
            $customerTaxClass = $customer->getTaxClassId();
        } elseif (($customerTaxClass === false) || !$customer) {
            $customerTaxClass = $this->getDefaultCustomerTaxClass($store);
        }

        $request = new Varien_Object();
        $request
            ->setCountryId($address->getCountryId())
            ->setRegionId($address->getRegionId())
            ->setPostcode($address->getPostcode())
            ->setStore($store)
            ->setCustomerClassId($customerTaxClass)
        	->setTaxvat($address->getTaxvat() ? 1 : 0)
        ;
        return $request;
    }
	
	/**
	 * Compare data and rates for two tax rate requests for same products (product tax class ids).
	 * Returns true if requests are similar (i.e. equal taxes rates will be applied to them)
	 *
	 * Notice:
	 * a) productClassId MUST be identical for both requests, because we intend to check selling SAME products to DIFFERENT locations
	 * b) due to optimization productClassId can be array of ids, not only single id
	 *
	 * @param   Varien_Object $first
	 * @param   Varien_Object $second
	 * @return  bool
	 */
	public function compareRequests($first, $second)
	{
		$country = $first->getCountryId() == $second->getCountryId();
		// "0" support for admin dropdown with --please select--
		$region  = (int)$first->getRegionId() == (int)$second->getRegionId();
		$postcode= $first->getPostcode() == $second->getPostcode();
		$taxClass= $first->getCustomerClassId() == $second->getCustomerClassId();
		$taxvat = $first->getTaxvat() == $second->getTaxvat();
	
		if ($country && $region && $postcode && $taxClass && $taxvat) {
			return true;
		}
		/**
		 * Compare available tax rates for both requests
		 */
		$firstReqRates = $this->_getResource()->getRateIds($first);
		$secondReqRates = $this->_getResource()->getRateIds($second);
		if ($firstReqRates === $secondReqRates) {
			return true;
		}
	
		/**
		 * If rates are not equal by ids then compare actual values
		 * All product classes must have same rates to assume requests been similar
		 */
		$productClassId1 = $first->getProductClassId(); // Save to set it back later
		$productClassId2 = $second->getProductClassId(); // Save to set it back later
	
		// Ids are equal for both requests, so take any of them to process
		$ids = is_array($productClassId1) ? $productClassId1 : array($productClassId1);
		$identical = true;
		foreach ($ids as $productClassId) {
			$first->setProductClassId($productClassId);
			$rate1 = $this->getRate($first);
	
			$second->setProductClassId($productClassId);
			$rate2 = $this->getRate($second);
	
			if ($rate1 != $rate2) {
				$identical = false;
				break;
			}
		}
	
		$first->setProductClassId($productClassId1);
		$second->setProductClassId($productClassId2);
	
		return $identical;
	}
}