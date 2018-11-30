<?php

/**
 * Model für Zahlungen auf Rechnung
 * 
 * Der Kunde bekommt eine Zahlungsfrist eingeräumt und die Ware kann sofort an den Kunden versendet werden.<br>
 * Der Kunde zahlt in der Regel nach erhalt der Ware.
 *
 * @category   	Egovs
 * @package    	Egovs_Openaccountpayment
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 * @see Egovs_Paymentbase_Model_Abstract
 */
class Egovs_Zahlpartnerkonten_Model_Payment_Openaccount extends Egovs_Openaccountpayment_Model_Openaccount
{
	private $__kZModel = null;
	
	private $__kennzMahn = null;
	
	/**
	 * Liefert das Kennzeichen für Mahnverfahren und setzt den Status für ZP-Konten
	 *
	 * Nur für ZÜV mit 5 Stelligen Mahnkennzeichen verwendbar
	 *
	 * @param Mage_Sales_Model_Order_Payment $payment Payment
	 * @param float 						 $amount  Betrag
	 *
	 * @return string
	 */
	public function getKennzeichenMahnverfahren($payment, $amount) {
		if (is_null($this->__kennzMahn)) {
			$this->__kennzMahn = parent::getKennzeichenMahnverfahren($payment, $amount);
			$kennzMahn = str_split($this->__kennzMahn);
				
			if (!empty($kennzMahn)) {
				if (!isset($kennzMahn[1])) {
					$kennzMahn[] = '0';
				}
				if (!isset($kennzMahn[2])) {
					$kennzMahn[] = '0';
				}
				$kennzMahn[2] = (int) $this->_getOrder()->getCustomer()->getUseZpkonto();
				$this->__kennzMahn = implode('', $kennzMahn);
			}
		}
	
		return $this->__kennzMahn;
	}
	
	/**
	 * Authorize
	 *
	 * @param Varien_Object $payment Payment
	 * @param integer 	    $amount  Betrag
	 * 
	 * @return  Mage_Payment_Model_Method_Abstract
	 *
	 * @see		Egovs_Paymentbase_Model_Abstract::_authorize
	 */
	protected function _authorize(Varien_Object $payment, $amount) {
		//	Kommunikation mit dem ePayment-Server
		//	zur Registrierung der Zahlung im Zahlverfahren
		//
		//	"Vorkasse / Offene Rechnung"

		// prüfen, ob Kunde mit seiner eShopKundennummer schon am Server existiert, sonst anlegen
		$this->createCustomerForPayment();

		if (Mage::helper('zpkonten')->isUseZpkonto($this->_getOrder()->getCustomer()) == true) {
			if ($this->_getOrder()->getCustomer()->getId() < 1) {
				$payment->setData('betrag_hauptforderungen', 0.0);
			} else {
				$kassenzeichenInfo = Mage::helper('paymentbase')->lesenKassenzeichenInfo($this->_getKassenzeichen());
				if (Mage::helper('zpkonten')->kassenzeichenExists($kassenzeichenInfo)) {
					Mage::helper('zpkonten')->validateSaldoWithLastPaymentMethode($kassenzeichenInfo,$this->_getKZModel(), $this);
					$this->validateSoapResult($kassenzeichenInfo, array(), 'lesenKassenzeichenInfo');
					$payment->setData('betrag_hauptforderungen', $kassenzeichenInfo->betragHauptforderungen);
					/*
					 * 20140110::Frank Rochlitzer
					 * Bei vorhandenen KZs wird die Paymentmethod nicht aktualisiert
					 */
					if ($this->_getKZModel()->getLastPayment() != $this->getCode()) {
						$this->_getKZModel()->setLastPayment($this->getCode())->save();
					}
				} else {
					$payment->setData('betrag_hauptforderungen', 0.0);
				}
			}
		}

		// Fälligkeitsdatum berechnen
		$iDatumFaelligkeit = strtotime("+{$this->getPayWithinXDays()} days");

		// Objekt für Buchungsliste erstellen
		$objBuchungsliste = $this->createAccountingList(
				$payment,
				$amount,
				$this->_getKassenzeichen(),
				$iDatumFaelligkeit
		);
			
		// Webservice aufrufen
		$objResult = null;
		
		$objResult = $this->_getSoapClient()->ueberweisenNachLieferungMitBLP($this->_getECustomerId(), $objBuchungsliste, $this->getBuchungsListeParameter($payment, $amount));
		if ($objResult instanceof SoapFault && $objResult->faultcode == 'Client' && $objResult->code == '0' && stripos($objResult->faultstring, self::SOAP_METHOD_NOT_AVAILABLE) > 0) {
			//Fallback zu alter Methode
			Mage::log($this->getCode().'::Fallback new Method MitBLP not available try old method without parameter list.', Zend_Log::NOTICE, Egovs_Helper::LOG_FILE);
		        $objResult = $this->_getSoapClient()->ueberweisenNachLieferung($this->_getECustomerId(), $objBuchungsliste);
		}
		$this->validateSoapResult($objResult, $objBuchungsliste, 'ueberweisenNachLieferung');

		//das kassenzeichen sollte erst abgeholt werden wenn das ergebniss geprueft wurde
		$payment->setData('kassenzeichen', $objResult->buchungsListe->kassenzeichen);
		//print_r($objResult->buchungsListe->kassenzeichen);
		$this->loeschenKunde();
		
		return $this;
	}

	protected function _getKassenzeichen() {
    	return $this->_getKZModel()->getKassenzeichen();
    }
    
	protected function _getKZModel() {
    	if ($this->__kZModel == null) {
	    	$model = Mage::getModel('zpkonten/pool');
	    	$customer = $this->_getOrder()->getCustomer();
	    	$data = array();
	    	$data ['mandant'] = $this->_getMandantNr();
	    	$data ['bewirtschafter'] = $this->_getBewirtschafterNr();
	    	$data ['currency'] = 'EUR';
	    	$data ['paymentmethod'] = $this->_code;

    		$this->__kZModel = $model->findKassenzeichen($customer, $data);
    	}
    	return $this->__kZModel;
    }
    
  	public function validateSoapResult($objResult, $objBuchungsliste, $soapFunction = '', $keepCustomer = false) {
    	try {
    		parent::validateSoapResult($objResult, $objBuchungsliste, $soapFunction, $keepCustomer);
    	} catch (Exception $ex) {
    		if (Mage::helper('zpkonten')->isUseZpkonto($this->_getOrder()->getCustomer()) != true) {
    			if ($objResult instanceof Egovs_Paymentbase_Model_Webservice_Types_Response_BuchungsListeErgebnis) {
    				$this->_getKZModel()->setComment($objResult->ergebnis->getLongText());
    			}
    			$this->_getKZModel()->setStatus(Egovs_Zahlpartnerkonten_Model_Status::STATUS_ERROR)
    				->save();
    		}
    		throw $ex;
    	}	
    }
}
