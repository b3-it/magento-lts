<?php
/**
 * File for class Egovs_Paymentbase_Model_Payplace_Types_AdditionalCheckResult
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
/**
 * This class stands for Egovs_Paymentbase_Model_Payplace_Types_AdditionalCheckResult originally named additionalCheckResult
 * Meta informations extracted from the WSDL
 * - from schema : file:///etc/Callback.wsdl
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
class Egovs_Paymentbase_Model_Payplace_Types_Additional_Check_Result extends Egovs_Paymentbase_Model_Payplace_WsdlClass
{
    /**
     * The compareResult
     * @var Egovs_Paymentbase_Model_Payplace_Types_Compare_Result
     */
    public $compareResult;
    /**
     * Constructor method for additionalCheckResult
     * @see parent::__construct()
     * @param Egovs_Paymentbase_Model_Payplace_Types_Compare_Result $_compareResult
     * @return Egovs_Paymentbase_Model_Payplace_Types_Additional_Check_Result
     */
    public function __construct($_compareResult = NULL)
    {
        parent::__construct(array('compareResult'=>$_compareResult),false);
    }
    /**
     * Get compareResult value
     * @return Egovs_Paymentbase_Model_Payplace_Types_Compare_Result|null
     */
    public function getCompareResult()
    {
        return $this->compareResult;
    }
    /**
     * Set compareResult value
     * @param Egovs_Paymentbase_Model_Payplace_Types_Compare_Result $_compareResult the compareResult
     * @return Egovs_Paymentbase_Model_Payplace_Types_Compare_Result
     */
    public function setCompareResult($_compareResult)
    {
        return ($this->compareResult = $_compareResult);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @uses Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @param array $_array the exported values
     * @return Egovs_Paymentbase_Model_Payplace_Types_Additional_Check_Result
     */
    public static function __set_state(array $_array,$_className = __CLASS__)
    {
        return parent::__set_state($_array,$_className);
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
