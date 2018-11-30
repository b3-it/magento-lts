<?php
/**
 * File for class Egovs_Paymentbase_Model_Payplace_Types_Payment_Base_Request
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
/**
 * This class stands for Egovs_Paymentbase_Model_Payplace_Types_Payment_Base_Request originally named paymentBaseRequest
 * Meta informations extracted from the WSDL
 * - from schema : file:///etc/Callback.wsdl
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
class Egovs_Paymentbase_Model_Payplace_Types_Payment_Base_Request extends Egovs_Paymentbase_Model_Payplace_Types_Base_Request
{
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
     * The autocapture
     * Meta informations extracted from the WSDL
     * - documentation : Period – in hours – between reservation and automatic capture. If the parameter is not sent no automatic capture takes place. Values between 0 to 336 hours, thus up to 14 days in the case of credit card payments and values between 0 to 720 hours, thus up to 30 days in the case of debits are allowed.
     * - from schema : file:///etc/Callback.wsdl
     * - maxInclusive : 720
     * - minInclusive : 0
     * @var int
     */
    public $autocapture;
    /**
     * The additionalCheck
     * @var Egovs_Paymentbase_Model_Payplace_Types_Additional_Check
     */
    public $additionalCheck;
    /**
     * Constructor method for paymentBaseRequest
     * @see parent::__construct()
     * @param string $_timeStamp
     * @param string $_eventExtId
     * @param string $_basketId
     * @param Egovs_Paymentbase_Model_Payplace_Enum_KindEnum $_kind
     * @param Egovs_Paymentbase_Model_Payplace_Enum_IndicatorEnum $_indicator
     * @param Egovs_Paymentbase_Model_Payplace_Enum_SeriesFlagEnum $_seriesFlag
     * @param string $_additionalNote
     * @param Egovs_Paymentbase_Model_Payplace_Enum_DebitModeEnum $_debitMode
     * @param int $_autocapture
     * @param Egovs_Paymentbase_Model_Payplace_Types_Additional_Check $_additionalCheck
     * @return Egovs_Paymentbase_Model_Payplace_Types_Payment_Base_Request
     */
    public function __construct($_timeStamp = NULL,$_eventExtId = NULL,$_basketId = NULL,$_kind = NULL,$_indicator = NULL,$_seriesFlag = NULL,$_additionalNote = NULL,$_debitMode = NULL,$_autocapture = NULL,$_additionalCheck = NULL)
    {
        Egovs_Paymentbase_Model_Payplace_WsdlClass::__construct(array('timeStamp'=>$_timeStamp,'eventExtId'=>$_eventExtId,'basketId'=>$_basketId,'kind'=>$_kind,'indicator'=>$_indicator,'seriesFlag'=>$_seriesFlag,'additionalNote'=>$_additionalNote,'debitMode'=>$_debitMode,'autocapture'=>$_autocapture,'additionalCheck'=>$_additionalCheck),false);
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
     * Get autocapture value
     * @return int|null
     */
    public function getAutocapture()
    {
        return $this->autocapture;
    }
    /**
     * Set autocapture value
     * @param int $_autocapture the autocapture
     * @return int
     */
    public function setAutocapture($_autocapture)
    {
        return ($this->autocapture = $_autocapture);
    }
    /**
     * Get additionalCheck value
     * @return Egovs_Paymentbase_Model_Payplace_Types_Additional_Check|null
     */
    public function getAdditionalCheck()
    {
        return $this->additionalCheck;
    }
    /**
     * Set additionalCheck value
     * @param Egovs_Paymentbase_Model_Payplace_Types_Additional_Check $_additionalCheck the additionalCheck
     * @return Egovs_Paymentbase_Model_Payplace_Types_Additional_Check
     */
    public function setAdditionalCheck($_additionalCheck)
    {
        return ($this->additionalCheck = $_additionalCheck);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @uses Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @param array $_array the exported values
     * @return Egovs_Paymentbase_Model_Payplace_Types_Payment_Base_Request
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
