<?php
/**
 * File for class Egovs_Paymentbase_Model_Payplace_Types_Form_Service_Response
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
/**
 * This class stands for Egovs_Paymentbase_Model_Payplace_Types_Form_Service_Response originally named formServiceResponse
 * Meta informations extracted from the WSDL
 * - from schema : file:///etc/Callback.wsdl
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
class Egovs_Paymentbase_Model_Payplace_Types_Form_Service_Response extends Egovs_Paymentbase_Model_Payplace_Types_Base_Response
{
    /**
     * The redirectURL
     * @var anyURI
     */
    public $redirectURL;
    /**
     * Constructor method for formServiceResponse
     * @see parent::__construct()
     * @param anyURI $_redirectURL
     * @return Egovs_Paymentbase_Model_Payplace_Types_Form_Service_Response
     */
    public function __construct($_redirectURL = NULL)
    {
        Egovs_Paymentbase_Model_Payplace_WsdlClass::__construct(array('redirectURL'=>$_redirectURL),false);
    }
    /**
     * Get redirectURL value
     * @return anyURI|null
     */
    public function getRedirectURL()
    {
        return $this->redirectURL;
    }
    /**
     * Set redirectURL value
     * @param anyURI $_redirectURL the redirectURL
     * @return anyURI
     */
    public function setRedirectURL($_redirectURL)
    {
        return ($this->redirectURL = $_redirectURL);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @uses Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @param array $_array the exported values
     * @return Egovs_Paymentbase_Model_Payplace_Types_Form_Service_Response
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
