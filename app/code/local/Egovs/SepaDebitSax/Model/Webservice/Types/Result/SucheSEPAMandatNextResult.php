<?php
/**
 * File for class Egovs_SepaDebitSax_Model_Webservice_Types_Result_SucheSEPAMandatNextResult
 * @package SepaMv
 * @subpackage Structs
 * @date 2014-03-12
 * @author Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @version 0.9.0.0
 */
/**
 * This class stands for Egovs_SepaDebitSax_Model_Webservice_Types_Result_SucheSEPAMandatNextResult originally named SucheSEPAMandatNextResult
 * Documentation : Result: Returncode;
 * Meta informations extracted from the WSDL
 * - from schema : ../sepatest2.mandatsverwaltungWS.wsdl
 * @package SepaMv
 * @subpackage Structs
 * @date 2014-03-12
 * @author Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @version 0.9.0.0
 */
class Egovs_SepaDebitSax_Model_Webservice_Types_Result_SucheSEPAMandatNextResult extends Egovs_SepaDebitSax_Model_Webservice_WsdlClass
{
    /**
     * The Result
     * @var Egovs_SepaDebitSax_Model_Webservice_Types_Result
     */
    public $Result;
    /**
     * The SuchanfragenId
     * @var string
     */
    public $SuchanfragenId;
    /**
     * The Mandate
     * @var Egovs_SepaDebitSax_Model_Webservice_Types_MandatListe
     */
    public $Mandate;
    /**
     * The Verbleibende
     * @var integer
     */
    public $Verbleibende;
    /**
     * Constructor method for SucheSEPAMandatNextResult
     * @see parent::__construct()
     * @param Egovs_SepaDebitSax_Model_Webservice_Types_Result $_result
     * @param string $_suchanfragenId
     * @param Egovs_SepaDebitSax_Model_Webservice_Types_MandatListe $_mandate
     * @param integer $_verbleibende
     * @return Egovs_SepaDebitSax_Model_Webservice_Types_Result_SucheSEPAMandatNextResult
     */
    public function __construct($_result = NULL,$_suchanfragenId = NULL,$_mandate = NULL,$_verbleibende = NULL)
    {
        parent::__construct(array('Result'=>$_result,'SuchanfragenId'=>$_suchanfragenId,'Mandate'=>$_mandate,'Verbleibende'=>$_verbleibende),false);
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
     * Get SuchanfragenId value
     * @return string|null
     */
    public function getSuchanfragenId()
    {
        return $this->SuchanfragenId;
    }
    /**
     * Set SuchanfragenId value
     * @param string $_suchanfragenId the SuchanfragenId
     * @return string
     */
    public function setSuchanfragenId($_suchanfragenId)
    {
        return ($this->SuchanfragenId = $_suchanfragenId);
    }
    /**
     * Get Mandate value
     * @return Egovs_SepaDebitSax_Model_Webservice_Types_MandatListe|null
     */
    public function getMandate()
    {
        return $this->Mandate;
    }
    /**
     * Set Mandate value
     * @param Egovs_SepaDebitSax_Model_Webservice_Types_MandatListe $_mandate the Mandate
     * @return Egovs_SepaDebitSax_Model_Webservice_Types_MandatListe
     */
    public function setMandate($_mandate)
    {
        return ($this->Mandate = $_mandate);
    }
    /**
     * Get Verbleibende value
     * @return integer|null
     */
    public function getVerbleibende()
    {
        return $this->Verbleibende;
    }
    /**
     * Set Verbleibende value
     * @param integer $_verbleibende the Verbleibende
     * @return integer
     */
    public function setVerbleibende($_verbleibende)
    {
        return ($this->Verbleibende = $_verbleibende);
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
