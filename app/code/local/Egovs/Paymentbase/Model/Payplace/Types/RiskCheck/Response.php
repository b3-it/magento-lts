<?php
/**
 * File for class Egovs_Paymentbase_Model_Payplace_Types_RiskCheck_Response
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
/**
 * This class stands for Egovs_Paymentbase_Model_Payplace_Types_RiskCheck_Response originally named riskCheckResponse
 * Documentation : Response element for eScore and Bürgel transactions.
 * Meta informations extracted from the WSDL
 * - from schema : file:///etc/Callback.wsdl
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
class Egovs_Paymentbase_Model_Payplace_Types_RiskCheck_Response extends Egovs_Paymentbase_Model_Payplace_Types_Base_Response
{
    /**
     * The merchantId
     * Meta informations extracted from the WSDL
     * - documentation : Unique identification of the online trader for whom the transaction is carried out.
     * - from schema : file:///etc/Callback.wsdl
     * - length : 10
     * - pattern : [0-9]+
     * @var string
     */
    public $merchantId;
    /**
     * The timeStamp
     * Meta informations extracted from the WSDL
     * - documentation : Date and time in the form YYYY-MM-DDTHH:mm:ss.
     * - from schema : file:///etc/Callback.wsdl
     * - pattern : [12][9012][0-9][0-9]-(0[0-9]|1[0-2])-([0-2][0-9]|3[0-2])T[0-2][0-9]:[0-5][0-9]:[0-5][0-9]
     * @var string
     */
    public $timeStamp;
    /**
     * The eventExtId
     * Meta informations extracted from the WSDL
     * - documentation : Unique process number, that identifies this transaction for a shop.
     * - from schema : file:///etc/Callback.wsdl
     * - maxLength : 17
     * - pattern : [A-Za-z0-9_/\-]+
     * @var int
     */
    public $eventExtId;
    /**
     * The basketId
     * Meta informations extracted from the WSDL
     * - documentation : Shopping basket number. Can be freely filled in by the merchant to submit additional information.
     * - from schema : file:///etc/Callback.wsdl
     * - maxLength : 50
     * @var string
     */
    public $basketId;
    /**
     * The action
     * @var Egovs_Paymentbase_Model_Payplace_Enum_RiskCheck_ActionEnum
     */
    public $action;
    /**
     * The eScoreData
     * @var Egovs_Paymentbase_Model_Payplace_Types_EScore_Data
     */
    public $eScoreData;
    /**
     * The customerId
     * @var string
     */
    public $customerId;
    /**
     * The addressData
     * @var Egovs_Paymentbase_Model_Payplace_Types_Address_Data
     */
    public $addressData;
    /**
     * The reason
     * @var Egovs_Paymentbase_Model_Payplace_Enum_ReasonEnum
     */
    public $reason;
    /**
     * The backendTxId
     * @var string
     */
    public $backendTxId;
    /**
     * The addressNote
     * @var Egovs_Paymentbase_Model_Payplace_Enum_Address_NoteEnum
     */
    public $addressNote;
    /**
     * The eScoreFreightRoutingCode
     * Meta informations extracted from the WSDL
     * - documentation : Freight routing code of the Deutsche Post AG (German mail)
     * - from schema : file:///etc/Callback.wsdl
     * - maxLength : 12
     * @var string
     */
    public $eScoreFreightRoutingCode;
    /**
     * The score
     * @var string
     */
    public $score;
    /**
     * The eScoreInformaScoreVal
     * Meta informations extracted from the WSDL
     * - documentation : Generated scoring value of the InFoScore Consumer Data GmbH.
     * - from schema : file:///etc/Callback.wsdl
     * - length : 3
     * - pattern : [0-9]+
     * @var string
     */
    public $eScoreInformaScoreVal;
    /**
     * The eScoreScoreType
     * Meta informations extracted from the WSDL
     * - documentation : Score type (B or I or M) and 3 digits for further classification.
     * - from schema : file:///etc/Callback.wsdl
     * - length : 4
     * @var string
     */
    public $eScoreScoreType;
    /**
     * The negativeCriterion
     * @var Egovs_Paymentbase_Model_Payplace_Types_NegativeCriterion
     */
    public $negativeCriterion;
    /**
     * The relation
     * @var Egovs_Paymentbase_Model_Payplace_Types_Relation
     */
    public $relation;
    /**
     * The bankAccount
     * @var Egovs_Paymentbase_Model_Payplace_Types_BankAccount
     */
    public $bankAccount;
    /**
     * The eScoreBankAccountValidationResult
     * Meta informations extracted from the WSDL
     * - documentation : Result of the validation
     * - from schema : file:///etc/Callback.wsdl
     * - length : 2
     * - pattern : [0-9]+
     * @var string
     */
    public $eScoreBankAccountValidationResult;
    /**
     * The eScoreBankAccountValidationMessage
     * Meta informations extracted from the WSDL
     * - documentation : Description of the validation result
     * - from schema : file:///etc/Callback.wsdl
     * - maxLength : 30
     * @var string
     */
    public $eScoreBankAccountValidationMessage;
    /**
     * The eScoreRppMatch
     * @var Egovs_Paymentbase_Model_Payplace_Enum_EScore_Rpp_Match
     */
    public $eScoreRppMatch;
    /**
     * The eScoreRppResult
     * @var Egovs_Paymentbase_Model_Payplace_Types_EScore_RppResult
     */
    public $eScoreRppResult;
    /**
     * The eScoreErrorCodeName
     * Meta informations extracted from the WSDL
     * - documentation : error code of the RPP check
     * - from schema : file:///etc/Callback.wsdl
     * - maxLength : 33
     * @var string
     */
    public $eScoreErrorCodeName;
    /**
     * The eScoreErrorDescription
     * Meta informations extracted from the WSDL
     * - documentation : Error description of the RPP check
     * - from schema : file:///etc/Callback.wsdl
     * - maxLength : 50
     * @var string
     */
    public $eScoreErrorDescription;
    /**
     * The scoringRc
     * @var Egovs_Paymentbase_Model_Payplace_Enum_Scoring_RcEnum
     */
    public $scoringRc;
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
     * The txExtId
     * Meta informations extracted from the WSDL
     * - documentation : A uniqe identification returned by the system to reference a transaction.
     * - from schema : file:///etc/Callback.wsdl
     * - maxLength : 20
     * - pattern : [A-Za-z0-9_/\-]+
     * @var int
     */
    public $txExtId;
    /**
     * Constructor method for riskCheckResponse
     * @see parent::__construct()
     * @param string $_merchantId
     * @param string $_timeStamp
     * @param int $_eventExtId
     * @param string $_basketId
     * @param Egovs_Paymentbase_Model_Payplace_Enum_RiskCheck_ActionEnum $_action
     * @param Egovs_Paymentbase_Model_Payplace_Types_EScore_Data $_eScoreData
     * @param string $_customerId
     * @param Egovs_Paymentbase_Model_Payplace_Types_Address_Data $_addressData
     * @param Egovs_Paymentbase_Model_Payplace_Enum_ReasonEnum $_reason
     * @param string $_backendTxId
     * @param Egovs_Paymentbase_Model_Payplace_Enum_Address_NoteEnum $_addressNote
     * @param string $_eScoreFreightRoutingCode
     * @param string $_score
     * @param string $_eScoreInformaScoreVal
     * @param string $_eScoreScoreType
     * @param Egovs_Paymentbase_Model_Payplace_Types_NegativeCriterion $_negativeCriterion
     * @param Egovs_Paymentbase_Model_Payplace_Types_Relation $_relation
     * @param Egovs_Paymentbase_Model_Payplace_Types_BankAccount $_bankAccount
     * @param string $_eScoreBankAccountValidationResult
     * @param string $_eScoreBankAccountValidationMessage
     * @param Egovs_Paymentbase_Model_Payplace_Enum_EScore_Rpp_Match $_eScoreRppMatch
     * @param Egovs_Paymentbase_Model_Payplace_Types_EScore_RppResult $_eScoreRppResult
     * @param string $_eScoreErrorCodeName
     * @param string $_eScoreErrorDescription
     * @param Egovs_Paymentbase_Model_Payplace_Enum_Scoring_RcEnum $_scoringRc
     * @param string $_rc
     * @param string $_message
     * @param int $_txExtId
     * @return Egovs_Paymentbase_Model_Payplace_Types_RiskCheck_Response
     */
    public function __construct($_merchantId = NULL,$_timeStamp = NULL,$_eventExtId = NULL,$_basketId = NULL,$_action = NULL,$_eScoreData = NULL,$_customerId = NULL,$_addressData = NULL,$_reason = NULL,$_backendTxId = NULL,$_addressNote = NULL,$_eScoreFreightRoutingCode = NULL,$_score = NULL,$_eScoreInformaScoreVal = NULL,$_eScoreScoreType = NULL,$_negativeCriterion = NULL,$_relation = NULL,$_bankAccount = NULL,$_eScoreBankAccountValidationResult = NULL,$_eScoreBankAccountValidationMessage = NULL,$_eScoreRppMatch = NULL,$_eScoreRppResult = NULL,$_eScoreErrorCodeName = NULL,$_eScoreErrorDescription = NULL,$_scoringRc = NULL,$_rc = NULL,$_message = NULL,$_txExtId = NULL)
    {
        Egovs_Paymentbase_Model_Payplace_WsdlClass::__construct(array('merchantId'=>$_merchantId,'timeStamp'=>$_timeStamp,'eventExtId'=>$_eventExtId,'basketId'=>$_basketId,'action'=>$_action,'eScoreData'=>$_eScoreData,'customerId'=>$_customerId,'addressData'=>$_addressData,'reason'=>$_reason,'backendTxId'=>$_backendTxId,'addressNote'=>$_addressNote,'eScoreFreightRoutingCode'=>$_eScoreFreightRoutingCode,'score'=>$_score,'eScoreInformaScoreVal'=>$_eScoreInformaScoreVal,'eScoreScoreType'=>$_eScoreScoreType,'negativeCriterion'=>$_negativeCriterion,'relation'=>$_relation,'bankAccount'=>$_bankAccount,'eScoreBankAccountValidationResult'=>$_eScoreBankAccountValidationResult,'eScoreBankAccountValidationMessage'=>$_eScoreBankAccountValidationMessage,'eScoreRppMatch'=>$_eScoreRppMatch,'eScoreRppResult'=>$_eScoreRppResult,'eScoreErrorCodeName'=>$_eScoreErrorCodeName,'eScoreErrorDescription'=>$_eScoreErrorDescription,'scoringRc'=>$_scoringRc,'rc'=>$_rc,'message'=>$_message,'txExtId'=>$_txExtId),false);
    }
    /**
     * Get merchantId value
     * @return string|null
     */
    public function getMerchantId()
    {
        return $this->merchantId;
    }
    /**
     * Set merchantId value
     * @param string $_merchantId the merchantId
     * @return string
     */
    public function setMerchantId($_merchantId)
    {
        return ($this->merchantId = $_merchantId);
    }
    /**
     * Get timeStamp value
     * @return string|null
     */
    public function getTimeStamp()
    {
        return $this->timeStamp;
    }
    /**
     * Set timeStamp value
     * @param string $_timeStamp the timeStamp
     * @return string
     */
    public function setTimeStamp($_timeStamp)
    {
        return ($this->timeStamp = $_timeStamp);
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
     * Get basketId value
     * @return string|null
     */
    public function getBasketId()
    {
        return $this->basketId;
    }
    /**
     * Set basketId value
     * @param string $_basketId the basketId
     * @return string
     */
    public function setBasketId($_basketId)
    {
        return ($this->basketId = $_basketId);
    }
    /**
     * Get action value
     * @return Egovs_Paymentbase_Model_Payplace_Enum_RiskCheck_ActionEnum|null
     */
    public function getAction()
    {
        return $this->action;
    }
    /**
     * Set action value
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_RiskCheck_ActionEnum::valueIsValid()
     * @param Egovs_Paymentbase_Model_Payplace_Enum_RiskCheck_ActionEnum $_action the action
     * @return Egovs_Paymentbase_Model_Payplace_Enum_RiskCheck_ActionEnum
     */
    public function setAction($_action)
    {
        if(!Egovs_Paymentbase_Model_Payplace_Enum_RiskCheck_ActionEnum::valueIsValid($_action))
        {
            return false;
        }
        return ($this->action = $_action);
    }
    /**
     * Get eScoreData value
     * @return Egovs_Paymentbase_Model_Payplace_Types_EScore_Data|null
     */
    public function getEScoreData()
    {
        return $this->eScoreData;
    }
    /**
     * Set eScoreData value
     * @param Egovs_Paymentbase_Model_Payplace_Types_EScore_Data $_eScoreData the eScoreData
     * @return Egovs_Paymentbase_Model_Payplace_Types_EScore_Data
     */
    public function setEScoreData($_eScoreData)
    {
        return ($this->eScoreData = $_eScoreData);
    }
    /**
     * Get customerId value
     * @return string|null
     */
    public function getCustomerId()
    {
        return $this->customerId;
    }
    /**
     * Set customerId value
     * @param string $_customerId the customerId
     * @return string
     */
    public function setCustomerId($_customerId)
    {
        return ($this->customerId = $_customerId);
    }
    /**
     * Get addressData value
     * @return Egovs_Paymentbase_Model_Payplace_Types_Address_Data|null
     */
    public function getAddressData()
    {
        return $this->addressData;
    }
    /**
     * Set addressData value
     * @param Egovs_Paymentbase_Model_Payplace_Types_Address_Data $_addressData the addressData
     * @return Egovs_Paymentbase_Model_Payplace_Types_Address_Data
     */
    public function setAddressData($_addressData)
    {
        return ($this->addressData = $_addressData);
    }
    /**
     * Get reason value
     * @return Egovs_Paymentbase_Model_Payplace_Enum_ReasonEnum|null
     */
    public function getReason()
    {
        return $this->reason;
    }
    /**
     * Set reason value
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_ReasonEnum::valueIsValid()
     * @param Egovs_Paymentbase_Model_Payplace_Enum_ReasonEnum $_reason the reason
     * @return Egovs_Paymentbase_Model_Payplace_Enum_ReasonEnum
     */
    public function setReason($_reason)
    {
        if(!Egovs_Paymentbase_Model_Payplace_Enum_ReasonEnum::valueIsValid($_reason))
        {
            return false;
        }
        return ($this->reason = $_reason);
    }
    /**
     * Get backendTxId value
     * @return string|null
     */
    public function getBackendTxId()
    {
        return $this->backendTxId;
    }
    /**
     * Set backendTxId value
     * @param string $_backendTxId the backendTxId
     * @return string
     */
    public function setBackendTxId($_backendTxId)
    {
        return ($this->backendTxId = $_backendTxId);
    }
    /**
     * Get addressNote value
     * @return Egovs_Paymentbase_Model_Payplace_Enum_Address_NoteEnum|null
     */
    public function getAddressNote()
    {
        return $this->addressNote;
    }
    /**
     * Set addressNote value
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_Address_NoteEnum::valueIsValid()
     * @param Egovs_Paymentbase_Model_Payplace_Enum_Address_NoteEnum $_addressNote the addressNote
     * @return Egovs_Paymentbase_Model_Payplace_Enum_Address_NoteEnum
     */
    public function setAddressNote($_addressNote)
    {
        if(!Egovs_Paymentbase_Model_Payplace_Enum_Address_NoteEnum::valueIsValid($_addressNote))
        {
            return false;
        }
        return ($this->addressNote = $_addressNote);
    }
    /**
     * Get eScoreFreightRoutingCode value
     * @return string|null
     */
    public function getEScoreFreightRoutingCode()
    {
        return $this->eScoreFreightRoutingCode;
    }
    /**
     * Set eScoreFreightRoutingCode value
     * @param string $_eScoreFreightRoutingCode the eScoreFreightRoutingCode
     * @return string
     */
    public function setEScoreFreightRoutingCode($_eScoreFreightRoutingCode)
    {
        return ($this->eScoreFreightRoutingCode = $_eScoreFreightRoutingCode);
    }
    /**
     * Get score value
     * @return string|null
     */
    public function getScore()
    {
        return $this->score;
    }
    /**
     * Set score value
     * @param string $_score the score
     * @return string
     */
    public function setScore($_score)
    {
        return ($this->score = $_score);
    }
    /**
     * Get eScoreInformaScoreVal value
     * @return string|null
     */
    public function getEScoreInformaScoreVal()
    {
        return $this->eScoreInformaScoreVal;
    }
    /**
     * Set eScoreInformaScoreVal value
     * @param string $_eScoreInformaScoreVal the eScoreInformaScoreVal
     * @return string
     */
    public function setEScoreInformaScoreVal($_eScoreInformaScoreVal)
    {
        return ($this->eScoreInformaScoreVal = $_eScoreInformaScoreVal);
    }
    /**
     * Get eScoreScoreType value
     * @return string|null
     */
    public function getEScoreScoreType()
    {
        return $this->eScoreScoreType;
    }
    /**
     * Set eScoreScoreType value
     * @param string $_eScoreScoreType the eScoreScoreType
     * @return string
     */
    public function setEScoreScoreType($_eScoreScoreType)
    {
        return ($this->eScoreScoreType = $_eScoreScoreType);
    }
    /**
     * Get negativeCriterion value
     * @return Egovs_Paymentbase_Model_Payplace_Types_NegativeCriterion|null
     */
    public function getNegativeCriterion()
    {
        return $this->negativeCriterion;
    }
    /**
     * Set negativeCriterion value
     * @param Egovs_Paymentbase_Model_Payplace_Types_NegativeCriterion $_negativeCriterion the negativeCriterion
     * @return Egovs_Paymentbase_Model_Payplace_Types_NegativeCriterion
     */
    public function setNegativeCriterion($_negativeCriterion)
    {
        return ($this->negativeCriterion = $_negativeCriterion);
    }
    /**
     * Get relation value
     * @return Egovs_Paymentbase_Model_Payplace_Types_Relation|null
     */
    public function getRelation()
    {
        return $this->relation;
    }
    /**
     * Set relation value
     * @param Egovs_Paymentbase_Model_Payplace_Types_Relation $_relation the relation
     * @return Egovs_Paymentbase_Model_Payplace_Types_Relation
     */
    public function setRelation($_relation)
    {
        return ($this->relation = $_relation);
    }
    /**
     * Get bankAccount value
     * @return Egovs_Paymentbase_Model_Payplace_Types_BankAccount|null
     */
    public function getBankAccount()
    {
        return $this->bankAccount;
    }
    /**
     * Set bankAccount value
     * @param Egovs_Paymentbase_Model_Payplace_Types_BankAccount $_bankAccount the bankAccount
     * @return Egovs_Paymentbase_Model_Payplace_Types_BankAccount
     */
    public function setBankAccount($_bankAccount)
    {
        return ($this->bankAccount = $_bankAccount);
    }
    /**
     * Get eScoreBankAccountValidationResult value
     * @return string|null
     */
    public function getEScoreBankAccountValidationResult()
    {
        return $this->eScoreBankAccountValidationResult;
    }
    /**
     * Set eScoreBankAccountValidationResult value
     * @param string $_eScoreBankAccountValidationResult the eScoreBankAccountValidationResult
     * @return string
     */
    public function setEScoreBankAccountValidationResult($_eScoreBankAccountValidationResult)
    {
        return ($this->eScoreBankAccountValidationResult = $_eScoreBankAccountValidationResult);
    }
    /**
     * Get eScoreBankAccountValidationMessage value
     * @return string|null
     */
    public function getEScoreBankAccountValidationMessage()
    {
        return $this->eScoreBankAccountValidationMessage;
    }
    /**
     * Set eScoreBankAccountValidationMessage value
     * @param string $_eScoreBankAccountValidationMessage the eScoreBankAccountValidationMessage
     * @return string
     */
    public function setEScoreBankAccountValidationMessage($_eScoreBankAccountValidationMessage)
    {
        return ($this->eScoreBankAccountValidationMessage = $_eScoreBankAccountValidationMessage);
    }
    /**
     * Get eScoreRppMatch value
     * @return Egovs_Paymentbase_Model_Payplace_Enum_EScore_Rpp_Match|null
     */
    public function getEScoreRppMatch()
    {
        return $this->eScoreRppMatch;
    }
    /**
     * Set eScoreRppMatch value
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_EScore_Rpp_Match::valueIsValid()
     * @param Egovs_Paymentbase_Model_Payplace_Enum_EScore_Rpp_Match $_eScoreRppMatch the eScoreRppMatch
     * @return Egovs_Paymentbase_Model_Payplace_Enum_EScore_Rpp_Match
     */
    public function setEScoreRppMatch($_eScoreRppMatch)
    {
        if(!Egovs_Paymentbase_Model_Payplace_Enum_EScore_Rpp_Match::valueIsValid($_eScoreRppMatch))
        {
            return false;
        }
        return ($this->eScoreRppMatch = $_eScoreRppMatch);
    }
    /**
     * Get eScoreRppResult value
     * @return Egovs_Paymentbase_Model_Payplace_Types_EScore_RppResult|null
     */
    public function getEScoreRppResult()
    {
        return $this->eScoreRppResult;
    }
    /**
     * Set eScoreRppResult value
     * @param Egovs_Paymentbase_Model_Payplace_Types_EScore_RppResult $_eScoreRppResult the eScoreRppResult
     * @return Egovs_Paymentbase_Model_Payplace_Types_EScore_RppResult
     */
    public function setEScoreRppResult($_eScoreRppResult)
    {
        return ($this->eScoreRppResult = $_eScoreRppResult);
    }
    /**
     * Get eScoreErrorCodeName value
     * @return string|null
     */
    public function getEScoreErrorCodeName()
    {
        return $this->eScoreErrorCodeName;
    }
    /**
     * Set eScoreErrorCodeName value
     * @param string $_eScoreErrorCodeName the eScoreErrorCodeName
     * @return string
     */
    public function setEScoreErrorCodeName($_eScoreErrorCodeName)
    {
        return ($this->eScoreErrorCodeName = $_eScoreErrorCodeName);
    }
    /**
     * Get eScoreErrorDescription value
     * @return string|null
     */
    public function getEScoreErrorDescription()
    {
        return $this->eScoreErrorDescription;
    }
    /**
     * Set eScoreErrorDescription value
     * @param string $_eScoreErrorDescription the eScoreErrorDescription
     * @return string
     */
    public function setEScoreErrorDescription($_eScoreErrorDescription)
    {
        return ($this->eScoreErrorDescription = $_eScoreErrorDescription);
    }
    /**
     * Get scoringRc value
     * @return Egovs_Paymentbase_Model_Payplace_Enum_Scoring_RcEnum|null
     */
    public function getScoringRc()
    {
        return $this->scoringRc;
    }
    /**
     * Set scoringRc value
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_Scoring_RcEnum::valueIsValid()
     * @param Egovs_Paymentbase_Model_Payplace_Enum_Scoring_RcEnum $_scoringRc the scoringRc
     * @return Egovs_Paymentbase_Model_Payplace_Enum_Scoring_RcEnum
     */
    public function setScoringRc($_scoringRc)
    {
        if(!Egovs_Paymentbase_Model_Payplace_Enum_Scoring_RcEnum::valueIsValid($_scoringRc))
        {
            return false;
        }
        return ($this->scoringRc = $_scoringRc);
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
     * Get txExtId value
     * @return int|null
     */
    public function getTxExtId()
    {
        return $this->txExtId;
    }
    /**
     * Set txExtId value
     * @param int $_txExtId the txExtId
     * @return bool
     */
    public function setTxExtId($_txExtId)
    {
        return ($this->txExtId = $_txExtId);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @uses Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @param array $_array the exported values
     * @return Egovs_Paymentbase_Model_Payplace_Types_RiskCheck_Response
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
