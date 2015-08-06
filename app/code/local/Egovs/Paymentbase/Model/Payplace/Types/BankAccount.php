<?php
/**
 * File for class Egovs_Paymentbase_Model_Payplace_Types_BankAccount
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
/**
 * This class stands for Egovs_Paymentbase_Model_Payplace_Types_BankAccount originally named bankAccount
 * Documentation : Includes bank details for debit and giropay transactions. For SEPA payments.
 * Meta informations extracted from the WSDL
 * - from schema : file:///etc/Callback.wsdl
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
class Egovs_Paymentbase_Model_Payplace_Types_BankAccount extends Egovs_Paymentbase_Model_Payplace_WsdlClass
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
     * The accountNumber
     * Meta informations extracted from the WSDL
     * - documentation : The customer's account number.
     * - from schema : file:///etc/Callback.wsdl
     * - maxLength : 10
     * - pattern : [0-9]+
     * @var string
     */
    public $accountNumber;
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
     * The iban
     * Meta informations extracted from the WSDL
     * - maxLength : 34
     * - minLength : 15
     * - pattern : [A-Z]{2}[0-9]{2}[A-Z0-9]{11,30}
     * @var string
     */
    public $iban;
    /**
     * The panalias
     * @var Egovs_Paymentbase_Model_Payplace_Types_Panalias
     */
    public $panalias;
    /**
     * The holder
     * @var string
     */
    public $holder;
    /**
     * The bankName
     * Meta informations extracted from the WSDL
     * - documentation : Name of the customer'S bank.
     * - from schema : file:///etc/Callback.wsdl
     * - maxLength : 255
     * @var string
     */
    public $bankName;
    /**
     * Constructor method for bankAccount
     * @see parent::__construct()
     * @param string $_bankCode
     * @param string $_accountNumber
     * @param string $_bic
     * @param string $_iban
     * @param Egovs_Paymentbase_Model_Payplace_Types_Panalias $_panalias
     * @param string $_holder
     * @param string $_bankName
     * @return Egovs_Paymentbase_Model_Payplace_Types_BankAccount
     */
    public function __construct($_bankCode = NULL,$_accountNumber = NULL,$_bic = NULL,$_iban = NULL,$_panalias = NULL,$_holder = NULL,$_bankName = NULL)
    {
        parent::__construct(array('bankCode'=>$_bankCode,'accountNumber'=>$_accountNumber,'bic'=>$_bic,'iban'=>$_iban,'panalias'=>$_panalias,'holder'=>$_holder,'bankName'=>$_bankName),false);
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
     * Get accountNumber value
     * @return string|null
     */
    public function getAccountNumber()
    {
        return $this->accountNumber;
    }
    /**
     * Set accountNumber value
     * @param string $_accountNumber the accountNumber
     * @return string
     */
    public function setAccountNumber($_accountNumber)
    {
        return ($this->accountNumber = $_accountNumber);
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
     * Get iban value
     * @return string|null
     */
    public function getIban()
    {
        return $this->iban;
    }
    /**
     * Set iban value
     * @param string $_iban the iban
     * @return string
     */
    public function setIban($_iban)
    {
        return ($this->iban = $_iban);
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
     * Get holder value
     * @return string|null
     */
    public function getHolder()
    {
        return $this->holder;
    }
    /**
     * Set holder value
     * @param string $_holder the holder
     * @return string
     */
    public function setHolder($_holder)
    {
        return ($this->holder = $_holder);
    }
    /**
     * Get bankName value
     * @return string|null
     */
    public function getBankName()
    {
        return $this->bankName;
    }
    /**
     * Set bankName value
     * @param string $_bankName the bankName
     * @return string
     */
    public function setBankName($_bankName)
    {
        return ($this->bankName = $_bankName);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @uses Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @param array $_array the exported values
     * @return Egovs_Paymentbase_Model_Payplace_Types_BankAccount
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
