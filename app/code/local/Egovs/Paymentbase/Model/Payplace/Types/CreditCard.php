<?php
/**
 * File for class Egovs_Paymentbase_Model_Payplace_Types_CreditCard
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
/**
 * This class stands for Egovs_Paymentbase_Model_Payplace_Types_CreditCard originally named creditCard
 * Meta informations extracted from the WSDL
 * - from schema : file:///etc/Callback.wsdl
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
class Egovs_Paymentbase_Model_Payplace_Types_CreditCard extends Egovs_Paymentbase_Model_Payplace_WsdlClass
{
    /**
     * The pan
     * Meta informations extracted from the WSDL
     * - documentation : Credit card number (Primary Account Number)
     * - from schema : file:///etc/Callback.wsdl
     * - maxLength : 19
     * - minLength : 12
     * - pattern : [0-9]+
     * @var string
     */
    public $pan;
    /**
     * The panalias
     * @var Egovs_Paymentbase_Model_Payplace_Types_Panalias
     */
    public $panalias;
    /**
     * The expiryDate
     * @var Egovs_Paymentbase_Model_Payplace_Types_ExpiryDate
     */
    public $expiryDate;
    /**
     * The holder
     * @var string
     */
    public $holder;
    /**
     * The verificationCode
     * Meta informations extracted from the WSDL
     * - documentation : Card verification code. Safety code of a credit card (also known as cvv or cvc).
     * - from schema : file:///etc/Callback.wsdl
     * - maxLength : 4
     * - minLength : 3
     * - pattern : [0-9]*
     * @var string
     */
    public $verificationCode;
    /**
     * Constructor method for creditCard
     * @see parent::__construct()
     * @param string $_pan
     * @param Egovs_Paymentbase_Model_Payplace_Types_Panalias $_panalias
     * @param Egovs_Paymentbase_Model_Payplace_Types_ExpiryDate $_expiryDate
     * @param string $_holder
     * @param string $_verificationCode
     * @return Egovs_Paymentbase_Model_Payplace_Types_CreditCard
     */
    public function __construct($_pan = NULL,$_panalias = NULL,$_expiryDate = NULL,$_holder = NULL,$_verificationCode = NULL)
    {
        parent::__construct(array('pan'=>$_pan,'panalias'=>$_panalias,'expiryDate'=>$_expiryDate,'holder'=>$_holder,'verificationCode'=>$_verificationCode),false);
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
     * Get verificationCode value
     * @return string|null
     */
    public function getVerificationCode()
    {
        return $this->verificationCode;
    }
    /**
     * Set verificationCode value
     * @param string $_verificationCode the verificationCode
     * @return string
     */
    public function setVerificationCode($_verificationCode)
    {
        return ($this->verificationCode = $_verificationCode);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @uses Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @param array $_array the exported values
     * @return Egovs_Paymentbase_Model_Payplace_Types_CreditCard
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
