<?php
/**
 * File for class Egovs_Paymentbase_Model_Payplace_Types_EScore_Data
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
/**
 * This class stands for Egovs_Paymentbase_Model_Payplace_Types_EScore_Data originally named eScoreData
 * Documentation : Includes data specific to eScore.
 * Meta informations extracted from the WSDL
 * - from schema : file:///etc/Callback.wsdl
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
class Egovs_Paymentbase_Model_Payplace_Types_EScore_Data extends Egovs_Paymentbase_Model_Payplace_WsdlClass
{
    /**
     * The partnerNumber
     * Meta informations extracted from the WSDL
     * - documentation : eScore participant number
     * - from schema : file:///etc/Callback.wsdl
     * - length : 5
     * @var string
     */
    public $partnerNumber;
    /**
     * The partnerCode
     * Meta informations extracted from the WSDL
     * - documentation : eScore participant identification code
     * - from schema : file:///etc/Callback.wsdl
     * - length : 8
     * @var string
     */
    public $partnerCode;
    /**
     * The userName
     * Meta informations extracted from the WSDL
     * - documentation : eScore user name
     * - from schema : file:///etc/Callback.wsdl
     * - maxLength : 30
     * @var string
     */
    public $userName;
    /**
     * The userCode
     * Meta informations extracted from the WSDL
     * - documentation : eScore user identifier
     * - from schema : file:///etc/Callback.wsdl
     * - maxLength : 8
     * @var string
     */
    public $userCode;
    /**
     * Constructor method for eScoreData
     * @see parent::__construct()
     * @param string $_partnerNumber
     * @param string $_partnerCode
     * @param string $_userName
     * @param string $_userCode
     * @return Egovs_Paymentbase_Model_Payplace_Types_EScore_Data
     */
    public function __construct($_partnerNumber = NULL,$_partnerCode = NULL,$_userName = NULL,$_userCode = NULL)
    {
        parent::__construct(array('partnerNumber'=>$_partnerNumber,'partnerCode'=>$_partnerCode,'userName'=>$_userName,'userCode'=>$_userCode),false);
    }
    /**
     * Get partnerNumber value
     * @return string|null
     */
    public function getPartnerNumber()
    {
        return $this->partnerNumber;
    }
    /**
     * Set partnerNumber value
     * @param string $_partnerNumber the partnerNumber
     * @return string
     */
    public function setPartnerNumber($_partnerNumber)
    {
        return ($this->partnerNumber = $_partnerNumber);
    }
    /**
     * Get partnerCode value
     * @return string|null
     */
    public function getPartnerCode()
    {
        return $this->partnerCode;
    }
    /**
     * Set partnerCode value
     * @param string $_partnerCode the partnerCode
     * @return string
     */
    public function setPartnerCode($_partnerCode)
    {
        return ($this->partnerCode = $_partnerCode);
    }
    /**
     * Get userName value
     * @return string|null
     */
    public function getUserName()
    {
        return $this->userName;
    }
    /**
     * Set userName value
     * @param string $_userName the userName
     * @return string
     */
    public function setUserName($_userName)
    {
        return ($this->userName = $_userName);
    }
    /**
     * Get userCode value
     * @return string|null
     */
    public function getUserCode()
    {
        return $this->userCode;
    }
    /**
     * Set userCode value
     * @param string $_userCode the userCode
     * @return string
     */
    public function setUserCode($_userCode)
    {
        return ($this->userCode = $_userCode);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @uses Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @param array $_array the exported values
     * @return Egovs_Paymentbase_Model_Payplace_Types_EScore_Data
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
