<?php
/**
 * File for class Egovs_Paymentbase_Model_Payplace_Types_Base_Response
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
/**
 * This class stands for Egovs_Paymentbase_Model_Payplace_Types_Base_Response originally named baseResponse
 * Meta informations extracted from the WSDL
 * - from schema : file:///etc/Callback.wsdl
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
class Egovs_Paymentbase_Model_Payplace_Types_Base_Response extends Egovs_Paymentbase_Model_Payplace_WsdlClass
{
    /**
     * The ref
     * Meta informations extracted from the WSDL
     * - use : optional
     * @var string
     */
    public $ref;
    /**
     * Constructor method for baseResponse
     * @see parent::__construct()
     * @param string $_ref
     * @return Egovs_Paymentbase_Model_Payplace_Types_Base_Response
     */
    public function __construct($_ref = NULL)
    {
        parent::__construct(array('ref'=>$_ref),false);
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
     * @return Egovs_Paymentbase_Model_Payplace_Types_Base_Response
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
