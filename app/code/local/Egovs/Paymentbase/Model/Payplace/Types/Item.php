<?php
/**
 * File for class Egovs_Paymentbase_Model_Payplace_Types_Item
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
/**
 * This class stands for Egovs_Paymentbase_Model_Payplace_Types_Item originally named item
 * Meta informations extracted from the WSDL
 * - from schema : file:///etc/Callback.wsdl
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
class Egovs_Paymentbase_Model_Payplace_Types_Item extends Egovs_Paymentbase_Model_Payplace_WsdlClass
{
    /**
     * The type
     * Meta informations extracted from the WSDL
     * - documentation : Type of the comparison item.
     * - use : required
     * @var Egovs_Paymentbase_Model_Payplace_Enum_Item_TypeEnum
     */
    public $type;
    /**
     * The ip
     * Meta informations extracted from the WSDL
     * - documentation : IP address of a computer
     * - pattern : [0-9]+\.[0-9]+\.[0-9]+\.[0-9]+
     * @var string
     */
    public $ip;
    /**
     * The acceptCountries
     * @var Egovs_Paymentbase_Model_Payplace_Types_CountryList
     */
    public $acceptCountries;
    /**
     * The rejectCountries
     * @var Egovs_Paymentbase_Model_Payplace_Types_CountryList
     */
    public $rejectCountries;
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
     * Constructor method for item
     * @see parent::__construct()
     * @param Egovs_Paymentbase_Model_Payplace_Enum_Item_TypeEnum $_type
     * @param string $_ip
     * @param Egovs_Paymentbase_Model_Payplace_Types_CountryList $_acceptCountries
     * @param Egovs_Paymentbase_Model_Payplace_Types_CountryList $_rejectCountries
     * @param string $_country
     * @return Egovs_Paymentbase_Model_Payplace_Types_Item
     */
    public function __construct($_type,$_ip = NULL,$_acceptCountries = NULL,$_rejectCountries = NULL,$_country = NULL)
    {
        parent::__construct(array('type'=>$_type,'ip'=>$_ip,'acceptCountries'=>$_acceptCountries,'rejectCountries'=>$_rejectCountries,'country'=>$_country),false);
    }
    /**
     * Get type value
     * @return Egovs_Paymentbase_Model_Payplace_Enum_Item_TypeEnum
     */
    public function getType()
    {
        return $this->type;
    }
    /**
     * Set type value
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_Item_TypeEnum::valueIsValid()
     * @param Egovs_Paymentbase_Model_Payplace_Enum_Item_TypeEnum $_type the type
     * @return Egovs_Paymentbase_Model_Payplace_Enum_Item_TypeEnum
     */
    public function setType($_type)
    {
        if(!Egovs_Paymentbase_Model_Payplace_Enum_Item_TypeEnum::valueIsValid($_type))
        {
            return false;
        }
        return ($this->type = $_type);
    }
    /**
     * Get ip value
     * @return string|null
     */
    public function getIp()
    {
        return $this->ip;
    }
    /**
     * Set ip value
     * @param string $_ip the ip
     * @return string
     */
    public function setIp($_ip)
    {
        return ($this->ip = $_ip);
    }
    /**
     * Get acceptCountries value
     * @return Egovs_Paymentbase_Model_Payplace_Types_CountryList|null
     */
    public function getAcceptCountries()
    {
        return $this->acceptCountries;
    }
    /**
     * Set acceptCountries value
     * @param Egovs_Paymentbase_Model_Payplace_Types_CountryList $_acceptCountries the acceptCountries
     * @return Egovs_Paymentbase_Model_Payplace_Types_CountryList
     */
    public function setAcceptCountries($_acceptCountries)
    {
        return ($this->acceptCountries = $_acceptCountries);
    }
    /**
     * Get rejectCountries value
     * @return Egovs_Paymentbase_Model_Payplace_Types_CountryList|null
     */
    public function getRejectCountries()
    {
        return $this->rejectCountries;
    }
    /**
     * Set rejectCountries value
     * @param Egovs_Paymentbase_Model_Payplace_Types_CountryList $_rejectCountries the rejectCountries
     * @return Egovs_Paymentbase_Model_Payplace_Types_CountryList
     */
    public function setRejectCountries($_rejectCountries)
    {
        return ($this->rejectCountries = $_rejectCountries);
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
     * @return Egovs_Paymentbase_Model_Payplace_Types_Item
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
