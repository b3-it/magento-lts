<?php
/**
 * File for class Egovs_SepaDebitSax_Model_Webservice_Types_Result_LesenSEPAMandatMitPDFResult
 * @package SepaMv
 * @subpackage Structs
 * @date 2014-03-12
 * @author Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @version 0.9.0.0
 */
/**
 * This class stands for Egovs_SepaDebitSax_Model_Webservice_Types_Result_LesenSEPAMandatMitPDFResult originally named LesenSEPAMandatMitPDFResult
 * Documentation : Result: Returncode;
 * Meta informations extracted from the WSDL
 * - from schema : ../sepatest2.mandatsverwaltungWS.wsdl
 * @package SepaMv
 * @subpackage Structs
 * @date 2014-03-12
 * @author Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @version 0.9.0.0
 */
class Egovs_SepaDebitSax_Model_Webservice_Types_Result_LesenSEPAMandatMitPDFResult extends Egovs_SepaDebitSax_Model_Webservice_WsdlClass
{
    /**
     * The Result
     * @var Egovs_SepaDebitSax_Model_Webservice_Types_Result
     */
    public $Result;
    /**
     * The Mandat
     * @var Egovs_SepaDebitSax_Model_Webservice_Types_Mandat
     */
    public $Mandat;
    /**
     * The MandatPdf
     * @var base64Binary
     */
    public $MandatPdf;
    /**
     * Constructor method for LesenSEPAMandatMitPDFResult
     * @see parent::__construct()
     * @param Egovs_SepaDebitSax_Model_Webservice_Types_Result $_result
     * @param Egovs_SepaDebitSax_Model_Webservice_Types_Mandat $_mandat
     * @param base64Binary $_mandatPdf
     * @return Egovs_SepaDebitSax_Model_Webservice_Types_Result_LesenSEPAMandatMitPDFResult
     */
    public function __construct($_result = NULL,$_mandat = NULL,$_mandatPdf = NULL)
    {
        parent::__construct(array('Result'=>$_result,'Mandat'=>$_mandat,'MandatPdf'=>$_mandatPdf),false);
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
     * Get Mandat value
     * @return Egovs_SepaDebitSax_Model_Webservice_Types_Mandat|null
     */
    public function getMandat()
    {
        return $this->Mandat;
    }
    /**
     * Set Mandat value
     * @param Egovs_SepaDebitSax_Model_Webservice_Types_Mandat $_mandat the Mandat
     * @return Egovs_SepaDebitSax_Model_Webservice_Types_Mandat
     */
    public function setMandat($_mandat)
    {
        return ($this->Mandat = $_mandat);
    }
    /**
     * Get MandatPdf value
     * @return base64Binary|null
     */
    public function getMandatPdf()
    {
        return $this->MandatPdf;
    }
    /**
     * Set MandatPdf value
     * @param base64Binary $_mandatPdf the MandatPdf
     * @return base64Binary
     */
    public function setMandatPdf($_mandatPdf)
    {
        return ($this->MandatPdf = $_mandatPdf);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see Egovs_SepaDebitSax_Model_Webservice_WsdlClass::__set_state()
     * @uses Egovs_SepaDebitSax_Model_Webservice_WsdlClass::__set_state()
     * @param array $_array the exported values
     * @return Egovs_SepaDebitSax_Model_Webservice_Types_Result_LesenSEPAMandatMitPDFResult
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
