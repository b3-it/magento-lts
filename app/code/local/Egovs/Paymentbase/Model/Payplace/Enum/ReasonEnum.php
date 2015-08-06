<?php
/**
 * File for class Egovs_Paymentbase_Model_Payplace_Enum_ReasonEnum
 * @package Egovs_Paymentbase
 * @subpackage Enumerations
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
/**
 * This class stands for Egovs_Paymentbase_Model_Payplace_Enum_ReasonEnum originally named reasonEnum
 * Meta informations extracted from the WSDL
 * - from schema : file:///etc/Callback.wsdl
 * @package Egovs_Paymentbase
 * @subpackage Enumerations
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
class Egovs_Paymentbase_Model_Payplace_Enum_ReasonEnum extends Egovs_Paymentbase_Model_Payplace_WsdlClass
{
    /**
     * Constant for value 'ABK'
     * Meta informations extracted from the WSDL
     * - documentation : eScore: request for credit assessment before concluding a purchase contract (in particular purchase on account or by instalments)
     * @return string 'ABK'
     */
    const VALUE_ABK = 'ABK';
    /**
     * Constant for value 'ABV'
     * Meta informations extracted from the WSDL
     * - documentation : eScore: request for credit assessment before concluding an insurance contract
     * @return string 'ABV'
     */
    const VALUE_ABV = 'ABV';
    /**
     * Constant for value 'BZV'
     * Meta informations extracted from the WSDL
     * - documentation : eScore: credit assessment within the scope of evaluating the reliability of an insurance broker or an insurance field representative
     * @return string 'BZV'
     */
    const VALUE_BZV = 'BZV';
    /**
     * Constant for value 'BMT'
     * Meta informations extracted from the WSDL
     * - documentation : eScore: credit assessment before opening or installing a mobile telecommunication account
     * @return string 'BMT'
     */
    const VALUE_BMT = 'BMT';
    /**
     * Constant for value 'BFT'
     * Meta informations extracted from the WSDL
     * - documentation : eScore: credit assessment before opening or installing a landline telecommunication account
     * @return string 'BFT'
     */
    const VALUE_BFT = 'BFT';
    /**
     * Constant for value 'ABI'
     * Meta informations extracted from the WSDL
     * - documentation : eScore: request for credit assessment before or in connection with the initiation or carrying out of debt-collecting measures
     * @return string 'ABI'
     */
    const VALUE_ABI = 'ABI';
    /**
     * Constant for value 'ABF'
     * Meta informations extracted from the WSDL
     * - documentation : eScore: request for credit assessment before takeover/purchase of a claim or before assuming del credere liability
     * @return string 'ABF'
     */
    const VALUE_ABF = 'ABF';
    /**
     * Constant for value 'ABD'
     * Meta informations extracted from the WSDL
     * - documentation : eScore: request for credit assessment before concluding a service contract
     * @return string 'ABD'
     */
    const VALUE_ABD = 'ABD';
    /**
     * Constant for value 'ABW'
     * Meta informations extracted from the WSDL
     * - documentation : eScore: request for credit assessment before concluding a contract for work and labour
     * @return string 'ABW'
     */
    const VALUE_ABW = 'ABW';
    /**
     * Constant for value 'ABL'
     * Meta informations extracted from the WSDL
     * - documentation : eScore: request for credit assessment before concluding a lease or rental contract (chattels)
     * @return string 'ABL'
     */
    const VALUE_ABL = 'ABL';
    /**
     * Constant for value 'BKV'
     * Meta informations extracted from the WSDL
     * - documentation : eScore: credit assessment before granting of credit
     * @return string 'BKV'
     */
    const VALUE_BKV = 'BKV';
    /**
     * Constant for value 'BKE'
     * Meta informations extracted from the WSDL
     * - documentation : eScore: credit assessment before opening an account
     * @return string 'BKE'
     */
    const VALUE_BKE = 'BKE';
    /**
     * Constant for value 'BKA'
     * Meta informations extracted from the WSDL
     * - documentation : eScore: credit assessment due to a credit or customer card application
     * @return string 'BKA'
     */
    const VALUE_BKA = 'BKA';
    /**
     * Constant for value 'BBS'
     * Meta informations extracted from the WSDL
     * - documentation : eScore: credit assessment before concluding a building loan contract
     * @return string 'BBS'
     */
    const VALUE_BBS = 'BBS';
    /**
     * Constant for value 'BMV'
     * Meta informations extracted from the WSDL
     * - documentation : eScore: credit assessment before concluding a rental contract (real estate)
     * @return string 'BMV'
     */
    const VALUE_BMV = 'BMV';
    /**
     * Constant for value 'BFV'
     * Meta informations extracted from the WSDL
     * - documentation : eScore: credit assessment before concluding a franchising contract
     * @return string 'BFV'
     */
    const VALUE_BFV = 'BFV';
    /**
     * Constant for value 'BER'
     * Meta informations extracted from the WSDL
     * - documentation : eScore: credit assessment due to ascertainment order (credit agency company)
     * @return string 'BER'
     */
    const VALUE_BER = 'BER';
    /**
     * Constant for value 'creditRequest'
     * Meta informations extracted from the WSDL
     * - documentation : Bürgel: credit request - Kreditanfrage
     * @return string 'creditRequest'
     */
    const VALUE_CREDITREQUEST = 'creditRequest';
    /**
     * Constant for value 'businessInitiation'
     * Meta informations extracted from the WSDL
     * - documentation : Bürgel: business initiation - Geschäftsanbahnung
     * @return string 'businessInitiation'
     */
    const VALUE_BUSINESSINITIATION = 'businessInitiation';
    /**
     * Constant for value 'creditAssessment'
     * Meta informations extracted from the WSDL
     * - documentation : Bürgel: credit assessment - Bonitätsprüfung
     * @return string 'creditAssessment'
     */
    const VALUE_CREDITASSESSMENT = 'creditAssessment';
    /**
     * Constant for value 'claim'
     * Meta informations extracted from the WSDL
     * - documentation : Bürgel: claim - Forderung
     * @return string 'claim'
     */
    const VALUE_CLAIM = 'claim';
    /**
     * Return true if value is allowed
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_ReasonEnum::VALUE_ABK
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_ReasonEnum::VALUE_ABV
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_ReasonEnum::VALUE_BZV
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_ReasonEnum::VALUE_BMT
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_ReasonEnum::VALUE_BFT
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_ReasonEnum::VALUE_ABI
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_ReasonEnum::VALUE_ABF
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_ReasonEnum::VALUE_ABD
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_ReasonEnum::VALUE_ABW
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_ReasonEnum::VALUE_ABL
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_ReasonEnum::VALUE_BKV
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_ReasonEnum::VALUE_BKE
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_ReasonEnum::VALUE_BKA
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_ReasonEnum::VALUE_BBS
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_ReasonEnum::VALUE_BMV
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_ReasonEnum::VALUE_BFV
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_ReasonEnum::VALUE_BER
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_ReasonEnum::VALUE_CREDITREQUEST
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_ReasonEnum::VALUE_BUSINESSINITIATION
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_ReasonEnum::VALUE_CREDITASSESSMENT
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_ReasonEnum::VALUE_CLAIM
     * @param mixed $_value value
     * @return bool true|false
     */
    public static function valueIsValid($_value)
    {
        return in_array($_value,array(Egovs_Paymentbase_Model_Payplace_Enum_ReasonEnum::VALUE_ABK,Egovs_Paymentbase_Model_Payplace_Enum_ReasonEnum::VALUE_ABV,Egovs_Paymentbase_Model_Payplace_Enum_ReasonEnum::VALUE_BZV,Egovs_Paymentbase_Model_Payplace_Enum_ReasonEnum::VALUE_BMT,Egovs_Paymentbase_Model_Payplace_Enum_ReasonEnum::VALUE_BFT,Egovs_Paymentbase_Model_Payplace_Enum_ReasonEnum::VALUE_ABI,Egovs_Paymentbase_Model_Payplace_Enum_ReasonEnum::VALUE_ABF,Egovs_Paymentbase_Model_Payplace_Enum_ReasonEnum::VALUE_ABD,Egovs_Paymentbase_Model_Payplace_Enum_ReasonEnum::VALUE_ABW,Egovs_Paymentbase_Model_Payplace_Enum_ReasonEnum::VALUE_ABL,Egovs_Paymentbase_Model_Payplace_Enum_ReasonEnum::VALUE_BKV,Egovs_Paymentbase_Model_Payplace_Enum_ReasonEnum::VALUE_BKE,Egovs_Paymentbase_Model_Payplace_Enum_ReasonEnum::VALUE_BKA,Egovs_Paymentbase_Model_Payplace_Enum_ReasonEnum::VALUE_BBS,Egovs_Paymentbase_Model_Payplace_Enum_ReasonEnum::VALUE_BMV,Egovs_Paymentbase_Model_Payplace_Enum_ReasonEnum::VALUE_BFV,Egovs_Paymentbase_Model_Payplace_Enum_ReasonEnum::VALUE_BER,Egovs_Paymentbase_Model_Payplace_Enum_ReasonEnum::VALUE_CREDITREQUEST,Egovs_Paymentbase_Model_Payplace_Enum_ReasonEnum::VALUE_BUSINESSINITIATION,Egovs_Paymentbase_Model_Payplace_Enum_ReasonEnum::VALUE_CREDITASSESSMENT,Egovs_Paymentbase_Model_Payplace_Enum_ReasonEnum::VALUE_CLAIM));
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
