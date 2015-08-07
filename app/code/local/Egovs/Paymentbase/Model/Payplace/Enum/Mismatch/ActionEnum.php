<?php
/**
 * File for class Egovs_Paymentbase_Model_Payplace_Enum_Mismatch_ActionEnum
 * @package Egovs_Paymentbase
 * @subpackage Enumerations
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
/**
 * This class stands for Egovs_Paymentbase_Model_Payplace_Enum_Mismatch_ActionEnum originally named mismatchActionEnum
 * Meta informations extracted from the WSDL
 * - from schema : file:///etc/Callback.wsdl
 * @package Egovs_Paymentbase
 * @subpackage Enumerations
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
class Egovs_Paymentbase_Model_Payplace_Enum_Mismatch_ActionEnum extends Egovs_Paymentbase_Model_Payplace_WsdlClass
{
    /**
     * Constant for value 'notify'
     * Meta informations extracted from the WSDL
     * - documentation : The shop will be informed if an additional check fails.
     * @return string 'notify'
     */
    const VALUE_NOTIFY = 'notify';
    /**
     * Constant for value 'reject'
     * Meta informations extracted from the WSDL
     * - documentation : The transaction will be aborted if an additional check fails.
     * @return string 'reject'
     */
    const VALUE_REJECT = 'reject';
    /**
     * Return true if value is allowed
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_Mismatch_ActionEnum::VALUE_NOTIFY
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_Mismatch_ActionEnum::VALUE_REJECT
     * @param mixed $_value value
     * @return bool true|false
     */
    public static function valueIsValid($_value)
    {
        return in_array($_value,array(Egovs_Paymentbase_Model_Payplace_Enum_Mismatch_ActionEnum::VALUE_NOTIFY,Egovs_Paymentbase_Model_Payplace_Enum_Mismatch_ActionEnum::VALUE_REJECT));
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
