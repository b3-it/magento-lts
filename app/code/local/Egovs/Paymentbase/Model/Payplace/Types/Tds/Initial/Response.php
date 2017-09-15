<?php
/**
 * File for class Egovs_Paymentbase_Model_Payplace_Types_Tds_Initial_Response
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
/**
 * This class stands for Egovs_Paymentbase_Model_Payplace_Types_Tds_Initial_Response originally named tdsInitialResponse
 * Meta informations extracted from the WSDL
 * - from schema : file:///etc/Callback.wsdl
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
class Egovs_Paymentbase_Model_Payplace_Types_Tds_Initial_Response extends Egovs_Paymentbase_Model_Payplace_Types_Base_Response
{
    /**
     * The acsURL
     * @var string
     */
    public $acsURL;
    /**
     * The paReq
     * @var string
     */
    public $paReq;
    /**
     * Constructor method for tdsInitialResponse
     * @see parent::__construct()
     * @param string $_acsURL
     * @param string $_paReq
     * @return Egovs_Paymentbase_Model_Payplace_Types_Tds_Initial_Response
     */
    public function __construct($_acsURL = NULL,$_paReq = NULL)
    {
        Egovs_Paymentbase_Model_Payplace_WsdlClass::__construct(array('acsURL'=>$_acsURL,'paReq'=>$_paReq),false);
    }
    /**
     * Get acsURL value
     * @return string|null
     */
    public function getAcsURL()
    {
        return $this->acsURL;
    }
    /**
     * Set acsURL value
     * @param string $_acsURL the acsURL
     * @return bool
     */
    public function setAcsURL($_acsURL)
    {
        return ($this->acsURL = $_acsURL);
    }
    /**
     * Get paReq value
     * @return string|null
     */
    public function getPaReq()
    {
        return $this->paReq;
    }
    /**
     * Set paReq value
     * @param string $_paReq the paReq
     * @return string
     */
    public function setPaReq($_paReq)
    {
        return ($this->paReq = $_paReq);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @uses Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @param array $_array the exported values
     * @return Egovs_Paymentbase_Model_Payplace_Types_Tds_Initial_Response
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
