<?php
/**
 * File for class Egovs_Paymentbase_Model_Payplace_Types_ExportResponse
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
/**
 * This class stands for Egovs_Paymentbase_Model_Payplace_Types_ExportResponse originally named exportResponse
 * Documentation : Root element for a transaction export.
 * Meta informations extracted from the WSDL
 * - from schema : file:///etc/Callback.wsdl
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
class Egovs_Paymentbase_Model_Payplace_Types_ExportResponse extends Egovs_Paymentbase_Model_Payplace_WsdlClass
{
    /**
     * The paymentResponse
     * @var Egovs_Paymentbase_Model_Payplace_Types_Payment_Response
     */
    public $paymentResponse;
    /**
     * The riskCheckResponse
     * @var Egovs_Paymentbase_Model_Payplace_Types_RiskCheck_Response
     */
    public $riskCheckResponse;
    /**
     * The ref
     * @var string
     */
    public $ref;
    /**
     * Constructor method for exportResponse
     * @see parent::__construct()
     * @param Egovs_Paymentbase_Model_Payplace_Types_Payment_Response $_paymentResponse
     * @param Egovs_Paymentbase_Model_Payplace_Types_RiskCheck_Response $_riskCheckResponse
     * @param string $_ref
     * @return Egovs_Paymentbase_Model_Payplace_Types_ExportResponse
     */
    public function __construct($_paymentResponse = NULL,$_riskCheckResponse = NULL,$_ref = NULL)
    {
        parent::__construct(array('paymentResponse'=>$_paymentResponse,'riskCheckResponse'=>$_riskCheckResponse,'ref'=>$_ref),false);
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
     * Get riskCheckResponse value
     * @return Egovs_Paymentbase_Model_Payplace_Types_RiskCheck_Response|null
     */
    public function getRiskCheckResponse()
    {
        return $this->riskCheckResponse;
    }
    /**
     * Set riskCheckResponse value
     * @param Egovs_Paymentbase_Model_Payplace_Types_RiskCheck_Response $_riskCheckResponse the riskCheckResponse
     * @return Egovs_Paymentbase_Model_Payplace_Types_RiskCheck_Response
     */
    public function setRiskCheckResponse($_riskCheckResponse)
    {
        return ($this->riskCheckResponse = $_riskCheckResponse);
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
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @uses Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @param array $_array the exported values
     * @return Egovs_Paymentbase_Model_Payplace_Types_ExportResponse
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
