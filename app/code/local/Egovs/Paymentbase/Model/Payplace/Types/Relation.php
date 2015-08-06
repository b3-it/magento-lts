<?php
/**
 * File for class Egovs_Paymentbase_Model_Payplace_Types_Relation
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
/**
 * This class stands for Egovs_Paymentbase_Model_Payplace_Types_Relation originally named relation
 * Documentation : Relation of a person to a company in Bürgel ConCheck responses.
 * Meta informations extracted from the WSDL
 * - from schema : file:///etc/Callback.wsdl
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
class Egovs_Paymentbase_Model_Payplace_Types_Relation extends Egovs_Paymentbase_Model_Payplace_WsdlClass
{
    /**
     * The objectNumber
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $objectNumber;
    /**
     * The name
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $name;
    /**
     * The nameExtra
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $nameExtra;
    /**
     * The postcode
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $postcode;
    /**
     * The city
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $city;
    /**
     * The countryCode
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $countryCode;
    /**
     * Constructor method for relation
     * @see parent::__construct()
     * @param string $_objectNumber
     * @param string $_name
     * @param string $_nameExtra
     * @param string $_postcode
     * @param string $_city
     * @param string $_countryCode
     * @return Egovs_Paymentbase_Model_Payplace_Types_Relation
     */
    public function __construct($_objectNumber = NULL,$_name = NULL,$_nameExtra = NULL,$_postcode = NULL,$_city = NULL,$_countryCode = NULL)
    {
        parent::__construct(array('objectNumber'=>$_objectNumber,'name'=>$_name,'nameExtra'=>$_nameExtra,'postcode'=>$_postcode,'city'=>$_city,'countryCode'=>$_countryCode),false);
    }
    /**
     * Get objectNumber value
     * @return string|null
     */
    public function getObjectNumber()
    {
        return $this->objectNumber;
    }
    /**
     * Set objectNumber value
     * @param string $_objectNumber the objectNumber
     * @return string
     */
    public function setObjectNumber($_objectNumber)
    {
        return ($this->objectNumber = $_objectNumber);
    }
    /**
     * Get name value
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Set name value
     * @param string $_name the name
     * @return string
     */
    public function setName($_name)
    {
        return ($this->name = $_name);
    }
    /**
     * Get nameExtra value
     * @return string|null
     */
    public function getNameExtra()
    {
        return $this->nameExtra;
    }
    /**
     * Set nameExtra value
     * @param string $_nameExtra the nameExtra
     * @return string
     */
    public function setNameExtra($_nameExtra)
    {
        return ($this->nameExtra = $_nameExtra);
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
     * Get countryCode value
     * @return string|null
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }
    /**
     * Set countryCode value
     * @param string $_countryCode the countryCode
     * @return string
     */
    public function setCountryCode($_countryCode)
    {
        return ($this->countryCode = $_countryCode);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @uses Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @param array $_array the exported values
     * @return Egovs_Paymentbase_Model_Payplace_Types_Relation
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
