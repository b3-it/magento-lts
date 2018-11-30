<?php
/**
 * File for class Egovs_Paymentbase_Model_Payplace_Types_Base_Request
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
/**
 * This class stands for Egovs_Paymentbase_Model_Payplace_Types_Base_Request originally named baseRequest
 * Meta informations extracted from the WSDL
 * - from schema : file:///etc/Callback.wsdl
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
class Egovs_Paymentbase_Model_Payplace_Types_Base_Request extends Egovs_Paymentbase_Model_Payplace_WsdlClass
{
    /**
     * The id
     * Meta informations extracted from the WSDL
     * - use : required
     * @var int
     */
    public $id;
    /**
     * The option
     * @var Egovs_Paymentbase_Model_Payplace_Types_Option
     */
    public $option;
    /**
     * The merchantId
     * Meta informations extracted from the WSDL
     * - documentation : Unique identification of the online trader for whom the transaction is carried out.
     * - from schema : file:///etc/Callback.wsdl
     * - length : 10
     * - pattern : [0-9]+
     * @var string
     */
    public $merchantId;
    /**
     * Constructor method for baseRequest
     * @see parent::__construct()
     * @param int $_id
     * @param Egovs_Paymentbase_Model_Payplace_Types_Option $_option
     * @param string $_merchantId
     * @return Egovs_Paymentbase_Model_Payplace_Types_Base_Request
     */
    public function __construct($_id,$_option = NULL,$_merchantId = NULL)
    {
        parent::__construct(array('id'=>$_id,'option'=>$_option,'merchantId'=>$_merchantId),false);
    }
    /**
     * Get id value
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * Set id value
     * @param int $_id the id
     * @return bool
     */
    public function setId($_id)
    {
        return ($this->id = $_id);
    }
    /**
     * Get option value
     * @return Egovs_Paymentbase_Model_Payplace_Types_Option|null
     */
    public function getOption()
    {
        return $this->option;
    }
    /**
     * Set option value
     * @param Egovs_Paymentbase_Model_Payplace_Types_Option $_option the option
     * @return Egovs_Paymentbase_Model_Payplace_Types_Option
     */
    public function setOption($_option)
    {
        return ($this->option = $_option);
    }
    /**
     * Get merchantId value
     * @return string|null
     */
    public function getMerchantId()
    {
        return $this->merchantId;
    }
    /**
     * Set merchantId value
     * @param string $_merchantId the merchantId
     * @return string
     */
    public function setMerchantId($_merchantId)
    {
        return ($this->merchantId = $_merchantId);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @uses Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @param array $_array the exported values
     * @return Egovs_Paymentbase_Model_Payplace_Types_Base-Request
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
