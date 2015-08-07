<?php
/**
 * File for class Egovs_Paymentbase_Model_Payplace_Types_AdditionalCheck
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
/**
 * This class stands for Egovs_Paymentbase_Model_Payplace_Types_AdditionalCheck originally named additionalCheck
 * Documentation : Includes information for payment related verifications of country of delivery, IP address, etc.
 * Meta informations extracted from the WSDL
 * - from schema : file:///etc/Callback.wsdl
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
class Egovs_Paymentbase_Model_Payplace_Types_Additional_Check extends Egovs_Paymentbase_Model_Payplace_WsdlClass
{
    /**
     * The compare
     * @var Egovs_Paymentbase_Model_Payplace_Types_Compare
     */
    public $compare;
    /**
     * Constructor method for additionalCheck
     * @see parent::__construct()
     * @param Egovs_Paymentbase_Model_Payplace_Types_Compare $_compare
     * @return Egovs_Paymentbase_Model_Payplace_Types_Additional_Check
     */
    public function __construct($_compare = NULL)
    {
        parent::__construct(array('compare'=>$_compare),false);
    }
    /**
     * Get compare value
     * @return Egovs_Paymentbase_Model_Payplace_Types_Compare|null
     */
    public function getCompare()
    {
        return $this->compare;
    }
    /**
     * Set compare value
     * @param Egovs_Paymentbase_Model_Payplace_Types_Compare $_compare the compare
     * @return Egovs_Paymentbase_Model_Payplace_Types_Compare
     */
    public function setCompare($_compare)
    {
        return ($this->compare = $_compare);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @uses Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @param array $_array the exported values
     * @return Egovs_Paymentbase_Model_Payplace_Types_Additional_Check
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
