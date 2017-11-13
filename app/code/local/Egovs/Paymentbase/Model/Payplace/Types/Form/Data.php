<?php
/**
 * File for class Egovs_Paymentbase_Model_Payplace_Types_Form_Data
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
/**
 * This class stands for Egovs_Paymentbase_Model_Payplace_Types_Form_Data originally named formData
 * Documentation : For the form service. Information that influences the display of the form and the payment process.
 * Meta informations extracted from the WSDL
 * - from schema : file:///etc/Callback.wsdl
 * @package Egovs_Paymentbase
 * @subpackage Structs
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
class Egovs_Paymentbase_Model_Payplace_Types_Form_Data extends Egovs_Paymentbase_Model_Payplace_WsdlClass
{
    /**
     * The locale
     * Meta informations extracted from the WSDL
     * - default : de
     * - documentation : Language of the form to be displayed. "de" for German, "en" for English. If not submitted the German form will be displayed. For donations and contributions additional "locales" with adapted text exist: "spde" (donation, German), "spen" (donation, English), "btde" (contribution, German), "bten" (contribution, English).
     * - minOccurs : 0
     * @var string
     */
    public $locale;
    /**
     * The version
     * Meta informations extracted from the WSDL
     * - documentation : Version of the form. If omitted, the current default is 1.6. Use 1.6m to display forms optimised for mobile phones. Note that a different version might require a different CSS file.
     * - minOccurs : 0
     * @var string
     */
    public $version;
    /**
     * The cssURL
     * Meta informations extracted from the WSDL
     * - documentation : URL of the cascading stylesheet which the form service uses to display the form.
     * - minOccurs : 0
     * @var string
     */
    public $cssURL;
    /**
     * The formServiceOption
     * @var Egovs_Paymentbase_Model_Payplace_Types_Form_Service_Option
     */
    public $formServiceOption;
    /**
     * The merchantName
     * Meta informations extracted from the WSDL
     * - documentation : Merchant name to be displayed in the form. If empty, no merchant name will be displayed. If this element is omitted the merchant name configured in the system is displayed.
     * - minOccurs : 0
     * @var string
     */
    public $merchantName;
    /**
     * The label
     * @var Egovs_Paymentbase_Model_Payplace_Types_Label
     */
    public $label;
    /**
     * The retries
     * Meta informations extracted from the WSDL
     * - documentation : Specifies how often the customer can retry the payment if the payment fails.
     * - from schema : file:///etc/Callback.wsdl
     * - minInclusive : 0
     * @var int
     */
    public $retries;
    /**
     * Constructor method for formData
     * @see parent::__construct()
     * @param string $_locale
     * @param string $_version
     * @param string $_cssURL
     * @param Egovs_Paymentbase_Model_Payplace_Types_Form_Service_Option $_formServiceOption
     * @param string $_merchantName
     * @param Egovs_Paymentbase_Model_Payplace_Types_Label $_label
     * @param int $_retries
     * @return Egovs_Paymentbase_Model_Payplace_Types_Form_Data
     */
    public function __construct($_locale = 'de',$_version = NULL,$_cssURL = NULL,$_formServiceOption = NULL,$_merchantName = NULL,$_label = NULL,$_retries = NULL)
    {
        parent::__construct(array('locale'=>$_locale,'version'=>$_version,'cssURL'=>$_cssURL,'formServiceOption'=>$_formServiceOption,'merchantName'=>$_merchantName,'label'=>$_label,'retries'=>$_retries),false);
    }
    /**
     * Get locale value
     * @return string|null
     */
    public function getLocale()
    {
        return $this->locale;
    }
    /**
     * Set locale value
     * @param string $_locale the locale
     * @return bool
     */
    public function setLocale($_locale)
    {
        return ($this->locale = $_locale);
    }
    /**
     * Get version value
     * @return string|null
     */
    public function getVersion()
    {
        return $this->version;
    }
    /**
     * Set version value
     * @param string $_version the version
     * @return bool
     */
    public function setVersion($_version)
    {
        return ($this->version = $_version);
    }
    /**
     * Get cssURL value
     * @return string|null
     */
    public function getCssURL()
    {
        return $this->cssURL;
    }
    /**
     * Set cssURL value
     * @param string $_cssURL the cssURL
     * @return bool
     */
    public function setCssURL($_cssURL)
    {
        return ($this->cssURL = $_cssURL);
    }
    /**
     * Get formServiceOption value
     * @return Egovs_Paymentbase_Model_Payplace_Types_Form_Service_Option|null
     */
    public function getFormServiceOption()
    {
        return $this->formServiceOption;
    }
    /**
     * Set formServiceOption value
     * @param Egovs_Paymentbase_Model_Payplace_Types_Form_Service_Option $_formServiceOption the formServiceOption
     * @return Egovs_Paymentbase_Model_Payplace_Types_Form_Service_Option
     */
    public function setFormServiceOption($_formServiceOption)
    {
        return ($this->formServiceOption = $_formServiceOption);
    }
    /**
     * Get merchantName value
     * @return string|null
     */
    public function getMerchantName()
    {
        return $this->merchantName;
    }
    /**
     * Set merchantName value
     * @param string $_merchantName the merchantName
     * @return string
     */
    public function setMerchantName($_merchantName)
    {
        return ($this->merchantName = $_merchantName);
    }
    /**
     * Get label value
     * @return Egovs_Paymentbase_Model_Payplace_Types_Label|null
     */
    public function getLabel()
    {
        return $this->label;
    }
    /**
     * Set label value
     * @param Egovs_Paymentbase_Model_Payplace_Types_Label $_label the label
     * @return Egovs_Paymentbase_Model_Payplace_Types_Label
     */
    public function setLabel($_label)
    {
        return ($this->label = $_label);
    }
    /**
     * Get retries value
     * @return int|null
     */
    public function getRetries()
    {
        return $this->retries;
    }
    /**
     * Set retries value
     * @param int $_retries the retries
     * @return int
     */
    public function setRetries($_retries)
    {
        return ($this->retries = $_retries);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @uses Egovs_Paymentbase_Model_Payplace_WsdlClass::__set_state()
     * @param array $_array the exported values
     * @return Egovs_Paymentbase_Model_Payplace_Types_Form_Data
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
