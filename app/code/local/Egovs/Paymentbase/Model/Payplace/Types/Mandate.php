<?php
/**
 * File for class Egovs_Paymentbase_Model_Payplace_Types_Mandate
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
/**
 * This class stands for Egovs_Paymentbase_Model_Payplace_Types_Mandate originally named mandate
 * Documentation : Includes data of a SEPA direct debit mandate
 * Meta informations extracted from the WSDL
 * - from schema : file:///etc/Callback.wsdl
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
class Egovs_Paymentbase_Model_Payplace_Types_Mandate extends Egovs_Paymentbase_Model_Payplace_WsdlClass
{
    /**
     * The reference
     * Meta informations extracted from the WSDL
     * - documentation : Unique identification of the SEPA mandate.
     * - from schema : file:///etc/Callback.wsdl
     * - maxLength : 35
     * - pattern : [0-9A-Za-z+?/\-:().,']+
     * @var string
     */
    public $reference;
    /**
     * The signedOn
     * Meta informations extracted from the WSDL
     * - documentation : Date when the SEPA mandate was signed.
     * - documentation : A date in YYYY-MM-DD format.
     * - pattern : [12][0-9][0-9][0-9]-(1[0-3]|0[1-9])-[0-3][0-9]
     * @var string
     */
    public $signedOn;
    /**
     * The name
     * Meta informations extracted from the WSDL
     * - documentation : Name of the recipient used in the SEPA mandate. If not submitted the name configured in the standing data is used.
     * - from schema : file:///etc/Callback.wsdl
     * - maxLength : 70
     * - pattern : [0-9A-Za-z+?/\-:().,' ]+
     * @var string
     */
    public $name;
    /**
     * The sequenceType
     * Meta informations extracted from the WSDL
     * - documentation : If not submitted a single payment is assumed.
     * - minOccurs : 0
     * @var Egovs_Paymentbase_Model_Payplace_Enum_SequenceTypeEnum
     */
    public $sequenceType;
    /**
     * The previousCreditorId
     * Meta informations extracted from the WSDL
     * - documentation : Previous creditor ID of the shop. Only for recurring payments if the creditor ID of the shop has changed from the previous payment.
     * - from schema : file:///etc/Callback.wsdl
     * - length : 18
     * - pattern : DE[0-9]{2}[A-Za-z0-9]{3}0[0-9]{10}
     * @var string
     */
    public $previousCreditorId;
    /**
     * The previousBic
     * Meta informations extracted from the WSDL
     * - documentation : Previous BIC of the customer. Only for recurring payments if the IBAN has changed from the previous payment. Only required for non German previous IBANs.
     * - minOccurs : 0
     * - maxLength : 11
     * - minLength : 8
     * - pattern : [A-Z]{6}[A-Z2-9][A-NP-Z0-9]([A-Z0-9]{3})?
     * @var string
     */
    public $previousBic;
    /**
     * The previousIban
     * Meta informations extracted from the WSDL
     * - documentation : Previous IBAN of the customer. Only for recurring payments if the IBAN has changed from the previous payment.
     * - minOccurs : 0
     * - maxLength : 34
     * - minLength : 15
     * - pattern : [A-Z]{2}[0-9]{2}[A-Z0-9]{11,30}
     * @var string
     */
    public $previousIban;
    /**
     * The previousReference
     * Meta informations extracted from the WSDL
     * - documentation : Previous mandate reference. Only for recurring payments if the mandate reference has changed from the previous payment.
     * - from schema : file:///etc/Callback.wsdl
     * - maxLength : 35
     * - pattern : [0-9A-Za-z+?/\-:().,']+
     * @var string
     */
    public $previousReference;
    /**
     * Constructor method for mandate
     * @see parent::__construct()
     * @param string $_reference
     * @param string $_signedOn
     * @param string $_name
     * @param Egovs_Paymentbase_Model_Payplace_Enum_SequenceTypeEnum $_sequenceType
     * @param string $_previousCreditorId
     * @param string $_previousBic
     * @param string $_previousIban
     * @param string $_previousReference
     * @return Egovs_Paymentbase_Model_Payplace_Types_Mandate
     */
    public function __construct($_reference = NULL,$_signedOn = NULL,$_name = NULL,$_sequenceType = NULL,$_previousCreditorId = NULL,$_previousBic = NULL,$_previousIban = NULL,$_previousReference = NULL)
    {
        parent::__construct(array('reference'=>$_reference,'signedOn'=>$_signedOn,'name'=>$_name,'sequenceType'=>$_sequenceType,'previousCreditorId'=>$_previousCreditorId,'previousBic'=>$_previousBic,'previousIban'=>$_previousIban,'previousReference'=>$_previousReference),false);
    }
    /**
     * Get reference value
     * @return string|null
     */
    public function getReference()
    {
        return $this->reference;
    }
    /**
     * Set reference value
     * @param string $_reference the reference
     * @return string
     */
    public function setReference($_reference)
    {
        return ($this->reference = $_reference);
    }
    /**
     * Get signedOn value
     * @return string|null
     */
    public function getSignedOn()
    {
        return $this->signedOn;
    }
    /**
     * Set signedOn value
     * @param string $_signedOn the signedOn
     * @return string
     */
    public function setSignedOn($_signedOn)
    {
        return ($this->signedOn = $_signedOn);
    }
    /**
     * Get name value
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Set name value
     * @param string $_name the name
     * @return string
     */
    public function setName($_name)
    {
        return ($this->name = $_name);
    }
    /**
     * Get sequenceType value
     * @return Egovs_Paymentbase_Model_Payplace_Enum_SequenceTypeEnum|null
     */
    public function getSequenceType()
    {
        return $this->sequenceType;
    }
    /**
     * Set sequenceType value
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_SequenceTypeEnum::valueIsValid()
     * @param Egovs_Paymentbase_Model_Payplace_Enum_SequenceTypeEnum $_sequenceType the sequenceType
     * @return Egovs_Paymentbase_Model_Payplace_Enum_SequenceTypeEnum
     */
    public function setSequenceType($_sequenceType)
    {
        if(!Egovs_Paymentbase_Model_Payplace_Enum_SequenceTypeEnum::valueIsValid($_sequenceType))
        {
            return false;
        }
        return ($this->sequenceType = $_sequenceType);
    }
    /**
     * Get previousCreditorId value
     * @return string|null
     */
    public function getPreviousCreditorId()
    {
        return $this->previousCreditorId;
    }
    /**
     * Set previousCreditorId value
     * @param string $_previousCreditorId the previousCreditorId
     * @return string
     */
    public function setPreviousCreditorId($_previousCreditorId)
    {
        return ($this->previousCreditorId = $_previousCreditorId);
    }
    /**
     * Get previousBic value
     * @return string|null
     */
    public function getPreviousBic()
    {
        return $this->previousBic;
    }
    /**
     * Set previousBic value
     * @param string $_previousBic the previousBic
     * @return string
     */
    public function setPreviousBic($_previousBic)
    {
        return ($this->previousBic = $_previousBic);
    }
    /**
     * Get previousIban value
     * @return string|null
     */
    public function getPreviousIban()
    {
        return $this->previousIban;
    }
    /**
     * Set previousIban value
     * @param string $_previousIban the previousIban
     * @return string
     */
    public function setPreviousIban($_previousIban)
    {
        return ($this->previousIban = $_previousIban);
    }
    /**
     * Get previousReference value
     * @return string|null
     */
    public function getPreviousReference()
    {
        return $this->previousReference;
    }
    /**
     * Set previousReference value
     * @param string $_previousReference the previousReference
     * @return string
     */
    public function setPreviousReference($_previousReference)
    {
        return ($this->previousReference = $_previousReference);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @uses Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @param array $_array the exported values
     * @return Egovs_Paymentbase_Model_Payplace_Types_Mandate
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
