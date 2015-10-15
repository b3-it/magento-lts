<?php

/**
 * Model für Barzahlungen
 *
 * @category   	Egovs
 * @package    	Egovs_Cashpayment
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license		http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 * @see Mage_Payment_Model_Method_Abstract
 */
class Egovs_Cashpayment_Model_PaymentLogic extends Mage_Payment_Model_Method_Abstract
{
	/**
	 * unique internal payment method identifier [a-z0-9_]
	 *
	 * @var string $_code
	 */
	protected $_code = 'cashpayment';

	/**
	 * Flag ob der Aufruf der authorize Methode erlaubt ist
	 *
	 * Authorize wird in der Regel bei der Bestellerstellung aufgerufen.
	 *
	 * @var boolean $_canCapture
	 */
	protected $_canAuthorize = false;

	/**
	 * Flag ob der Aufruf der capture Methode erlaubt ist
	 *
	 * Capture wird in der Regel bei der Rechnungserstellung aufgerufen.
	 *
	 * @var boolean $_canCapture
	 */
	protected $_canCapture = true;

	/**
	 * Flag ob die Erstellung von Teilrechnungen erlaubt ist
	 *
	 * @var boolean $_canCapture
	 */
	protected $_canCapturePartial = true;

	/**
	 * Formblock Type
	 *
	 * @var string $_formBlockType
	 */
	protected $_formBlockType = 'cashpayment/payment_form_cashpayment';

	/**
	 * Infoblock Type
	 * 
	 * Type als String oder 'paymentbase/noinfo' für keinen Infoblock
	 *
	 * @var string $_infoBlockType
	 */
	protected $_infoBlockType = 'paymentbase/noinfo';
	
    /**
     * Prüft ob dieses Bezahlform verfügbar ist.
     * 
     * Folgende Bedingungen werden geprüft:
     * <ul>
     * 	<li>Warenkorb-Gesamtpreis muss > 0.0 sein</li>
     * 	<li>Die Ware muss im Store abgeholt werden</li>
     * </ul>
     *
     * @param Mage_Sales_Model_Quote $quote Warenkorb
     * 
     * @return boolean
     */
    public function isAvailable($quote=null) {
    	if (!parent::isAvailable($quote)) {
    		return false;
    	}
    	
    	if ((isset($quote)) && ($quote->getGrandTotal() <= 0.0000001)) {
			return false;
		}

		if (isset($quote) && $quote->getIsVirtual()) {
			return false;
		}
        
		if ($quote) {
			$totals = $quote->getTotals();
			
			if (!isset($totals['shipping'])) {
				return true;
			}
			
			$shippingMethod = $quote->getShippingAddress()->getShippingMethod();
			if ($quote->getGrandTotal() > 0.001) {
				if ($shippingMethod != 'storepickup_storepickup') {
					return false;
				}
				 
				return true;
			}
		}
    	    	
    	return true;
    }
    
    /**
     * Gibt den Titel aus den Admineinstellungen zurück
     *
     * @return string
     */
    public function getCODTitle()
    {
    	return $this->getConfigData('title');
    }
    
    /**
     * Gibt einen einstellbaren Text aus den Admineinstellungen zurück
     *
     * @return string
     */
    public function getCustomText()
    {
    	return $this->getConfigData('customtext');
    }
}
