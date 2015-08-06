<?php
/**
 * File for class Egovs_Paymentbase_Model_Payplace_Enum_RiskCheck_ActionEnum
 * @package Egovs_Paymentbase
 * @subpackage Enumerations
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
/**
 * This class stands for Egovs_Paymentbase_Model_Payplace_Enum_RiskCheck_ActionEnum originally named riskCheckActionEnum
 * Meta informations extracted from the WSDL
 * - from schema : file:///etc/Callback.wsdl
 * @package Egovs_Paymentbase
 * @subpackage Enumerations
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
class Egovs_Paymentbase_Model_Payplace_Enum_RiskCheck_ActionEnum extends Egovs_Paymentbase_Model_Payplace_WsdlClass
{
    /**
     * Constant for value 'addresscheck'
     * Meta informations extracted from the WSDL
     * - documentation : eScore address verification ES0013
     * @return string 'addresscheck'
     */
    const VALUE_ADDRESSCHECK = 'addresscheck';
    /**
     * Constant for value 'creditassessment'
     * Meta informations extracted from the WSDL
     * - documentation : eScore credit assessment ES0012
     * @return string 'creditassessment'
     */
    const VALUE_CREDITASSESSMENT = 'creditassessment';
    /**
     * Constant for value 'scoring'
     * Meta informations extracted from the WSDL
     * - documentation : eScore integrated address verification, credit assessment and scoring ES0015
     * @return string 'scoring'
     */
    const VALUE_SCORING = 'scoring';
    /**
     * Constant for value 'boniscoreandscoring'
     * Meta informations extracted from the WSDL
     * - documentation : eScoreIntegrated credit assessment (Boniscore) and scoring ES0036
     * @return string 'boniscoreandscoring'
     */
    const VALUE_BONISCOREANDSCORING = 'boniscoreandscoring';
    /**
     * Constant for value 'boniscoreandaddresscheck'
     * Meta informations extracted from the WSDL
     * - documentation : eScore integrated credit assessment (Boniscore) and address verification ES0037
     * @return string 'boniscoreandaddresscheck'
     */
    const VALUE_BONISCOREANDADDRESSCHECK = 'boniscoreandaddresscheck';
    /**
     * Constant for value 'bankaccount'
     * Meta informations extracted from the WSDL
     * - documentation : RPP check ES0024
     * @return string 'bankaccount'
     */
    const VALUE_BANKACCOUNT = 'bankaccount';
    /**
     * Constant for value 'concheck'
     * Meta informations extracted from the WSDL
     * - documentation : Bürgel ConCheck
     * @return string 'concheck'
     */
    const VALUE_CONCHECK = 'concheck';
    /**
     * Constant for value 'concheckbasic'
     * Meta informations extracted from the WSDL
     * - documentation : Bürgel ConCheck basic
     * @return string 'concheckbasic'
     */
    const VALUE_CONCHECKBASIC = 'concheckbasic';
    /**
     * Return true if value is allowed
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_RiskCheck_ActionEnum::VALUE_ADDRESSCHECK
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_RiskCheck_ActionEnum::VALUE_CREDITASSESSMENT
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_RiskCheck_ActionEnum::VALUE_SCORING
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_RiskCheck_ActionEnum::VALUE_BONISCOREANDSCORING
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_RiskCheck_ActionEnum::VALUE_BONISCOREANDADDRESSCHECK
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_RiskCheck_ActionEnum::VALUE_BANKACCOUNT
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_RiskCheck_ActionEnum::VALUE_CONCHECK
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_RiskCheck_ActionEnum::VALUE_CONCHECKBASIC
     * @param mixed $_value value
     * @return bool true|false
     */
    public static function valueIsValid($_value)
    {
        return in_array($_value,array(Egovs_Paymentbase_Model_Payplace_Enum_RiskCheck_ActionEnum::VALUE_ADDRESSCHECK,Egovs_Paymentbase_Model_Payplace_Enum_RiskCheck_ActionEnum::VALUE_CREDITASSESSMENT,Egovs_Paymentbase_Model_Payplace_Enum_RiskCheck_ActionEnum::VALUE_SCORING,Egovs_Paymentbase_Model_Payplace_Enum_RiskCheck_ActionEnum::VALUE_BONISCOREANDSCORING,Egovs_Paymentbase_Model_Payplace_Enum_RiskCheck_ActionEnum::VALUE_BONISCOREANDADDRESSCHECK,Egovs_Paymentbase_Model_Payplace_Enum_RiskCheck_ActionEnum::VALUE_BANKACCOUNT,Egovs_Paymentbase_Model_Payplace_Enum_RiskCheck_ActionEnum::VALUE_CONCHECK,Egovs_Paymentbase_Model_Payplace_Enum_RiskCheck_ActionEnum::VALUE_CONCHECKBASIC));
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
