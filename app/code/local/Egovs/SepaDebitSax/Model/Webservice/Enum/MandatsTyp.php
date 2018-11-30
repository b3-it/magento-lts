<?php
/**
 * File for class Egovs_SepaDebitSax_Model_Webservice_Enum_MandatsTyp
 * @package SepaMv
 * @subpackage Enumerations
 * @date 2014-03-12
 * @author Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @version 0.9.0.0
 */
/**
 * This class stands for Egovs_SepaDebitSax_Model_Webservice_Enum_MandatsTyp originally named WSMandatsTyp
 * Documentation : CORE, B2B, COR1
 * Meta informations extracted from the WSDL
 * - from schema : ../sepatest2.mandatsverwaltungWS.wsdl
 * @package SepaMv
 * @subpackage Enumerations
 * @date 2014-03-12
 * @author Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @version 0.9.0.0
 */
class Egovs_SepaDebitSax_Model_Webservice_Enum_MandatsTyp extends Egovs_SepaDebitSax_Model_Webservice_WsdlClass
{
    /**
     * Constant for value 'CORE'
     * @return string 'CORE'
     */
    const VALUE_CORE = 'CORE';
    /**
     * Constant for value 'B2B'
     * @return string 'B2B'
     */
    const VALUE_B2B = 'B2B';
    /**
     * Constant for value 'COR1'
     * @return string 'COR1'
     *
     * @deprecated Seit SEPA 3.0 - Es gibt nur noch CORE oder B2B
     */
    const VALUE_COR1 = 'COR1';
    /**
     * Return true if value is allowed
     * @uses Egovs_SepaDebitSax_Model_Webservice_Enum_MandatsTyp::VALUE_CORE
     * @uses Egovs_SepaDebitSax_Model_Webservice_Enum_MandatsTyp::VALUE_B2B
     * @uses Egovs_SepaDebitSax_Model_Webservice_Enum_MandatsTyp::VALUE_COR1
     * @param mixed $_value value
     * @return bool true|false
     */
    public static function valueIsValid($_value)
    {
        return in_array($_value,array(Egovs_SepaDebitSax_Model_Webservice_Enum_MandatsTyp::VALUE_CORE,Egovs_SepaDebitSax_Model_Webservice_Enum_MandatsTyp::VALUE_B2B,Egovs_SepaDebitSax_Model_Webservice_Enum_MandatsTyp::VALUE_COR1));
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
