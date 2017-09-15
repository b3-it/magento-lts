<?php
/**
 * File for class Egovs_Paymentbase_Model_Payplace_Types_NegativeCriterion
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
/**
 * This class stands for Egovs_Paymentbase_Model_Payplace_Types_NegativeCriterion originally named negativeCriterion
 * Meta informations extracted from the WSDL
 * - from schema : file:///etc/Callback.wsdl
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
class Egovs_Paymentbase_Model_Payplace_Types_NegativeCriterion extends Egovs_Paymentbase_Model_Payplace_WsdlClass
{
    /**
     * The kind
     * Meta informations extracted from the WSDL
     * - documentation : Determines the kind of transaction. 3 uppercase letters for eScore, a number for Bürgel.
     * - from schema : file:///etc/Callback.wsdl
     * @var string
     */
    public $kind;
    /**
     * The text
     * Meta informations extracted from the WSDL
     * - documentation : Bürgel only
     * - minOccurs : 0
     * @var string
     */
    public $text;
    /**
     * The amount
     * Meta informations extracted from the WSDL
     * - documentation : Bürgel only
     * - minOccurs : 0
     * @var float
     */
    public $amount;
    /**
     * The currency
     * Meta informations extracted from the WSDL
     * - documentation : Bürgel only
     * - minOccurs : 0
     * @var string
     */
    public $currency;
    /**
     * The count
     * Meta informations extracted from the WSDL
     * - documentation : Bürgel only
     * - minOccurs : 0
     * @var int
     */
    public $count;
    /**
     * The date
     * Meta informations extracted from the WSDL
     * - documentation : eScore: date of the negative criterion. Bürgel: last occurence of this kind of negative criterion.
     * - documentation : A date in YYYY-MM-DD format.
     * - pattern : [12][0-9][0-9][0-9]-(1[0-3]|0[1-9])-[0-3][0-9]
     * @var string
     */
    public $date;
    /**
     * The completionDate
     * Meta informations extracted from the WSDL
     * - documentation : eScore only
     * - minOccurs : 0
     * - documentation : A date in YYYY-MM-DD format.
     * - pattern : [12][0-9][0-9][0-9]-(1[0-3]|0[1-9])-[0-3][0-9]
     * @var string
     */
    public $completionDate;
    /**
     * The completionFlag
     * Meta informations extracted from the WSDL
     * - documentation : eScore only.
     * - from schema : file:///etc/Callback.wsdl
     * - length : 1
     * @var string
     */
    public $completionFlag;
    /**
     * The docReference
     * Meta informations extracted from the WSDL
     * - documentation : Reference number of the negative criterion.
     * - minOccurs : 0
     * @var string
     */
    public $docReference;
    /**
     * Constructor method for negativeCriterion
     * @see parent::__construct()
     * @param string $_kind
     * @param string $_text
     * @param float $_amount
     * @param string $_currency
     * @param int $_count
     * @param string $_date
     * @param string $_completionDate
     * @param string $_completionFlag
     * @param string $_docReference
     * @return Egovs_Paymentbase_Model_Payplace_Types_NegativeCriterion
     */
    public function __construct($_kind = NULL,$_text = NULL,$_amount = NULL,$_currency = NULL,$_count = NULL,$_date = NULL,$_completionDate = NULL,$_completionFlag = NULL,$_docReference = NULL)
    {
        parent::__construct(array('kind'=>$_kind,'text'=>$_text,'amount'=>$_amount,'currency'=>$_currency,'count'=>$_count,'date'=>$_date,'completionDate'=>$_completionDate,'completionFlag'=>$_completionFlag,'docReference'=>$_docReference),false);
    }
    /**
     * Get kind value
     * @return string|null
     */
    public function getKind()
    {
        return $this->kind;
    }
    /**
     * Set kind value
     * @param string $_kind the kind
     * @return string
     */
    public function setKind($_kind)
    {
        return ($this->kind = $_kind);
    }
    /**
     * Get text value
     * @return string|null
     */
    public function getText()
    {
        return $this->text;
    }
    /**
     * Set text value
     * @param string $_text the text
     * @return string
     */
    public function setText($_text)
    {
        return ($this->text = $_text);
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
     * Get count value
     * @return int|null
     */
    public function getCount()
    {
        return $this->count;
    }
    /**
     * Set count value
     * @param int $_count the count
     * @return int
     */
    public function setCount($_count)
    {
        return ($this->count = $_count);
    }
    /**
     * Get date value
     * @return string|null
     */
    public function getDate()
    {
        return $this->date;
    }
    /**
     * Set date value
     * @param string $_date the date
     * @return string
     */
    public function setDate($_date)
    {
        return ($this->date = $_date);
    }
    /**
     * Get completionDate value
     * @return string|null
     */
    public function getCompletionDate()
    {
        return $this->completionDate;
    }
    /**
     * Set completionDate value
     * @param string $_completionDate the completionDate
     * @return string
     */
    public function setCompletionDate($_completionDate)
    {
        return ($this->completionDate = $_completionDate);
    }
    /**
     * Get completionFlag value
     * @return string|null
     */
    public function getCompletionFlag()
    {
        return $this->completionFlag;
    }
    /**
     * Set completionFlag value
     * @param string $_completionFlag the completionFlag
     * @return string
     */
    public function setCompletionFlag($_completionFlag)
    {
        return ($this->completionFlag = $_completionFlag);
    }
    /**
     * Get docReference value
     * @return string|null
     */
    public function getDocReference()
    {
        return $this->docReference;
    }
    /**
     * Set docReference value
     * @param string $_docReference the docReference
     * @return string
     */
    public function setDocReference($_docReference)
    {
        return ($this->docReference = $_docReference);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @uses Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @param array $_array the exported values
     * @return Egovs_Paymentbase_Model_Payplace_Types_NegativeCriterion
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
