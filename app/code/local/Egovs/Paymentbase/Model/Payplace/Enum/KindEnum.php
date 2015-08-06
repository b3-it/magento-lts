<?php
/**
 * File for class Egovs_Paymentbase_Model_Payplace_Enum_KindEnum
 * @package Egovs_Paymentbase
 * @subpackage Enumerations
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
/**
 * This class stands for Egovs_Paymentbase_Model_Payplace_Enum_KindEnum originally named kindEnum
 * Meta informations extracted from the WSDL
 * - from schema : file:///etc/Callback.wsdl
 * @package Egovs_Paymentbase
 * @subpackage Enumerations
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
class Egovs_Paymentbase_Model_Payplace_Enum_KindEnum extends Egovs_Paymentbase_Model_Payplace_WsdlClass
{
    /**
     * Constant for value 'cic'
     * @return string 'cic'
     */
    const VALUE_CIC = 'cic';
    /**
     * Constant for value 'creditcard'
     * @return string 'creditcard'
     */
    const VALUE_CREDITCARD = 'creditcard';
    /**
     * Constant for value 'creditcard-3dsecure'
     * @return string 'creditcard-3dsecure'
     */
    const VALUE_CREDITCARD_3DSECURE = 'creditcard-3dsecure';
    /**
     * Constant for value 'debit'
     * @return string 'debit'
     */
    const VALUE_DEBIT = 'debit';
    /**
     * Constant for value 'debit-checklist'
     * @return string 'debit-checklist'
     */
    const VALUE_DEBIT_CHECKLIST = 'debit-checklist';
    /**
     * Constant for value 'giropay'
     * @return string 'giropay'
     */
    const VALUE_GIROPAY = 'giropay';
    /**
     * Constant for value 'maestro'
     * @return string 'maestro'
     */
    const VALUE_MAESTRO = 'maestro';
    /**
     * Constant for value 'paypal'
     * @return string 'paypal'
     */
    const VALUE_PAYPAL = 'paypal';
    /**
     * Constant for value 'scoring'
     * @return string 'scoring'
     */
    const VALUE_SCORING = 'scoring';
    /**
     * Return true if value is allowed
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_KindEnum::VALUE_CIC
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_KindEnum::VALUE_CREDITCARD
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_KindEnum::VALUE_CREDITCARD_3DSECURE
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_KindEnum::VALUE_DEBIT
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_KindEnum::VALUE_DEBIT_CHECKLIST
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_KindEnum::VALUE_GIROPAY
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_KindEnum::VALUE_MAESTRO
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_KindEnum::VALUE_PAYPAL
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_KindEnum::VALUE_SCORING
     * @param mixed $_value value
     * @return bool true|false
     */
    public static function valueIsValid($_value)
    {
        return in_array($_value,array(Egovs_Paymentbase_Model_Payplace_Enum_KindEnum::VALUE_CIC,Egovs_Paymentbase_Model_Payplace_Enum_KindEnum::VALUE_CREDITCARD,Egovs_Paymentbase_Model_Payplace_Enum_KindEnum::VALUE_CREDITCARD_3DSECURE,Egovs_Paymentbase_Model_Payplace_Enum_KindEnum::VALUE_DEBIT,Egovs_Paymentbase_Model_Payplace_Enum_KindEnum::VALUE_DEBIT_CHECKLIST,Egovs_Paymentbase_Model_Payplace_Enum_KindEnum::VALUE_GIROPAY,Egovs_Paymentbase_Model_Payplace_Enum_KindEnum::VALUE_MAESTRO,Egovs_Paymentbase_Model_Payplace_Enum_KindEnum::VALUE_PAYPAL,Egovs_Paymentbase_Model_Payplace_Enum_KindEnum::VALUE_SCORING));
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
