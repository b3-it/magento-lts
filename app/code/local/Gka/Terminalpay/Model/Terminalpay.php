<?php
/**
 * Terminalpay über Saferpay Model
 *
 * @category   	Gka
 * @package    	Gka_Terminalpay
 * @name       	Gka_Terminalpay_Model_Terminalpay
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2014 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 * 
 * @see Egovs_Paymentbase_Model_Saferpay
 */
class Gka_Terminalpay_Model_Terminalpay extends Egovs_Paymentbase_Model_Saferpay
{
	/**
	 * Unique internal payment method identifier
	 *
	 * @var string $_code
	 */
	protected $_code = 'terminalpay';

	/**
	 * Flag: Ist dieses Model als Gateway
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
	protected $_formBlockType = 'terminalpay/form';
	/**
	 * Infoblock Type
	 *
	 * Type als String oder 'paymentbase/noinfo' für keinen Infoblock
	 *
	 * @var string $_infoBlockType
	 */
	protected $_infoBlockType = 'paymentbase/noinfo';
	/**
	 * Unterscheidet zwischen Terminalpay und Kreditkarte
	 *
	 * @var string $_saferpay_type
	 */
	protected $_saferpay_type = 'TERMINALPAY';
	/**
	 * Initialisiert das Array mit den zu übergebenden Parametern 
	 * 
	 * @return void
	 * 
	 * @see Egovs_Paymentbase_Model_Saferpay::getSaferpayUrl()
	 */
	protected function _getSaferpayUrl() {
	}
	
	public function getInfoBlockType() {
		$_cmsBlock = Mage::getStoreConfig("payment/{$this->getCode()}/cms_block");
		if (!empty($_cmsBlock)) {
			return 'payment/info';
		}
		
		return parent::getInfoBlockType();
	} 
}
