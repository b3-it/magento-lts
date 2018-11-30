<?php
/**
 * File for class Egovs_Paymentbase_Model_Payplace_Types_ExpiryDate
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
/**
 * This class stands for Egovs_Paymentbase_Model_Payplace_Types_ExpiryDate originally named expiryDate
 * Documentation : Expiry date of a credit card.
 * Meta informations extracted from the WSDL
 * - from schema : file:///etc/Callback.wsdl
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
class Egovs_Paymentbase_Model_Payplace_Types_ExpiryDate extends Egovs_Paymentbase_Model_Payplace_WsdlClass
{
    /**
     * The month
     * Meta informations extracted from the WSDL
     * - from schema : file:///etc/Callback.wsdl
     * - maxInclusive : 12
     * - minInclusive : 1
     * @var int
     */
    public $month;
    /**
     * The year
     * Meta informations extracted from the WSDL
     * - from schema : file:///etc/Callback.wsdl
     * - maxInclusive : 9999
     * - minInclusive : 1000
     * @var int
     */
    public $year;
    /**
     * Constructor method for expiryDate
     * @see parent::__construct()
     * @param int $_month
     * @param int $_year
     * @return Egovs_Paymentbase_Model_Payplace_Types_ExpiryDate
     */
    public function __construct($_month = NULL,$_year = NULL)
    {
        parent::__construct(array('month'=>$_month,'year'=>$_year),false);
    }
    /**
     * Get month value
     * @return int|null
     */
    public function getMonth()
    {
        return $this->month;
    }
    /**
     * Set month value
     * @param int $_month the month
     * @return bool
     */
    public function setMonth($_month)
    {
        return ($this->month = $_month);
    }
    /**
     * Get year value
     * @return int|null
     */
    public function getYear()
    {
        return $this->year;
    }
    /**
     * Set year value
     * @param int $_year the year
     * @return int
     */
    public function setYear($_year)
    {
        return ($this->year = $_year);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @uses Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @param array $_array the exported values
     * @return Egovs_Paymentbase_Model_Payplace_Types_ExpiryDate
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
