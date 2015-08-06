<?php
/**
 * File for class Egovs_Paymentbase_Model_Payplace_Enum_CheckResultEnum
 * @package Egovs_Paymentbase
 * @subpackage Enumerations
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
/**
 * This class stands for Egovs_Paymentbase_Model_Payplace_Enum_CheckResultEnum originally named checkResultEnum
 * Meta informations extracted from the WSDL
 * - from schema : file:///etc/Callback.wsdl
 * @package Egovs_Paymentbase
 * @subpackage Enumerations
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
class Egovs_Paymentbase_Model_Payplace_Enum_CheckResultEnum extends Egovs_Paymentbase_Model_Payplace_WsdlClass
{
    /**
     * Constant for value 'passed'
     * Meta informations extracted from the WSDL
     * - documentation : OK, test passed.
     * @return string 'passed'
     */
    const VALUE_PASSED = 'passed';
    /**
     * Constant for value 'failed'
     * Meta informations extracted from the WSDL
     * - documentation : Did not pass the test.
     * @return string 'failed'
     */
    const VALUE_FAILED = 'failed';
    /**
     * Constant for value 'unknown'
     * Meta informations extracted from the WSDL
     * - documentation : The validation was not possible or could not be completed normally.
     * @return string 'unknown'
     */
    const VALUE_UNKNOWN = 'unknown';
    /**
     * Return true if value is allowed
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_CheckResultEnum::VALUE_PASSED
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_CheckResultEnum::VALUE_FAILED
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_CheckResultEnum::VALUE_UNKNOWN
     * @param mixed $_value value
     * @return bool true|false
     */
    public static function valueIsValid($_value)
    {
        return in_array($_value,array(Egovs_Paymentbase_Model_Payplace_Enum_CheckResultEnum::VALUE_PASSED,Egovs_Paymentbase_Model_Payplace_Enum_CheckResultEnum::VALUE_FAILED,Egovs_Paymentbase_Model_Payplace_Enum_CheckResultEnum::VALUE_UNKNOWN));
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
