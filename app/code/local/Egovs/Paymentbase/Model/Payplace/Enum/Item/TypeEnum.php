<?php
/**
 * File for class Egovs_Paymentbase_Model_Payplace_Enum_Item_TypeEnum
 * @package Egovs_Paymentbase
 * @subpackage Enumerations
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
/**
 * This class stands for Egovs_Paymentbase_Model_Payplace_Enum_Item_TypeEnum originally named itemTypeEnum
 * Meta informations extracted from the WSDL
 * - from schema : file:///etc/Callback.wsdl
 * @package Egovs_Paymentbase
 * @subpackage Enumerations
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
class Egovs_Paymentbase_Model_Payplace_Enum_Item_TypeEnum extends Egovs_Paymentbase_Model_Payplace_WsdlClass
{
    /**
     * Constant for value 'ipStrict'
     * @return string 'ipStrict'
     */
    const VALUE_IPSTRICT = 'ipStrict';
    /**
     * Constant for value 'ipSloppy'
     * @return string 'ipSloppy'
     */
    const VALUE_IPSLOPPY = 'ipSloppy';
    /**
     * Constant for value 'countryList'
     * @return string 'countryList'
     */
    const VALUE_COUNTRYLIST = 'countryList';
    /**
     * Constant for value 'cardIssuingCountry'
     * @return string 'cardIssuingCountry'
     */
    const VALUE_CARDISSUINGCOUNTRY = 'cardIssuingCountry';
    /**
     * Return true if value is allowed
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_Item_TypeEnum::VALUE_IPSTRICT
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_Item_TypeEnum::VALUE_IPSLOPPY
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_Item_TypeEnum::VALUE_COUNTRYLIST
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_Item_TypeEnum::VALUE_CARDISSUINGCOUNTRY
     * @param mixed $_value value
     * @return bool true|false
     */
    public static function valueIsValid($_value)
    {
        return in_array($_value,array(Egovs_Paymentbase_Model_Payplace_Enum_Item_TypeEnum::VALUE_IPSTRICT,Egovs_Paymentbase_Model_Payplace_Enum_Item_TypeEnum::VALUE_IPSLOPPY,Egovs_Paymentbase_Model_Payplace_Enum_Item_TypeEnum::VALUE_COUNTRYLIST,Egovs_Paymentbase_Model_Payplace_Enum_Item_TypeEnum::VALUE_CARDISSUINGCOUNTRY));
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
