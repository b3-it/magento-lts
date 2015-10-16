<?php
/**
 * File for class Egovs_SepaDebitSax_Model_Webservice_Enum_ResultState
 * @package SepaMv
 * @subpackage Enumerations
 * @date 2014-03-12
 * @author Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @version 0.9.0.0
 */
/**
 * This class stands for Egovs_SepaDebitSax_Model_Webservice_Enum_ResultState originally named WSResultState
 * Documentation : Erfolge / Fehler
 * Meta informations extracted from the WSDL
 * - from schema : ../sepatest2.mandatsverwaltungWS.wsdl
 * @package SepaMv
 * @subpackage Enumerations
 * @date 2014-03-12
 * @author Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @version 0.9.0.0
 */
class Egovs_SepaDebitSax_Model_Webservice_Enum_ResultState extends Egovs_SepaDebitSax_Model_Webservice_WsdlClass
{
    /**
     * Constant for value 0
     * @return integer 0
     */
    const VALUE_0 = 0;
    /**
     * Constant for value 1
     * @return integer 1
     */
    const VALUE_1 = 1;
    /**
     * Return true if value is allowed
     * @uses Egovs_SepaDebitSax_Model_Webservice_Enum_ResultState::VALUE_0
     * @uses Egovs_SepaDebitSax_Model_Webservice_Enum_ResultState::VALUE_1
     * @param mixed $_value value
     * @return bool true|false
     */
    public static function valueIsValid($_value)
    {
        return in_array($_value,array(Egovs_SepaDebitSax_Model_Webservice_Enum_ResultState::VALUE_0,Egovs_SepaDebitSax_Model_Webservice_Enum_ResultState::VALUE_1));
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
