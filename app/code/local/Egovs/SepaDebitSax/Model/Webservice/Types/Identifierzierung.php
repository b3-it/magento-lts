<?php
/**
 * File for class Egovs_SepaDebitSax_Model_Webservice_Types_Identifierzierung
 * @package SepaMv
 * @subpackage Structs
 * @date 2014-03-12
 * @author Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @version 0.9.0.0
 */
/**
 * This class stands for Egovs_SepaDebitSax_Model_Webservice_Types_Identifierzierung originally named WSIdentifierzierung
 * Documentation : Identifizierungsobjekt fuer den Webservicezugriff
 * Meta informations extracted from the WSDL
 * - from schema : ../sepatest2.mandatsverwaltungWS.wsdl
 * @package SepaMv
 * @subpackage Structs
 * @date 2014-03-12
 * @author Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @version 0.9.0.0
 */
class Egovs_SepaDebitSax_Model_Webservice_Types_Identifierzierung extends Egovs_SepaDebitSax_Model_Webservice_WsdlClass
{
    /**
     * The Konzernname
     * Meta informations extracted from the WSDL
     * - maxOccurs : 1
     * - minOccurs : 1
     * - nillable : false
     * @var string
     */
    public $Konzernname;
    /**
     * The GeschaeftsbereichsId
     * Meta informations extracted from the WSDL
     * - maxOccurs : unbounded
     * - minOccurs : 1
     * - nillable : false
     * @var Egovs_SepaDebitSax_Model_Webservice_Types_GeschaeftsbereichsId
     */
    public $GeschaeftsbereichsId;
    /**
     * Constructor method for WSIdentifierzierung
     * @see parent::__construct()
     * @param string $_konzernname
     * @param Egovs_SepaDebitSax_Model_Webservice_Types_GeschaeftsbereichsId $_geschaeftsbereichsId
     * @return Egovs_SepaDebitSax_Model_Webservice_Types_Identifierzierung
     */
    public function __construct($_konzernname,$_geschaeftsbereichsId)
    {
        parent::__construct(array('Konzernname'=>$_konzernname,'GeschaeftsbereichsId'=>$_geschaeftsbereichsId),false);
    }
    /**
     * Get Konzernname value
     * @return string
     */
    public function getKonzernname()
    {
        return $this->Konzernname;
    }
    /**
     * Set Konzernname value
     * @param string $_konzernname the Konzernname
     * @return string
     */
    public function setKonzernname($_konzernname)
    {
        return ($this->Konzernname = $_konzernname);
    }
    /**
     * Get GeschaeftsbereichsId value
     * @return Egovs_SepaDebitSax_Model_Webservice_Types_GeschaeftsbereichsId
     */
    public function getGeschaeftsbereichsId()
    {
        return $this->GeschaeftsbereichsId;
    }
    /**
     * Set GeschaeftsbereichsId value
     * @param Egovs_SepaDebitSax_Model_Webservice_Types_GeschaeftsbereichsId $_geschaeftsbereichsId the GeschaeftsbereichsId
     * @return Egovs_SepaDebitSax_Model_Webservice_Types_GeschaeftsbereichsId
     */
    public function setGeschaeftsbereichsId($_geschaeftsbereichsId)
    {
        return ($this->GeschaeftsbereichsId = $_geschaeftsbereichsId);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see Egovs_SepaDebitSax_Model_Webservice_WsdlClass::__set_state()
     * @uses Egovs_SepaDebitSax_Model_Webservice_WsdlClass::__set_state()
     * @param array $_array the exported values
     * @return Egovs_SepaDebitSax_Model_Webservice_Types_Identifierzierung
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
