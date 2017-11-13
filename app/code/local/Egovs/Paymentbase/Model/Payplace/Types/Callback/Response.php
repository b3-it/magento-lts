<?php
/**
 * File for class Egovs_Paymentbase_Model_Payplace_Types_Callback_Response
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
/**
 * This class stands for Egovs_Paymentbase_Model_Payplace_Types_Callback_Response originally named callbackResponse
 * Documentation : Root element of a callback response.
 * Meta informations extracted from the WSDL
 * - from schema : file:///etc/Callback.wsdl
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
class Egovs_Paymentbase_Model_Payplace_Types_Callback_Response extends Egovs_Paymentbase_Model_Payplace_WsdlClass
{
    /**
     * The ref
     * Meta informations extracted from the WSDL
     * - documentation : This reference makes it easier to assign a response to a request. This attribute will be copied from the "id" attribute of the request, if it has been provided.
     * @var string
     */
    public $ref;
    /**
     * The version
     * @var string
     */
    public $version;
    /**
     * Constructor method for callbackResponse
     * @see parent::__construct()
     * @param string $_ref
     * @param string $_version
     * @return Egovs_Paymentbase_Model_Payplace_Types_Callback_Response
     */
    public function __construct($_ref = NULL,$_version = NULL)
    {
        parent::__construct(array('ref'=>$_ref,'version'=>$_version),false);
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
     * Get version value
     * @return string|null
     */
    public function getVersion()
    {
        return $this->version;
    }
    /**
     * Set version value
     * @param string $_version the version
     * @return bool
     */
    public function setVersion($_version)
    {
        return ($this->version = $_version);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @uses Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @param array $_array the exported values
     * @return Egovs_Paymentbase_Model_Payplace_Types_Callback_Response
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
