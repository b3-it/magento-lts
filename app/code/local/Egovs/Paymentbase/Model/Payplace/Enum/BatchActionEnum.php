<?php
/**
 * File for class Egovs_Paymentbase_Model_Payplace_Enum_BatchActionEnum
 * @package Egovs_Paymentbase
 * @subpackage Enumerations
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
/**
 * This class stands for Egovs_Paymentbase_Model_Payplace_Enum_BatchActionEnum originally named batchActionEnum
 * Documentation : Action for batches.
 * Meta informations extracted from the WSDL
 * - from schema : file:///etc/Callback.wsdl
 * @package Egovs_Paymentbase
 * @subpackage Enumerations
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
class Egovs_Paymentbase_Model_Payplace_Enum_BatchActionEnum extends Egovs_Paymentbase_Model_Payplace_WsdlClass
{
    /**
     * Constant for value 'open'
     * @return string 'open'
     */
    const VALUE_OPEN = 'open';
    /**
     * Constant for value 'close'
     * @return string 'close'
     */
    const VALUE_CLOSE = 'close';
    /**
     * Return true if value is allowed
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_BatchActionEnum::VALUE_OPEN
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_BatchActionEnum::VALUE_CLOSE
     * @param mixed $_value value
     * @return bool true|false
     */
    public static function valueIsValid($_value)
    {
        return in_array($_value,array(Egovs_Paymentbase_Model_Payplace_Enum_BatchActionEnum::VALUE_OPEN,Egovs_Paymentbase_Model_Payplace_Enum_BatchActionEnum::VALUE_CLOSE));
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
