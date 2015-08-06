<?php
/**
 * File for class Egovs_Paymentbase_Model_Payplace_Types_Panalias
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
/**
 * This class stands for Egovs_Paymentbase_Model_Payplace_Types_Panalias originally named panalias
 * Documentation : An alias for creditcard's pan and expiry.
 * Meta informations extracted from the WSDL
 * - from schema : file:///etc/Callback.wsdl
 * - maxLength : 50
 * - minLength : 0
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
class Egovs_Paymentbase_Model_Payplace_Types_Panalias extends Egovs_Paymentbase_Model_Payplace_WsdlClass
{
    /**
     * The _
     * Meta informations extracted from the WSDL
     * - maxLength : 50
     * - minLength : 0
     * @var string
     */
    public $_;
    /**
     * The generate
     * Meta informations extracted from the WSDL
     * - default : false
     * - documentation : If "true" alias will be generated.
     * - use : optional
     * @var boolean
     */
    public $generate;
    /**
     * Constructor method for panalias
     * @see parent::__construct()
     * @param string $__
     * @param boolean $_generate
     * @return Egovs_Paymentbase_Model_Payplace_Types_Panalias
     */
    public function __construct($__ = NULL,$_generate = false)
    {
        parent::__construct(array('_'=>$__,'generate'=>$_generate),false);
    }
    /**
     * Get _ value
     * @return string|null
     */
    public function get_()
    {
        return $this->_;
    }
    /**
     * Set _ value
     * @param string $__ the _
     * @return string
     */
    public function set_($__)
    {
        return ($this->_ = $__);
    }
    /**
     * Get generate value
     * @return boolean|null
     */
    public function getGenerate()
    {
        return $this->generate;
    }
    /**
     * Set generate value
     * @param boolean $_generate the generate
     * @return boolean
     */
    public function setGenerate($_generate)
    {
        return ($this->generate = $_generate);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @uses Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @param array $_array the exported values
     * @return Egovs_Paymentbase_Model_Payplace_Types_Panalias
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
