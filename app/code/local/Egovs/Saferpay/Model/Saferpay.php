<?php
/**
 * Model für Kreditkarte über Saferpay
 *
 * @category   	Egovs
 * @package    	Egovs_Saferpay
 * @name       	Egovs_Saferpay_Model_Saferpay
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @author 		René Sieberg <rsieberg@web.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 * 
 * 
 * @see Egovs_Paymentbase_Model_Saferpay
 */
class Egovs_Saferpay_Model_Saferpay extends Egovs_Paymentbase_Model_Saferpay
{
	/**
	 * Unique internal payment method identifier
	 *
	 * @var string $_code
	 */
	protected $_code = 'saferpay';
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
	protected $_formBlockType = 'saferpay/form';
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
	protected $_saferpay_type = 'KREDITKARTE';
	/**
	 * Initialisiert das Array mit den zu übergebenden Parametern
	 * 
	 * Im Debugmodus wird der Kreditkartenprovider auf 90 gesetzt.
	 * 
	 * @return void
	 * 
	 * @see Egovs_Paymentbase_Model_Saferpay::getSaferpayUrl()
	 */
	protected function _getSaferpayUrl() {
		/*
		 * 20130403::Frank Rochlitzer
		 * URL Encode findet in Egovs_Paymentbase_Model_Curl::getResponse statt siehe #1582 ZVM844
		 */
		
		/*
		 * Nur Visa und Mastercard
		 */		
		Mage::getStoreConfig("payment/{$this->getCode()}/providerset")
			? $this->_fieldsArr ['PROVIDERSET'] = htmlentities(Mage::getStoreConfig("payment/{$this->getCode()}/providerset"))
			: $this->_fieldsArr ['PROVIDERSET'] = '102,104'
		;
		if ($this->getDebug()) {
			//Test-Kreditkartenprovider
			Mage::getStoreConfig("payment/{$this->getCode()}/providerset")
				? $this->_fieldsArr ['PROVIDERSET'] = htmlentities(Mage::getStoreConfig("payment/{$this->getCode()}/providerset"))
				: $this->_fieldsArr ['PROVIDERSET'] = '90'
			;
		}
	}
}
