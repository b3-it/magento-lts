<?php
/**
 * File for class Egovs_Paymentbase_Model_Payplace_Enum_IndicatorEnum
 * @package Egovs_Paymentbase
 * @subpackage Enumerations
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
/**
 * This class stands for Egovs_Paymentbase_Model_Payplace_Enum_IndicatorEnum originally named indicatorEnum
 * Meta informations extracted from the WSDL
 * - from schema : file:///etc/Callback.wsdl
 * @package Egovs_Paymentbase
 * @subpackage Enumerations
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
class Egovs_Paymentbase_Model_Payplace_Enum_IndicatorEnum extends Egovs_Paymentbase_Model_Payplace_WsdlClass
{
    /**
     * Constant for value 'ecom'
     * @return string 'ecom'
     */
    const VALUE_ECOM = 'ecom';
    /**
     * Constant for value 'moto'
     * @return string 'moto'
     */
    const VALUE_MOTO = 'moto';
    /**
     * Constant for value 'pos'
     * @return string 'pos'
     */
    const VALUE_POS = 'pos';
    /**
     * Return true if value is allowed
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_IndicatorEnum::VALUE_ECOM
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_IndicatorEnum::VALUE_MOTO
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_IndicatorEnum::VALUE_POS
     * @param mixed $_value value
     * @return bool true|false
     */
    public static function valueIsValid($_value)
    {
        return in_array($_value,array(Egovs_Paymentbase_Model_Payplace_Enum_IndicatorEnum::VALUE_ECOM,Egovs_Paymentbase_Model_Payplace_Enum_IndicatorEnum::VALUE_MOTO,Egovs_Paymentbase_Model_Payplace_Enum_IndicatorEnum::VALUE_POS));
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
