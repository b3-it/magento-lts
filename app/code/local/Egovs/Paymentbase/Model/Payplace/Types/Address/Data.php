<?php
/**
 * File for class Egovs_Paymentbase_Model_Payplace_Types_AddressData
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
/**
 * This class stands for Egovs_Paymentbase_Model_Payplace_Types_Address_Data originally named addressData
 * Documentation : Defines an address, e.g. for adress verification or scoring.
 * Meta informations extracted from the WSDL
 * - from schema : file:///etc/Callback.wsdl
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
class Egovs_Paymentbase_Model_Payplace_Types_Address_Data extends Egovs_Paymentbase_Model_Payplace_WsdlClass
{
    /**
     * The title
     * Meta informations extracted from the WSDL
     * - documentation : Mandatory for eScore, omit it for Bürgel.
     * - minOccurs : 0
     * @var Egovs_Paymentbase_Model_Payplace_Enum_Customer_TitleEnum
     */
    public $title;
    /**
     * The firstName
     * @var string
     */
    public $firstName;
    /**
     * The lastName
     * @var string
     */
    public $lastName;
    /**
     * The name2
     * Meta informations extracted from the WSDL
     * - documentation : Second or extra name for Bürgel requests.
     * - minOccurs : 0
     * @var string
     */
    public $name2;
    /**
     * The dateOfBirth
     * Meta informations extracted from the WSDL
     * - documentation : Date of birth in YYYY-MM-DD format.
     * - minOccurs : 0
     * - documentation : A date in YYYY-MM-DD format.
     * - pattern : [12][0-9][0-9][0-9]-(1[0-3]|0[1-9])-[0-3][0-9]
     * @var string
     */
    public $dateOfBirth;
    /**
     * The street
     * Meta informations extracted from the WSDL
     * - from schema : file:///etc/Callback.wsdl
     * - maxLength : 30
     * - minLength : 1
     * @var string
     */
    public $street;
    /**
     * The streetNumber
     * Meta informations extracted from the WSDL
     * - documentation : Only 8 characters allowed for eScore, Bürgel allows up to 10 characters.
     * - from schema : file:///etc/Callback.wsdl
     * - maxLength : 10
     * - minLength : 1
     * @var string
     */
    public $streetNumber;
    /**
     * The postcode
     * Meta informations extracted from the WSDL
     * - from schema : file:///etc/Callback.wsdl
     * - length : 5
     * - pattern : [0-9]+
     * @var string
     */
    public $postcode;
    /**
     * The city
     * Meta informations extracted from the WSDL
     * - from schema : file:///etc/Callback.wsdl
     * - maxLength : 30
     * - minLength : 1
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
     * The phone
     * Meta informations extracted from the WSDL
     * - documentation : Not for eScore, optional for Bürgel.
     * - from schema : file:///etc/Callback.wsdl
     * - maxLength : 20
     * - minLength : 1
     * - pattern : [-0-9 /]+
     * @var string
     */
    public $phone;
    /**
     * The email
     * Meta informations extracted from the WSDL
     * - documentation : Not for eScore, optional for Bürgel.
     * - from schema : file:///etc/Callback.wsdl
     * - maxLength : 60
     * - minLength : 1
     * @var string
     */
    public $email;
    /**
     * Constructor method for addressData
     * @see parent::__construct()
     * @param Egovs_Paymentbase_Model_Payplace_Enum_Customer_TitleEnum $_title
     * @param string $_firstName
     * @param string $_lastName
     * @param string $_name2
     * @param string $_dateOfBirth
     * @param string $_street
     * @param string $_streetNumber
     * @param string $_postcode
     * @param string $_city
     * @param string $_country
     * @param string $_phone
     * @param string $_email
     * @return Egovs_Paymentbase_Model_Payplace_Types_Address_Data
     */
    public function __construct($_title = NULL,$_firstName = NULL,$_lastName = NULL,$_name2 = NULL,$_dateOfBirth = NULL,$_street = NULL,$_streetNumber = NULL,$_postcode = NULL,$_city = NULL,$_country = NULL,$_phone = NULL,$_email = NULL)
    {
        parent::__construct(array('title'=>$_title,'firstName'=>$_firstName,'lastName'=>$_lastName,'name2'=>$_name2,'dateOfBirth'=>$_dateOfBirth,'street'=>$_street,'streetNumber'=>$_streetNumber,'postcode'=>$_postcode,'city'=>$_city,'country'=>$_country,'phone'=>$_phone,'email'=>$_email),false);
    }
    /**
     * Get title value
     * @return Egovs_Paymentbase_Model_Payplace_Enum_Customer_TitleEnum|null
     */
    public function getTitle()
    {
        return $this->title;
    }
    /**
     * Set title value
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_Customer_TitleEnum::valueIsValid()
     * @param Egovs_Paymentbase_Model_Payplace_Enum_Customer_TitleEnum $_title the title
     * @return Egovs_Paymentbase_Model_Payplace_Enum_Customer_TitleEnum
     */
    public function setTitle($_title)
    {
        if(!Egovs_Paymentbase_Model_Payplace_Enum_Customer_TitleEnum::valueIsValid($_title))
        {
            return false;
        }
        return ($this->title = $_title);
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
     * Get name2 value
     * @return string|null
     */
    public function getName2()
    {
        return $this->name2;
    }
    /**
     * Set name2 value
     * @param string $_name2 the name2
     * @return string
     */
    public function setName2($_name2)
    {
        return ($this->name2 = $_name2);
    }
    /**
     * Get dateOfBirth value
     * @return string|null
     */
    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }
    /**
     * Set dateOfBirth value
     * @param string $_dateOfBirth the dateOfBirth
     * @return string
     */
    public function setDateOfBirth($_dateOfBirth)
    {
        return ($this->dateOfBirth = $_dateOfBirth);
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
     * Get phone value
     * @return string|null
     */
    public function getPhone()
    {
        return $this->phone;
    }
    /**
     * Set phone value
     * @param string $_phone the phone
     * @return string
     */
    public function setPhone($_phone)
    {
        return ($this->phone = $_phone);
    }
    /**
     * Get email value
     * @return string|null
     */
    public function getEmail()
    {
        return $this->email;
    }
    /**
     * Set email value
     * @param string $_email the email
     * @return string
     */
    public function setEmail($_email)
    {
        return ($this->email = $_email);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @uses Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @param array $_array the exported values
     * @return Egovs_Paymentbase_Model_Payplace_Types_Address_Data
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
