<?php
/**
 * File for class Egovs_Paymentbase_Model_Payplace_Types_Form_Service_Request
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
/**
 * This class stands for Egovs_Paymentbase_Model_Payplace_Types_Form_Service_Request originally named formServiceRequest
 * Meta informations extracted from the WSDL
 * - from schema : file:///etc/Callback.wsdl
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
class Egovs_Paymentbase_Model_Payplace_Types_Form_Service_Request extends Egovs_Paymentbase_Model_Payplace_Types_Payment_Base_Request
{
    /**
     * The action
     * @var Egovs_Paymentbase_Model_Payplace_Enum_Action
     */
    public $action;
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
     * The bankAccount
     * @var Egovs_Paymentbase_Model_Payplace_Types_BankAccount
     */
    public $bankAccount;
    /**
     * The giropayData
     * @var Egovs_Paymentbase_Model_Payplace_Types_Giropay_Data
     */
    public $giropayData;
    /**
     * The panalias
     * @var Egovs_Paymentbase_Model_Payplace_Types_Panalias
     */
    public $panalias;
    /**
     * The merchantRef
     * Meta informations extracted from the WSDL
     * - documentation : Transaction reference for credit card transactions.
     * - from schema : file:///etc/Callback.wsdl
     * - maxLength : 30
     * - pattern : [a-zA-Z0-9/,.+ _\-]*
     * @var string
     */
    public $merchantRef;
    /**
     * The address
     * @var Egovs_Paymentbase_Model_Payplace_Types_Address
     */
    public $address;
    /**
     * The dueDate
     * Meta informations extracted from the WSDL
     * - documentation : A date in YYYY-MM-DD format.
     * - pattern : [12][0-9][0-9][0-9]-(1[0-3]|0[1-9])-[0-3][0-9]
     * @var string
     */
    public $dueDate;
    /**
     * The mandate
     * @var Egovs_Paymentbase_Model_Payplace_Types_Mandate
     */
    public $mandate;
    /**
     * The additionalData
     * @var string
     */
    public $additionalData;
    /**
     * The formData
     * @var Egovs_Paymentbase_Model_Payplace_Types_Form_Data
     */
    public $formData;
    /**
     * The basket
     * @var Egovs_Paymentbase_Model_Payplace_Types_Basket
     */
    public $basket;
    /**
     * The callbackData
     * @var Egovs_Paymentbase_Model_Payplace_Types_Callback_Data
     */
    public $callbackData;
    /**
     * The customerContinuation
     * @var Egovs_Paymentbase_Model_Payplace_Types_Customer_Continuation
     */
    public $customerContinuation;
    /**
     * Constructor method for formServiceRequest
     * @see parent::__construct()
     * @param Egovs_Paymentbase_Model_Payplace_Enum_Action $_action
     * @param float $_amount
     * @param string $_currency
     * @param Egovs_Paymentbase_Model_Payplace_Types_BankAccount $_bankAccount
     * @param Egovs_Paymentbase_Model_Payplace_Types_Giropay_Data $_giropayData
     * @param Egovs_Paymentbase_Model_Payplace_Types_Panalias $_panalias
     * @param string $_merchantRef
     * @param Egovs_Paymentbase_Model_Payplace_Types_Address $_address
     * @param string $_dueDate
     * @param Egovs_Paymentbase_Model_Payplace_Types_Mandate $_mandate
     * @param string $_additionalData
     * @param Egovs_Paymentbase_Model_Payplace_Types_Form_Data $_formData
     * @param Egovs_Paymentbase_Model_Payplace_Types_Basket $_basket
     * @param Egovs_Paymentbase_Model_Payplace_Types_Callback_Data $_callbackData
     * @param Egovs_Paymentbase_Model_Payplace_Types_Customer_Continuation $_customerContinuation
     * @return Egovs_Paymentbase_Model_Payplace_Types_Form_Service_Request
     */
    public function __construct($_action = NULL,$_amount = NULL,$_currency = NULL,$_bankAccount = NULL,$_giropayData = NULL,$_panalias = NULL,$_merchantRef = NULL,$_address = NULL,$_dueDate = NULL,$_mandate = NULL,$_additionalData = NULL,$_formData = NULL,$_basket = NULL,$_callbackData = NULL,$_customerContinuation = NULL)
    {
        Egovs_Paymentbase_Model_Payplace_WsdlClass::__construct(array('action'=>$_action,'amount'=>$_amount,'currency'=>$_currency,'bankAccount'=>$_bankAccount,'giropayData'=>$_giropayData,'panalias'=>$_panalias,'merchantRef'=>$_merchantRef,'address'=>$_address,'dueDate'=>$_dueDate,'mandate'=>$_mandate,'additionalData'=>$_additionalData,'formData'=>$_formData,'basket'=>$_basket,'callbackData'=>$_callbackData,'customerContinuation'=>$_customerContinuation),false);
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
     * Get giropayData value
     * @return Egovs_Paymentbase_Model_Payplace_Types_Giropay_Data|null
     */
    public function getGiropayData()
    {
        return $this->giropayData;
    }
    /**
     * Set giropayData value
     * @param Egovs_Paymentbase_Model_Payplace_Types_Giropay_Data $_giropayData the giropayData
     * @return Egovs_Paymentbase_Model_Payplace_Types_Giropay_Data
     */
    public function setGiropayData($_giropayData)
    {
        return ($this->giropayData = $_giropayData);
    }
    /**
     * Get panalias value
     * @return Egovs_Paymentbase_Model_Payplace_Types_Panalias|null
     */
    public function getPanalias()
    {
        return $this->panalias;
    }
    /**
     * Set panalias value
     * @param Egovs_Paymentbase_Model_Payplace_Types_Panalias $_panalias the panalias
     * @return Egovs_Paymentbase_Model_Payplace_Types_Panalias
     */
    public function setPanalias($_panalias)
    {
        return ($this->panalias = $_panalias);
    }
    /**
     * Get merchantRef value
     * @return string|null
     */
    public function getMerchantRef()
    {
        return $this->merchantRef;
    }
    /**
     * Set merchantRef value
     * @param string $_merchantRef the merchantRef
     * @return string
     */
    public function setMerchantRef($_merchantRef)
    {
        return ($this->merchantRef = $_merchantRef);
    }
    /**
     * Get address value
     * @return Egovs_Paymentbase_Model_Payplace_Types_Address|null
     */
    public function getAddress()
    {
        return $this->address;
    }
    /**
     * Set address value
     * @param Egovs_Paymentbase_Model_Payplace_Types_Address $_address the address
     * @return Egovs_Paymentbase_Model_Payplace_Types_Address
     */
    public function setAddress($_address)
    {
        return ($this->address = $_address);
    }
    /**
     * Get dueDate value
     * @return string|null
     */
    public function getDueDate()
    {
        return $this->dueDate;
    }
    /**
     * Set dueDate value
     * @param string $_dueDate the dueDate
     * @return string
     */
    public function setDueDate($_dueDate)
    {
        return ($this->dueDate = $_dueDate);
    }
    /**
     * Get mandate value
     * @return Egovs_Paymentbase_Model_Payplace_Types_Mandate|null
     */
    public function getMandate()
    {
        return $this->mandate;
    }
    /**
     * Set mandate value
     * @param Egovs_Paymentbase_Model_Payplace_Types_Mandate $_mandate the mandate
     * @return Egovs_Paymentbase_Model_Payplace_Types_Mandate
     */
    public function setMandate($_mandate)
    {
        return ($this->mandate = $_mandate);
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
     * Get formData value
     * @return Egovs_Paymentbase_Model_Payplace_Types_Form_Data|null
     */
    public function getFormData()
    {
        return $this->formData;
    }
    /**
     * Set formData value
     * @param Egovs_Paymentbase_Model_Payplace_Types_Form_Data $_formData the formData
     * @return Egovs_Paymentbase_Model_Payplace_Types_Form_Data
     */
    public function setFormData($_formData)
    {
        return ($this->formData = $_formData);
    }
    /**
     * Get basket value
     * @return Egovs_Paymentbase_Model_Payplace_Types_Basket|null
     */
    public function getBasket()
    {
        return $this->basket;
    }
    /**
     * Set basket value
     * @param Egovs_Paymentbase_Model_Payplace_Types_Basket $_basket the basket
     * @return Egovs_Paymentbase_Model_Payplace_Types_Basket
     */
    public function setBasket($_basket)
    {
        return ($this->basket = $_basket);
    }
    /**
     * Get callbackData value
     * @return Egovs_Paymentbase_Model_Payplace_Types_Callback_Data|null
     */
    public function getCallbackData()
    {
        return $this->callbackData;
    }
    /**
     * Set callbackData value
     * @param Egovs_Paymentbase_Model_Payplace_Types_Callback_Data $_callbackData the callbackData
     * @return Egovs_Paymentbase_Model_Payplace_Types_Callback_Data
     */
    public function setCallbackData($_callbackData)
    {
        return ($this->callbackData = $_callbackData);
    }
    /**
     * Get customerContinuation value
     * @return Egovs_Paymentbase_Model_Payplace_Types_Customer_Continuation|null
     */
    public function getCustomerContinuation()
    {
        return $this->customerContinuation;
    }
    /**
     * Set customerContinuation value
     * @param Egovs_Paymentbase_Model_Payplace_Types_Customer_Continuation $_customerContinuation the customerContinuation
     * @return Egovs_Paymentbase_Model_Payplace_Types_Customer_Continuation
     */
    public function setCustomerContinuation($_customerContinuation)
    {
        return ($this->customerContinuation = $_customerContinuation);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @uses Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @param array $_array the exported values
     * @return Egovs_Paymentbase_Model_Payplace_Types_Form_Service_Request
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
