<?php
class Egovs_Checkout_Model_Validateadr extends Varien_Object
{
	public function validateShippingAddress(&$data) {
		$method = 'shipping';
		$errors = array();

		/**
		 * @var Mage_Directory_Helper_Data $directoryHelper
		 */
		$directoryHelper = Mage::helper("directory");

		if (!$this->__testShipping($data,'firstname'))
			$errors[] = Mage::helper('mpcheckout')->__('Please enter first name or company name.');
		if (!$this->__testShipping($data,'lastname'))
			$errors[] = Mage::helper('mpcheckout')->__('Please enter last name or company name.');
		 
		if ($this->__testShipping($data,'company'))
			$errors = array();
		 
		if (isset($data['street'])) {
			$adr = $data['street'];
			if (is_array($adr)) $adr = implode('',$adr);
			if(strlen($adr) < 1) $errors[] = Mage::helper('mpcheckout')->__('Please enter street.');
		} else {
			$errors[] = Mage::helper('mpcheckout')->__('Please enter street.');
		}
		 
		//if(!$this->__testShipping($data,'street'))$errors[] = Mage::helper('mpcheckout')->__('Please enter street.');
		if (!$this->__testShipping($data,'city'))$errors[] = Mage::helper('mpcheckout')->__('Please enter city.');
		if (!$this->__testShipping($data,'postcode'))$errors[] = Mage::helper('mpcheckout')->__('Please enter zip/postal code.');
		if (!$this->__testShipping($data,'country_id'))$errors[] = Mage::helper('mpcheckout')->__('Please enter country.');
		//if(!$this->i__testShippingsValid($data,'region_id'))$errors[] = Mage::helper('mpcheckout')->__('Please enter region.');
		if (!$this->__isValid($data,'telephone',$method))$errors[] = Mage::helper('mpcheckout')->__('Please enter telephone.');
		if (!$this->__isValid($data,'email',$method))$errors[] = Mage::helper('mpcheckout')->__('Please enter email.');
		if (!$this->__isValid($data,'company',$method))$errors[] = Mage::helper('mpcheckout')->__('Please enter company.');
		if (!$this->__isValid($data,'fax',$method))$errors[] = Mage::helper('mpcheckout')->__('Please enter fax.');
		if ((isset($data['country_id'])) && ($this->__isFieldRequired('region',$method))) {
		    // directory says that region is required for Country
		    if ($directoryHelper->isRegionRequired($data['country_id']) && $data['region'] == '') {
		        $errors[] = Mage::helper('mpcheckout')->__('Please enter region.');
		    }
		}
		if ((isset($data['country_id'])) && ($data['country_id']=='DE')) {
			if (isset($data['postcode']) && (strlen($data['postcode'])>0)) {
				$data['postcode'] = trim(str_replace('D-','',$data['postcode']));
				if (preg_match("/^[0-9]{5}$/",$data['postcode'])==0) {
					$errors[] = Mage::helper('mpcheckout')->__('Please enter valid zip/postal code.');
				}
			}

		}
		
		$this->_validateVat($data, $errors);
		
		if (count($errors) > 0 ) {
			return implode(' ',$errors);
		}
		
		return true;
	}
	
	public function validateShippingAddressField($field, $value) {
		$this->__testShipping(array($field => $value), $field);
	}

	public function validatePickupAddress(&$data) {
		$errors = array();
			
		if (!$this->__testShipping($data,'firstname'))
			$errors[] = Mage::helper('mpcheckout')->__('Please enter first name or company name.');
		if (!$this->__testShipping($data,'lastname'))
			$errors[] = Mage::helper('mpcheckout')->__('Please enter last name or company name.');
			
		if ($this->__testShipping($data,'company'))
			$errors = array();
		
		$this->_validateVat($data, $errors);
	
		if (count($errors)> 0 ) {
			return implode(' ',$errors);
		}
	
		return true;
	}
	
	/**
	 * Überprüft  die VAT mit den Adressdaten
	 * 
	 * Im Moment können folgende Felder validiert werden:
	 * <ul>
	 * 	<li>VAT</li>
	 * 	<li>Land</li>
	 *  <li>Firmenname (optional)</li>
	 * </ul>
	 * 
	 * Falls die Adresse vom VIES geliefert wird, wird dieses in die Validierung einbezogen.
	 * Bei einem Fehler wird der Fehler im $errors Array eingefügt.
	 * 
	 * @param array $data   Adresse
	 * @param array $errors Fehler Array
	 * 
	 * @return boolean
	 */
	protected function _validateVat(&$data, &$errors) {
		//falls das feld nicht gesetzt wurde braucht es nicht geprüft werden
		if (!isset($data['tax_id']) || empty($data['tax_id'])) {
			return true;
		}
		
		$result = Mage::helper('customer')->checkVatNumber($data['country_id'], $data['tax_id']);
		$customerAddress = new Varien_Object($data);
		
		$disableAutoGroupChange = true;
		$quote = Mage::getSingleton('checkout/session')->getQuote();
		if ($quote instanceof Mage_Sales_Model_Quote && ($customer = $quote->getCustomer())) {
			if ($customer instanceof Mage_Customer_Model_Customer) {
				$disableAutoGroupChange = $customer->getDisableAutoGroupChange();
			}
		}
		$validationMessage = Mage::helper('customer')->getVatValidationUserMessage(
				$customerAddress, $disableAutoGroupChange, $result
		);
		$errors[] = $validationMessage->getMessage();
		
		return $result->getIsValid();
	}


	private function __testShipping($data, $key) {
		return ((isset($data[$key])) && (strlen(trim($data[$key])) > 1));
	}


	private function __isFieldRequired($key,$method = null) {
		 
		return (Mage::helper('mpcheckout/config')->isFieldRequired($key,$method));
	}

	private function __isValid(&$data, $key, $method = null) {

		//falls das feld nicht gesetzt wurde braucht es nicht geprüft werden
		if (!isset($data[$key])) return true;
		 
		if ((strlen(trim($data[$key])) < 1)) {
			if ($this->__isFieldRequired($key,$method)) {
				return false;
			} else {
				//unset($data[$key]);
				return true;
			}
		}
		return true;
	}
}