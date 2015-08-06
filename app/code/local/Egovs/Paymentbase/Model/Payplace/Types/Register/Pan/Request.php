<?php
/**
 * File for class Egovs_Paymentbase_Model_Payplace_Types_Register_Pan_Request
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
/**
 * This class stands for Egovs_Paymentbase_Model_Payplace_Types_Register_Pan_Request originally named registerPanRequest
 * Documentation : Register a pan alias. The form service is used to have the user enter the credit card (or bank account) details.
 * Meta informations extracted from the WSDL
 * - from schema : file:///etc/Callback.wsdl
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
class Egovs_Paymentbase_Model_Payplace_Types_Register_Pan_Request extends Egovs_Paymentbase_Model_Payplace_Types_Base_Request
{
    /**
     * The kind
     * @var Egovs_Paymentbase_Model_Payplace_Enum_KindEnum
     */
    public $kind;
    /**
     * The panalias
     * @var Egovs_Paymentbase_Model_Payplace_Types_Panalias
     */
    public $panalias;
    /**
     * The formData
     * @var Egovs_Paymentbase_Model_Payplace_Types_Form_Data
     */
    public $formData;
    /**
     * The callbackData
     * @var Egovs_Paymentbase_Model_Payplace_Types_Callback_Data
     */
    public $callbackData;
    /**
     * The customerContinuation
     * @var Egovs_Paymentbase_Model_Payplace_Types_Customer_Continuation
     */
    public $customerContinuation;
    /**
     * Constructor method for registerPanRequest
     * @see parent::__construct()
     * @param Egovs_Paymentbase_Model_Payplace_Enum_KindEnum $_kind
     * @param Egovs_Paymentbase_Model_Payplace_Types_Panalias $_panalias
     * @param Egovs_Paymentbase_Model_Payplace_Types_Form_Data $_formData
     * @param Egovs_Paymentbase_Model_Payplace_Types_Callback_Data $_callbackData
     * @param Egovs_Paymentbase_Model_Payplace_Types_Customer_Continuation $_customerContinuation
     * @return Egovs_Paymentbase_Model_Payplace_Types_Register_Pan_Request
     */
    public function __construct($_kind = NULL,$_panalias = NULL,$_formData = NULL,$_callbackData = NULL,$_customerContinuation = NULL)
    {
        Egovs_Paymentbase_Model_Payplace_WsdlClass::__construct(array('kind'=>$_kind,'panalias'=>$_panalias,'formData'=>$_formData,'callbackData'=>$_callbackData,'customerContinuation'=>$_customerContinuation),false);
    }
    /**
     * Get kind value
     * @return Egovs_Paymentbase_Model_Payplace_Enum_KindEnum|null
     */
    public function getKind()
    {
        return $this->kind;
    }
    /**
     * Set kind value
     * @uses Egovs_Paymentbase_Model_Payplace_Enum_KindEnum::valueIsValid()
     * @param Egovs_Paymentbase_Model_Payplace_Enum_KindEnum $_kind the kind
     * @return Egovs_Paymentbase_Model_Payplace_Enum_KindEnum
     */
    public function setKind($_kind)
    {
        if(!Egovs_Paymentbase_Model_Payplace_Enum_KindEnum::valueIsValid($_kind))
        {
            return false;
        }
        return ($this->kind = $_kind);
    }
    /**
     * Get panalias value
     * @return Egovs_Paymentbase_Model_Payplace_Types_Panalias|null
     */
    public function getPanalias()
    {
        return $this->panalias;
    }
    /**
     * Set panalias value
     * @param Egovs_Paymentbase_Model_Payplace_Types_Panalias $_panalias the panalias
     * @return Egovs_Paymentbase_Model_Payplace_Types_Panalias
     */
    public function setPanalias($_panalias)
    {
        return ($this->panalias = $_panalias);
    }
    /**
     * Get formData value
     * @return Egovs_Paymentbase_Model_Payplace_Types_Form_Data|null
     */
    public function getFormData()
    {
        return $this->formData;
    }
    /**
     * Set formData value
     * @param Egovs_Paymentbase_Model_Payplace_Types_Form_Data $_formData the formData
     * @return Egovs_Paymentbase_Model_Payplace_Types_Form_Data
     */
    public function setFormData($_formData)
    {
        return ($this->formData = $_formData);
    }
    /**
     * Get callbackData value
     * @return Egovs_Paymentbase_Model_Payplace_Types_Callback_Data|null
     */
    public function getCallbackData()
    {
        return $this->callbackData;
    }
    /**
     * Set callbackData value
     * @param Egovs_Paymentbase_Model_Payplace_Types_Callback_Data $_callbackData the callbackData
     * @return Egovs_Paymentbase_Model_Payplace_Types_Callback_Data
     */
    public function setCallbackData($_callbackData)
    {
        return ($this->callbackData = $_callbackData);
    }
    /**
     * Get customerContinuation value
     * @return Egovs_Paymentbase_Model_Payplace_Types_Customer_Continuation|null
     */
    public function getCustomerContinuation()
    {
        return $this->customerContinuation;
    }
    /**
     * Set customerContinuation value
     * @param Egovs_Paymentbase_Model_Payplace_Types_Customer_Continuation $_customerContinuation the customerContinuation
     * @return Egovs_Paymentbase_Model_Payplace_Types_Customer_Continuation
     */
    public function setCustomerContinuation($_customerContinuation)
    {
        return ($this->customerContinuation = $_customerContinuation);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @uses Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @param array $_array the exported values
     * @return Egovs_Paymentbase_Model_Payplace_Types_Register_Pan_Request
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
