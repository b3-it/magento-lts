<?php
/**
 * File for class Egovs_Paymentbase_Model_Payplace_Types_Tds_Initial_Request
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
/**
 * This class stands for Egovs_Paymentbase_Model_Payplace_Types_Tds_Initial_Request originally named tdsInitialRequest
 * Meta informations extracted from the WSDL
 * - from schema : file:///etc/Callback.wsdl
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
class Egovs_Paymentbase_Model_Payplace_Types_Tds_Initial_Request extends Egovs_Paymentbase_Model_Payplace_Types_Payment_Base_Request
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
     * The creditCard
     * @var Egovs_Paymentbase_Model_Payplace_Types_CreditCard
     */
    public $creditCard;
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
     * The fallBackOnSSL
     * @var boolean
     */
    public $fallBackOnSSL;
    /**
     * Constructor method for tdsInitialRequest
     * @see parent::__construct()
     * @param Egovs_Paymentbase_Model_Payplace_Enum_Action $_action
     * @param float $_amount
     * @param string $_currency
     * @param Egovs_Paymentbase_Model_Payplace_Types_CreditCard $_creditCard
     * @param string $_merchantRef
     * @param boolean $_fallBackOnSSL
     * @return Egovs_Paymentbase_Model_Payplace_Types_Tds_Initial_Request
     */
    public function __construct($_action = NULL,$_amount = NULL,$_currency = NULL,$_creditCard = NULL,$_merchantRef = NULL,$_fallBackOnSSL = NULL)
    {
        Egovs_Paymentbase_Model_Payplace_WsdlClass::__construct(array('action'=>$_action,'amount'=>$_amount,'currency'=>$_currency,'creditCard'=>$_creditCard,'merchantRef'=>$_merchantRef,'fallBackOnSSL'=>$_fallBackOnSSL),false);
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
     * Get fallBackOnSSL value
     * @return boolean|null
     */
    public function getFallBackOnSSL()
    {
        return $this->fallBackOnSSL;
    }
    /**
     * Set fallBackOnSSL value
     * @param boolean $_fallBackOnSSL the fallBackOnSSL
     * @return boolean
     */
    public function setFallBackOnSSL($_fallBackOnSSL)
    {
        return ($this->fallBackOnSSL = $_fallBackOnSSL);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @uses Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @param array $_array the exported values
     * @return Egovs_Paymentbase_Model_Payplace_Types_Tds_Initial_Request
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
