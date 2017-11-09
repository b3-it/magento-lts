<?php
/**
 * File for class Egovs_Paymentbase_Model_Payplace_Types_Payment_Request
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
/**
 * This class stands for Egovs_Paymentbase_Model_Payplace_Types_Payment_Request originally named paymentRequest
 * Meta informations extracted from the WSDL
 * - from schema : file:///etc/Callback.wsdl
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
class Egovs_Paymentbase_Model_Payplace_Types_Payment_Request extends Egovs_Paymentbase_Model_Payplace_Types_Payment_Base_Request
{
    /**
     * The action
     * @var Egovs_Paymentbase_Model_Payplace_Enum_Action
     */
    public $action;
    /**
     * The xid
     * Meta informations extracted from the WSDL
     * - documentation : 3D secure field. Unique transaction identifier determined by merchant.
     * - from schema : file:///etc/Callback.wsdl
     * - length : 28
     * @var string
     */
    public $xid;
    /**
     * The cavv
     * Meta informations extracted from the WSDL
     * - documentation : 3D secure field. Determined by ACS.
     * - from schema : file:///etc/Callback.wsdl
     * - length : 28
     * @var string
     */
    public $cavv;
    /**
     * The ucaf
     * Meta informations extracted from the WSDL
     * - pattern : [A-Za-z0-9/+]*={0,2}
     * @var string
     */
    public $ucaf;
    /**
     * The txReferenceExtId
     * Meta informations extracted from the WSDL
     * - documentation : References the txExtId of a previous transaction.
     * - from schema : file:///etc/Callback.wsdl
     * - maxLength : 22
     * - pattern : [A-Za-z0-9_/\-]+
     * @var int
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
     * The dueDate
     * Meta informations extracted from the WSDL
     * - documentation : A date in YYYY-MM-DD format.
     * - pattern : [12][0-9][0-9][0-9]-(1[0-3]|0[1-9])-[0-3][0-9]
     * @var string
     */
    public $dueDate;
    /**
     * The bankAccount
     * @var Egovs_Paymentbase_Model_Payplace_Types_BankAccount
     */
    public $bankAccount;
    /**
     * The mandate
     * @var Egovs_Paymentbase_Model_Payplace_Types_Mandate
     */
    public $mandate;
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
     * The batchReferenceExtId
     * Meta informations extracted from the WSDL
     * - minLength : 1
     * @var int
     */
    public $batchReferenceExtId;
    /**
     * The aid
     * @var string
     */
    public $aid;
    /**
     * Constructor method for paymentRequest
     * @see parent::__construct()
     * @param Egovs_Paymentbase_Model_Payplace_Enum_Action $_action
     * @param string $_xid
     * @param string $_cavv
     * @param string $_ucaf
     * @param int $_txReferenceExtId
     * @param float $_changedAmount
     * @param float $_amount
     * @param string $_currency
     * @param Egovs_Paymentbase_Model_Payplace_Types_CreditCard $_creditCard
     * @param string $_dueDate
     * @param Egovs_Paymentbase_Model_Payplace_Types_BankAccount $_bankAccount
     * @param Egovs_Paymentbase_Model_Payplace_Types_Mandate $_mandate
     * @param string $_merchantRef
     * @param Egovs_Paymentbase_Model_Payplace_Types_Address $_address
     * @param int $_batchReferenceExtId
     * @param string $_aid
     * @return Egovs_Paymentbase_Model_Payplace_Types_Payment_Request
     */
    public function __construct($_action = NULL,$_xid = NULL,$_cavv = NULL,$_ucaf = NULL,$_txReferenceExtId = NULL,$_changedAmount = NULL,$_amount = NULL,$_currency = NULL,$_creditCard = NULL,$_dueDate = NULL,$_bankAccount = NULL,$_mandate = NULL,$_merchantRef = NULL,$_address = NULL,$_batchReferenceExtId = NULL,$_aid = NULL)
    {
        Egovs_Paymentbase_Model_Payplace_WsdlClass::__construct(
        	array(
        		'action'=>$_action,
        		'xid'=>$_xid,
        		'cavv'=>$_cavv,
        		'ucaf'=>$_ucaf,
        		'txReferenceExtId'=>$_txReferenceExtId,
        		'changedAmount'=>$_changedAmount,
        		'amount'=>$_amount,
        		'currency'=>$_currency,
        		'creditCard'=>$_creditCard,
        		'dueDate'=>$_dueDate,
        		'bankAccount'=>$_bankAccount,
        		'mandate'=>$_mandate,
        		'merchantRef'=>$_merchantRef,
        		'address'=>$_address,
        		'batchReferenceExtId'=>$_batchReferenceExtId,
        		'aid'=>$_aid),
        	false
        );
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
     * Get xid value
     * @return string|null
     */
    public function getXid()
    {
        return $this->xid;
    }
    /**
     * Set xid value
     * @param string $_xid the xid
     * @return bool
     */
    public function setXid($_xid)
    {
        return ($this->xid = $_xid);
    }
    /**
     * Get cavv value
     * @return string|null
     */
    public function getCavv()
    {
        return $this->cavv;
    }
    /**
     * Set cavv value
     * @param string $_cavv the cavv
     * @return bool
     */
    public function setCavv($_cavv)
    {
        return ($this->cavv = $_cavv);
    }
    /**
     * Get ucaf value
     * @return string|null
     */
    public function getUcaf()
    {
        return $this->ucaf;
    }
    /**
     * Set ucaf value
     * @param string $_ucaf the ucaf
     * @return string
     */
    public function setUcaf($_ucaf)
    {
        return ($this->ucaf = $_ucaf);
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
     * @return int|null
     */
    public function getAmount()
    {
        return $this->amount;
    }
    /**
     * Set amount value
     * @param int $_amount the amount
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
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @uses Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @param array $_array the exported values
     * @return Egovs_Paymentbase_Model_Payplace_Types_Payment_Request
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
