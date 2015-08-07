<?php
/**
 * File for class Egovs_Paymentbase_Model_Payplace_Enum_Action
 * @package Egovs_Paymentbase
 * @subpackage Enumerations
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
/**
 * This class stands for Egovs_Paymentbase_Model_Payplace_Enum_Action originally named action
 * Meta informations extracted from the WSDL
 * - from schema : file:///etc/Callback.wsdl
 * @package Egovs_Paymentbase
 * @subpackage Enumerations
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
class Egovs_Paymentbase_Model_Payplace_Enum_Action extends Egovs_Paymentbase_Model_Payplace_WsdlClass
{
    /**
     * Constant for value 'preauthorization'
     * @return string 'preauthorization'
     */
    const VALUE_PREAUTHORIZATION = 'preauthorization';
    /**
     * Constant for value 'authorization'
     * @return string 'authorization'
     */
    const VALUE_AUTHORIZATION = 'authorization';
    /**
     * Constant for value 'capture'
     * @return string 'capture'
     */
    const VALUE_CAPTURE = 'capture';
    /**
     * Constant for value 'refund'
     * @return string 'refund'
     */
    const VALUE_REFUND = 'refund';
    /**
     * Constant for value 'reversal'
     * @return string 'reversal'
     */
    const VALUE_REVERSAL = 'reversal';
    /**
     * Constant for value 'credit'
     * @return string 'credit'
     */
    const VALUE_CREDIT = 'credit';
    /**
     * Constant for value 'avs'
     * @return string 'avs'
     */
    const VALUE_AVS = 'avs';
    /**
     * Constant for value 'payment'
     * @return string 'payment'
     */
    const VALUE_PAYMENT = 'payment';
    /**
     * Constant for value 'avspayment'
     * @return string 'avspayment'
     */
    const VALUE_AVSPAYMENT = 'avspayment';
    /**
     * Return true if value is allowed
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_Action::VALUE_PREAUTHORIZATION
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_Action::VALUE_AUTHORIZATION
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_Action::VALUE_CAPTURE
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_Action::VALUE_REFUND
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_Action::VALUE_REVERSAL
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_Action::VALUE_CREDIT
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_Action::VALUE_AVS
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_Action::VALUE_PAYMENT
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_Action::VALUE_AVSPAYMENT
     * @param mixed $_value value
     * @return bool true|false
     */
    public static function valueIsValid($_value)
    {
        return in_array($_value,array(Egovs_Paymentbase_Model_Payplace_Enum_Action::VALUE_PREAUTHORIZATION,Egovs_Paymentbase_Model_Payplace_Enum_Action::VALUE_AUTHORIZATION,Egovs_Paymentbase_Model_Payplace_Enum_Action::VALUE_CAPTURE,Egovs_Paymentbase_Model_Payplace_Enum_Action::VALUE_REFUND,Egovs_Paymentbase_Model_Payplace_Enum_Action::VALUE_REVERSAL,Egovs_Paymentbase_Model_Payplace_Enum_Action::VALUE_CREDIT,Egovs_Paymentbase_Model_Payplace_Enum_Action::VALUE_AVS,Egovs_Paymentbase_Model_Payplace_Enum_Action::VALUE_PAYMENT,Egovs_Paymentbase_Model_Payplace_Enum_Action::VALUE_AVSPAYMENT));
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
