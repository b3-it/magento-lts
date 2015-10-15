<?php
/**
 * Helper für Lastschriftzahlungen mit schriftlicher Einwilligung
 *
 * Überschreibt hier Egovs_Paymentbase_Helper_Data
 *
 * @category   	Egovs
 * @package    	Egovs_DebitPIN
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de * 
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 * @see Egovs_Paymentbase_Helper_Data
 */
class Egovs_DebitPIN_Helper_Data extends Egovs_Paymentbase_Helper_Data
{
	/**
	 * Kunden ID am ePayment Server
	 * @var string
	 */
	private $__eCustomerId = null;
	 
	/**
     * Liefert die Kundennummer für die ePayment Plattform
     * 
     * Die Kundennummer kann maximal 100 Zeichen lang sein.
     * Hier wird sie wie folgt erzeugt:
     * <p>
     * "WebShopDesMandanten-eCustomerId"
     * </p>
     * Falls kein Customer angegeben wird, wird dieser aus der Quote bzw. der Session ermittelt.
     * 
     * @param int|Mage_Customer_Model_Customer $customer         Customer, customer id or null
     * @param boolean                          $throwIfNotExists Dieser Parameter ist hier ohne Funktion!
     * 
     * @return String ePayment Kundennummer
     * 
     * @see Egovs_Paymentbase_Model_Abstract::_getECustomerId
     */
    public function getECustomerId($customer = null, $throwIfNotExists = false) {
    	if (!$this->__eCustomerId) {
    		$this->__eCustomerId = $this->getECustomerIdNonVolatile($customer, $throwIfNotExists);
    	}
    	
    	return $this->__eCustomerId;
    }
}