<?php
/**
 * File for class Egovs_SepaDebitSax_Model_Webservice_Types_GeschaeftsbereichsId
 * @package SepaMv
 * @subpackage Structs
 * @date 2014-03-12
 * @author Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @version 0.9.0.0
 */
/**
 * This class stands for Egovs_SepaDebitSax_Model_Webservice_Types_GeschaeftsbereichsId originally named WSGeschaeftsbereichsId
 * Documentation : Identifizierungsobjekt fuer den Webservicezugriff
 * Meta informations extracted from the WSDL
 * - from schema : ../sepatest2.mandatsverwaltungWS.wsdl
 * @package SepaMv
 * @subpackage Structs
 * @date 2014-03-12
 * @author Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @version 0.9.0.0
 */
class Egovs_SepaDebitSax_Model_Webservice_Types_GeschaeftsbereichsId extends Egovs_SepaDebitSax_Model_Webservice_WsdlClass
{
    /**
     * The GlaeubigerId
     * Meta informations extracted from the WSDL
     * - maxOccurs : 1
     * - minOccurs : 1
     * - nillable : false
     * @var string
     */
    public $GlaeubigerId;
    /**
     * The Geschaeftsbereichskennung
     * Meta informations extracted from the WSDL
     * - maxOccurs : 1
     * - minOccurs : 1
     * - nillable : true
     * @var string
     */
    public $Geschaeftsbereichskennung;
    /**
     * Constructor method for WSGeschaeftsbereichsId
     * @see parent::__construct()
     * @param string $_glaeubigerId
     * @param string $_geschaeftsbereichskennung
     * @return Egovs_SepaDebitSax_Model_Webservice_Types_GeschaeftsbereichsId
     */
    public function __construct($_glaeubigerId,$_geschaeftsbereichskennung)
    {
        parent::__construct(array('GlaeubigerId'=>$_glaeubigerId,'Geschaeftsbereichskennung'=>$_geschaeftsbereichskennung),false);
    }
    /**
     * Get GlaeubigerId value
     * @return string
     */
    public function getGlaeubigerId()
    {
        return $this->GlaeubigerId;
    }
    /**
     * Set GlaeubigerId value
     * @param string $_glaeubigerId the GlaeubigerId
     * @return string
     */
    public function setGlaeubigerId($_glaeubigerId)
    {
        return ($this->GlaeubigerId = $_glaeubigerId);
    }
    /**
     * Get Geschaeftsbereichskennung value
     * @return string
     */
    public function getGeschaeftsbereichskennung()
    {
        return $this->Geschaeftsbereichskennung;
    }
    /**
     * Set Geschaeftsbereichskennung value
     * @param string $_geschaeftsbereichskennung the Geschaeftsbereichskennung
     * @return string
     */
    public function setGeschaeftsbereichskennung($_geschaeftsbereichskennung)
    {
        return ($this->Geschaeftsbereichskennung = $_geschaeftsbereichskennung);
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
