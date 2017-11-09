<?php
/**
 * File for class Egovs_Paymentbase_Model_Payplace_Types_Callback_Data
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
/**
 * This class stands for Egovs_Paymentbase_Model_Payplace_Types_Callback_Data originally named callbackData
 * Documentation : Includes data (URL and possibly authentication data) for callbacks (giropay or form service).
 * Meta informations extracted from the WSDL
 * - from schema : file:///etc/Callback.wsdl
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
class Egovs_Paymentbase_Model_Payplace_Types_Callback_Data extends Egovs_Paymentbase_Model_Payplace_WsdlClass
{
    /**
     * The notifyURL
     * @var string
     */
    public $notifyURL;
    /**
     * The credentials
     * @var Egovs_Paymentbase_Model_Payplace_Types_Credentials
     */
    public $credentials;
    /**
     * Constructor method for callbackData
     * @see parent::__construct()
     * @param string $_notifyURL
     * @param Egovs_Paymentbase_Model_Payplace_Types_Credentials $_credentials
     * @return Egovs_Paymentbase_Model_Payplace_Types_Callback_Data
     */
    public function __construct($_notifyURL = NULL,$_credentials = NULL)
    {
        parent::__construct(array('notifyURL'=>$_notifyURL,'credentials'=>$_credentials),false);
    }
    /**
     * Get notifyURL value
     * @return string|null
     */
    public function getNotifyURL()
    {
        return $this->notifyURL;
    }
    /**
     * Set notifyURL value
     * @param string $_notifyURL the notifyURL
     * @return bool
     */
    public function setNotifyURL($_notifyURL)
    {
        return ($this->notifyURL = $_notifyURL);
    }
    /**
     * Get credentials value
     * @return Egovs_Paymentbase_Model_Payplace_Types_Credentials|null
     */
    public function getCredentials()
    {
        return $this->credentials;
    }
    /**
     * Set credentials value
     * @param Egovs_Paymentbase_Model_Payplace_Types_Credentials $_credentials the credentials
     * @return Egovs_Paymentbase_Model_Payplace_Types_Credentials
     */
    public function setCredentials($_credentials)
    {
        return ($this->credentials = $_credentials);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @uses Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @param array $_array the exported values
     * @return Egovs_Paymentbase_Model_Payplace_Types_Callback_Data
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
