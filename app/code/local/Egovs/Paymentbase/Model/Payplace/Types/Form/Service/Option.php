<?php
/**
 * File for class Egovs_Paymentbase_Model_Payplace_Types_Form_Service_Option
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
/**
 * This class stands for Egovs_Paymentbase_Model_Payplace_Types_Form_Service_Option originally named formServiceOption
 * Documentation : Possible values for the "name" attribute: for credit card transactions: "cardHolder" states that the form that is shown to the customer contains a mandatory field for entering the credit card owner. "optionalCardHolder" means that the form includes a field for the card owner but the customer is not required to enter anything. Without this parameter the form will not include an input field for the credit card owner. "fallBackOnSSL": specifies that an SSL transaction without liability shifting is carried out in case of a Visa card if no answer is received from the Visa Directory or if the Visa or MasterCard Directory could not determine if the credit card is enrolled for 3D Secure. If not submitted, the transaction will be aborted under these circumstances. "amexAvs": if the customer pays with an American Express card he is asked for his address and an American Express address verification is carried out. The result of the address verification is returned in the payment notification in the fields rcAvsAmex and scoringRc. "generate_ppan_verify_online": only if your account is configured to use card number aliases. Specifies that the transaction is a registration of a card number and not a payment. The text in the form is displayed as is appropriate for a registration, the amount is not displayed. Can be used only together with <action>preauthorization</action> and only with an amount of not more than 1 EUR or 1 of another currency respectively. In the case of direct debits: "accountHolder" signifies that the direct debit form, which is displayed to the customer, includes a mandatory field to enter the account holder. "optionalAccountHolder" signifies that the direct debit form includes an optional field to enter the account holder. Without this detail the direct debit form only includes fields for the account number and the bank identification number. "checklist": before the direct debit a blacklist is checked. Only available if this option has been activated for your account. "sepa_pdf_mandate" specifies that a PDF file with a SEPA direct debit mandate should be created in the form service. This requires additional information which the customer has to enter in the course of the form service dialogue. Only available if this option has been activated for your account. Possibly there will be more options in future versions.
 * Meta informations extracted from the WSDL
 * - from schema : file:///etc/Callback.wsdl
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
class Egovs_Paymentbase_Model_Payplace_Types_Form_Service_Option extends Egovs_Paymentbase_Model_Payplace_WsdlClass
{
    /**
     * The name
     * Meta informations extracted from the WSDL
     * - use : required
     * @var string
     */
    public $name;
    /**
     * Constructor method for formServiceOption
     * @see parent::__construct()
     * @param string $_name
     * @return Egovs_Paymentbase_Model_Payplace_Types_Form_Service_Option
     */
    public function __construct($_name)
    {
        parent::__construct(array('name'=>$_name),false);
    }
    /**
     * Get name value
     * @return string
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
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @uses Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @param array $_array the exported values
     * @return Egovs_Paymentbase_Model_Payplace_Types_Form_Service_Option
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
