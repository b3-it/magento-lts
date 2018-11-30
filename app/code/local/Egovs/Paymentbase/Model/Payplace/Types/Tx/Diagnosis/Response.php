<?php
/**
 * File for class Egovs_Paymentbase_Model_Payplace_Types_Tx_Diagnosis_Response
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
/**
 * This class stands for Egovs_Paymentbase_Model_Payplace_Types_Tx_Diagnosis_Response originally named txDiagnosisResponse
 * Meta informations extracted from the WSDL
 * - from schema : file:///etc/Callback.wsdl
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
class Egovs_Paymentbase_Model_Payplace_Types_Tx_Diagnosis_Response extends Egovs_Paymentbase_Model_Payplace_Types_Base_Response
{
    /**
     * The eventExtId
     * Meta informations extracted from the WSDL
     * - documentation : Unique process number, that identifies this transaction for a shop.
     * - from schema : file:///etc/Callback.wsdl
     * - maxLength : 17
     * - pattern : [A-Za-z0-9_/\-]+
     * @var string
     */
    public $eventExtId;
    /**
     * The kind
     * @var Egovs_Paymentbase_Model_Payplace_Enum_KindEnum
     */
    public $kind;
    /**
     * The txReferenceExtId
     * Meta informations extracted from the WSDL
     * - documentation : References the txExtId of a previous transaction.
     * - from schema : file:///etc/Callback.wsdl
     * - maxLength : 22
     * - pattern : [A-Za-z0-9_/\-]+
     * @var string
     */
    public $txReferenceExtId;
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
     * Constructor method for txDiagnosisResponse
     * @see parent::__construct()
     * @param int $_eventExtId
     * @param Egovs_Paymentbase_Model_Payplace_Enum_KindEnum $_kind
     * @param int $_txReferenceExtId
     * @param string $_rc
     * @param string $_message
     * @return Egovs_Paymentbase_Model_Payplace_Types_Tx_Diagnosis_Response
     */
    public function __construct($_eventExtId = NULL,$_kind = NULL,$_txReferenceExtId = NULL,$_rc = NULL,$_message = NULL)
    {
        Egovs_Paymentbase_Model_Payplace_WsdlClass::__construct(array('eventExtId'=>$_eventExtId,'kind'=>$_kind,'txReferenceExtId'=>$_txReferenceExtId,'rc'=>$_rc,'message'=>$_message),false);
    }
    /**
     * Get eventExtId value
     * @return int|null
     */
    public function getEventExtId()
    {
        return $this->eventExtId;
    }
    /**
     * Set eventExtId value
     * @param int $_eventExtId the eventExtId
     * @return bool
     */
    public function setEventExtId($_eventExtId)
    {
        return ($this->eventExtId = $_eventExtId);
    }
    /**
     * Get kind value
     * @return Egovs_Paymentbase_Model_Payplace_Enum_KindEnum|null
     */
    public function getKind()
    {
        return $this->kind;
    }
    /**
     * Set kind value
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_KindEnum::valueIsValid()
     * @param Egovs_Paymentbase_Model_Payplace_Enum_KindEnum $_kind the kind
     * @return Egovs_Paymentbase_Model_Payplace_Enum_KindEnum
     */
    public function setKind($_kind)
    {
        if(!Egovs_Paymentbase_Model_Payplace_Enum_KindEnum::valueIsValid($_kind))
        {
            return false;
        }
        return ($this->kind = $_kind);
    }
    /**
     * Get txReferenceExtId value
     * @return int|null
     */
    public function getTxReferenceExtId()
    {
        return $this->txReferenceExtId;
    }
    /**
     * Set txReferenceExtId value
     * @param int $_txReferenceExtId the txReferenceExtId
     * @return bool
     */
    public function setTxReferenceExtId($_txReferenceExtId)
    {
        return ($this->txReferenceExtId = $_txReferenceExtId);
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
     * @return Egovs_Paymentbase_Model_Payplace_Types_Tx_Diagnosis_Response
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
