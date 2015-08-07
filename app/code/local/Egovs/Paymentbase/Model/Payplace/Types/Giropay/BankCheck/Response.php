<?php
/**
 * File for class Egovs_Paymentbase_Model_Payplace_Types_Giropay_BankCheck_Response
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
/**
 * This class stands for Egovs_Paymentbase_Model_Payplace_Types_Giropay_BankCheck_Response originally named giropayBankCheckResponse
 * Meta informations extracted from the WSDL
 * - from schema : file:///etc/Callback.wsdl
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
class Egovs_Paymentbase_Model_Payplace_Types_Giropay_BankCheck_Response extends Egovs_Paymentbase_Model_Payplace_Types_Base_Response
{
    /**
     * The bankCode
     * Meta informations extracted from the WSDL
     * - documentation : Bank code of the customer's bank details.
     * - from schema : file:///etc/Callback.wsdl
     * - length : 8
     * - pattern : [0-9]+
     * @var string
     */
    public $bankCode;
    /**
     * The bic
     * Meta informations extracted from the WSDL
     * - maxLength : 11
     * - minLength : 8
     * - pattern : [A-Z]{6}[A-Z2-9][A-NP-Z0-9]([A-Z0-9]{3})?
     * @var string
     */
    public $bic;
    /**
     * The bankCheckResult
     * Meta informations extracted from the WSDL
     * - documentation : Result of the validation. "passed": the bank takes part in giropay. "failed": the bank does not take part. "unknown": the bank code ist invalid or unknown.
     * - minOccurs : 0
     * @var Egovs_Paymentbase_Model_Payplace_Enum_CheckResultEnum
     */
    public $bankCheckResult;
    /**
     * The service
     * Meta informations extracted from the WSDL
     * - documentation : Lists the giropay services that are available for this bank.
     * - maxOccurs : 3
     * - minOccurs : 0
     * @var Egovs_Paymentbase_Model_Payplace_Enum_Giropay_ServiceEnum
     */
    public $service;
    /**
     * The rc
     * Meta informations extracted from the WSDL
     * - from schema : file:///etc/Callback.wsdl
     * - length : 4
     * - pattern : [0-9]*
     * @var string
     */
    public $rc;
    /**
     * The message
     * Meta informations extracted from the WSDL
     * - documentation : A message that explains the return code.
     * - from schema : file:///etc/Callback.wsdl
     * - minLength : 1
     * @var string
     */
    public $message;
    /**
     * Constructor method for giropayBankCheckResponse
     * @see parent::__construct()
     * @param string $_bankCode
     * @param string $_bic
     * @param Egovs_Paymentbase_Model_Payplace_Enum_CheckResultEnum $_bankCheckResult
     * @param Egovs_Paymentbase_Model_Payplace_Enum_Giropay_ServiceEnum $_service
     * @param string $_rc
     * @param string $_message
     * @return Egovs_Paymentbase_Model_Payplace_Types_Giropay_BankCheck_Response
     */
    public function __construct($_bankCode = NULL,$_bic = NULL,$_bankCheckResult = NULL,$_service = NULL,$_rc = NULL,$_message = NULL)
    {
        Egovs_Paymentbase_Model_Payplace_WsdlClass::__construct(array('bankCode'=>$_bankCode,'bic'=>$_bic,'bankCheckResult'=>$_bankCheckResult,'service'=>$_service,'rc'=>$_rc,'message'=>$_message),false);
    }
    /**
     * Get bankCode value
     * @return string|null
     */
    public function getBankCode()
    {
        return $this->bankCode;
    }
    /**
     * Set bankCode value
     * @param string $_bankCode the bankCode
     * @return string
     */
    public function setBankCode($_bankCode)
    {
        return ($this->bankCode = $_bankCode);
    }
    /**
     * Get bic value
     * @return string|null
     */
    public function getBic()
    {
        return $this->bic;
    }
    /**
     * Set bic value
     * @param string $_bic the bic
     * @return string
     */
    public function setBic($_bic)
    {
        return ($this->bic = $_bic);
    }
    /**
     * Get bankCheckResult value
     * @return Egovs_Paymentbase_Model_Payplace_Enum_CheckResultEnum|null
     */
    public function getBankCheckResult()
    {
        return $this->bankCheckResult;
    }
    /**
     * Set bankCheckResult value
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_CheckResultEnum::valueIsValid()
     * @param Egovs_Paymentbase_Model_Payplace_Enum_CheckResultEnum $_bankCheckResult the bankCheckResult
     * @return Egovs_Paymentbase_Model_Payplace_Enum_CheckResultEnum
     */
    public function setBankCheckResult($_bankCheckResult)
    {
        if(!Egovs_Paymentbase_Model_Payplace_Enum_CheckResultEnum::valueIsValid($_bankCheckResult))
        {
            return false;
        }
        return ($this->bankCheckResult = $_bankCheckResult);
    }
    /**
     * Get service value
     * @return Egovs_Paymentbase_Model_Payplace_Enum_Giropay_ServiceEnum|null
     */
    public function getService()
    {
        return $this->service;
    }
    /**
     * Set service value
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_Giropay_ServiceEnum::valueIsValid()
     * @param Egovs_Paymentbase_Model_Payplace_Enum_Giropay_ServiceEnum $_service the service
     * @return Egovs_Paymentbase_Model_Payplace_Enum_Giropay_ServiceEnum
     */
    public function setService($_service)
    {
        if(!Egovs_Paymentbase_Model_Payplace_Enum_Giropay_ServiceEnum::valueIsValid($_service))
        {
            return false;
        }
        return ($this->service = $_service);
    }
    /**
     * Get rc value
     * @return string|null
     */
    public function getRc()
    {
        return $this->rc;
    }
    /**
     * Set rc value
     * @param string $_rc the rc
     * @return string
     */
    public function setRc($_rc)
    {
        return ($this->rc = $_rc);
    }
    /**
     * Get message value
     * @return string|null
     */
    public function getMessage()
    {
        return $this->message;
    }
    /**
     * Set message value
     * @param string $_message the message
     * @return string
     */
    public function setMessage($_message)
    {
        return ($this->message = $_message);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @uses Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @param array $_array the exported values
     * @return Egovs_Paymentbase_Model_Payplace_Types_Giropay_BankCheck_Response
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
