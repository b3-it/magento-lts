<?php
/**
 * File for class Egovs_Paymentbase_Model_Payplace_Types_RiskCheck_Request
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
/**
 * This class stands for Egovs_Paymentbase_Model_Payplace_Types_RiskCheck_Request originally named riskCheckRequest
 * Meta informations extracted from the WSDL
 * - from schema : file:///etc/Callback.wsdl
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
class Egovs_Paymentbase_Model_Payplace_Types_RiskCheck_Request extends Egovs_Paymentbase_Model_Payplace_Types_Base_Request
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
     * The bankAccount
     * @var Egovs_Paymentbase_Model_Payplace_Types_BankAccount
     */
    public $bankAccount;
    /**
     * Constructor method for riskCheckRequest
     * @see parent::__construct()
     * @param string $_timeStamp
     * @param int $_eventExtId
     * @param string $_basketId
     * @param Egovs_Paymentbase_Model_Payplace_Enum_RiskCheck_ActionEnum $_action
     * @param Egovs_Paymentbase_Model_Payplace_Types_EScore_Data $_eScoreData
     * @param string $_customerId
     * @param Egovs_Paymentbase_Model_Payplace_Types_Address_Data $_addressData
     * @param Egovs_Paymentbase_Model_Payplace_Enum_ReasonEnum $_reason
     * @param Egovs_Paymentbase_Model_Payplace_Types_BankAccount $_bankAccount
     * @return Egovs_Paymentbase_Model_Payplace_Types_RiskCheck_Request
     */
    public function __construct($_timeStamp = NULL,$_eventExtId = NULL,$_basketId = NULL,$_action = NULL,$_eScoreData = NULL,$_customerId = NULL,$_addressData = NULL,$_reason = NULL,$_bankAccount = NULL)
    {
        Egovs_Paymentbase_Model_Payplace_WsdlClass::__construct(array('timeStamp'=>$_timeStamp,'eventExtId'=>$_eventExtId,'basketId'=>$_basketId,'action'=>$_action,'eScoreData'=>$_eScoreData,'customerId'=>$_customerId,'addressData'=>$_addressData,'reason'=>$_reason,'bankAccount'=>$_bankAccount),false);
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
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @uses Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @param array $_array the exported values
     * @return Egovs_Paymentbase_Model_Payplace_Types_RiskCheck_Request
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
