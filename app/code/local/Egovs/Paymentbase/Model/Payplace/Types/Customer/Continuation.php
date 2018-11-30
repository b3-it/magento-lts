<?php
/**
 * File for class Egovs_Paymentbase_Model_Payplace_Types_Customer_Continuation
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
/**
 * This class stands for Egovs_Paymentbase_Model_Payplace_Types_Customer_Continuation originally named customerContinuation
 * Documentation : Includes data for redirecting a customer after a form service payment. If not provided, the URL for a successful transaction will be used. If not provided, the URL for a successful transaction will be used
 * Meta informations extracted from the WSDL
 * - from schema : file:///etc/Callback.wsdl
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
class Egovs_Paymentbase_Model_Payplace_Types_Customer_Continuation extends Egovs_Paymentbase_Model_Payplace_WsdlClass
{
    /**
     * The successURL
     * @var string
     */
    public $successURL;
    /**
     * The errorURL
     * @var string
     */
    public $errorURL;
    /**
     * The notificationFailedURL
     * @var string
     */
    public $notificationFailedURL;
    /**
     * The redirect
     * Meta informations extracted from the WSDL
     * - default : false
     * - documentation : If "true" the customer will be redirected directly. If "false" a page with a link "back to the shop" is shown to the customer.
     * @var boolean
     */
    public $redirect;
    /**
     * Constructor method for customerContinuation
     * @see parent::__construct()
     * @param string $_successURL
     * @param string $_errorURL
     * @param string $_notificationFailedURL
     * @param boolean $_redirect
     * @return Egovs_Paymentbase_Model_Payplace_Types_Customer_Continuation
     */
    public function __construct($_successURL = NULL,$_errorURL = NULL,$_notificationFailedURL = NULL,$_redirect = false)
    {
        parent::__construct(array('successURL'=>$_successURL,'errorURL'=>$_errorURL,'notificationFailedURL'=>$_notificationFailedURL,'redirect'=>$_redirect),false);
    }
    /**
     * Get successURL value
     * @return string|null
     */
    public function getSuccessURL()
    {
        return $this->successURL;
    }
    /**
     * Set successURL value
     * @param string $_successURL the successURL
     * @return bool
     */
    public function setSuccessURL($_successURL)
    {
        return ($this->successURL = $_successURL);
    }
    /**
     * Get errorURL value
     * @return string|null
     */
    public function getErrorURL()
    {
        return $this->errorURL;
    }
    /**
     * Set errorURL value
     * @param string $_errorURL the errorURL
     * @return bool
     */
    public function setErrorURL($_errorURL)
    {
        return ($this->errorURL = $_errorURL);
    }
    /**
     * Get notificationFailedURL value
     * @return string|null
     */
    public function getNotificationFailedURL()
    {
        return $this->notificationFailedURL;
    }
    /**
     * Set notificationFailedURL value
     * @param string $_notificationFailedURL the notificationFailedURL
     * @return bool
     */
    public function setNotificationFailedURL($_notificationFailedURL)
    {
        return ($this->notificationFailedURL = $_notificationFailedURL);
    }
    /**
     * Get redirect value
     * @return boolean|null
     */
    public function getRedirect()
    {
        return $this->redirect;
    }
    /**
     * Set redirect value
     * @param boolean $_redirect the redirect
     * @return boolean
     */
    public function setRedirect($_redirect)
    {
        return ($this->redirect = $_redirect);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @uses Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @param array $_array the exported values
     * @return Egovs_Paymentbase_Model_Payplace_Types_Customer_Continuation
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
