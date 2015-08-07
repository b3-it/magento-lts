<?php
/**
 * File for class Egovs_Paymentbase_Model_Payplace_Enum_DebitModeEnum
 * @package Egovs_Paymentbase
 * @subpackage Enumerations
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
/**
 * This class stands for Egovs_Paymentbase_Model_Payplace_Enum_DebitModeEnum originally named debitModeEnum
 * Meta informations extracted from the WSDL
 * - from schema : file:///etc/Callback.wsdl
 * @package Egovs_Paymentbase
 * @subpackage Enumerations
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
class Egovs_Paymentbase_Model_Payplace_Enum_DebitModeEnum extends Egovs_Paymentbase_Model_Payplace_WsdlClass
{
    /**
     * Constant for value 'debitOrder'
     * Meta informations extracted from the WSDL
     * - documentation : Debit due to a debit order.
     * @return string 'debitOrder'
     */
    const VALUE_DEBITORDER = 'debitOrder';
    /**
     * Constant for value 'directDebit'
     * Meta informations extracted from the WSDL
     * - documentation : Debit due to a direct debit authorisation.
     * @return string 'directDebit'
     */
    const VALUE_DIRECTDEBIT = 'directDebit';
    /**
     * Constant for value 'sepaCore'
     * Meta informations extracted from the WSDL
     * - documentation : SEPA Core direct debit (default is SDD COR1).
     * @return string 'sepaCore'
     */
    const VALUE_SEPACORE = 'sepaCore';
    /**
     * Return true if value is allowed
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_DebitModeEnum::VALUE_DEBITORDER
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_DebitModeEnum::VALUE_DIRECTDEBIT
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_DebitModeEnum::VALUE_SEPACORE
     * @param mixed $_value value
     * @return bool true|false
     */
    public static function valueIsValid($_value)
    {
        return in_array($_value,array(Egovs_Paymentbase_Model_Payplace_Enum_DebitModeEnum::VALUE_DEBITORDER,Egovs_Paymentbase_Model_Payplace_Enum_DebitModeEnum::VALUE_DIRECTDEBIT,Egovs_Paymentbase_Model_Payplace_Enum_DebitModeEnum::VALUE_SEPACORE));
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
