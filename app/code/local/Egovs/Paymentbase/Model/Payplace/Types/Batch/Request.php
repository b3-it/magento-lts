<?php
/**
 * File for class Egovs_Paymentbase_Model_Payplace_Types_BatchRequest
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
/**
 * This class stands for Egovs_Paymentbase_Model_Payplace_Types_Batch_Request originally named batchRequest
 * Meta informations extracted from the WSDL
 * - from schema : file:///etc/Callback.wsdl
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
class Egovs_Paymentbase_Model_Payplace_Types_Batch_Request extends Egovs_Paymentbase_Model_Payplace_Types_Base_Request
{
    /**
     * The batchExtId
     * Meta informations extracted from the WSDL
     * - minLength : 1
     * @var int
     */
    public $batchExtId;
    /**
     * The action
     * @var Egovs_Paymentbase_Model_Payplace_Enum_BatchActionEnum
     */
    public $action;
    /**
     * Constructor method for batchRequest
     * @see parent::__construct()
     * @param int $_batchExtId
     * @param Egovs_Paymentbase_Model_Payplace_Enum_BatchActionEnum $_action
     * @return Egovs_Paymentbase_Model_Payplace_Types_Batch_Request
     */
    public function __construct($_batchExtId = NULL,$_action = NULL)
    {
        Egovs_Paymentbase_Model_Payplace_WsdlClass::__construct(array('batchExtId'=>$_batchExtId,'action'=>$_action),false);
    }
    /**
     * Get batchExtId value
     * @return int|null
     */
    public function getBatchExtId()
    {
        return $this->batchExtId;
    }
    /**
     * Set batchExtId value
     * @param int $_batchExtId the batchExtId
     * @return bool
     */
    public function setBatchExtId($_batchExtId)
    {
        return ($this->batchExtId = $_batchExtId);
    }
    /**
     * Get action value
     * @return Egovs_Paymentbase_Model_Payplace_Enum_BatchActionEnum|null
     */
    public function getAction()
    {
        return $this->action;
    }
    /**
     * Set action value
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_BatchActionEnum::valueIsValid()
     * @param Egovs_Paymentbase_Model_Payplace_Enum_BatchActionEnum $_action the action
     * @return Egovs_Paymentbase_Model_Payplace_Enum_BatchActionEnum
     */
    public function setAction($_action)
    {
        if(!Egovs_Paymentbase_Model_Payplace_Enum_BatchActionEnum::valueIsValid($_action))
        {
            return false;
        }
        return ($this->action = $_action);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @uses Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @param array $_array the exported values
     * @return Egovs_Paymentbase_Model_Payplace_Types_Batch_Request
     */
    public static function __set_state(array $_array, $_className = __CLASS__)
    {
        return parent::__set_state($_array, $_className);
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
