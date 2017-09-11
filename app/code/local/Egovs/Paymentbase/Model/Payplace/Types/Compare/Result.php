<?php
/**
 * File for class Egovs_Paymentbase_Model_Payplace_Types_Compare_Result
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
/**
 * This class stands for Egovs_Paymentbase_Model_Payplace_Types_Compare_Result originally named compareResult
 * Documentation : Result of a comparison.
 * Meta informations extracted from the WSDL
 * - from schema : file:///etc/Callback.wsdl
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
class Egovs_Paymentbase_Model_Payplace_Types_Compare_Result extends Egovs_Paymentbase_Model_Payplace_Enum_CheckResultEnum
{
    /**
     * The _
     * @var Egovs_Paymentbase_Model_Payplace_Enum_CheckResultEnum
     */
    public $_;
    /**
     * The ref
     * @var string
     */
    public $ref;
    /**
     * Constructor method for compareResult
     * @see parent::__construct()
     * @param Egovs_Paymentbase_Model_Payplace_Enum_CheckResultEnum $__
     * @param string $_ref
     * @return Egovs_Paymentbase_Model_Payplace_Types_Compare_Result
     */
    public function __construct($__ = NULL,$_ref = NULL)
    {
        Egovs_Paymentbase_Model_Payplace_WsdlClass::__construct(array('_'=>$__,'ref'=>$_ref),false);
    }
    /**
     * Get _ value
     * @return Egovs_Paymentbase_Model_Payplace_Enum_CheckResultEnum|null
     */
    public function get_()
    {
        return $this->_;
    }
    /**
     * Set _ value
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_CheckResultEnum::valueIsValid()
     * @param Egovs_Paymentbase_Model_Payplace_Enum_CheckResultEnum $__ the _
     * @return Egovs_Paymentbase_Model_Payplace_Enum_CheckResultEnum
     */
    public function set_($__)
    {
        if(!Egovs_Paymentbase_Model_Payplace_Enum_CheckResultEnum::valueIsValid($__))
        {
            return false;
        }
        return ($this->_ = $__);
    }
    /**
     * Get ref value
     * @return string|null
     */
    public function getRef()
    {
        return $this->ref;
    }
    /**
     * Set ref value
     * @param string $_ref the ref
     * @return bool
     */
    public function setRef($_ref)
    {
        return ($this->ref = $_ref);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @uses Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @param array $_array the exported values
     * @return Egovs_Paymentbase_Model_Payplace_Types_Compare_Result
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
