<?php
/**
 * File for class Egovs_SepaDebitSax_Model_Webservice_Types_Result_AnlegenSEPAKreditorenMandatMitPDFResult
 * @package SepaMv
 * @subpackage Structs
 * @date 2014-03-12
 * @author Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @version 0.9.0.0
 */
/**
 * This class stands for Egovs_SepaDebitSax_Model_Webservice_Types_Result_AnlegenSEPAKreditorenMandatMitPDFResult originally named AnlegenSEPAKreditorenMandatMitPDFResult
 * Documentation : Result: Returncode;
 * Meta informations extracted from the WSDL
 * - from schema : ../sepatest2.mandatsverwaltungWS.wsdl
 * @package SepaMv
 * @subpackage Structs
 * @date 2014-03-12
 * @author Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @version 0.9.0.0
 */
class Egovs_SepaDebitSax_Model_Webservice_Types_Result_AnlegenSEPAKreditorenMandatMitPDFResult extends Egovs_SepaDebitSax_Model_Webservice_WsdlClass
{
    /**
     * The Result
     * @var Egovs_SepaDebitSax_Model_Webservice_Types_Result
     */
    public $Result;
    /**
     * The Mandatsdaten
     * @var Egovs_SepaDebitSax_Model_Webservice_Types_Mandatsdaten
     */
    public $Mandatsdaten;
    /**
     * The MandatPdf
     * @var Varien_File_Object base64Binary
     */
    public $MandatPdf;
    /**
     * Constructor method for AnlegenSEPAKreditorenMandatMitPDFResult
     * @see parent::__construct()
     * @param Egovs_SepaDebitSax_Model_Webservice_Types_Result $_result
     * @param Egovs_SepaDebitSax_Model_Webservice_Types_Mandatsdaten $_mandatsdaten
     * @param Varien_File_Object base64Binary $_mandatPdf
     * @return Egovs_SepaDebitSax_Model_Webservice_Types_Result_AnlegenSEPAKreditorenMandatMitPDFResult
     */
    public function __construct($_result = NULL,$_mandatsdaten = NULL,$_mandatPdf = NULL)
    {
        parent::__construct(array('Result'=>$_result,'Mandatsdaten'=>$_mandatsdaten,'MandatPdf'=>$_mandatPdf),false);
    }
    
    public function xx__call($method, $args) {
    	parent::__call($method, $args);
    
    }
    
    /**
     * Get Result value
     * @return Egovs_SepaDebitSax_Model_Webservice_Types_Result|null
     */
    public function getResult()
    {
    	if($this->Result instanceof Egovs_SepaDebitSax_Model_Webservice_Types_Result_AnlegenSEPAKreditorenMandatMitPDFResult)
    	{
        	return $this->Result->Result;
    	}
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
     * Get Mandatsdaten value
     * @return Egovs_SepaDebitSax_Model_Webservice_Types_Mandatsdaten|null
     */
    public function getMandatsdaten()
    {
        return $this->Mandatsdaten;
    }
    /**
     * Set Mandatsdaten value
     * @param Egovs_SepaDebitSax_Model_Webservice_Types_Mandatsdaten $_mandatsdaten the Mandatsdaten
     * @return Egovs_SepaDebitSax_Model_Webservice_Types_Mandatsdaten
     */
    public function setMandatsdaten($_mandatsdaten)
    {
        return ($this->Mandatsdaten = $_mandatsdaten);
    }
    /**
     * Get MandatPdf value
     * @return Varien_File_Object base64Binary|null
     */
    public function getMandatPdf()
    {
        return $this->MandatPdf;
    }
    /**
     * Set MandatPdf value
     * @param Varien_File_Object base64Binary $_mandatPdf the MandatPdf
     * @return Varien_File_Object base64Binary
     */
    public function setMandatPdf($_mandatPdf)
    {
        return ($this->MandatPdf = $_mandatPdf);
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
