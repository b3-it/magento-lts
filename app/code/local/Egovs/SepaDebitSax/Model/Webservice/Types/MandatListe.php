<?php
/**
 * File for class Egovs_SepaDebitSax_Model_Webservice_Types_MandatListe
 * @package SepaMv
 * @subpackage Structs
 * @date 2014-03-12
 * @author Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @version 0.9.0.0
 */
/**
 * This class stands for Egovs_SepaDebitSax_Model_Webservice_Types_MandatListe originally named WSMandatListe
 * Documentation : Liste von Glaeubiger-Ids
 * Meta informations extracted from the WSDL
 * - from schema : ../sepatest2.mandatsverwaltungWS.wsdl
 * @package SepaMv
 * @subpackage Structs
 * @date 2014-03-12
 * @author Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @version 0.9.0.0
 */
class Egovs_SepaDebitSax_Model_Webservice_Types_MandatListe extends Egovs_SepaDebitSax_Model_Webservice_WsdlClass
{
    /**
     * The Mandat
     * Meta informations extracted from the WSDL
     * - maxOccurs : unbounded
     * - minOccurs : 1
     * @var Egovs_SepaDebitSax_Model_Webservice_Types_Mandat
     */
    public $Mandat;
    /**
     * Constructor method for WSMandatListe
     * @see parent::__construct()
     * @param Egovs_SepaDebitSax_Model_Webservice_Types_Mandat $_mandat
     * @return Egovs_SepaDebitSax_Model_Webservice_Types_MandatListe
     */
    public function __construct($_mandat)
    {
        parent::__construct(array('Mandat'=>$_mandat),false);
    }
    /**
     * Get Mandat value
     * @return Egovs_SepaDebitSax_Model_Webservice_Types_Mandat
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
