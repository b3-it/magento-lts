<?php
/**
 * Model für Giropay über Girosolution
 *
 * @category   	Egovs
 * @package    	Egovs_Girosolution
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 * 
 * @see Egovs_Paymentbase_Model_Girosolution
 */
class Egovs_Girosolution_Model_Payment_Giropay extends Egovs_Paymentbase_Model_Girosolution
{
	/**
	 * Unique internal payment method identifier
	 *
	 * @var string $_code
	 */
	protected $_code = 'egovs_girosolution_giropay';
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
	protected $_canCapturePartial = true;
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
	protected $_formBlockType = 'egovs_girosolution/form_giropay';
	/**
	 * Unterscheidet zwischen Giropay und Kreditkarte für die ePayBL
	 *
	 * @var string $_epaybl_transaction_type
	 */
	protected $_epaybl_transaction_type = 'GIROPAY';
	
	/**
	 * Unterscheidet zwischen Giropay und Kreditkarte für Girosolution
	 *
	 * @var string $_transaction_type
	 */
	protected $_transaction_type = 'giropayTransaction';
	/**
	 * Initialisiert das Array mit den zu übergebenden Parametern
	 *
	 * @return void
	 *
	 * @see Egovs_Paymentbase_Model_Girosolution::_getGirosolutionRedirectUrl()
	 */
	protected function _getGirosolutionRedirectUrl() {
		$this->_fieldsArr['bic'] = $this->getBic();
	}
	
	protected function _callSoapClientImpl($objSOAPClient, $wId, $mandantNr, $refId, $providerName) {
        /** @noinspection SuspiciousAssignmentsInspection */
        $providerName = "GIROPAY";
		if (Mage::helper('paymentbase')->getEpayblVersionInUse() == Egovs_Paymentbase_Helper_Data::EPAYBL_3_X_VERSION) {
			return $objSOAPClient->aktiviereTempKassenzeichen($wId, $refId, $providerName);
		}
		return $objSOAPClient->aktiviereTempGiropayKassenzeichen($wId, $mandantNr, $refId, $providerName);
	}
	
	public function getTransactionType() {
		return $this->_transaction_type;
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
	
	public function validate() {
		parent::validate();
	
		$mn = $this->getMerchantName();
		$payment = $this->getInfoInstance();
		$requestPayment = Mage::app()->getFrontController()->getRequest()->getParam('payment', false);
	
		if (isset($requestPayment['cc_type']) && $payment->getQuote()) {
			$this->_validateBankdata();
		}
		
		return $this;
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
	
	protected function _validateBankdata() {
		$this->_preprocessBic();
		if (!preg_match('/^[a-z]{6}[0-9a-z]{2}([0-9a-z]{3})?\z/i', $this->getBic())) {
			throw new Egovs_Paymentbase_Exception_Validation($this->__('TEXT_PROCESS_ERROR_BIC_INVALID-0440'));
		}
		
		try {
			//Check if the bank provides giropay from BIC.
			$request = new GiroCheckout_SDK_Request('giropayBankstatus');
			$request->setSecret($this->getProjectPassword());
			$request->addParam('merchantId', $this->getMerchantId())
				->addParam('projectId', $this->getProjectId())
				->addParam('bic', $this->getBic())
				->submit();
		
			if (!$request->requestHasSucceeded()) {
				$iReturnCode = $request->getResponseParam('rc');
				$msg = $request->getResponseMessage($iReturnCode, Mage::helper('egovs_girosolution')->getLanguageCode());
				throw new Egovs_Paymentbase_Exception_Validation($msg);
			}
		
		} catch (Egovs_Paymentbase_Exception_Validation $e) {
            Mage::logException($e);
            throw new Egovs_Paymentbase_Exception_Validation($this->__($e->getMessage(), $this->_getHelper()->getCustomerSupportMail()));
        } catch (Exception $e) {
			Mage::logException($e);
			throw new Egovs_Paymentbase_Exception_Validation($this->__('TEXT_PROCESS_ERROR_STANDARD', $this->_getHelper()->getCustomerSupportMail()));
		}
		
	}
}
