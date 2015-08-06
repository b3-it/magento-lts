<?php
/**
 * File for class Egovs_Paymentbase_Model_Payplace_Enum_EScore_Rpp_Match
 * @package Egovs_Paymentbase
 * @subpackage Enumerations
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
/**
 * This class stands for Egovs_Paymentbase_Model_Payplace_Enum_EScore_Rpp_Match originally named eScoreRppMatch
 * Documentation : Hit in RPP. 0: no hit, 1: hit(s).
 * Meta informations extracted from the WSDL
 * - from schema : file:///etc/Callback.wsdl
 * @package Egovs_Paymentbase
 * @subpackage Enumerations
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
class Egovs_Paymentbase_Model_Payplace_Enum_EScore_Rpp_Match extends Egovs_Paymentbase_Model_Payplace_WsdlClass
{
    /**
     * Constant for value 0
     * @return integer 0
     */
    const VALUE_0 = 0;
    /**
     * Constant for value 1
     * @return integer 1
     */
    const VALUE_1 = 1;
    /**
     * Return true if value is allowed
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_EScore_Rpp_Match::VALUE_0
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_EScore_Rpp_Match::VALUE_1
     * @param mixed $_value value
     * @return bool true|false
     */
    public static function valueIsValid($_value)
    {
        return in_array($_value,array(Egovs_Paymentbase_Model_Payplace_Enum_EScore_Rpp_Match::VALUE_0,Egovs_Paymentbase_Model_Payplace_Enum_EScore_Rpp_Match::VALUE_1));
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
