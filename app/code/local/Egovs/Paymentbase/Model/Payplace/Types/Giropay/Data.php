<?php
/**
 * File for class Egovs_Paymentbase_Model_Payplace_Types_Giropay_Data
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
/**
 * This class stands for Egovs_Paymentbase_Model_Payplace_Types_Giropay_Data originally named giropayData
 * Documentation : Includes data specific to giropay.
 * Meta informations extracted from the WSDL
 * - from schema : file:///etc/Callback.wsdl
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
class Egovs_Paymentbase_Model_Payplace_Types_Giropay_Data extends Egovs_Paymentbase_Model_Payplace_WsdlClass
{
    /**
     * The merchantSubId
     * Meta informations extracted from the WSDL
     * - documentation : Identification of the online trader for giropay.
     * - from schema : file:///etc/Callback.wsdl
     * - length : 4
     * - pattern : [0-9]+
     * @var string
     */
    public $merchantSubId;
    /**
     * The extMerchantId
     * Meta informations extracted from the WSDL
     * - documentation : External identification number of the online trader for giropay.
     * - from schema : file:///etc/Callback.wsdl
     * - maxLength : 20
     * @var string
     */
    public $extMerchantId;
    /**
     * The extMerchantTag
     * Meta informations extracted from the WSDL
     * - documentation : Optional field, which can be freely allocated by the trader for giropay.
     * - from schema : file:///etc/Callback.wsdl
     * - maxLength : 20
     * @var string
     */
    public $extMerchantTag;
    /**
     * The labelledText
     * @var Egovs_Paymentbase_Model_Payplace_Types_LabelledText
     */
    public $labelledText;
    /**
     * Constructor method for giropayData
     * @see parent::__construct()
     * @param string $_merchantSubId
     * @param string $_extMerchantId
     * @param string $_extMerchantTag
     * @param Egovs_Paymentbase_Model_Payplace_Types_LabelledText $_labelledText
     * @return Egovs_Paymentbase_Model_Payplace_Types_Giropay_Data
     */
    public function __construct($_merchantSubId = NULL,$_extMerchantId = NULL,$_extMerchantTag = NULL,$_labelledText = NULL)
    {
        parent::__construct(array('merchantSubId'=>$_merchantSubId,'extMerchantId'=>$_extMerchantId,'extMerchantTag'=>$_extMerchantTag,'labelledText'=>$_labelledText),false);
    }
    /**
     * Get merchantSubId value
     * @return string|null
     */
    public function getMerchantSubId()
    {
        return $this->merchantSubId;
    }
    /**
     * Set merchantSubId value
     * @param string $_merchantSubId the merchantSubId
     * @return string
     */
    public function setMerchantSubId($_merchantSubId)
    {
        return ($this->merchantSubId = $_merchantSubId);
    }
    /**
     * Get extMerchantId value
     * @return string|null
     */
    public function getExtMerchantId()
    {
        return $this->extMerchantId;
    }
    /**
     * Set extMerchantId value
     * @param string $_extMerchantId the extMerchantId
     * @return string
     */
    public function setExtMerchantId($_extMerchantId)
    {
        return ($this->extMerchantId = $_extMerchantId);
    }
    /**
     * Get extMerchantTag value
     * @return string|null
     */
    public function getExtMerchantTag()
    {
        return $this->extMerchantTag;
    }
    /**
     * Set extMerchantTag value
     * @param string $_extMerchantTag the extMerchantTag
     * @return string
     */
    public function setExtMerchantTag($_extMerchantTag)
    {
        return ($this->extMerchantTag = $_extMerchantTag);
    }
    /**
     * Get labelledText value
     * @return Egovs_Paymentbase_Model_Payplace_Types_LabelledText|null
     */
    public function getLabelledText()
    {
        return $this->labelledText;
    }
    /**
     * Set labelledText value
     * @param Egovs_Paymentbase_Model_Payplace_Types_LabelledText $_labelledText the labelledText
     * @return Egovs_Paymentbase_Model_Payplace_Types_LabelledText
     */
    public function setLabelledText($_labelledText)
    {
        return ($this->labelledText = $_labelledText);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @uses Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @param array $_array the exported values
     * @return Egovs_Paymentbase_Model_Payplace_Types_Giropay_Data
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
