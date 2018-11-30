<?php
/**
 * File for class Egovs_Paymentbase_Model_Payplace_Types_Compare
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
/**
 * This class stands for Egovs_Paymentbase_Model_Payplace_Types_Compare originally named compare
 * Meta informations extracted from the WSDL
 * - from schema : file:///etc/Callback.wsdl
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
class Egovs_Paymentbase_Model_Payplace_Types_Compare extends Egovs_Paymentbase_Model_Payplace_WsdlClass
{
    /**
     * The item
     * @var Egovs_Paymentbase_Model_Payplace_Types_Item
     */
    public $item;
    /**
     * The rejectMessage
     * Meta informations extracted from the WSDL
     * - documentation : Individual error message if payment is rejected, e.g. because the issuing country of the credit card is not an accepted country . For form service only. If not supplied the standard error message of the system for the error is displayed.
     * - from schema : file:///etc/Callback.wsdl
     * - minLength : 1
     * @var string
     */
    public $rejectMessage;
    /**
     * The id
     * @var int
     */
    public $id;
    /**
     * The mismatchAction
     * @var Egovs_Paymentbase_Model_Payplace_Enum_Mismatch_ActionEnum
     */
    public $mismatchAction;
    /**
     * Constructor method for compare
     * @see parent::__construct()
     * @param Egovs_Paymentbase_Model_Payplace_Types_Item $_item
     * @param string $_rejectMessage
     * @param int $_id
     * @param Egovs_Paymentbase_Model_Payplace_Enum_Mismatch_ActionEnum $_mismatchAction
     * @return Egovs_Paymentbase_Model_Payplace_Types_Compare
     */
    public function __construct($_item = NULL,$_rejectMessage = NULL,$_id = NULL,$_mismatchAction = NULL)
    {
        parent::__construct(array('item'=>$_item,'rejectMessage'=>$_rejectMessage,'id'=>$_id,'mismatchAction'=>$_mismatchAction),false);
    }
    /**
     * Get item value
     * @return Egovs_Paymentbase_Model_Payplace_Types_Item|null
     */
    public function getItem()
    {
        return $this->item;
    }
    /**
     * Set item value
     * @param Egovs_Paymentbase_Model_Payplace_Types_Item $_item the item
     * @return Egovs_Paymentbase_Model_Payplace_Types_Item
     */
    public function setItem($_item)
    {
        return ($this->item = $_item);
    }
    /**
     * Get rejectMessage value
     * @return string|null
     */
    public function getRejectMessage()
    {
        return $this->rejectMessage;
    }
    /**
     * Set rejectMessage value
     * @param string $_rejectMessage the rejectMessage
     * @return string
     */
    public function setRejectMessage($_rejectMessage)
    {
        return ($this->rejectMessage = $_rejectMessage);
    }
    /**
     * Get id value
     * @return int|null
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
     * Get mismatchAction value
     * @return Egovs_Paymentbase_Model_Payplace_Enum_Mismatch_ActionEnum|null
     */
    public function getMismatchAction()
    {
        return $this->mismatchAction;
    }
    /**
     * Set mismatchAction value
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_Mismatch_ActionEnum::valueIsValid()
     * @param Egovs_Paymentbase_Model_Payplace_Enum_Mismatch_ActionEnum $_mismatchAction the mismatchAction
     * @return Egovs_Paymentbase_Model_Payplace_Enum_Mismatch_ActionEnum
     */
    public function setMismatchAction($_mismatchAction)
    {
        if(!Egovs_Paymentbase_Model_Payplace_Enum_Mismatch_ActionEnum::valueIsValid($_mismatchAction))
        {
            return false;
        }
        return ($this->mismatchAction = $_mismatchAction);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @uses Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @param array $_array the exported values
     * @return Egovs_Paymentbase_Model_Payplace_Types_Compare
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
