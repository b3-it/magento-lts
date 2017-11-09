<?php
/**
 * File for class Egovs_Paymentbase_Model_Payplace_Types_BatchResponse
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
/**
 * This class stands for Egovs_Paymentbase_Model_Payplace_Types_Batch_Response originally named batchResponse
 * Meta informations extracted from the WSDL
 * - from schema : file:///etc/Callback.wsdl
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
class Egovs_Paymentbase_Model_Payplace_Types_Batch_Response extends Egovs_Paymentbase_Model_Payplace_Types_Base_Response
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
     * The rc
     * Meta informations extracted from the WSDL
     * - from schema : file:///etc/Callback.wsdl
     * - length : 4
     * - pattern : [0-9]*
     * @var string
     */
    public $rc;
    /**
     * The message
     * Meta informations extracted from the WSDL
     * - documentation : A message that explains the return code.
     * - from schema : file:///etc/Callback.wsdl
     * - minLength : 1
     * @var string
     */
    public $message;
    /**
     * Constructor method for batchResponse
     * @see parent::__construct()
     * @param int $_batchExtId
     * @param Egovs_Paymentbase_Model_Payplace_Enum_BatchActionEnum $_action
     * @param string $_rc
     * @param string $_message
     * @return Egovs_Paymentbase_Model_Payplace_Types_Batch_Response
     */
    public function __construct($_batchExtId = NULL,$_action = NULL,$_rc = NULL,$_message = NULL)
    {
        Egovs_Paymentbase_Model_Payplace_WsdlClass::__construct(
        	array(
        		'batchExtId'=>$_batchExtId,
        		'action'=>$_action,
        		'rc'=>$_rc,
        		'message'=>$_message
        	),
        	false
        );
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
     * Get rc value
     * @return string|null
     */
    public function getRc()
    {
        return $this->rc;
    }
    /**
     * Set rc value
     * @param string $_rc the rc
     * @return string
     */
    public function setRc($_rc)
    {
        return ($this->rc = $_rc);
    }
    /**
     * Get message value
     * @return string|null
     */
    public function getMessage()
    {
        return $this->message;
    }
    /**
     * Set message value
     * @param string $_message the message
     * @return string
     */
    public function setMessage($_message)
    {
        return ($this->message = $_message);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @uses Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @param array $_array the exported values
     * @return Egovs_Paymentbase_Model_Payplace_Types_Batch_Response
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
