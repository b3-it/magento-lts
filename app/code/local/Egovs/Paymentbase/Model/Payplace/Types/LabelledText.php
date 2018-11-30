<?php
/**
 * File for class PayplaceStructLabelledText
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
/**
 * This class stands for PayplaceStructLabelledText originally named labelledText
 * Documentation : Additional line of text, consisting of a label and the text itself, that is shown to customers on the giropay login page.
 * Meta informations extracted from the WSDL
 * - from schema : file:///etc/Callback.wsdl
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
class Egovs_Paymentbase_Model_Payplace_Types_LabelledText extends Egovs_Paymentbase_Model_Payplace_WsdlClass
{
    /**
     * The label
     * @var string
     */
    public $label;
    /**
     * The text
     * Meta informations extracted from the WSDL
     * - documentation : Additional text, which is displayed to the customer on the giropay login page.
     * - from schema : file:///etc/Callback.wsdl
     * - maxLength : 80
     * @var string
     */
    public $text;
    /**
     * Constructor method for labelledText
     * @see parent::__construct()
     * @param string $_label
     * @param string $_text
     * @return Egovs_Paymentbase_Model_Payplace_Types_LabelledText
     */
    public function __construct($_label = NULL,$_text = NULL)
    {
        parent::__construct(array('label'=>$_label,'text'=>$_text),false);
    }
    /**
     * Get label value
     * @return Egovs_Paymentbase_Model_Payplace_Types_LabelledText
     */
    public function getLabel()
    {
        return $this->label;
    }
    /**
     * Set label value
     * @param string $_label the label
     * @return Egovs_Paymentbase_Model_Payplace_Types_LabelledText
     */
    public function setLabel($_label)
    {
        return ($this->label = $_label);
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
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @uses Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @param array $_array the exported values
     * @return Egovs_Paymentbase_Model_Payplace_Types_LabelledText
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
