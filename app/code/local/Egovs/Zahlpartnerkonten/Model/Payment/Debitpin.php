<?php
/**
 * Bezahlung per Lastschrift mit schriftlicher Einzugsermächtigung.
 * 
 * @category	Egovs
 * @package		Egovs_DebitPIN
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright	Copyright (c) 2011 EDV Beratung Hempel
 * @copyright	Copyright (c) 2011 TRW-NET 
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 */
class Egovs_Zahlpartnerkonten_Model_Payment_Debitpin extends Egovs_DebitPIN_Model_PaymentLogic
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
	
	public function createAccountingList($payment, $amount, $bkz = null, $maturity = null, $arrBuchungsliste = null, $grandTotal = null, $currency = null) {
		// Objekt für Buchungsliste erstellen
		if (is_null($arrBuchungsliste)) {
			$arrBuchungsliste = $this->createAccountingListParts();
		}
		if (Mage::helper('paymentbase')->getEpayblVersionInUse() == Egovs_Paymentbase_Helper_Data::EPAYBL_3_X_VERSION) {
			$arrBuchungsliste = new Egovs_Paymentbase_Model_Webservice_Types_BuchungList($arrBuchungsliste);
		}
		$objBuchungsliste = new Egovs_Paymentbase_Model_Webservice_Types_BuchungsListe(
				// Gesamtsumme
				is_null($grandTotal) ? (float) $this->_getOrder()->getGrandTotal() : $grandTotal,
				// derzeit wird nur EUR vom ePayment-Server unterst�tzt
				is_null($currency) ? 'EUR' : $currency,
				// Fälligkeit
				is_null($maturity) ? strftime('%Y-%m-%dT%H:%M:%SZ') : $maturity,
				// Buchungsliste
				$arrBuchungsliste,
				// Bewirtschafter
				$this->_getBewirtschafterNr(),
				// Kennzeichen Mahnverfahren aus Konfiguration
				$this->getKennzeichenMahnverfahren($payment, $amount),
				// Kassenzeichen wird normalerweise vom ePayment-Server generiert
				$this->_getKassenzeichen()
		);
	
		return $objBuchungsliste;
	}
	
	protected function _getKassenzeichen() {
    	$customer = $this->_getOrder()->getCustomer();
		if ($customer->getId() > 0 && Mage::helper('zpkonten')->isUseZpkonto($customer) == true) {
			$kassenzeichenInfo = Mage::helper('paymentbase')->lesenKassenzeichenInfo($this->_getKZModel()->getKassenzeichen());
			if (Mage::helper('zpkonten')->kassenzeichenExists($kassenzeichenInfo)) {
				Mage::helper('zpkonten')->validateSaldoWithLastPaymentMethode($kassenzeichenInfo, $this->_getKZModel(), $this);
				$this->validateSoapResult($kassenzeichenInfo, array(), 'lesenKassenzeichenInfo');
				/*
				 * 20140110::Frank Rochlitzer
				 * Bei vorhandenen KZs wird die Paymentmethod nicht aktualisiert
				 */
				if ($this->_getKZModel()->getLastPayment() != $this->getCode()) {
					$this->_getKZModel()->setLastPayment($this->getCode())->save();
				}
			}
		}
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
    	}	
    	catch (Exception $ex) {
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