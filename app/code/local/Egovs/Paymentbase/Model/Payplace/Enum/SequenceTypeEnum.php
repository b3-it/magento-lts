<?php
/**
 * File for class Egovs_Paymentbase_Model_Payplace_Enum_SequenceTypeEnum
 * @package Egovs_Paymentbase
 * @subpackage Enumerations
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
/**
 * This class stands for Egovs_Paymentbase_Model_Payplace_Enum_SequenceTypeEnum originally named sequenceTypeEnum
 * Documentation : SEPA payment sequence type
 * Meta informations extracted from the WSDL
 * - from schema : file:///etc/Callback.wsdl
 * @package Egovs_Paymentbase
 * @subpackage Enumerations
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
class Egovs_Paymentbase_Model_Payplace_Enum_SequenceTypeEnum extends Egovs_Paymentbase_Model_Payplace_WsdlClass
{
    /**
     * Constant for value 'oneoff'
     * Meta informations extracted from the WSDL
     * - documentation : Single payment, the default
     * @return string 'oneoff'
     */
    const VALUE_ONEOFF = 'oneoff';
    /**
     * Constant for value 'first'
     * Meta informations extracted from the WSDL
     * - documentation : First payment of a sequence
     * @return string 'first'
     */
    const VALUE_FIRST = 'first';
    /**
     * Constant for value 'recurring'
     * Meta informations extracted from the WSDL
     * - documentation : Follow-up payment
     * @return string 'recurring'
     */
    const VALUE_RECURRING = 'recurring';
    /**
     * Constant for value 'final'
     * Meta informations extracted from the WSDL
     * - documentation : Last payment of a sequence
     * @return string 'final'
     */
    const VALUE_FINAL = 'final';
    /**
     * Return true if value is allowed
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_SequenceTypeEnum::VALUE_ONEOFF
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_SequenceTypeEnum::VALUE_FIRST
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_SequenceTypeEnum::VALUE_RECURRING
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_SequenceTypeEnum::VALUE_FINAL
     * @param mixed $_value value
     * @return bool true|false
     */
    public static function valueIsValid($_value)
    {
        return in_array($_value,array(Egovs_Paymentbase_Model_Payplace_Enum_SequenceTypeEnum::VALUE_ONEOFF,Egovs_Paymentbase_Model_Payplace_Enum_SequenceTypeEnum::VALUE_FIRST,Egovs_Paymentbase_Model_Payplace_Enum_SequenceTypeEnum::VALUE_RECURRING,Egovs_Paymentbase_Model_Payplace_Enum_SequenceTypeEnum::VALUE_FINAL));
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
