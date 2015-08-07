<?php
/**
 * File for class Egovs_Paymentbase_Model_Payplace_Types_CountryList
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
/**
 * This class stands for Egovs_Paymentbase_Model_Payplace_Types_CountryList originally named countryList
 * Meta informations extracted from the WSDL
 * - from schema : file:///etc/Callback.wsdl
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
class Egovs_Paymentbase_Model_Payplace_Types_CountryList extends Egovs_Paymentbase_Model_Payplace_WsdlClass
{
    /**
     * The country
     * Meta informations extracted from the WSDL
     * - documentation : Two letter country code according to the current version of ISO 3166.
     * - length : 2
     * - pattern : [A-Z]+
     * @var string
     */
    public $country;
    /**
     * The rejectMessage
     * Meta informations extracted from the WSDL
     * - documentation : Individual error message if payment is rejected, e.g. because the issuing country of the credit card is not an accepted country . For form service only. If not supplied the standard error message of the system for the error is displayed.
     * - from schema : file:///etc/Callback.wsdl
     * - minLength : 1
     * @var string
     */
    public $rejectMessage;
    /**
     * Constructor method for countryList
     * @see parent::__construct()
     * @param string $_country
     * @param string $_rejectMessage
     * @return Egovs_Paymentbase_Model_Payplace_Types_CountryList
     */
    public function __construct($_country = NULL,$_rejectMessage = NULL)
    {
        parent::__construct(array('country'=>$_country,'rejectMessage'=>$_rejectMessage),false);
    }
    /**
     * Get country value
     * @return string|null
     */
    public function getCountry()
    {
        return $this->country;
    }
    /**
     * Set country value
     * @param string $_country the country
     * @return string
     */
    public function setCountry($_country)
    {
        return ($this->country = $_country);
    }
    /**
     * Get rejectMessage value
     * @return string|null
     */
    public function getRejectMessage()
    {
        return $this->rejectMessage;
    }
    /**
     * Set rejectMessage value
     * @param string $_rejectMessage the rejectMessage
     * @return string
     */
    public function setRejectMessage($_rejectMessage)
    {
        return ($this->rejectMessage = $_rejectMessage);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @uses Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @param array $_array the exported values
     * @return Egovs_Paymentbase_Model_Payplace_Types_CountryList
     */
    public static function __set_state(array $_array,$_className = __CLASS__)
    {
        return parent::__set_state($_array,$_className);
    }
    /**
     * Method returning the class name
     * @return string __CLASS__
     */
    public function __toString()
    {
        return __CLASS__;
    }
}
