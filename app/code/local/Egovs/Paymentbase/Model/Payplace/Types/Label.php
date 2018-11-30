<?php
/**
 * File for class Egovs_Paymentbase_Model_Payplace_Types_Label
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
/**
 * This class stands for Egovs_Paymentbase_Model_Payplace_Types_Label originally named label
 * Documentation : Custom label to be displayed in the form instead of the standard text. Currently possible for the keys 'submit' and 'cancel' for the submit and cancel buttons. Label, which precedes additional text (field text) on the giropay login page.
 * Meta informations extracted from the WSDL
 * - from schema : file:///etc/Callback.wsdl
 * - maxLength : 30
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
class Egovs_Paymentbase_Model_Payplace_Types_Label extends Egovs_Paymentbase_Model_Payplace_WsdlClass
{
    /**
     * The _
     * @var string
     */
    public $_;
    /**
     * The key
     * @var string
     */
    public $key;
    /**
     * Constructor method for label
     * @see parent::__construct()
     * @param string $__
     * @param string $_key
     * @return Egovs_Paymentbase_Model_Payplace_Types_Label
     */
    public function __construct($__ = NULL,$_key = NULL)
    {
        parent::__construct(array('_'=>$__,'key'=>$_key),false);
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
     * Get key value
     * @return string|null
     */
    public function getKey()
    {
        return $this->key;
    }
    /**
     * Set key value
     * @param string $_key the key
     * @return bool
     */
    public function setKey($_key)
    {
        return ($this->key = $_key);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @uses Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @param array $_array the exported values
     * @return Egovs_Paymentbase_Model_Payplace_Types_Label
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
