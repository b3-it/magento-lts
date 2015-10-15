<?php
/**
 * File for class Egovs_SepaDebitSax_Model_Webservice_Enum_MandatStatus
 * @package SepaMv
 * @subpackage Enumerations
 * @date 2014-03-12
 * @author Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @version 0.9.0.0
 */
/**
 * This class stands for Egovs_SepaDebitSax_Model_Webservice_Enum_MandatStatus originally named WSMandatStatus
 * Documentation : AKTIV, AUFFREIGABEWARTEND, AUFUNTERSCHRIFTWARTEND, GEKUENDIGT, GESCHLOSSEN, GESPERRT, FREIGABEVERWEIGERT, AUFMANDATSREFERENZWARTEND
 * Meta informations extracted from the WSDL
 * - from schema : ../sepatest2.mandatsverwaltungWS.wsdl
 * @package SepaMv
 * @subpackage Enumerations
 * @date 2014-03-12
 * @author Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @version 0.9.0.0
 */
class Egovs_SepaDebitSax_Model_Webservice_Enum_MandatStatus extends Egovs_SepaDebitSax_Model_Webservice_WsdlClass
{
    /**
     * Constant for value 'AKTIV'
     * @return string 'AKTIV'
     */
    const VALUE_AKTIV = 'AKTIV';
    /**
     * Constant for value 'AUFFREIGABEWARTEND'
     * @return string 'AUFFREIGABEWARTEND'
     */
    const VALUE_AUFFREIGABEWARTEND = 'AUFFREIGABEWARTEND';
    /**
     * Constant for value 'AUFUNTERSCHRIFTWARTEND'
     * @return string 'AUFUNTERSCHRIFTWARTEND'
     */
    const VALUE_AUFUNTERSCHRIFTWARTEND = 'AUFUNTERSCHRIFTWARTEND';
    /**
     * Constant for value 'GEKUENDIGT'
     * @return string 'GEKUENDIGT'
     */
    const VALUE_GEKUENDIGT = 'GEKUENDIGT';
    /**
     * Constant for value 'GESCHLOSSEN'
     * @return string 'GESCHLOSSEN'
     */
    const VALUE_GESCHLOSSEN = 'GESCHLOSSEN';
    /**
     * Constant for value 'GESPERRT'
     * @return string 'GESPERRT'
     */
    const VALUE_GESPERRT = 'GESPERRT';
    /**
     * Constant for value 'FREIGABEVERWEIGERT'
     * @return string 'FREIGABEVERWEIGERT'
     */
    const VALUE_FREIGABEVERWEIGERT = 'FREIGABEVERWEIGERT';
    /**
     * Constant for value 'AUFMANDATSREFERENZWARTEND'
     * @return string 'AUFMANDATSREFERENZWARTEND'
     */
    const VALUE_AUFMANDATSREFERENZWARTEND = 'AUFMANDATSREFERENZWARTEND';
    /**
     * Return true if value is allowed
     * @uses Egovs_SepaDebitSax_Model_Webservice_Enum_MandatStatus::VALUE_AKTIV
     * @uses Egovs_SepaDebitSax_Model_Webservice_Enum_MandatStatus::VALUE_AUFFREIGABEWARTEND
     * @uses Egovs_SepaDebitSax_Model_Webservice_Enum_MandatStatus::VALUE_AUFUNTERSCHRIFTWARTEND
     * @uses Egovs_SepaDebitSax_Model_Webservice_Enum_MandatStatus::VALUE_GEKUENDIGT
     * @uses Egovs_SepaDebitSax_Model_Webservice_Enum_MandatStatus::VALUE_GESCHLOSSEN
     * @uses Egovs_SepaDebitSax_Model_Webservice_Enum_MandatStatus::VALUE_GESPERRT
     * @uses Egovs_SepaDebitSax_Model_Webservice_Enum_MandatStatus::VALUE_FREIGABEVERWEIGERT
     * @uses Egovs_SepaDebitSax_Model_Webservice_Enum_MandatStatus::VALUE_AUFMANDATSREFERENZWARTEND
     * @param mixed $_value value
     * @return bool true|false
     */
    public static function valueIsValid($_value)
    {
        return in_array($_value,array(Egovs_SepaDebitSax_Model_Webservice_Enum_MandatStatus::VALUE_AKTIV,Egovs_SepaDebitSax_Model_Webservice_Enum_MandatStatus::VALUE_AUFFREIGABEWARTEND,Egovs_SepaDebitSax_Model_Webservice_Enum_MandatStatus::VALUE_AUFUNTERSCHRIFTWARTEND,Egovs_SepaDebitSax_Model_Webservice_Enum_MandatStatus::VALUE_GEKUENDIGT,Egovs_SepaDebitSax_Model_Webservice_Enum_MandatStatus::VALUE_GESCHLOSSEN,Egovs_SepaDebitSax_Model_Webservice_Enum_MandatStatus::VALUE_GESPERRT,Egovs_SepaDebitSax_Model_Webservice_Enum_MandatStatus::VALUE_FREIGABEVERWEIGERT,Egovs_SepaDebitSax_Model_Webservice_Enum_MandatStatus::VALUE_AUFMANDATSREFERENZWARTEND));
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
