<?php
/**
 * Model für Giropay über Payplace
 *
 * @category   	Egovs
 * @package    	Egovs_PayplaceGiropay
 * @name       	Egovs_PayplaceGiropay_Model_Giropay
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright  	Copyright (c) 2014 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 * 
 * 
 * @see Egovs_Paymentbase_Model_Saferpay
 */
class Egovs_PayplaceGiropay_Model_Giropay extends Egovs_Paymentbase_Model_Payplace
{
	/**
	 * Unique internal payment method identifier
	 *
	 * @var string $_code
	 */
	protected $_code = 'payplacegiropay';
	/**
	 * Flag: Ist dieses Model ein Gateway
	 *
	 * @var boolean $_isGateway
	 */
	protected $_isGateway = true;
	/**
	 * Flag: Ob der Aufruf der authorize Methode erlaubt ist
	 *
	 * Authorize wird in der Regel bei der Bestellerstellung aufgerufen.
	 *
	 * @var boolean $_canAuthorize
	 */
	protected $_canAuthorize = true;
	/**
	 * Flag: Ob der Aufruf der capture Methode erlaubt ist
	 *
	 * Capture wird in der Regel bei der Rechnungserstellung aufgerufen.
	 *
	 * @var boolean $_canCapture
	 */
	protected $_canCapture = true;
	/**
	 * Flag: Ob die Erstellung von Teilrechnungen erlaubt ist
	 *
	 * @var boolean $_canCapturePartial
	 */
	protected $_canCapturePartial = false;
	/**
	 * Kann dieses Payment-Methode im administrations Bereich genutzt werden?
	 *
	 * @var boolean $_canUseInternal
	 */
	protected $_canUseInternal = false;
	/**
	 * Formblock Type
	 *
	 * @var string $_formBlockType
	 */
	protected $_formBlockType = 'payplacegiropay/form';
	/**
	 * Unterscheidet zwischen Giropay und Kreditkarte
	 *
	 * @var string $_type
	 */
	protected $_type = 'GIROPAY';
	
	/**
	 * Initialisiert das xmlApiRequest mit den zu übergebenden Parametern
	 * 
	 * @return void
	 * 
	 * @see Egovs_Paymentbase_Model_Payplace::initPayplacePayment
	 */
	protected function _initPayplacePayment() {
		if (strlen(Mage::getStoreConfig("payment/{$this->getCode()}/additional_note")) <= 0) {
			//Wenn Payernote nicht gefüllt ist
			if (strlen(Mage::getStoreConfig("payment/{$this->getCode()}/description")) <= 0) {
				//Wenn Description nicht gefüllt
				if (strlen(Mage::getStoreConfig("payment/{$this->getCode()}/title")) <= 0) {
					$desc = "Zahlung per Payplace";
				} else {
					$desc = Mage::getStoreConfig("payment/{$this->getCode()}/title");
				}
			} else {
				$desc = Mage::getStoreConfig("payment/{$this->getCode()}/description");
			}
		} else {
			$desc = Mage::getStoreConfig("payment/{$this->getCode()}/additional_note");
		}
		$_formServiceRequest = $this->_xmlApiRequest->getFormServiceRequest();
		//Taucht nirgends auf
		//$_formServiceRequest->setAdditionalData($desc);
		$_formServiceRequest->setAction(Egovs_Paymentbase_Model_Payplace_Enum_Action::VALUE_PAYMENT);
		$_bankAccount = new Egovs_Paymentbase_Model_Payplace_Types_BankAccount();
		$_formServiceRequest->setBankAccount($_bankAccount);
		$_bic = $this->getBic();
		$_bankAccount->setBic($_bic);
		
		$_giropayData = new Egovs_Paymentbase_Model_Payplace_Types_Giropay_Data();
		$_formServiceRequest->setGiropayData($_giropayData);
		$_merchantSubId = Mage::helper('core')->decrypt(Mage::getStoreConfig("payment/{$this->getCode()}/merchant_sub_id"));
		$_giropayData->setMerchantSubId($_merchantSubId);
		
		$_formServiceRequest->setKind(Egovs_Paymentbase_Model_Payplace_Enum_KindEnum::VALUE_GIROPAY);
	}
	
