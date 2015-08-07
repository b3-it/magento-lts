<?php
/**
 * File for class Egovs_Paymentbase_Model_Payplace_Types_PanAlias_Request
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
/**
 * This class stands for Egovs_Paymentbase_Model_Payplace_Types_PanAlias_Request originally named panAliasRequest
 * Meta informations extracted from the WSDL
 * - from schema : file:///etc/Callback.wsdl
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
class Egovs_Paymentbase_Model_Payplace_Types_PanAlias_Request extends Egovs_Paymentbase_Model_Payplace_Types_Base_Request
{
    /**
     * The action
     * @var Egovs_Paymentbase_Model_Payplace_Enum_PanAlias_ActionEnum
     */
    public $action;
    /**
     * The panalias
     * Meta informations extracted from the WSDL
     * - maxLength : 50
     * - minLength : 0
     * @var string
     */
    public $panalias;
    /**
     * The holder
     * @var string
     */
    public $holder;
    /**
     * Constructor method for panAliasRequest
     * @see parent::__construct()
     * @param Egovs_Paymentbase_Model_Payplace_Enum_PanAlias_ActionEnum $_action
     * @param string $_panalias
     * @param string $_holder
     * @return Egovs_Paymentbase_Model_Payplace_Types_PanAlias_Request
     */
    public function __construct($_action = NULL,$_panalias = NULL,$_holder = NULL)
    {
        Egovs_Paymentbase_Model_Payplace_WsdlClass::__construct(array('action'=>$_action,'panalias'=>$_panalias,'holder'=>$_holder),false);
    }
    /**
     * Get action value
     * @return Egovs_Paymentbase_Model_Payplace_Enum_PanAlias_ActionEnum|null
     */
    public function getAction()
    {
        return $this->action;
    }
    /**
     * Set action value
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_PanAlias_ActionEnum::valueIsValid()
     * @param Egovs_Paymentbase_Model_Payplace_Enum_PanAlias_ActionEnum $_action the action
     * @return Egovs_Paymentbase_Model_Payplace_Enum_PanAlias_ActionEnum
     */
    public function setAction($_action)
    {
        if(!Egovs_Paymentbase_Model_Payplace_Enum_PanAlias_ActionEnum::valueIsValid($_action))
        {
            return false;
        }
        return ($this->action = $_action);
    }
    /**
     * Get panalias value
     * @return string|null
     */
    public function getPanalias()
    {
        return $this->panalias;
    }
    /**
     * Set panalias value
     * @param string $_panalias the panalias
     * @return string
     */
    public function setPanalias($_panalias)
    {
        return ($this->panalias = $_panalias);
    }
    /**
     * Get holder value
     * @return string|null
     */
    public function getHolder()
    {
        return $this->holder;
    }
    /**
     * Set holder value
     * @param string $_holder the holder
     * @return string
     */
    public function setHolder($_holder)
    {
        return ($this->holder = $_holder);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @uses Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @param array $_array the exported values
     * @return Egovs_Paymentbase_Model_Payplace_Types_PanAlias_Request
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
