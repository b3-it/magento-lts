<?php
/**
 * File for class SepaMvStructWSResult
 * @package SepaMv
 * @subpackage Structs
 * @date 2014-03-12
 * @author Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @version 0.9.0.0
 */
/**
 * This class stands for SepaMvStructWSResult originally named WSResult
 * Documentation : ResultState: gibt an, ob die Operation erfolgreich (0) oder nicht war (1); ResultCode: TResultCode
 * Meta informations extracted from the WSDL
 * - from schema : ../sepatest2.mandatsverwaltungWS.wsdl
 * @package SepaMv
 * @subpackage Structs
 * @date 2014-03-12
 * @author Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @version 0.9.0.0
 */
class Egovs_SepaDebitSax_Model_Webservice_Types_Result extends Egovs_SepaDebitSax_Model_Webservice_WsdlClass
{
    /**
     * The ResultState
     * @var Egovs_SepaDebitSax_Model_Webservice_Enum_ResultState
     */
    public $ResultState;
    /**
     * The ResultCode
     * Meta informations extracted from the WSDL
     * - nillable : true
     * @var Egovs_SepaDebitSax_Model_Webservice_Types_ResultCode
     */
    public $ResultCode;
    
    /**
     * Constructor method for WSResult
     * @see parent::__construct()
     * @param Egovs_SepaDebitSax_Model_Webservice_Enum_ResultState $_resultState
     * @param Egovs_SepaDebitSax_Model_Webservice_Types_ResultCode $_resultCode
     * @return Egovs_SepaDebitSax_Model_Webservice_Types_Result
     */
    public function __construct($_resultState = NULL,$_resultCode = NULL)
    {
        parent::__construct(array('ResultState'=>$_resultState,'ResultCode'=>$_resultCode),false);
    }
    /**
     * Get ResultState value
     * @return Egovs_SepaDebitSax_Model_Webservice_Enum_ResultState|null
     */
    public function getResultState()
    {
        return $this->ResultState;
    }
    /**
     * Set ResultState value
     * @uses Egovs_SepaDebitSax_Model_Webservice_Types_Enum_ResultState::valueIsValid()
     * @param Egovs_SepaDebitSax_Model_Webservice_Enum_ResultState $_resultState the ResultState
     * @return Egovs_SepaDebitSax_Model_Webservice_Enum_ResultState
     */
    public function setResultState($_resultState)
    {
        if(!Egovs_SepaDebitSax_Model_Webservice_Enum_ResultState::valueIsValid($_resultState))
        {
            return false;
        }
        return ($this->ResultState = $_resultState);
    }
    /**
     * Get ResultCode value
     * @return Egovs_SepaDebitSax_Model_Webservice_Types_ResultCode|null
     */
    public function getResultCode()
    {
        return $this->ResultCode;
    }
    /**
     * Set ResultCode value
     * @param Egovs_SepaDebitSax_Model_Webservice_Types_ResultCode $_resultCode the ResultCode
     * @return Egovs_SepaDebitSax_Model_Webservice_Types_ResultCode
     */
    public function setResultCode($_resultCode)
    {
        return ($this->ResultCode = $_resultCode);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see Egovs_SepaDebitSax_Model_Webservice_WsdlClass::__set_state()
     * @uses Egovs_SepaDebitSax_Model_Webservice_WsdlClass::__set_state()
     * @param array $_array the exported values
     * @return Egovs_SepaDebitSax_Model_Webservice_Types_Result
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