	/**
	 * Liefert eine eShopTan
	 *
	 * Die TAN besteht bei giropay nur aus der OrderId.
	 *
	 * @return string
	 */
	protected function _geteShopTan() {
		if (empty($this->_eShopTan)) {
			$orderId = (int)$this->_getOrder()->getId();
			
			$this->_eShopTan = $orderId;
		}
		return $this->_eShopTan;
	}
	
	public function aktiviereKassenzeichen($wId, $refId, $providerId) {
		if (Mage::helper('paymentbase')->getEpayblVersionInUse() == Egovs_Paymentbase_Helper_Data::EPAYBL_3_X_VERSION) {
			return $this->_getSoapClient()->aktiviereTempKassenzeichen($wId, $refId, 'GIROPAY');
		}
		return $this->_getSoapClient()->aktiviereTempGiropayKassenzeichen($wId, null, $refId);
	}
	
	/**
	 * Liefert die IBAN des angegebenen Bankkontos
	 *
	 * Die IBAN ist im 'cc_number' Feld gespeichert
	 *
	 * @return string IBAN
	 */
	public function getIban() {
		$info = $this->getInfoInstance();
		$return = $info->getCcNumber();
	
		return (string) $return;
	}
	
	/**
	 * Liefert die BIC des angegebenen Bankkontos
	 *
	 * Die BIC ist im 'cc_type' Feld gespeichert.
	 *
	 * @return string BLZ des Kunden
	 */
	public function getBic() {
		$info = $this->getInfoInstance();
		$return = $info->getCcType();
	
		return (string) $return;
	}
	
	/**
	 * Preprocessing für BIC-Eingaben
	 *
	 * Die BIC wird optional mit X für die letzten 3 Stellen befüllt und in Großbuchstbaben gewandelt.
	 *
	 * @return Egovs_Paymentbase_Model_SepaDebit
	 */
	protected function _preprocessBic() {
		$payment = $this->getInfoInstance();
		$bic = $this->getBic();
	
		$bic = strtoupper($bic);
		if (strlen($bic) >=8 && strlen($bic) < 11) {
			$bic .= "XXX";
			$bic = substr($bic, 0, 11);
		}
	
		if ($bic != $this->getBic()) {
			$payment->setCcType($bic);
		}
	
		return $this;
	}
	
	public function validate() {
		parent::validate();
	
		$mn = $this->getMerchantName();
		$payment = $this->getInfoInstance();
		$requestPayment = Mage::app()->getFrontController()->getRequest()->getParam('payment', false);
		
		if (isset($requestPayment['cc_type']) && $payment->getQuote()) {
			$this->_validateBankdata();
		}
	}
	
