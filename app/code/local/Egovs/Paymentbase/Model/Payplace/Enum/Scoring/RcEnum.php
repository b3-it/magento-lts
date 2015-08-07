<?php
/**
 * File for class Egovs_Paymentbase_Model_Payplace_Enum_Scoring_RcEnum
 * @package Egovs_Paymentbase
 * @subpackage Enumerations
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
/**
 * This class stands for Egovs_Paymentbase_Model_Payplace_Enum_Scoring_RcEnum originally named scoringRcEnum
 * Meta informations extracted from the WSDL
 * - from schema : file:///etc/Callback.wsdl
 * @package Egovs_Paymentbase
 * @subpackage Enumerations
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
class Egovs_Paymentbase_Model_Payplace_Enum_Scoring_RcEnum extends Egovs_Paymentbase_Model_Payplace_WsdlClass
{
    /**
     * Constant for value 'Y'
     * Meta informations extracted from the WSDL
     * - documentation : yellow/amber
     * @return string 'Y'
     */
    const VALUE_Y = 'Y';
    /**
     * Constant for value 'R'
     * Meta informations extracted from the WSDL
     * - documentation : red
     * @return string 'R'
     */
    const VALUE_R = 'R';
    /**
     * Constant for value 'G'
     * Meta informations extracted from the WSDL
     * - documentation : green
     * @return string 'G'
     */
    const VALUE_G = 'G';
    /**
     * Constant for value 'U'
     * Meta informations extracted from the WSDL
     * - documentation : unknown
     * @return string 'U'
     */
    const VALUE_U = 'U';
    /**
     * Return true if value is allowed
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_Scoring_RcEnum::VALUE_Y
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_Scoring_RcEnum::VALUE_R
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_Scoring_RcEnum::VALUE_G
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_Scoring_RcEnum::VALUE_U
     * @param mixed $_value value
     * @return bool true|false
     */
    public static function valueIsValid($_value)
    {
        return in_array($_value,array(Egovs_Paymentbase_Model_Payplace_Enum_Scoring_RcEnum::VALUE_Y,Egovs_Paymentbase_Model_Payplace_Enum_Scoring_RcEnum::VALUE_R,Egovs_Paymentbase_Model_Payplace_Enum_Scoring_RcEnum::VALUE_G,Egovs_Paymentbase_Model_Payplace_Enum_Scoring_RcEnum::VALUE_U));
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
