<?php
/**
 * File for class Egovs_Paymentbase_Model_Payplace_Types_PanAlias_Response
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
/**
 * This class stands for Egovs_Paymentbase_Model_Payplace_Types_PanAlias_Response originally named panAliasResponse
 * Meta informations extracted from the WSDL
 * - from schema : file:///etc/Callback.wsdl
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
class Egovs_Paymentbase_Model_Payplace_Types_PanAlias_Response extends Egovs_Paymentbase_Model_Payplace_Types_Base_Response
{
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
     * The panalias
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * - maxLength : 50
     * - minLength : 0
     * @var string
     */
    public $panalias;
    /**
     * The pan
     * Meta informations extracted from the WSDL
     * - maxLength : 16
     * - minLength : 12
     * - pattern : [0-9\*]+
     * @var string
     */
    public $pan;
    /**
     * The expiryDate
     * @var Egovs_Paymentbase_Model_Payplace_Types_ExpiryDate
     */
    public $expiryDate;
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
     * The holder
     * @var string
     */
    public $holder;
    /**
     * The brand
     * @var string
     */
    public $brand;
    /**
     * Constructor method for panAliasResponse
     * @see parent::__construct()
     * @param string $_rc
     * @param string $_panalias
     * @param string $_pan
     * @param Egovs_Paymentbase_Model_Payplace_Types_ExpiryDate $_expiryDate
     * @param string $_bankCode
     * @param string $_accountNumber
     * @param string $_bic
     * @param string $_iban
     * @param string $_holder
     * @param string $_brand
     * @return Egovs_Paymentbase_Model_Payplace_Types_PanAlias_Response
     */
    public function __construct($_rc = NULL,$_panalias = NULL,$_pan = NULL,$_expiryDate = NULL,$_bankCode = NULL,$_accountNumber = NULL,$_bic = NULL,$_iban = NULL,$_holder = NULL,$_brand = NULL)
    {
        Egovs_Paymentbase_Model_Payplace_WsdlClass::__construct(array('rc'=>$_rc,'panalias'=>$_panalias,'pan'=>$_pan,'expiryDate'=>$_expiryDate,'bankCode'=>$_bankCode,'accountNumber'=>$_accountNumber,'bic'=>$_bic,'iban'=>$_iban,'holder'=>$_holder,'brand'=>$_brand),false);
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
     * Get panalias value
     * @return string|null
     */
    public function getPanalias()
    {
        return $this->panalias;
    }
    /**
     * Set panalias value
     * @param string $_panalias the panalias
     * @return string
     */
    public function setPanalias($_panalias)
    {
        return ($this->panalias = $_panalias);
    }
    /**
     * Get pan value
     * @return string|null
     */
    public function getPan()
    {
        return $this->pan;
    }
    /**
     * Set pan value
     * @param string $_pan the pan
     * @return string
     */
    public function setPan($_pan)
    {
        return ($this->pan = $_pan);
    }
    /**
     * Get expiryDate value
     * @return Egovs_Paymentbase_Model_Payplace_Types_ExpiryDate|null
     */
    public function getExpiryDate()
    {
        return $this->expiryDate;
    }
    /**
     * Set expiryDate value
     * @param Egovs_Paymentbase_Model_Payplace_Types_ExpiryDate $_expiryDate the expiryDate
     * @return Egovs_Paymentbase_Model_Payplace_Types_ExpiryDate
     */
    public function setExpiryDate($_expiryDate)
    {
        return ($this->expiryDate = $_expiryDate);
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
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @uses Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @param array $_array the exported values
     * @return Egovs_Paymentbase_Model_Payplace_Types_PanAlias_Response
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
