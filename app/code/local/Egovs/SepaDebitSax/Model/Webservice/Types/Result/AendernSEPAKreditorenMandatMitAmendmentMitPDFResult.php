<?php
/**
 * File for class Egovs_SepaDebitSax_Model_Webservice_Types_Result_AendernSEPAKreditorenMandatMitAmendmentMitPDFResult
 * @package SepaMv
 * @subpackage Structs
 * @date 2014-03-12
 * @author Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @version 0.9.0.0
 */
/**
 * This class stands for Egovs_SepaDebitSax_Model_Webservice_Types_Result_AendernSEPAKreditorenMandatMitAmendmentMitPDFResult originally named AendernSEPAKreditorenMandatMitAmendmentMitPDFResult
 * Documentation : Result: Returncode;
 * Meta informations extracted from the WSDL
 * - from schema : ../sepatest2.mandatsverwaltungWS.wsdl
 * @package SepaMv
 * @subpackage Structs
 * @date 2014-03-12
 * @author Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @version 0.9.0.0
 */
class Egovs_SepaDebitSax_Model_Webservice_Types_Result_AendernSEPAKreditorenMandatMitAmendmentMitPDFResult extends Egovs_SepaDebitSax_Model_Webservice_WsdlClass
{
    /**
     * The Result
     * @var Egovs_SepaDebitSax_Model_Webservice_Types_Result
     */
    public $Result;
    /**
     * The AmendmentPdf
     * @var Varien_File_Object base64Binary
     */
    public $AmendmentPdf;
    /**
     * Constructor method for AendernSEPAKreditorenMandatMitAmendmentMitPDFResult
     * @see parent::__construct()
     * @param Egovs_SepaDebitSax_Model_Webservice_Types_Result $_result
     * @param Varien_File_Object base64Binary $_amendmentPdf
     * @return Egovs_SepaDebitSax_Model_Webservice_Types_Result_AendernSEPAKreditorenMandatMitAmendmentMitPDFResult
     */
    public function __construct($_result = NULL,$_amendmentPdf = NULL)
    {
        parent::__construct(array('Result'=>$_result,'AmendmentPdf'=>$_amendmentPdf),false);
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
     * Get AmendmentPdf value
     * @return Varien_File_Object|null
     */
    public function getAmendmentPdf()
    {
        return $this->AmendmentPdf;
    }
    /**
     * Set AmendmentPdf value
     * @param Varien_File_Object base64Binary $_amendmentPdf the AmendmentPdf
     * @return Varien_File_Object base64Binary
     */
    public function setAmendmentPdf($_amendmentPdf)
    {
        return ($this->AmendmentPdf = $_amendmentPdf);
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
