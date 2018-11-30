<?php
/**
 * File for class Egovs_Paymentbase_Model_Payplace_Types_Payment_Response
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
/**
 * This class stands for Egovs_Paymentbase_Model_Payplace_Types_Payment_Response originally named paymentResponse
 * Meta informations extracted from the WSDL
 * - from schema : file:///etc/Callback.wsdl
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
class Egovs_Paymentbase_Model_Payplace_Types_Payment_Response extends Egovs_Paymentbase_Model_Payplace_Types_Base_Response
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
     * @var string
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
     * The kind
     * @var Egovs_Paymentbase_Model_Payplace_Enum_KindEnum
     */
    public $kind;
    /**
     * The indicator
     * @var Egovs_Paymentbase_Model_Payplace_Enum_IndicatorEnum
     */
    public $indicator;
    /**
     * The seriesFlag
     * @var Egovs_Paymentbase_Model_Payplace_Enum_SeriesFlagEnum
     */
    public $seriesFlag;
    /**
     * The additionalNote
     * Meta informations extracted from the WSDL
     * - documentation : Overrides the merchant name on the customer's credit card statement.
     * - from schema : file:///etc/Callback.wsdl
     * - maxLength : 25
     * - minLength : 1
     * @var string
     */
    public $additionalNote;
    /**
     * The debitMode
     * @var Egovs_Paymentbase_Model_Payplace_Enum_DebitModeEnum
     */
    public $debitMode;
    /**
     * The action
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var Egovs_Paymentbase_Model_Payplace_Enum_Action
     */
    public $action;
    /**
     * The brand
     * @var string
     */
    public $brand;
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
     * The changedAmount
     * Meta informations extracted from the WSDL
     * - documentation : Amount in the smallest currency unit (Cent in the case of the Euro). Only has to be submitted if different from the amount of the referenced transaction.
     * - from schema : file:///etc/Callback.wsdl
     * - minInclusive : 1
     * @var float
     */
    public $changedAmount;
    /**
     * The amount
     * Meta informations extracted from the WSDL
     * - documentation : Amount in the smallest currency unit (Cent in the case of the Euro).
     * - from schema : file:///etc/Callback.wsdl
     * - minInclusive : 0
     * @var float
     */
    public $amount;
    /**
     * The currency
     * Meta informations extracted from the WSDL
     * - documentation : Three letter currency code according to ISO 4217.
     * - from schema : file:///etc/Callback.wsdl
     * - length : 3
     * - pattern : [A-Z]+
     * @var string
     */
    public $currency;
    /**
     * The creditCard
     * @var Egovs_Paymentbase_Model_Payplace_Types_CreditCard
     */
    public $creditCard;
    /**
     * The bankAccount
     * @var Egovs_Paymentbase_Model_Payplace_Types_BankAccount
     */
    public $bankAccount;
    /**
     * The batchReferenceExtId
     * Meta informations extracted from the WSDL
     * - minLength : 1
     * @var int
     */
    public $batchReferenceExtId;
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
     * The backRc
     * Meta informations extracted from the WSDL
     * - documentation : Response code of a back end system (if available).E.g. GICC response code in the case of credit card transactions.
     * - minOccurs : 0
     * @var string
     */
    public $backRc;
    /**
     * The txExtId
     * Meta informations extracted from the WSDL
     * - documentation : A uniqe identification returned by the system to reference a transaction.
     * - from schema : file:///etc/Callback.wsdl
     * - maxLength : 20
     * - pattern : [A-Za-z0-9_/\-]+
     * @var string
     */
    public $txExtId;
    /**
     * The backendTxId
     * @var string
     */
    public $backendTxId;
    /**
     * The aid
     * @var string
     */
    public $aid;
    /**
     * The additionalData
     * @var string
     */
    public $additionalData;
    /**
     * The compareResult
     * @var Egovs_Paymentbase_Model_Payplace_Types_Compare_Result
     */
    public $compareResult;
    /**
     * The scoringRc
     * @var Egovs_Paymentbase_Model_Payplace_Enum_Scoring_RcEnum
     */
    public $scoringRc;
    /**
     * The rcAvsAmex
     * Meta informations extracted from the WSDL
     * - documentation : If an American Express address verification was carried out.
     * - minOccurs : 0
     * @var string
     */
    public $rcAvsAmex;
    /**
     * Constructor method for paymentResponse
     * @see parent::__construct()
     * @param string $_merchantId
     * @param string $_timeStamp
     * @param string $_eventExtId
     * @param string $_basketId
     * @param Egovs_Paymentbase_Model_Payplace_Enum_KindEnum $_kind
     * @param Egovs_Paymentbase_Model_Payplace_Enum_IndicatorEnum $_indicator
     * @param Egovs_Paymentbase_Model_Payplace_Enum_SeriesFlagEnum $_seriesFlag
     * @param string $_additionalNote
     * @param Egovs_Paymentbase_Model_Payplace_Enum_DebitModeEnum $_debitMode
     * @param Egovs_Paymentbase_Model_Payplace_Enum_Action $_action
     * @param string $_brand
     * @param string $_txReferenceExtId
     * @param float $_changedAmount
     * @param float $_amount
     * @param string $_currency
     * @param Egovs_Paymentbase_Model_Payplace_Types_CreditCard $_creditCard
     * @param Egovs_Paymentbase_Model_Payplace_Types_BankAccount $_bankAccount
     * @param int $_batchReferenceExtId
     * @param string $_rc
     * @param string $_message
     * @param string $_backRc
     * @param string $_txExtId
     * @param string $_backendTxId
     * @param string $_aid
     * @param string $_additionalData
     * @param Egovs_Paymentbase_Model_Payplace_Types_Compare_Result $_compareResult
     * @param Egovs_Paymentbase_Model_Payplace_Enum_Scoring_RcEnum $_scoringRc
     * @param string $_rcAvsAmex
     * @return Egovs_Paymentbase_Model_Payplace_Types_Payment_Response
     */
    public function __construct($_merchantId = NULL,$_timeStamp = NULL,$_eventExtId = NULL,$_basketId = NULL,$_kind = NULL,$_indicator = NULL,$_seriesFlag = NULL,$_additionalNote = NULL,$_debitMode = NULL,$_action = NULL,$_brand = NULL,$_txReferenceExtId = NULL,$_changedAmount = NULL,$_amount = NULL,$_currency = NULL,$_creditCard = NULL,$_bankAccount = NULL,$_batchReferenceExtId = NULL,$_rc = NULL,$_message = NULL,$_backRc = NULL,$_txExtId = NULL,$_backendTxId = NULL,$_aid = NULL,$_additionalData = NULL,$_compareResult = NULL,$_scoringRc = NULL,$_rcAvsAmex = NULL)
    {
        Egovs_Paymentbase_Model_Payplace_WsdlClass::__construct(array('merchantId'=>$_merchantId,'timeStamp'=>$_timeStamp,'eventExtId'=>$_eventExtId,'basketId'=>$_basketId,'kind'=>$_kind,'indicator'=>$_indicator,'seriesFlag'=>$_seriesFlag,'additionalNote'=>$_additionalNote,'debitMode'=>$_debitMode,'action'=>$_action,'brand'=>$_brand,'txReferenceExtId'=>$_txReferenceExtId,'changedAmount'=>$_changedAmount,'amount'=>$_amount,'currency'=>$_currency,'creditCard'=>$_creditCard,'bankAccount'=>$_bankAccount,'batchReferenceExtId'=>$_batchReferenceExtId,'rc'=>$_rc,'message'=>$_message,'backRc'=>$_backRc,'txExtId'=>$_txExtId,'backendTxId'=>$_backendTxId,'aid'=>$_aid,'additionalData'=>$_additionalData,'compareResult'=>$_compareResult,'scoringRc'=>$_scoringRc,'rcAvsAmex'=>$_rcAvsAmex),false);
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
     * @return string|null
     */
    public function getEventExtId()
    {
        return $this->eventExtId;
    }
    /**
     * Set eventExtId value
     * @param string $_eventExtId the eventExtId
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
     * Get indicator value
     * @return Egovs_Paymentbase_Model_Payplace_Enum_IndicatorEnum|null
     */
    public function getIndicator()
    {
        return $this->indicator;
    }
    /**
     * Set indicator value
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_IndicatorEnum::valueIsValid()
     * @param Egovs_Paymentbase_Model_Payplace_Enum_IndicatorEnum $_indicator the indicator
     * @return Egovs_Paymentbase_Model_Payplace_Enum_IndicatorEnum
     */
    public function setIndicator($_indicator)
    {
        if(!Egovs_Paymentbase_Model_Payplace_Enum_IndicatorEnum::valueIsValid($_indicator))
        {
            return false;
        }
        return ($this->indicator = $_indicator);
    }
    /**
     * Get seriesFlag value
     * @return Egovs_Paymentbase_Model_Payplace_Enum_SeriesFlagEnum|null
     */
    public function getSeriesFlag()
    {
        return $this->seriesFlag;
    }
    /**
     * Set seriesFlag value
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_SeriesFlagEnum::valueIsValid()
     * @param Egovs_Paymentbase_Model_Payplace_Enum_SeriesFlagEnum $_seriesFlag the seriesFlag
     * @return Egovs_Paymentbase_Model_Payplace_Enum_SeriesFlagEnum
     */
    public function setSeriesFlag($_seriesFlag)
    {
        if(!Egovs_Paymentbase_Model_Payplace_Enum_SeriesFlagEnum::valueIsValid($_seriesFlag))
        {
            return false;
        }
        return ($this->seriesFlag = $_seriesFlag);
    }
    /**
     * Get additionalNote value
     * @return string|null
     */
    public function getAdditionalNote()
    {
        return $this->additionalNote;
    }
    /**
     * Set additionalNote value
     * @param string $_additionalNote the additionalNote
     * @return string
     */
    public function setAdditionalNote($_additionalNote)
    {
        return ($this->additionalNote = $_additionalNote);
    }
    /**
     * Get debitMode value
     * @return Egovs_Paymentbase_Model_Payplace_Enum_DebitModeEnum|null
     */
    public function getDebitMode()
    {
        return $this->debitMode;
    }
    /**
     * Set debitMode value
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_DebitModeEnum::valueIsValid()
     * @param Egovs_Paymentbase_Model_Payplace_Enum_DebitModeEnum $_debitMode the debitMode
     * @return Egovs_Paymentbase_Model_Payplace_Enum_DebitModeEnum
     */
    public function setDebitMode($_debitMode)
    {
        if(!Egovs_Paymentbase_Model_Payplace_Enum_DebitModeEnum::valueIsValid($_debitMode))
        {
            return false;
        }
        return ($this->debitMode = $_debitMode);
    }
    /**
     * Get action value
     * @return Egovs_Paymentbase_Model_Payplace_Enum_Action|null
     */
    public function getAction()
    {
        return $this->action;
    }
    /**
     * Set action value
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_Action::valueIsValid()
     * @param Egovs_Paymentbase_Model_Payplace_Enum_Action $_action the action
     * @return Egovs_Paymentbase_Model_Payplace_Enum_Action
     */
    public function setAction($_action)
    {
        if(!Egovs_Paymentbase_Model_Payplace_Enum_Action::valueIsValid($_action))
        {
            return false;
        }
        return ($this->action = $_action);
    }
    /**
     * Get brand value
     * @return string|null
     */
    public function getBrand()
    {
        return $this->brand;
    }
    /**
     * Set brand value
     * @param string $_brand the brand
     * @return string
     */
    public function setBrand($_brand)
    {
        return ($this->brand = $_brand);
    }
    /**
     * Get txReferenceExtId value
     * @return string|null
     */
    public function getTxReferenceExtId()
    {
        return $this->txReferenceExtId;
    }
    /**
     * Set txReferenceExtId value
     * @param string $_txReferenceExtId the txReferenceExtId
     * @return bool
     */
    public function setTxReferenceExtId($_txReferenceExtId)
    {
        return ($this->txReferenceExtId = $_txReferenceExtId);
    }
    /**
     * Get changedAmount value
     * @return float|null
     */
    public function getChangedAmount()
    {
        return $this->changedAmount;
    }
    /**
     * Set changedAmount value
     * @param float $_changedAmount the changedAmount
     * @return bool
     */
    public function setChangedAmount($_changedAmount)
    {
        return ($this->changedAmount = $_changedAmount);
    }
    /**
     * Get amount value
     * @return float|null
     */
    public function getAmount()
    {
        return $this->amount;
    }
    /**
     * Set amount value
     * @param float $_amount the amount
     * @return bool
     */
    public function setAmount($_amount)
    {
        return ($this->amount = $_amount);
    }
    /**
     * Get currency value
     * @return string|null
     */
    public function getCurrency()
    {
        return $this->currency;
    }
    /**
     * Set currency value
     * @param string $_currency the currency
     * @return string
     */
    public function setCurrency($_currency)
    {
        return ($this->currency = $_currency);
    }
    /**
     * Get creditCard value
     * @return Egovs_Paymentbase_Model_Payplace_Types_CreditCard|null
     */
    public function getCreditCard()
    {
        return $this->creditCard;
    }
    /**
     * Set creditCard value
     * @param Egovs_Paymentbase_Model_Payplace_Types_CreditCard $_creditCard the creditCard
     * @return Egovs_Paymentbase_Model_Payplace_Types_CreditCard
     */
    public function setCreditCard($_creditCard)
    {
        return ($this->creditCard = $_creditCard);
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
     * Get batchReferenceExtId value
     * @return int|null
     */
    public function getBatchReferenceExtId()
    {
        return $this->batchReferenceExtId;
    }
    /**
     * Set batchReferenceExtId value
     * @param int $_batchReferenceExtId the batchReferenceExtId
     * @return bool
     */
    public function setBatchReferenceExtId($_batchReferenceExtId)
    {
        return ($this->batchReferenceExtId = $_batchReferenceExtId);
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
     * Get backRc value
     * @return string|null
     */
    public function getBackRc()
    {
        return $this->backRc;
    }
    /**
     * Set backRc value
     * @param string $_backRc the backRc
     * @return string
     */
    public function setBackRc($_backRc)
    {
        return ($this->backRc = $_backRc);
    }
    /**
     * Get txExtId value
     * @return string|null
     */
    public function getTxExtId()
    {
        return $this->txExtId;
    }
    /**
     * Set txExtId value
     * @param string $_txExtId the txExtId
     * @return bool
     */
    public function setTxExtId($_txExtId)
    {
        return ($this->txExtId = $_txExtId);
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
     * Get aid value
     * @return string|null
     */
    public function getAid()
    {
        return $this->aid;
    }
    /**
     * Set aid value
     * @param string $_aid the aid
     * @return string
     */
    public function setAid($_aid)
    {
        return ($this->aid = $_aid);
    }
    /**
     * Get additionalData value
     * @return string|null
     */
    public function getAdditionalData()
    {
        return $this->additionalData;
    }
    /**
     * Set additionalData value
     * @param string $_additionalData the additionalData
     * @return string
     */
    public function setAdditionalData($_additionalData)
    {
        return ($this->additionalData = $_additionalData);
    }
    /**
     * Get compareResult value
     * @return Egovs_Paymentbase_Model_Payplace_Types_Compare_Result|null
     */
    public function getCompareResult()
    {
        return $this->compareResult;
    }
    /**
     * Set compareResult value
     * @param Egovs_Paymentbase_Model_Payplace_Types_Compare_Result $_compareResult the compareResult
     * @return bool
     */
    public function setCompareResult($_compareResult)
    {
        return ($this->compareResult = $_compareResult);
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
     * Get rcAvsAmex value
     * @return string|null
     */
    public function getRcAvsAmex()
    {
        return $this->rcAvsAmex;
    }
    /**
     * Set rcAvsAmex value
     * @param string $_rcAvsAmex the rcAvsAmex
     * @return string
     */
    public function setRcAvsAmex($_rcAvsAmex)
    {
        return ($this->rcAvsAmex = $_rcAvsAmex);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @uses Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @param array $_array the exported values
     * @return Egovs_Paymentbase_Model_Payplace_Types_Payment_Response
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
