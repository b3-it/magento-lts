<?php
/**
 * File for class Egovs_SepaDebitSax_Model_Webservice_Enum_PruefStatus
 * @package SepaMv
 * @subpackage Enumerations
 * @date 2014-03-12
 * @author Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @version 0.9.0.0
 */
/**
 * This class stands for Egovs_SepaDebitSax_Model_Webservice_Enum_PruefStatus originally named WSPruefStatus
 * Documentation : GEPRUEFT, UNGEPRUEFT
 * Meta informations extracted from the WSDL
 * - from schema : ../sepatest2.mandatsverwaltungWS.wsdl
 * @package SepaMv
 * @subpackage Enumerations
 * @date 2014-03-12
 * @author Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @version 0.9.0.0
 */
class Egovs_SepaDebitSax_Model_Webservice_Enum_PruefStatus extends Egovs_SepaDebitSax_Model_Webservice_WsdlClass
{
    /**
     * Constant for value 'GEPRUEFT'
     * @return string 'GEPRUEFT'
     */
    const VALUE_GEPRUEFT = 'GEPRUEFT';
    /**
     * Constant for value 'UNGEPRUEFT'
     * @return string 'UNGEPRUEFT'
     */
    const VALUE_UNGEPRUEFT = 'UNGEPRUEFT';
    /**
     * Return true if value is allowed
     * @uses Egovs_SepaDebitSax_Model_Webservice_Enum_PruefStatus::VALUE_GEPRUEFT
     * @uses Egovs_SepaDebitSax_Model_Webservice_Enum_PruefStatus::VALUE_UNGEPRUEFT
     * @param mixed $_value value
     * @return bool true|false
     */
    public static function valueIsValid($_value)
    {
        return in_array($_value,array(Egovs_SepaDebitSax_Model_Webservice_Enum_PruefStatus::VALUE_GEPRUEFT,Egovs_SepaDebitSax_Model_Webservice_Enum_PruefStatus::VALUE_UNGEPRUEFT));
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
