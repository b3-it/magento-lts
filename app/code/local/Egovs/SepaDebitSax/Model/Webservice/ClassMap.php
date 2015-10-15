<?php
/**
 * File for the class which returns the class map definition
 * @package SepaMv
 * @date 2014-03-12
 * @author Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @version 0.9.0.0
 */
/**
 * Class which returns the class map definition by the static method SepaMvClassMap::classMap()
 * @package SepaMv
 * @date 2014-03-12
 * @author Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @version 0.9.0.0
 */
class Egovs_SepaDebitSax_Model_Webservice_ClassMap
{
    /**
     * This method returns the array containing the mapping between WSDL structs and generated classes
     * This array is sent to the SoapClient when calling the WS
     * @return array
     */
    final public static function classMap()
    {
        return array (
		  'AendernSEPAKreditorenMandatMitAmendmentMitPDFResult' => 'Egovs_SepaDebitSax_Model_Webservice_Types_Result_AendernSEPAKreditorenMandatMitAmendmentMitPDFResult',
		  'AendernSEPAMandatResult' => 'Egovs_SepaDebitSax_Model_Webservice_Types_Result_AendernSEPAMandatResult',
		  'AmendmentSEPAMandatResult' => 'Egovs_SepaDebitSax_Model_Webservice_Types_Result_AmendmentSEPAMandatResult',
		  'AnlegenSEPADebitorenMandatResult' => 'Egovs_SepaDebitSax_Model_Webservice_Types_Result_AnlegenSEPADebitorenMandatResult',
		  'AnlegenSEPAKreditorenMandatMitPDFResult' => 'Egovs_SepaDebitSax_Model_Webservice_Types_Result_AnlegenSEPAKreditorenMandatMitPDFResult',
		  'AnlegenSEPAKreditorenMandatResult' => 'Egovs_SepaDebitSax_Model_Webservice_Types_Result_AnlegenSEPAKreditorenMandatResult',
		  'AnlegenSEPAPreNotificationMitPDFResult' => 'Egovs_SepaDebitSax_Model_Webservice_Types_Result_AnlegenSEPAPreNotificationMitPDFResult',
		  'IsAliveResult' => 'Egovs_SepaDebitSax_Model_Webservice_Types_Result_IsAliveResult',
		  'LesenSEPAMandatMitPDFResult' => 'Egovs_SepaDebitSax_Model_Webservice_Types_Result_LesenSEPAMandatMitPDFResult',
		  'LesenSEPAMandatResult' => 'Egovs_SepaDebitSax_Model_Webservice_Types_Result_LesenSEPAMandatResult',
		  'SetzeFaelligkeitSEPAKreditorenMandatResult' => 'Egovs_SepaDebitSax_Model_Webservice_Types_Result_SetzeFaelligkeitSEPAKreditorenMandatResult',
		  'SetzeLetzteNutzungSEPADebitorenMandatResult' => 'Egovs_SepaDebitSax_Model_Webservice_Types_Result_SetzeLetzteNutzungSEPADebitorenMandatResult',
		  'SucheSEPAMandatBeendenResult' => 'Egovs_SepaDebitSax_Model_Webservice_Types_Result_SucheSEPAMandatBeendenResult',
		  'SucheSEPAMandatNextResult' => 'Egovs_SepaDebitSax_Model_Webservice_Types_Result_SucheSEPAMandatNextResult',
		  'SucheSEPAMandatResult' => 'Egovs_SepaDebitSax_Model_Webservice_Types_Result_SucheSEPAMandatResult',
		  'WSAdresse' => 'Egovs_SepaDebitSax_Model_Webservice_Types_Adresse',
		  'WSBankverbindung' => 'Egovs_SepaDebitSax_Model_Webservice_Types_Bankverbindung',
		  'WSGeschaeftsbereichsId' => 'Egovs_SepaDebitSax_Model_Webservice_Types_GeschaeftsbereichsId',
		  'WSIdentifierzierung' => 'Egovs_SepaDebitSax_Model_Webservice_Types_Identifierzierung',
		  'WSMandat' => 'Egovs_SepaDebitSax_Model_Webservice_Types_Mandat',
		  'WSMandatKategorie' => 'Egovs_SepaDebitSax_Model_Webservice_Enum_MandatKategorie',
		  'WSMandatListe' => 'Egovs_SepaDebitSax_Model_Webservice_Types_MandatListe',
		  'WSMandatStatus' => 'Egovs_SepaDebitSax_Model_Webservice_Enum_MandatStatus',
		  'WSMandatSuchanfrage' => 'Egovs_SepaDebitSax_Model_Webservice_Types_MandatSuchanfrage',
		  'WSMandatsTyp' => 'Egovs_SepaDebitSax_Model_Webservice_Enum_MandatsTyp',
		  'WSMandatsdaten' => 'Egovs_SepaDebitSax_Model_Webservice_Types_Mandatsdaten',
		  'WSPruefStatus' => 'Egovs_SepaDebitSax_Model_Webservice_Enum_PruefStatus',
		  'WSResult' => 'Egovs_SepaDebitSax_Model_Webservice_Types_Result',
		  'WSResultCode' => 'Egovs_SepaDebitSax_Model_Webservice_Types_ResultCode',
		  'WSResultState' => 'Egovs_SepaDebitSax_Model_Webservice_Enum_ResultState',
		  'WSSequenzTyp' => 'Egovs_SepaDebitSax_Model_Webservice_Enum_SequenzTyp',
		);
    }
}
