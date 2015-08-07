<?php
/**
 * File for class Egovs_Paymentbase_Model_Payplace_Types_Address
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
/**
 * This class stands for Egovs_Paymentbase_Model_Payplace_Types_Address originally named address
 * Documentation : Address for American Express address verification or for a SEPA PDF mandate. Not for American Express address verification
 * Meta informations extracted from the WSDL
 * - from schema : file:///etc/Callback.wsdl
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
class Egovs_Paymentbase_Model_Payplace_Types_Address extends Egovs_Paymentbase_Model_Payplace_WsdlClass
{
    /**
     * The firstName
     * Meta informations extracted from the WSDL
     * - documentation : Not for American Express address verification
     * - minOccurs : 0
     * @var string
     */
    public $firstName;
    /**
     * The lastName
     * Meta informations extracted from the WSDL
     * - documentation : Not for American Express address verification
     * - minOccurs : 0
     * @var string
     */
    public $lastName;
    /**
     * The street
     * Meta informations extracted from the WSDL
     * - documentation : Mandatory for American Express address verification
     * - minOccurs : 0
     * @var string
     */
    public $street;
    /**
     * The streetNumber
     * Meta informations extracted from the WSDL
     * - documentation : Mandatory for American Express address verification
     * - minOccurs : 0
     * @var string
     */
    public $streetNumber;
    /**
     * The postcode
     * Meta informations extracted from the WSDL
     * - documentation : Mandatory for American Express address verification
     * - minOccurs : 0
     * @var string
     */
    public $postcode;
    /**
     * The city
     * Meta informations extracted from the WSDL
     * - documentation : Mandatory for American Express address verification
     * - minOccurs : 0
     * @var string
     */
    public $city;
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
     * Constructor method for address
     * @see parent::__construct()
     * @param string $_firstName
     * @param string $_lastName
     * @param string $_street
     * @param string $_streetNumber
     * @param string $_postcode
     * @param string $_city
     * @param string $_country
     * @return Egovs_Paymentbase_Model_Payplace_Types_Address
     */
    public function __construct($_firstName = NULL,$_lastName = NULL,$_street = NULL,$_streetNumber = NULL,$_postcode = NULL,$_city = NULL,$_country = NULL)
    {
        parent::__construct(array('firstName'=>$_firstName,'lastName'=>$_lastName,'street'=>$_street,'streetNumber'=>$_streetNumber,'postcode'=>$_postcode,'city'=>$_city,'country'=>$_country),false);
    }
    /**
     * Get firstName value
     * @return string|null
     */
    public function getFirstName()
    {
        return $this->firstName;
    }
    /**
     * Set firstName value
     * @param string $_firstName the firstName
     * @return string
     */
    public function setFirstName($_firstName)
    {
        return ($this->firstName = $_firstName);
    }
    /**
     * Get lastName value
     * @return string|null
     */
    public function getLastName()
    {
        return $this->lastName;
    }
    /**
     * Set lastName value
     * @param string $_lastName the lastName
     * @return string
     */
    public function setLastName($_lastName)
    {
        return ($this->lastName = $_lastName);
    }
    /**
     * Get street value
     * @return string|null
     */
    public function getStreet()
    {
        return $this->street;
    }
    /**
     * Set street value
     * @param string $_street the street
     * @return string
     */
    public function setStreet($_street)
    {
        return ($this->street = $_street);
    }
    /**
     * Get streetNumber value
     * @return string|null
     */
    public function getStreetNumber()
    {
        return $this->streetNumber;
    }
    /**
     * Set streetNumber value
     * @param string $_streetNumber the streetNumber
     * @return string
     */
    public function setStreetNumber($_streetNumber)
    {
        return ($this->streetNumber = $_streetNumber);
    }
    /**
     * Get postcode value
     * @return string|null
     */
    public function getPostcode()
    {
        return $this->postcode;
    }
    /**
     * Set postcode value
     * @param string $_postcode the postcode
     * @return string
     */
    public function setPostcode($_postcode)
    {
        return ($this->postcode = $_postcode);
    }
    /**
     * Get city value
     * @return string|null
     */
    public function getCity()
    {
        return $this->city;
    }
    /**
     * Set city value
     * @param string $_city the city
     * @return string
     */
    public function setCity($_city)
    {
        return ($this->city = $_city);
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
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @uses Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @param array $_array the exported values
     * @return Egovs_Paymentbase_Model_Payplace_Types_Address
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
