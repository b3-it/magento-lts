<?php
/**
 * File for class Egovs_SepaDebitSax_Model_Webservice_Enum_MandatKategorie
 * @package SepaMv
 * @subpackage Enumerations
 * @date 2014-03-12
 * @author Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @version 0.9.0.0
 */
/**
 * This class stands for Egovs_SepaDebitSax_Model_Webservice_Enum_MandatKategorie originally named WSMandatKategorie
 * Documentation : Debitorenmandate; Kreditorenmandate
 * Meta informations extracted from the WSDL
 * - from schema : ../sepatest2.mandatsverwaltungWS.wsdl
 * @package SepaMv
 * @subpackage Enumerations
 * @date 2014-03-12
 * @author Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @version 0.9.0.0
 */
class Egovs_SepaDebitSax_Model_Webservice_Enum_MandatKategorie extends Egovs_SepaDebitSax_Model_Webservice_WsdlClass
{
    /**
     * Constant for value 'DEBITORENMANDAT'
     * @return string 'DEBITORENMANDAT'
     */
    const VALUE_DEBITORENMANDAT = 'DEBITORENMANDAT';
    /**
     * Constant for value 'KREDITORENMANDAT'
     * @return string 'KREDITORENMANDAT'
     */
    const VALUE_KREDITORENMANDAT = 'KREDITORENMANDAT';
    /**
     * Return true if value is allowed
     * @uses Egovs_SepaDebitSax_Model_Webservice_Enum_MandatKategorie::VALUE_DEBITORENMANDAT
     * @uses Egovs_SepaDebitSax_Model_Webservice_Enum_MandatKategorie::VALUE_KREDITORENMANDAT
     * @param mixed $_value value
     * @return bool true|false
     */
    public static function valueIsValid($_value)
    {
        return in_array($_value,array(Egovs_SepaDebitSax_Model_Webservice_Enum_MandatKategorie::VALUE_DEBITORENMANDAT,Egovs_SepaDebitSax_Model_Webservice_Enum_MandatKategorie::VALUE_KREDITORENMANDAT));
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
