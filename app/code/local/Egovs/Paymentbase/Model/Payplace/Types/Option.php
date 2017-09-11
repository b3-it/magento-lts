<?php
/**
 * File for class Egovs_Paymentbase_Model_Payplace_Types_Option
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
/**
 * This class stands for Egovs_Paymentbase_Model_Payplace_Types_Option originally named option
 * Documentation : In future versions this element will allow to influence details of the response or the transaction.
 * Meta informations extracted from the WSDL
 * - from schema : file:///etc/Callback.wsdl
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
class Egovs_Paymentbase_Model_Payplace_Types_Option extends Egovs_Paymentbase_Model_Payplace_WsdlClass
{
    /**
     * The name
     * Meta informations extracted from the WSDL
     * - use : required
     * @var string
     */
    public $name;
    /**
     * Constructor method for option
     * @see parent::__construct()
     * @param string $_name
     * @return Egovs_Paymentbase_Model_Payplace_Types_Option
     */
    public function __construct($_name)
    {
        parent::__construct(array('name'=>$_name),false);
    }
    /**
     * Get name value
     * @return Egovs_Paymentbase_Model_Payplace_Types_Option
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Set name value
     * @param string $_name the name
     * @return bool
     */
    public function setName($_name)
    {
        return ($this->name = $_name);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @uses Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @param array $_array the exported values
     * @return Egovs_Paymentbase_Model_Payplace_Types_Option
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
