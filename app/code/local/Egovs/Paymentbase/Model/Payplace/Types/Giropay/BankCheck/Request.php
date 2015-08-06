<?php
/**
 * File for class Egovs_Paymentbase_Model_Payplace_Types_Giropay_BankCheck_Request
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
/**
 * This class stands for Egovs_Paymentbase_Model_Payplace_Types_Giropay_BankCheck_Request originally named giropayBankCheckRequest
 * Meta informations extracted from the WSDL
 * - from schema : file:///etc/Callback.wsdl
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
class Egovs_Paymentbase_Model_Payplace_Types_Giropay_BankCheck_Request extends Egovs_Paymentbase_Model_Payplace_Types_Base_Request
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
     * The bic
     * Meta informations extracted from the WSDL
     * - maxLength : 11
     * - minLength : 8
     * - pattern : [A-Z]{6}[A-Z2-9][A-NP-Z0-9]([A-Z0-9]{3})?
     * @var string
     */
    public $bic;
    /**
     * Constructor method for giropayBankCheckRequest
     * @see parent::__construct()
     * @param string $_bankCode
     * @param string $_bic
     * @return Egovs_Paymentbase_Model_Payplace_Types_Giropay_BankCheck_Request
     */
    public function __construct($_bankCode = NULL,$_bic = NULL)
    {
        Egovs_Paymentbase_Model_Payplace_WsdlClass::__construct(array('bankCode'=>$_bankCode,'bic'=>$_bic),false);
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
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @uses Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @param array $_array the exported values
     * @return Egovs_Paymentbase_Model_Payplace_Types_Giropay_BankCheck_Request
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
