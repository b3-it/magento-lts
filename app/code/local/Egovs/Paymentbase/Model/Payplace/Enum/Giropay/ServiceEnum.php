<?php
/**
 * File for class Egovs_Paymentbase_Model_Payplace_Enum_Giropay_ServiceEnum
 * @package Egovs_Paymentbase
 * @subpackage Enumerations
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
/**
 * This class stands for Egovs_Paymentbase_Model_Payplace_Enum_Giropay_ServiceEnum originally named giropayServiceEnum
 * Meta informations extracted from the WSDL
 * - from schema : file:///etc/Callback.wsdl
 * @package Egovs_Paymentbase
 * @subpackage Enumerations
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
class Egovs_Paymentbase_Model_Payplace_Enum_Giropay_ServiceEnum extends Egovs_Paymentbase_Model_Payplace_WsdlClass
{
    /**
     * Constant for value 'payment'
     * @return string 'payment'
     */
    const VALUE_PAYMENT = 'payment';
    /**
     * Constant for value 'ageverification'
     * @return string 'ageverification'
     */
    const VALUE_AGEVERIFICATION = 'ageverification';
    /**
     * Return true if value is allowed
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_Giropay_ServiceEnum::VALUE_PAYMENT
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_Giropay_ServiceEnum::VALUE_AGEVERIFICATION
     * @param mixed $_value value
     * @return bool true|false
     */
    public static function valueIsValid($_value)
    {
        return in_array($_value,array(Egovs_Paymentbase_Model_Payplace_Enum_Giropay_ServiceEnum::VALUE_PAYMENT,Egovs_Paymentbase_Model_Payplace_Enum_Giropay_ServiceEnum::VALUE_AGEVERIFICATION));
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
