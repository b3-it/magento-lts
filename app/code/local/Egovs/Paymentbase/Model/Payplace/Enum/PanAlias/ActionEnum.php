<?php
/**
 * File for class Egovs_Paymentbase_Model_Payplace_Enum_PanAlias_ActionEnum
 * @package Egovs_Paymentbase
 * @subpackage Enumerations
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
/**
 * This class stands for Egovs_Paymentbase_Model_Payplace_Enum_PanAlias_ActionEnum originally named panAliasActionEnum
 * Documentation : Action for pan-alias requests.
 * Meta informations extracted from the WSDL
 * - from schema : file:///etc/Callback.wsdl
 * @package Egovs_Paymentbase
 * @subpackage Enumerations
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
class Egovs_Paymentbase_Model_Payplace_Enum_PanAlias_ActionEnum extends Egovs_Paymentbase_Model_Payplace_WsdlClass
{
    /**
     * Constant for value 'create'
     * @return string 'create'
     */
    const VALUE_CREATE = 'create';
    /**
     * Constant for value 'remove'
     * @return string 'remove'
     */
    const VALUE_REMOVE = 'remove';
    /**
     * Constant for value 'exists'
     * @return string 'exists'
     */
    const VALUE_EXISTS = 'exists';
    /**
     * Constant for value 'info'
     * @return string 'info'
     */
    const VALUE_INFO = 'info';
    /**
     * Return true if value is allowed
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_PanAlias_ActionEnum::VALUE_CREATE
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_PanAlias_ActionEnum::VALUE_REMOVE
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_PanAlias_ActionEnum::VALUE_EXISTS
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_PanAlias_ActionEnum::VALUE_INFO
     * @param mixed $_value value
     * @return bool true|false
     */
    public static function valueIsValid($_value)
    {
        return in_array($_value,array(Egovs_Paymentbase_Model_Payplace_Enum_PanAlias_ActionEnum::VALUE_CREATE,Egovs_Paymentbase_Model_Payplace_Enum_PanAlias_ActionEnum::VALUE_REMOVE,Egovs_Paymentbase_Model_Payplace_Enum_PanAlias_ActionEnum::VALUE_EXISTS,Egovs_Paymentbase_Model_Payplace_Enum_PanAlias_ActionEnum::VALUE_INFO));
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
