<?php
/**
 * File for class Egovs_SepaDebitSax_Model_Webservice_Types_Result_AnlegenSEPAPreNotificationMitPDFResult
 * @package SepaMv
 * @subpackage Structs
 * @date 2014-03-12
 * @author Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @version 0.9.0.0
 */
/**
 * This class stands for Egovs_SepaDebitSax_Model_Webservice_Types_Result_AnlegenSEPAPreNotificationMitPDFResult originally named AnlegenSEPAPreNotificationMitPDFResult
 * Documentation : Result: Returncode;
 * Meta informations extracted from the WSDL
 * - from schema : ../sepatest2.mandatsverwaltungWS.wsdl
 * @package SepaMv
 * @subpackage Structs
 * @date 2014-03-12
 * @author Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @version 0.9.0.0
 */
class Egovs_SepaDebitSax_Model_Webservice_Types_Result_AnlegenSEPAPreNotificationMitPDFResult extends Egovs_SepaDebitSax_Model_Webservice_WsdlClass
{
    /**
     * The Result
     * @var Egovs_SepaDebitSax_Model_Webservice_Types_Result
     */
    public $Result;
    /**
     * The PreNotificationPdf
     * @var Varien_File_Object base64Binary
     */
    public $PreNotificationPdf;
    /**
     * Constructor method for AnlegenSEPAPreNotificationMitPDFResult
     * @see parent::__construct()
     * @param Egovs_SepaDebitSax_Model_Webservice_Types_Result $_result
     * @param Varien_File_Object base64Binary $_preNotificationPdf
     * @return Egovs_SepaDebitSax_Model_Webservice_Types_Result_AnlegenSEPAPreNotificationMitPDFResult
     */
    public function __construct($_result = NULL,$_preNotificationPdf = NULL)
    {
        parent::__construct(array('Result'=>$_result,'PreNotificationPdf'=>$_preNotificationPdf),false);
    }
    /**
     * Get Result value
     * @return Egovs_SepaDebitSax_Model_Webservice_Types_Result|null
     */
    public function getResult()
    {
        return $this->Result;
    }
    /**
     * Set Result value
     * @param Egovs_SepaDebitSax_Model_Webservice_Types_Result $_result the Result
     * @return Egovs_SepaDebitSax_Model_Webservice_Types_Result
     */
    public function setResult($_result)
    {
        return ($this->Result = $_result);
    }
    /**
     * Get PreNotificationPdf value
     * @return Varien_File_Object base64Binary|null
     */
    public function getPreNotificationPdf()
    {
        return $this->PreNotificationPdf;
    }
    /**
     * Set PreNotificationPdf value
     * @param Varien_File_Object base64Binary $_preNotificationPdf the PreNotificationPdf
     * @return Varien_File_Object base64Binary
     */
    public function setPreNotificationPdf($_preNotificationPdf)
    {
        return ($this->PreNotificationPdf = $_preNotificationPdf);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see Egovs_SepaDebitSax_Model_Webservice_WsdlClass::__set_state()
     * @uses Egovs_SepaDebitSax_Model_Webservice_WsdlClass::__set_state()
     * @param array $_array the exported values
     * @return Egovs_SepaDebitSax_Model_Webservice_Types_Result_AnlegenSEPAPreNotificationMitPDFResult
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
