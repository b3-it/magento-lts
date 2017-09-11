<?php
/**
 * File for class Egovs_Paymentbase_Model_Payplace_Types_Callback_Request
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
/**
 * This class stands for Egovs_Paymentbase_Model_Payplace_Types_Callback_Request originally named callbackRequest
 * Documentation : Root element of a callback request.
 * Meta informations extracted from the WSDL
 * - from schema : file:///etc/Callback.wsdl
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
class Egovs_Paymentbase_Model_Payplace_Types_Callback_Request extends Egovs_Paymentbase_Model_Payplace_WsdlClass
{
    /**
     * The paymentResponse
     * @var Egovs_Paymentbase_Model_Payplace_Types_Payment_Response
     */
    public $paymentResponse;
    /**
     * The panAliasResponse
     * @var Egovs_Paymentbase_Model_Payplace_Types_PanAlias_Response
     */
    public $panAliasResponse;
    /**
     * The id
     * Meta informations extracted from the WSDL
     * - documentation : This id makes it easier to assign a response to a request. Copy this attribute to the "ref" attribute of the response, if it is provided.
     * @var int
     */
    public $id;
    /**
     * The version
     * @var string
     */
    public $version;
    /**
     * Constructor method for callbackRequest
     * @see parent::__construct()
     * @param Egovs_Paymentbase_Model_Payplace_Types_Payment_Response $_paymentResponse
     * @param Egovs_Paymentbase_Model_Payplace_Types_PanAlias_Response $_panAliasResponse
     * @param int $_id
     * @param string $_version
     * @return Egovs_Paymentbase_Model_Payplace_Types_Callback_Request
     */
    public function __construct($_paymentResponse = NULL,$_panAliasResponse = NULL,$_id = NULL,$_version = NULL)
    {
        parent::__construct(array('paymentResponse'=>$_paymentResponse,'panAliasResponse'=>$_panAliasResponse,'id'=>$_id,'version'=>$_version),false);
    }
    /**
     * Get paymentResponse value
     * @return Egovs_Paymentbase_Model_Payplace_Types_Payment_Response|null
     */
    public function getPaymentResponse()
    {
        return $this->paymentResponse;
    }
    /**
     * Set paymentResponse value
     * @param Egovs_Paymentbase_Model_Payplace_Types_Payment_Response $_paymentResponse the paymentResponse
     * @return Egovs_Paymentbase_Model_Payplace_Types_Payment_Response
     */
    public function setPaymentResponse($_paymentResponse)
    {
        return ($this->paymentResponse = $_paymentResponse);
    }
    /**
     * Get panAliasResponse value
     * @return Egovs_Paymentbase_Model_Payplace_Types_PanAlias_Response|null
     */
    public function getPanAliasResponse()
    {
        return $this->panAliasResponse;
    }
    /**
     * Set panAliasResponse value
     * @param Egovs_Paymentbase_Model_Payplace_Types_PanAlias_Response $_panAliasResponse the panAliasResponse
     * @return Egovs_Paymentbase_Model_Payplace_Types_PanAlias_Response
     */
    public function setPanAliasResponse($_panAliasResponse)
    {
        return ($this->panAliasResponse = $_panAliasResponse);
    }
    /**
     * Get id value
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * Set id value
     * @param int $_id the id
     * @return bool
     */
    public function setId($_id)
    {
        return ($this->id = $_id);
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
     * @return Egovs_Paymentbase_Model_Payplace_Types_Callback_Request
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