	protected function _validateBankdata() {
		$this->_preprocessBic();
		if (!preg_match('/^[a-z]{6}[0-9a-z]{2}([0-9a-z]{3})?\z/i', $this->getBic())) {
			throw new Egovs_Paymentbase_Exception_Validation($this->__('TEXT_PROCESS_ERROR_BIC_INVALID-0440'));
		}
		
		$_xmlApiRequest = new Egovs_Paymentbase_Model_Payplace_Types_Xml_Api_Request();
		$_xmlApiRequest->setVersion(self::PAYPLACE_INTERFACE_VERSION);
		$_id = $this->getBic().Mage::helper('paymentbase')->getSalt();
		$_xmlApiRequest->setId("id".hash('sha256', $_id));
		$_giropayBankCheckRequest = new Egovs_Paymentbase_Model_Payplace_Types_Giropay_BankCheck_Request(); 
		$_xmlApiRequest->setGiropayBankCheckRequest($_giropayBankCheckRequest);
		$_giropayBankCheckRequest->setMerchantId($this->getMerchantId());
		$_giropayBankCheckRequest->setId("id".hash('sha256', $_id."_1"));
		$_giropayBankCheckRequest->setBic($this->getBic());
		
		/* @var $payplaceSoapApi Egovs_Paymentbase_Model_Payplace_Soap_Service */
		$payplaceSoapApi = Mage::getModel('paymentbase/payplace_soap_service');
		if ($payplaceSoapApi->process($_xmlApiRequest) === false) {
			//TODO Fehlerbehebung
			$error = $payplaceSoapApi->getLastError();
			if (isset($error[0])) {
				Mage::logException($error[0]);
			}
			$_lastRequest = $payplaceSoapApi->getLastRequest();
			Mage::log(sprintf("%s::XML Request:\n%s", $this->getCode(), $_lastRequest), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
			Mage::throwException('Error');
		}
		$_xmlApiResponse = $payplaceSoapApi->getResult();
		
		if ($_xmlApiResponse->getRef() != 'id'.hash("sha256", $_id)) {
			//TODO Fehlerbehebung
			Mage::throwException('Error');
		}
		$_giropayBankCheckResponse = $_xmlApiResponse->getGiropayBankCheckResponse();
		if (!$_giropayBankCheckResponse) {
			//TODO Fehlerbehebung
			$_paymentResponse = $_xmlApiResponse->getPaymentResponse();
			if (!$_paymentResponse) {
				Mage::throwException($this->__('TEXT_PROCESS_ERROR_STANDARD'));
			}
			if (is_array($_paymentResponse) && isset($_paymentResponse[0])) {
				$_paymentResponse = $_paymentResponse[0];
			}
			if (!($_paymentResponse instanceof Egovs_Paymentbase_Model_Payplace_Types_Payment_Response)) {
				Mage::throwException($this->__('TEXT_PROCESS_ERROR_STANDARD'));
			}
				
			$msg = sprintf("{$this->getCode()}::REFID:%s\nrc:%s message:%s", $_xmlApiResponse->getRef(), $_paymentResponse->getRc(), $_paymentResponse->getMessage());
			Mage::log($msg, Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
			Mage::throwException($this->__('TEXT_PROCESS_ERROR_STANDARD'));
		}
		if (is_array($_giropayBankCheckResponse) && isset($_giropayBankCheckResponse[0])) {
			$_giropayBankCheckResponse = $_giropayBankCheckResponse[0];
		}
		if (!($_giropayBankCheckResponse instanceof Egovs_Paymentbase_Model_Payplace_Types_Giropay_BankCheck_Response)) {
			Mage::throwException($this->__('TEXT_PROCESS_ERROR_STANDARD'));
		}
		if ($_giropayBankCheckResponse->getRef() != "id".hash("sha256", $_id."_1")) {
			Mage::throwException($this->__('TEXT_PROCESS_ERROR_STANDARD'));
		}
		
		switch (intval($_giropayBankCheckResponse->getRc())) {
			case 0:
				//Alles in Ordnung;
				break;
			case 1375:
				Mage::throwException($this->__('TEXT_PROCESS_ERROR_INVALID_BIC'));
			case 1376:
				Mage::throwException($this->__('TEXT_PROCESS_ERROR_MISSING_BIC'));
			default:
				Mage::log(
					sprintf("payplacegiropay::Invalid bank data with RC code: %s", $_giropayBankCheckResponse->getRc()),
					Zend_Log::ERR,
					Egovs_Helper::LOG_FILE
				);
				Mage::throwException($this->__('TEXT_PROCESS_ERROR_STANDARD', $this->_getHelper()->getCustomerSupportMail()));
		}
		$_service = $_giropayBankCheckResponse->getService();
		if (is_array($_service)) {
			$_service = array_search(Egovs_Paymentbase_Model_Payplace_Enum_Giropay_ServiceEnum::VALUE_PAYMENT, $_service);
		}
		if ($_giropayBankCheckResponse->getBankCheckResult() != Egovs_Paymentbase_Model_Payplace_Enum_CheckResultEnum::VALUE_PASSED
			|| $_service === false) {
			Mage::throwException($this->__('TEXT_PROCESS_ERROR_NOGIROPAY'));
		}
		return $this;
	}
}
