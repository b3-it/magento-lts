<?php
/**
 * File for class Egovs_Paymentbase_Model_Payplace_Enum_SeriesFlagEnum
 * @package Egovs_Paymentbase
 * @subpackage Enumerations
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
/**
 * This class stands for Egovs_Paymentbase_Model_Payplace_Enum_SeriesFlagEnum originally named seriesFlagEnum
 * Meta informations extracted from the WSDL
 * - from schema : file:///etc/Callback.wsdl
 * @package Egovs_Paymentbase
 * @subpackage Enumerations
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
class Egovs_Paymentbase_Model_Payplace_Enum_SeriesFlagEnum extends Egovs_Paymentbase_Model_Payplace_WsdlClass
{
    /**
     * Constant for value 'installment'
     * Meta informations extracted from the WSDL
     * - documentation : instalment
     * @return string 'installment'
     */
    const VALUE_INSTALLMENT = 'installment';
    /**
     * Constant for value 'recurring'
     * Meta informations extracted from the WSDL
     * - documentation : preiodic payment (subscription payments).
     * @return string 'recurring'
     */
    const VALUE_RECURRING = 'recurring';
    /**
     * Return true if value is allowed
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_SeriesFlagEnum::VALUE_INSTALLMENT
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_SeriesFlagEnum::VALUE_RECURRING
     * @param mixed $_value value
     * @return bool true|false
     */
    public static function valueIsValid($_value)
    {
        return in_array($_value,array(Egovs_Paymentbase_Model_Payplace_Enum_SeriesFlagEnum::VALUE_INSTALLMENT,Egovs_Paymentbase_Model_Payplace_Enum_SeriesFlagEnum::VALUE_RECURRING));
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
