<?php
/**
 * File for class Egovs_Paymentbase_Model_Payplace_Types_EScore_RppResult
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
/**
 * This class stands for Egovs_Paymentbase_Model_Payplace_Types_EScore_RppResult originally named eScoreRppResult
 * Meta informations extracted from the WSDL
 * - from schema : file:///etc/Callback.wsdl
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
class Egovs_Paymentbase_Model_Payplace_Types_EScore_RppResult extends Egovs_Paymentbase_Model_Payplace_WsdlClass
{
    /**
     * The eScoreContentType
     * Meta informations extracted from the WSDL
     * - documentation : eScore RPP: type of the notice
     * - from schema : file:///etc/Callback.wsdl
     * - length : 2
     * @var string
     */
    public $eScoreContentType;
    /**
     * The eScoreContentDescription
     * Meta informations extracted from the WSDL
     * - documentation : eScore RPP: content description, e.g. RLS for a return debit note or NCA for publicly known bank details ("non consumer account")
     * - from schema : file:///etc/Callback.wsdl
     * - maxLength : 30
     * @var string
     */
    public $eScoreContentDescription;
    /**
     * The eScoreContentCode
     * Meta informations extracted from the WSDL
     * - documentation : eScore RPP: reason of the notice
     * - from schema : file:///etc/Callback.wsdl
     * - length : 2
     * @var string
     */
    public $eScoreContentCode;
    /**
     * The eScoreNoOfMatches
     * Meta informations extracted from the WSDL
     * - documentation : number of hits
     * - from schema : file:///etc/Callback.wsdl
     * - length : 1
     * @var string
     */
    public $eScoreNoOfMatches;
    /**
     * The eScoreFirstNoticeDate
     * Meta informations extracted from the WSDL
     * - documentation : date of the first notice
     * - from schema : file:///etc/Callback.wsdl
     * @var DateTime
     */
    public $eScoreFirstNoticeDate;
    /**
     * The eScoreLastNoticeDate
     * Meta informations extracted from the WSDL
     * - documentation : date of the last notice
     * - from schema : file:///etc/Callback.wsdl
     * @var DateTime
     */
    public $eScoreLastNoticeDate;
    /**
     * Constructor method for eScoreRppResult
     * @see parent::__construct()
     * @param string $_eScoreContentType
     * @param string $_eScoreContentDescription
     * @param string $_eScoreContentCode
     * @param string $_eScoreNoOfMatches
     * @param DateTime $_eScoreFirstNoticeDate
     * @param DateTime $_eScoreLastNoticeDate
     * @return Egovs_Paymentbase_Model_Payplace_Types_EScore_RppResult
     */
    public function __construct($_eScoreContentType = NULL,$_eScoreContentDescription = NULL,$_eScoreContentCode = NULL,$_eScoreNoOfMatches = NULL,$_eScoreFirstNoticeDate = NULL,$_eScoreLastNoticeDate = NULL)
    {
        parent::__construct(array('eScoreContentType'=>$_eScoreContentType,'eScoreContentDescription'=>$_eScoreContentDescription,'eScoreContentCode'=>$_eScoreContentCode,'eScoreNoOfMatches'=>$_eScoreNoOfMatches,'eScoreFirstNoticeDate'=>$_eScoreFirstNoticeDate,'eScoreLastNoticeDate'=>$_eScoreLastNoticeDate),false);
    }
    /**
     * Get eScoreContentType value
     * @return string|null
     */
    public function getEScoreContentType()
    {
        return $this->eScoreContentType;
    }
    /**
     * Set eScoreContentType value
     * @param string $_eScoreContentType the eScoreContentType
     * @return string
     */
    public function setEScoreContentType($_eScoreContentType)
    {
        return ($this->eScoreContentType = $_eScoreContentType);
    }
    /**
     * Get eScoreContentDescription value
     * @return string|null
     */
    public function getEScoreContentDescription()
    {
        return $this->eScoreContentDescription;
    }
    /**
     * Set eScoreContentDescription value
     * @param string $_eScoreContentDescription the eScoreContentDescription
     * @return string
     */
    public function setEScoreContentDescription($_eScoreContentDescription)
    {
        return ($this->eScoreContentDescription = $_eScoreContentDescription);
    }
    /**
     * Get eScoreContentCode value
     * @return string|null
     */
    public function getEScoreContentCode()
    {
        return $this->eScoreContentCode;
    }
    /**
     * Set eScoreContentCode value
     * @param string $_eScoreContentCode the eScoreContentCode
     * @return string
     */
    public function setEScoreContentCode($_eScoreContentCode)
    {
        return ($this->eScoreContentCode = $_eScoreContentCode);
    }
    /**
     * Get eScoreNoOfMatches value
     * @return string|null
     */
    public function getEScoreNoOfMatches()
    {
        return $this->eScoreNoOfMatches;
    }
    /**
     * Set eScoreNoOfMatches value
     * @param string $_eScoreNoOfMatches the eScoreNoOfMatches
     * @return string
     */
    public function setEScoreNoOfMatches($_eScoreNoOfMatches)
    {
        return ($this->eScoreNoOfMatches = $_eScoreNoOfMatches);
    }
    /**
     * Get eScoreFirstNoticeDate value
     * @return DateTime|null
     */
    public function getEScoreFirstNoticeDate()
    {
        return $this->eScoreFirstNoticeDate;
    }
    /**
     * Set eScoreFirstNoticeDate value
     * @param DateTime $_eScoreFirstNoticeDate the eScoreFirstNoticeDate
     * @return bool
     */
    public function setEScoreFirstNoticeDate($_eScoreFirstNoticeDate)
    {
        return ($this->eScoreFirstNoticeDate = $_eScoreFirstNoticeDate);
    }
    /**
     * Get eScoreLastNoticeDate value
     * @return DateTime|null
     */
    public function getEScoreLastNoticeDate()
    {
        return $this->eScoreLastNoticeDate;
    }
    /**
     * Set eScoreLastNoticeDate value
     * @param DateTime $_eScoreLastNoticeDate the eScoreLastNoticeDate
     * @return bool
     */
    public function setEScoreLastNoticeDate($_eScoreLastNoticeDate)
    {
        return ($this->eScoreLastNoticeDate = $_eScoreLastNoticeDate);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @uses Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @param array $_array the exported values
     * @return Egovs_Paymentbase_Model_Payplace_Types_EScore_RppResult
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
