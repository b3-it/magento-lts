<?php
/**
 * File for class Egovs_Paymentbase_Model_Payplace_Enum_Customer_TitleEnum
 * @package Egovs_Paymentbase
 * @subpackage Enumerations
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
/**
 * This class stands for Egovs_Paymentbase_Model_Payplace_Enum_Customer_TitleEnum originally named customerTitleEnum
 * Meta informations extracted from the WSDL
 * - from schema : file:///etc/Callback.wsdl
 * @package Egovs_Paymentbase
 * @subpackage Enumerations
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
class Egovs_Paymentbase_Model_Payplace_Enum_Customer_TitleEnum extends Egovs_Paymentbase_Model_Payplace_WsdlClass
{
    /**
     * Constant for value 'Mr.'
     * @return string 'Mr.'
     */
    const VALUE_MR_ = 'Mr.';
    /**
     * Constant for value 'Mrs.'
     * @return string 'Mrs.'
     */
    const VALUE_MRS_ = 'Mrs.';
    /**
     * Constant for value 'Company'
     * @return string 'Company'
     */
    const VALUE_COMPANY = 'Company';
    /**
     * Return true if value is allowed
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_Customer_TitleEnum::VALUE_MR_
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_Customer_TitleEnum::VALUE_MRS_
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_Customer_TitleEnum::VALUE_COMPANY
     * @param mixed $_value value
     * @return bool true|false
     */
    public static function valueIsValid($_value)
    {
        return in_array($_value,array(Egovs_Paymentbase_Model_Payplace_Enum_Customer_TitleEnum::VALUE_MR_,Egovs_Paymentbase_Model_Payplace_Enum_Customer_TitleEnum::VALUE_MRS_,Egovs_Paymentbase_Model_Payplace_Enum_Customer_TitleEnum::VALUE_COMPANY));
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
