<?php
/**
 * File for class Egovs_Paymentbase_Model_Payplace_Types_Credentials
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
/**
 * This class stands for Egovs_Paymentbase_Model_Payplace_Types_Credentials originally named credentials
 * Documentation : Authentication data for callbacks (giropay or form service)
 * Meta informations extracted from the WSDL
 * - from schema : file:///etc/Callback.wsdl
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
class Egovs_Paymentbase_Model_Payplace_Types_Credentials extends Egovs_Paymentbase_Model_Payplace_WsdlClass
{
    /**
     * The login
     * @var string
     */
    public $login;
    /**
     * The password
     * @var string
     */
    public $password;
    /**
     * Constructor method for credentials
     * @see parent::__construct()
     * @param string $_login
     * @param string $_password
     * @return Egovs_Paymentbase_Model_Payplace_Types_Credentials
     */
    public function __construct($_login = NULL,$_password = NULL)
    {
        parent::__construct(array('login'=>$_login,'password'=>$_password),false);
    }
    /**
     * Get login value
     * @return string|null
     */
    public function getLogin()
    {
        return $this->login;
    }
    /**
     * Set login value
     * @param string $_login the login
     * @return string
     */
    public function setLogin($_login)
    {
        return ($this->login = $_login);
    }
    /**
     * Get password value
     * @return string|null
     */
    public function getPassword()
    {
        return $this->password;
    }
    /**
     * Set password value
     * @param string $_password the password
     * @return string
     */
    public function setPassword($_password)
    {
        return ($this->password = $_password);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @uses Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @param array $_array the exported values
     * @return Egovs_Paymentbase_Model_Payplace_Types_Credentials
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
