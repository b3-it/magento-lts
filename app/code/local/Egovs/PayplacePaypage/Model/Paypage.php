<?php
/**
 * Model für Kreditkarte über Payplace
 *
 * @category   	Egovs
 * @package    	Egovs_PayplacePaypage
 * @name       	Egovs_PayplacePaypage_Model_Paypage
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright  	Copyright (c) 2014 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 * 
 * 
 * @see Egovs_Paymentbase_Model_Saferpay
 */
class Egovs_PayplacePaypage_Model_Paypage extends Egovs_Paymentbase_Model_Payplace
{
	/**
	 * Unique internal payment method identifier
	 *
	 * @var string $_code
	 */
	protected $_code = 'payplacepaypage';
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
	protected $_formBlockType = 'payment/form';
	/**
	 * Infoblock Type
	 *
	 * Type als String oder 'paymentbase/noinfo' für keinen Infoblock
	 *
	 * @var string $_infoBlockType
	 */
	protected $_infoBlockType = 'paymentbase/noinfo';
	/**
	 * Unterscheidet zwischen Giropay und Kreditkarte
	 *
	 * @var string $_saferpay_type
	 */
	protected $_type = 'KREDITKARTE';
	
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
		if ($this->usePreAuthorization()) {
			$_formServiceRequest->setAction(Egovs_Paymentbase_Model_Payplace_Enum_Action::VALUE_PREAUTHORIZATION);
		} else {
			$_formServiceRequest->setAction(Egovs_Paymentbase_Model_Payplace_Enum_Action::VALUE_AUTHORIZATION);
		}
		$_formServiceRequest->setAdditionalNote(substr($desc, 0, 25));
		$_formServiceRequest->setKind(Egovs_Paymentbase_Model_Payplace_Enum_KindEnum::VALUE_CREDITCARD);
		//$_formServiceRequest->giropayData = null;
	}
	
	public function aktiviereKassenzeichen($wId, $refId, $providerId) {
		return $this->_getSoapClient()->aktiviereTempKreditkartenKassenzeichen($wId, null, $refId, $providerId);
	}
	
	/**
	 * Wird Pre-Autorisierung verwendet
	 * 
	 * @return bool
	 */
	public function usePreAuthorization() {
		return Mage::getStoreConfigFlag('payment/payplacepaypage/use_preauthorization');
	}
}
