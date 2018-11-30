<?php
/**
 * File for class Egovs_Paymentbase_Model_Payplace_Types_Xml_Api_Response
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
/**
 * This class stands for Egovs_Paymentbase_Model_Payplace_Types_Xml_Api_Response originally named xmlApiResponse
 * Documentation : Root element of a response of the XML API.
 * Meta informations extracted from the WSDL
 * - from schema : file:///etc/Callback.wsdl
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
class Egovs_Paymentbase_Model_Payplace_Types_Xml_Api_Response extends Egovs_Paymentbase_Model_Payplace_WsdlClass
{
    /**
     * The paymentResponse
     * @var Egovs_Paymentbase_Model_Payplace_Types_Payment_Response
     */
    public $paymentResponse;
    /**
     * The formServiceResponse
     * @var Egovs_Paymentbase_Model_Payplace_Types_Form_Service_Response
     */
    public $formServiceResponse;
    /**
     * The txDiagnosisResponse
     * @var Egovs_Paymentbase_Model_Payplace_Types_Tx_Diagnosis_Response
     */
    public $txDiagnosisResponse;
    /**
     * The giropayBankCheckResponse
     * @var Egovs_Paymentbase_Model_Payplace_Types_Giropay_BankCheck_Response
     */
    public $giropayBankCheckResponse;
    /**
     * The tdsInitialResponse
     * @var Egovs_Paymentbase_Model_Payplace_Types_Tds_Initial_Response
     */
    public $tdsInitialResponse;
    /**
     * The riskCheckResponse
     * @var Egovs_Paymentbase_Model_Payplace_Types_RiskCheck_Response
     */
    public $riskCheckResponse;
    /**
     * The batchResponse
     * @var Egovs_Paymentbase_Model_Payplace_Types_Batch_Response
     */
    public $batchResponse;
    /**
     * The panAliasResponse
     * @var Egovs_Paymentbase_Model_Payplace_Types_PanAlias_Response
     */
    public $panAliasResponse;
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
     * Constructor method for xmlApiResponse
     * @see parent::__construct()
     * @param Egovs_Paymentbase_Model_Payplace_Types_Payment_Response $_paymentResponse
     * @param Egovs_Paymentbase_Model_Payplace_Types_Form_Service_Response $_formServiceResponse
     * @param Egovs_Paymentbase_Model_Payplace_Types_Tx_Diagnosis_Response $_txDiagnosisResponse
     * @param Egovs_Paymentbase_Model_Payplace_Types_Giropay_BankCheck_Response $_giropayBankCheckResponse
     * @param Egovs_Paymentbase_Model_Payplace_Types_Tds_Initial_Response $_tdsInitialResponse
     * @param Egovs_Paymentbase_Model_Payplace_Types_RiskCheck_Response $_riskCheckResponse
     * @param Egovs_Paymentbase_Model_Payplace_Types_Batch_Response $_batchResponse
     * @param Egovs_Paymentbase_Model_Payplace_Types_PanAlias_Response $_panAliasResponse
     * @param string $_ref
     * @param string $_version
     * @return Egovs_Paymentbase_Model_Payplace_Types_Xml_Api_Response
     */
    public function __construct($_paymentResponse = NULL,$_formServiceResponse = NULL,$_txDiagnosisResponse = NULL,$_giropayBankCheckResponse = NULL,$_tdsInitialResponse = NULL,$_riskCheckResponse = NULL,$_batchResponse = NULL,$_panAliasResponse = NULL,$_ref = NULL,$_version = NULL)
    {
        parent::__construct(array('paymentResponse'=>$_paymentResponse,'formServiceResponse'=>$_formServiceResponse,'txDiagnosisResponse'=>$_txDiagnosisResponse,'giropayBankCheckResponse'=>$_giropayBankCheckResponse,'tdsInitialResponse'=>$_tdsInitialResponse,'riskCheckResponse'=>$_riskCheckResponse,'batchResponse'=>$_batchResponse,'panAliasResponse'=>$_panAliasResponse,'ref'=>$_ref,'version'=>$_version),false);
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
     * Get formServiceResponse value
     * @return Egovs_Paymentbase_Model_Payplace_Types_Form_Service_Response|null
     */
    public function getFormServiceResponse()
    {
        return $this->formServiceResponse;
    }
    /**
     * Set formServiceResponse value
     * @param Egovs_Paymentbase_Model_Payplace_Types_Form_Service_Response $_formServiceResponse the formServiceResponse
     * @return Egovs_Paymentbase_Model_Payplace_Types_Form_Service_Response
     */
    public function setFormServiceResponse($_formServiceResponse)
    {
        return ($this->formServiceResponse = $_formServiceResponse);
    }
    /**
     * Get txDiagnosisResponse value
     * @return Egovs_Paymentbase_Model_Payplace_Types_Tx_Diagnosis_Response|null
     */
    public function getTxDiagnosisResponse()
    {
        return $this->txDiagnosisResponse;
    }
    /**
     * Set txDiagnosisResponse value
     * @param Egovs_Paymentbase_Model_Payplace_Types_Tx_Diagnosis_Response $_txDiagnosisResponse the txDiagnosisResponse
     * @return Egovs_Paymentbase_Model_Payplace_Types_Tx_Diagnosis_Response
     */
    public function setTxDiagnosisResponse($_txDiagnosisResponse)
    {
        return ($this->txDiagnosisResponse = $_txDiagnosisResponse);
    }
    /**
     * Get giropayBankCheckResponse value
     * @return Egovs_Paymentbase_Model_Payplace_Types_Giropay_BankCheck_Response|null
     */
    public function getGiropayBankCheckResponse()
    {
        return $this->giropayBankCheckResponse;
    }
    /**
     * Set giropayBankCheckResponse value
     * @param Egovs_Paymentbase_Model_Payplace_Types_Giropay_BankCheck_Response $_giropayBankCheckResponse the giropayBankCheckResponse
     * @return Egovs_Paymentbase_Model_Payplace_Types_Giropay_BankCheck_Response
     */
    public function setGiropayBankCheckResponse($_giropayBankCheckResponse)
    {
        return ($this->giropayBankCheckResponse = $_giropayBankCheckResponse);
    }
    /**
     * Get tdsInitialResponse value
     * @return Egovs_Paymentbase_Model_Payplace_Types_Tds_Initial_Response|null
     */
    public function getTdsInitialResponse()
    {
        return $this->tdsInitialResponse;
    }
    /**
     * Set tdsInitialResponse value
     * @param Egovs_Paymentbase_Model_Payplace_Types_Tds_Initial_Response $_tdsInitialResponse the tdsInitialResponse
     * @return Egovs_Paymentbase_Model_Payplace_Types_Tds_Initial_Response
     */
    public function setTdsInitialResponse($_tdsInitialResponse)
    {
        return ($this->tdsInitialResponse = $_tdsInitialResponse);
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
     * Get batchResponse value
     * @return Egovs_Paymentbase_Model_Payplace_Types_Batch_Response|null
     */
    public function getBatchResponse()
    {
        return $this->batchResponse;
    }
    /**
     * Set batchResponse value
     * @param Egovs_Paymentbase_Model_Payplace_Types_Batch_Response $_batchResponse the batchResponse
     * @return Egovs_Paymentbase_Model_Payplace_Types_Batch_Response
     */
    public function setBatchResponse($_batchResponse)
    {
        return ($this->batchResponse = $_batchResponse);
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
     * @return Egovs_Paymentbase_Model_Payplace_Types_Xml_Api_Response
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
