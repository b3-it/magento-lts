<?php
/**
 * File for the class which returns the class map definition
 * @package Egovs_Paymentbase
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
/**
 * Class which returns the class map definition by the static method Egovs_Paymentbase_Model_Payplace_ClassMap::classMap()
 * @package Egovs_Paymentbase
 * @date 16.10.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
class Egovs_Paymentbase_Model_Payplace_ClassMap
{
    /**
     * This method returns the array containing the mapping between WSDL structs and generated classes
     * This array is sent to the SoapClient when calling the WS
     * @return array
     */
    final public static function classMap()
    {
    	return array (
    			'action' => 'Egovs_Paymentbase_Model_Payplace_Enum_Action',
    			'actionEnum' => 'Egovs_Paymentbase_Model_Payplace_Enum_Action',
    			'additionalCheck' => 'Egovs_Paymentbase_Model_Payplace_Types_Additional_Check',
    			'additionalCheckResult' => 'Egovs_Paymentbase_Model_Payplace_Types_Additional_Check_Result',
    			'address' => 'Egovs_Paymentbase_Model_Payplace_Types_Address',
    			'addressData' => 'Egovs_Paymentbase_Model_Payplace_Types_Address_Data',
    			'addressNoteEnum' => 'Egovs_Paymentbase_Model_Payplace_Enum_Address_NoteEnum',
    			'article' => 'Egovs_Paymentbase_Model_Payplace_Types_Article',
    			'bankAccount' => 'Egovs_Paymentbase_Model_Payplace_Types_BankAccount',
    			'baseRequest' => 'Egovs_Paymentbase_Model_Payplace_Types_Base_Request',
    			'baseResponse' => 'Egovs_Paymentbase_Model_Payplace_Types_Base_Response',
    			'basket' => 'Egovs_Paymentbase_Model_Payplace_Types_Basket',
    			'batchActionEnum' => 'Egovs_Paymentbase_Model_Payplace_Enum_BatchActionEnum',
    			'batchRequest' => 'Egovs_Paymentbase_Model_Payplace_Types_Batch_Request',
    			'batchResponse' => 'Egovs_Paymentbase_Model_Payplace_Types_Batch_Response',
    			'callbackData' => 'Egovs_Paymentbase_Model_Payplace_Types_Callback_Data',
    			'callbackRequest' => 'Egovs_Paymentbase_Model_Payplace_Types_Callback_Request',
    			'callbackResponse' => 'Egovs_Paymentbase_Model_Payplace_Types_Callback_Response',
    			'checkResultEnum' => 'Egovs_Paymentbase_Model_Payplace_Enum_CheckResultEnum',
    			'compare' => 'Egovs_Paymentbase_Model_Payplace_Types_Compare',
    			'compareResult' => 'Egovs_Paymentbase_Model_Payplace_Types_Compare_Result',
    			'countryList' => 'Egovs_Paymentbase_Model_Payplace_Types_CountryList',
    			'credentials' => 'Egovs_Paymentbase_Model_Payplace_Types_Credentials',
    			'creditCard' => 'Egovs_Paymentbase_Model_Payplace_Types_CreditCard',
    			'customerContinuation' => 'Egovs_Paymentbase_Model_Payplace_Types_Customer_Continuation',
    			'customerTitleEnum' => 'Egovs_Paymentbase_Model_Payplace_Enum_Customer_TitleEnum',
    			'debitModeEnum' => 'Egovs_Paymentbase_Model_Payplace_Enum_DebitModeEnum',
    			'eScoreData' => 'Egovs_Paymentbase_Model_Payplace_Types_EScore_Data',
    			'eScoreRppMatch' => 'Egovs_Paymentbase_Model_Payplace_Enum_EScore_Rpp_Match',
    			'eScoreRppResult' => 'Egovs_Paymentbase_Model_Payplace_Types_EScore_RppResult',
    			'expiryDate' => 'Egovs_Paymentbase_Model_Payplace_Types_ExpiryDate',
    			'exportResponse' => 'Egovs_Paymentbase_Model_Payplace_Types_ExportResponse',
    			'formData' => 'Egovs_Paymentbase_Model_Payplace_Types_Form_Data',
    			'formServiceOption' => 'Egovs_Paymentbase_Model_Payplace_Types_Form_Service_Option',
    			'formServiceRequest' => 'Egovs_Paymentbase_Model_Payplace_Types_Form_Service_Request',
    			'formServiceResponse' => 'Egovs_Paymentbase_Model_Payplace_Types_Form_Service_Response',
    			'giropayBankCheckRequest' => 'Egovs_Paymentbase_Model_Payplace_Types_Giropay_BankCheck_Request',
    			'giropayBankCheckResponse' => 'Egovs_Paymentbase_Model_Payplace_Types_Giropay_BankCheck_Response',
    			'giropayData' => 'Egovs_Paymentbase_Model_Payplace_Types_Giropay_Data',
    			'giropayServiceEnum' => 'Egovs_Paymentbase_Model_Payplace_Enum_Giropay_ServiceEnum',
    			'indicatorEnum' => 'Egovs_Paymentbase_Model_Payplace_Enum_IndicatorEnum',
    			'item' => 'Egovs_Paymentbase_Model_Payplace_Types_Item',
    			'itemTypeEnum' => 'Egovs_Paymentbase_Model_Payplace_Enum_Item_TypeEnum',
    			'kindEnum' => 'Egovs_Paymentbase_Model_Payplace_Enum_KindEnum',
    			'label' => 'Egovs_Paymentbase_Model_Payplace_Types_Label',
    			'labelledText' => 'Egovs_Paymentbase_Model_Payplace_Types_LabelledText',
    			'mandate' => 'Egovs_Paymentbase_Model_Payplace_Types_Mandate',
    			'mismatchActionEnum' => 'Egovs_Paymentbase_Model_Payplace_Enum_Mismatch_ActionEnum',
    			'negativeCriterion' => 'Egovs_Paymentbase_Model_Payplace_Types_NegativeCriterion',
    			'option' => 'Egovs_Paymentbase_Model_Payplace_Types_Option',
    			'panAliasActionEnum' => 'Egovs_Paymentbase_Model_Payplace_Enum_PanAlias_ActionEnum',
    			'panAliasRequest' => 'Egovs_Paymentbase_Model_Payplace_Types_PanAlias_Request',
    			'panAliasResponse' => 'Egovs_Paymentbase_Model_Payplace_Types_PanAlias_Response',
    			'panalias' => 'Egovs_Paymentbase_Model_Payplace_Types_Panalias',
    			'paymentBaseRequest' => 'Egovs_Paymentbase_Model_Payplace_Types_Payment_Base_Request',
    			'paymentRequest' => 'Egovs_Paymentbase_Model_Payplace_Types_Payment_Request',
    			'paymentResponse' => 'Egovs_Paymentbase_Model_Payplace_Types_Payment_Response',
    			'reasonEnum' => 'Egovs_Paymentbase_Model_Payplace_Enum_ReasonEnum',
    			'registerPanRequest' => 'Egovs_Paymentbase_Model_Payplace_Types_Register_Pan_Request',
    			'relation' => 'Egovs_Paymentbase_Model_Payplace_Types_Relation',
    			'riskCheckActionEnum' => 'Egovs_Paymentbase_Model_Payplace_Enum_RiskCheck_ActionEnum',
    			'riskCheckRequest' => 'Egovs_Paymentbase_Model_Payplace_Types_RiskCheck_Request',
    			'riskCheckResponse' => 'Egovs_Paymentbase_Model_Payplace_Types_RiskCheck_Response',
    			'scoringRcEnum' => 'Egovs_Paymentbase_Model_Payplace_Enum_Scoring_RcEnum',
    			'sequenceTypeEnum' => 'Egovs_Paymentbase_Model_Payplace_Enum_SequenceTypeEnum',
    			'seriesFlagEnum' => 'Egovs_Paymentbase_Model_Payplace_Enum_SeriesFlagEnum',
    			'tdsFinalRequest' => 'Egovs_Paymentbase_Model_Payplace_Types_Tds_Final_Request',
    			'tdsInitialRequest' => 'Egovs_Paymentbase_Model_Payplace_Types_Tds_Initial_Request',
    			'tdsInitialResponse' => 'Egovs_Paymentbase_Model_Payplace_Types_Tds_Initial_Response',
    			'txDiagnosisRequest' => 'Egovs_Paymentbase_Model_Payplace_Types_Tx_Diagnosis_Request',
    			'txDiagnosisResponse' => 'Egovs_Paymentbase_Model_Payplace_Types_Tx_Diagnosis_Response',
    			'xmlApiRequest' => 'Egovs_Paymentbase_Model_Payplace_Types_Xml_Api_Request',
    			'xmlApiResponse' => 'Egovs_Paymentbase_Model_Payplace_Types_Xml_Api_Response',
    	);
    }
}
