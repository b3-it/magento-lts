<?php
/**
 * File for class Egovs_Paymentbase_Model_Payplace_Types_Tds_Final_Request
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
/**
 * This class stands for Egovs_Paymentbase_Model_Payplace_Types_Tds_Final_Request originally named tdsFinalRequest
 * Meta informations extracted from the WSDL
 * - from schema : file:///etc/Callback.wsdl
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
class Egovs_Paymentbase_Model_Payplace_Types_Tds_Final_Request extends Egovs_Paymentbase_Model_Payplace_Types_Base_Request
{
    /**
     * The paRes
     * @var string
     */
    public $paRes;
    /**
     * Constructor method for tdsFinalRequest
     * @see parent::__construct()
     * @param string $_paRes
     * @return Egovs_Paymentbase_Model_Payplace_Types_Tds_Final_Request
     */
    public function __construct($_paRes = NULL)
    {
        Egovs_Paymentbase_Model_Payplace_WsdlClass::__construct(array('paRes'=>$_paRes),false);
    }
    /**
     * Get paRes value
     * @return string|null
     */
    public function getPaRes()
    {
        return $this->paRes;
    }
    /**
     * Set paRes value
     * @param string $_paRes the paRes
     * @return string
     */
    public function setPaRes($_paRes)
    {
        return ($this->paRes = $_paRes);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @uses Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @param array $_array the exported values
     * @return Egovs_Paymentbase_Model_Payplace_Types_Tds_Final_Request
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
