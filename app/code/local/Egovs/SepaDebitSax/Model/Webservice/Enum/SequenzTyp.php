<?php
/**
 * File for class Egovs_SepaDebitSax_Model_Webservice_Enum_SequenzTyp
 * @package SepaMv
 * @subpackage Enumerations
 * @date 2014-03-12
 * @author Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @version 0.9.0.0
 */
/**
 * This class stands for Egovs_SepaDebitSax_Model_Webservice_Enum_SequenzTyp originally named WSSequenzTyp
 * Documentation : FRST, RCUR, OOFF, FNAL
 * Meta informations extracted from the WSDL
 * - from schema : ../sepatest2.mandatsverwaltungWS.wsdl
 * @package SepaMv
 * @subpackage Enumerations
 * @date 2014-03-12
 * @author Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @version 0.9.0.0
 */
class Egovs_SepaDebitSax_Model_Webservice_Enum_SequenzTyp extends Egovs_SepaDebitSax_Model_Webservice_WsdlClass
{
    /**
     * Constant for value 'FRST' First = erstes Mandat
     * @return string 'FRST'
     *
     * @deprecated Seit SEPA 3.0 - Es soll immer 'RCUR' benutzt werden!
     */
    const VALUE_FRST = 'FRST';
    /**
     * Constant for value 'RCUR' Wiederholungsmandat
     * @return string 'RCUR'
     */
    const VALUE_RCUR = 'RCUR';
    /**
     * Constant for value 'OOFF' oneOff = Einmalmandat 
     * @return string 'OOFF'
     */
    const VALUE_OOFF = 'OOFF';
    /**
     * Constant for value 'FNAL'
     * @return string 'FNAL'
     */
    const VALUE_FNAL = 'FNAL';
    /**
     * Return true if value is allowed
     * @uses Egovs_SepaDebitSax_Model_Webservice_Enum_SequenzTyp::VALUE_FRST
     * @uses Egovs_SepaDebitSax_Model_Webservice_Enum_SequenzTyp::VALUE_RCUR
     * @uses Egovs_SepaDebitSax_Model_Webservice_Enum_SequenzTyp::VALUE_OOFF
     * @uses Egovs_SepaDebitSax_Model_Webservice_Enum_SequenzTyp::VALUE_FNAL
     * @param mixed $_value value
     * @return bool true|false
     */
    public static function valueIsValid($_value)
    {
        return in_array($_value,array(Egovs_SepaDebitSax_Model_Webservice_Enum_SequenzTyp::VALUE_FRST,Egovs_SepaDebitSax_Model_Webservice_Enum_SequenzTyp::VALUE_RCUR,Egovs_SepaDebitSax_Model_Webservice_Enum_SequenzTyp::VALUE_OOFF,Egovs_SepaDebitSax_Model_Webservice_Enum_SequenzTyp::VALUE_FNAL));
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
