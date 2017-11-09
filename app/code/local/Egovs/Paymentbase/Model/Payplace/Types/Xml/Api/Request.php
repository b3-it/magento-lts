<?php
/**
 * File for class Egovs_Paymentbase_Model_Payplace_Types_Xml_Api_Request
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
/**
 * This class stands for Egovs_Paymentbase_Model_Payplace_Types_Xml_Api_Request originally named xmlApiRequest
 * Documentation : Root element of an XML API request.
 * Meta informations extracted from the WSDL
 * - from schema : file:///etc/Callback.wsdl
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
class Egovs_Paymentbase_Model_Payplace_Types_Xml_Api_Request extends Egovs_Paymentbase_Model_Payplace_WsdlClass
{
    /**
     * The paymentRequest
     * @var Egovs_Paymentbase_Model_Payplace_Types_Payment_Request
     */
    public $paymentRequest;
    /**
     * The txDiagnosisRequest
     * @var Egovs_Paymentbase_Model_Payplace_Types_Tx_Diagnosis_Request
     */
    public $txDiagnosisRequest;
    /**
     * The riskCheckRequest
     * @var Egovs_Paymentbase_Model_Payplace_Types_RiskCheck_Request
     */
    public $riskCheckRequest;
    /**
     * The formServiceRequest
     * @var Egovs_Paymentbase_Model_Payplace_Types_Form_Service_Request
     */
    public $formServiceRequest;
    /**
     * The giropayBankCheckRequest
     * @var Egovs_Paymentbase_Model_Payplace_Types_Giropay_BankCheck_Request
     */
    public $giropayBankCheckRequest;
    /**
     * The tdsInitialRequest
     * @var Egovs_Paymentbase_Model_Payplace_Types_Tds_Initial_Request
     */
    public $tdsInitialRequest;
    /**
     * The tdsFinalRequest
     * @var Egovs_Paymentbase_Model_Payplace_Types_Tds_Final_Request
     */
    public $tdsFinalRequest;
    /**
     * The batchRequest
     * @var Egovs_Paymentbase_Model_Payplace_Types_Batch_Request
     */
    public $batchRequest;
    /**
     * The panAliasRequest
     * @var Egovs_Paymentbase_Model_Payplace_Types_PanAlias_Request
     */
    public $panAliasRequest;
    /**
     * The registerPanRequest
     * @var Egovs_Paymentbase_Model_Payplace_Types_Register_Pan_Request
     */
    public $registerPanRequest;
    /**
     * The id
     * Meta informations extracted from the WSDL
     * - documentation : This id makes it easier to assign a response to a request. This attribute will be copied to the "ref" attribute of the response, if it is provided.
     * @var int
     */
    public $id;
    /**
     * The version
     * @var string
     */
    public $version;
    /**
     * Constructor method for xmlApiRequest
     * @see parent::__construct()
     * @param Egovs_Paymentbase_Model_Payplace_Types_Payment_Request $_paymentRequest
     * @param Egovs_Paymentbase_Model_Payplace_Types_Tx_Diagnosis_Request $_txDiagnosisRequest
     * @param Egovs_Paymentbase_Model_Payplace_Types_RiskCheck_Request $_riskCheckRequest
     * @param Egovs_Paymentbase_Model_Payplace_Types_Form_Service_Request $_formServiceRequest
     * @param Egovs_Paymentbase_Model_Payplace_Types_Giropay_BankCheck_Request $_giropayBankCheckRequest
     * @param Egovs_Paymentbase_Model_Payplace_Types_Tds_Initial_Request $_tdsInitialRequest
     * @param Egovs_Paymentbase_Model_Payplace_Types_Tds_Final_Request $_tdsFinalRequest
     * @param Egovs_Paymentbase_Model_Payplace_Types_Batch_Request $_batchRequest
     * @param Egovs_Paymentbase_Model_Payplace_Types_PanAlias_Request $_panAliasRequest
     * @param Egovs_Paymentbase_Model_Payplace_Types_Register_Pan_Request $_registerPanRequest
     * @param int $_id
     * @param string $_version
     * @return Egovs_Paymentbase_Model_Payplace_Types_Xml_Api_Request
     */
    public function __construct($_paymentRequest = NULL,$_txDiagnosisRequest = NULL,$_riskCheckRequest = NULL,$_formServiceRequest = NULL,$_giropayBankCheckRequest = NULL,$_tdsInitialRequest = NULL,$_tdsFinalRequest = NULL,$_batchRequest = NULL,$_panAliasRequest = NULL,$_registerPanRequest = NULL,$_id = NULL,$_version = NULL)
    {
        parent::__construct(array('paymentRequest'=>$_paymentRequest,'txDiagnosisRequest'=>$_txDiagnosisRequest,'riskCheckRequest'=>$_riskCheckRequest,'formServiceRequest'=>$_formServiceRequest,'giropayBankCheckRequest'=>$_giropayBankCheckRequest,'tdsInitialRequest'=>$_tdsInitialRequest,'tdsFinalRequest'=>$_tdsFinalRequest,'batchRequest'=>$_batchRequest,'panAliasRequest'=>$_panAliasRequest,'registerPanRequest'=>$_registerPanRequest,'id'=>$_id,'version'=>$_version),false);
    }
    /**
     * Get paymentRequest value
     * @return Egovs_Paymentbase_Model_Payplace_Types_Payment_Request|null
     */
    public function getPaymentRequest()
    {
        return $this->paymentRequest;
    }
    /**
     * Set paymentRequest value
     * @param Egovs_Paymentbase_Model_Payplace_Types_Payment_Request $_paymentRequest the paymentRequest
     * @return Egovs_Paymentbase_Model_Payplace_Types_Payment_Request
     */
    public function setPaymentRequest($_paymentRequest)
    {
        return ($this->paymentRequest = $_paymentRequest);
    }
    /**
     * Get txDiagnosisRequest value
     * @return Egovs_Paymentbase_Model_Payplace_Types_Tx_Diagnosis_Request|null
     */
    public function getTxDiagnosisRequest()
    {
        return $this->txDiagnosisRequest;
    }
    /**
     * Set txDiagnosisRequest value
     * @param Egovs_Paymentbase_Model_Payplace_Types_Tx_Diagnosis_Request $_txDiagnosisRequest the txDiagnosisRequest
     * @return Egovs_Paymentbase_Model_Payplace_Types_Tx_Diagnosis_Request
     */
    public function setTxDiagnosisRequest($_txDiagnosisRequest)
    {
        return ($this->txDiagnosisRequest = $_txDiagnosisRequest);
    }
    /**
     * Get riskCheckRequest value
     * @return Egovs_Paymentbase_Model_Payplace_Types_RiskCheck_Request|null
     */
    public function getRiskCheckRequest()
    {
        return $this->riskCheckRequest;
    }
    /**
     * Set riskCheckRequest value
     * @param Egovs_Paymentbase_Model_Payplace_Types_RiskCheck_Request $_riskCheckRequest the riskCheckRequest
     * @return Egovs_Paymentbase_Model_Payplace_Types_RiskCheck_Request
     */
    public function setRiskCheckRequest($_riskCheckRequest)
    {
        return ($this->riskCheckRequest = $_riskCheckRequest);
    }
    /**
     * Get formServiceRequest value
     * @return Egovs_Paymentbase_Model_Payplace_Types_Form_Service_Request|null
     */
    public function getFormServiceRequest()
    {
        return $this->formServiceRequest;
    }
    /**
     * Set formServiceRequest value
     * @param Egovs_Paymentbase_Model_Payplace_Types_Form_Service_Request $_formServiceRequest the formServiceRequest
     * @return Egovs_Paymentbase_Model_Payplace_Types_Form_Service_Request
     */
    public function setFormServiceRequest($_formServiceRequest)
    {
        return ($this->formServiceRequest = $_formServiceRequest);
    }
    /**
     * Get giropayBankCheckRequest value
     * @return Egovs_Paymentbase_Model_Payplace_Types_Giropay_BankCheck_Request|null
     */
    public function getGiropayBankCheckRequest()
    {
        return $this->giropayBankCheckRequest;
    }
    /**
     * Set giropayBankCheckRequest value
     * @param Egovs_Paymentbase_Model_Payplace_Types_Giropay_BankCheck_Request $_giropayBankCheckRequest the giropayBankCheckRequest
     * @return Egovs_Paymentbase_Model_Payplace_Types_Giropay_BankCheck_Request
     */
    public function setGiropayBankCheckRequest($_giropayBankCheckRequest)
    {
        return ($this->giropayBankCheckRequest = $_giropayBankCheckRequest);
    }
    /**
     * Get tdsInitialRequest value
     * @return Egovs_Paymentbase_Model_Payplace_Types_Tds_Initial_Request|null
     */
    public function getTdsInitialRequest()
    {
        return $this->tdsInitialRequest;
    }
    /**
     * Set tdsInitialRequest value
     * @param Egovs_Paymentbase_Model_Payplace_Types_Tds_Initial_Request $_tdsInitialRequest the tdsInitialRequest
     * @return Egovs_Paymentbase_Model_Payplace_Types_Tds_Initial_Request
     */
    public function setTdsInitialRequest($_tdsInitialRequest)
    {
        return ($this->tdsInitialRequest = $_tdsInitialRequest);
    }
    /**
     * Get tdsFinalRequest value
     * @return Egovs_Paymentbase_Model_Payplace_Types_Tds_Final_Request|null
     */
    public function getTdsFinalRequest()
    {
        return $this->tdsFinalRequest;
    }
    /**
     * Set tdsFinalRequest value
     * @param Egovs_Paymentbase_Model_Payplace_Types_Tds_Final_Request $_tdsFinalRequest the tdsFinalRequest
     * @return Egovs_Paymentbase_Model_Payplace_Types_Tds_Final_Request
     */
    public function setTdsFinalRequest($_tdsFinalRequest)
    {
        return ($this->tdsFinalRequest = $_tdsFinalRequest);
    }
    /**
     * Get batchRequest value
     * @return Egovs_Paymentbase_Model_Payplace_Types_Batch_Request|null
     */
    public function getBatchRequest()
    {
        return $this->batchRequest;
    }
    /**
     * Set batchRequest value
     * @param Egovs_Paymentbase_Model_Payplace_Types_Batch_Request $_batchRequest the batchRequest
     * @return Egovs_Paymentbase_Model_Payplace_Types_Batch_Request
     */
    public function setBatchRequest($_batchRequest)
    {
        return ($this->batchRequest = $_batchRequest);
    }
    /**
     * Get panAliasRequest value
     * @return Egovs_Paymentbase_Model_Payplace_Types_PanAlias_Request|null
     */
    public function getPanAliasRequest()
    {
        return $this->panAliasRequest;
    }
    /**
     * Set panAliasRequest value
     * @param Egovs_Paymentbase_Model_Payplace_Types_PanAlias_Request $_panAliasRequest the panAliasRequest
     * @return Egovs_Paymentbase_Model_Payplace_Types_PanAlias_Request
     */
    public function setPanAliasRequest($_panAliasRequest)
    {
        return ($this->panAliasRequest = $_panAliasRequest);
    }
    /**
     * Get registerPanRequest value
     * @return Egovs_Paymentbase_Model_Payplace_Types_Register_Pan_Request|null
     */
    public function getRegisterPanRequest()
    {
        return $this->registerPanRequest;
    }
    /**
     * Set registerPanRequest value
     * @param Egovs_Paymentbase_Model_Payplace_Types_Register_Pan_Request $_registerPanRequest the registerPanRequest
     * @return Egovs_Paymentbase_Model_Payplace_Types_Register_Pan_Request
     */
    public function setRegisterPanRequest($_registerPanRequest)
    {
        return ($this->registerPanRequest = $_registerPanRequest);
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
     * @return Egovs_Paymentbase_Model_Payplace_Types_Xml_Api_Request
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
