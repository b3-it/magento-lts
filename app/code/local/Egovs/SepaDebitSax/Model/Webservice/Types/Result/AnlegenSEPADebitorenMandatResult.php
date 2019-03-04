<?php
/**
 * File for class Egovs_SepaDebitSax_Model_Webservice_Types_Result_AnlegenSEPADebitorenMandatResult
 * @package SepaMv
 * @subpackage Structs
 * @date 2014-03-12
 * @author Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @version 0.9.0.0
 */
/**
 * This class stands for Egovs_SepaDebitSax_Model_Webservice_Types_Result_AnlegenSEPADebitorenMandatResult originally named AnlegenSEPADebitorenMandatResult
 * Documentation : Result: Returncode;
 * Meta informations extracted from the WSDL
 * - from schema : ../sepatest2.mandatsverwaltungWS.wsdl
 * @package SepaMv
 * @subpackage Structs
 * @date 2014-03-12
 * @author Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @version 0.9.0.0
 */
class Egovs_SepaDebitSax_Model_Webservice_Types_Result_AnlegenSEPADebitorenMandatResult extends Egovs_SepaDebitSax_Model_Webservice_WsdlClass
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
     * Constructor method for AnlegenSEPADebitorenMandatResult
     * @see parent::__construct()
     * @param Egovs_SepaDebitSax_Model_Webservice_Types_Result $_result
     * @param Egovs_SepaDebitSax_Model_Webservice_Types_Mandat $_mandat
     * @return Egovs_SepaDebitSax_Model_Webservice_Types_Result_AnlegenSEPADebitorenMandatResult
     */
    public function __construct($_result = NULL,$_mandat = NULL)
    {
        parent::__construct(array('Result'=>$_result,'Mandat'=>$_mandat),false);
    }
    /**
     * Get Result value
     * @return Egovs_SepaDebitSax_Model_Webservice_Types_Result|null
     */
 	public function getResult()
    {
        if($this->Result instanceof self )
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
     * Method returning the class name
     * @return string __CLASS__
     */
    public function __toString()
    {
        return __CLASS__;
    }
}
