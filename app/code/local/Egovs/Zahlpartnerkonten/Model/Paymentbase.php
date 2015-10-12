<?php
/**
 * Basisklasse für gemeinsam genutzte Methoden zur ePayment-Kommunikation.
 *
 * @category	Egovs
 * @package		Egovs_Zahlpartnerkonten
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright	Copyright (c) 2011-2012 EDV Beratung Hempel
 * @copyright	Copyright (c) 2011-2012 TRW-NET 
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Zahlpartnerkonten_Model_Paymentbase extends Egovs_Paymentbase_Model_Paymentbase
{
	protected $_customer = null;
	
	/**
	 * Prüft ob der Kunde der Bestellung ZP-Konten nutzt.
	 * 
	 * @return boolean
	 */
	public function isZpKonto() {
		$customerId = $this->_getOrder()->getCustomerId();
		
		if (empty($customerId)) {
			$this->_customer = null;
			return false;
		}
		
		if (!$this->_customer || $this->_customer->getId() != $customerId) {
			$this->_customer = Mage::getModel('customer/customer')->load($customerId, array(Egovs_Zahlpartnerkonten_Helper_Data::ATTRIBUTE_USE_ZPKONTO));
		}
		return (bool) $this->_customer->getUseZpkonto();
	}
	
	protected function _getDeltaBetrag() {
		$betragHauptforderungen = $this->_getOrder()->getPayment()->getBetragHauptforderungen();
		if (!isset($betragHauptforderungen)) {
			$betragHauptforderungen = 0.0;
		}
		//Wenn sich die Hauptforderungen nicht unterscheiden so darf das delta nicht neu berechnet werden!
		if ($this->hasData($this->getKassenzeichenInfo()->kassenzeichen)
			&& $this->getData($this->getKassenzeichenInfo()->kassenzeichen)->getBetragHauptforderungen() == $betragHauptforderungen
			) {
			return $this->getData($this->getKassenzeichenInfo()->kassenzeichen)->getDeltaSumDebitIn();
		}
		
		$delta = round($this->getKassenzeichenInfo()->betragZahlungseingaenge - $betragHauptforderungen, 4);
		
		return max($delta, 0.0);
	}
	/**
	 * Liefert Informationen zum übergebenen Kassenzeichen am ePayBL
	 *
	 * Für ZP-Konten wird die KassenzeichenInfo über das Kassenzeichen gecached.<br/>
	 * Verwendete WebService - Schnittstelle(n):
	 * <ul>
	 * 	<li>lesenKassenzeichenInfo</li>
	 * </ul>
	 *
	 * @param string $kzeichen Kassenzeichen
	 *
	 * @return Egovs_Paymentbase_Model_Webservice_Types_Response_KassenzeichenInfoErgebnis
	 */
	protected function _lesenKassenzeichenInfo($kzeichen) {
		if ($this->isZpKonto() && $this->hasData($kzeichen)) {
			$this->setKassenzeichenInfo($this->getData($kzeichen)->getKassenzeichenInfo());
			$this->getData($kzeichen)->setDeltaSumDebitIn($this->_getDeltaBetrag());
			$this->getData($kzeichen)->setBetragHauptforderungen($this->_getOrder()->getPayment()->getBetragHauptforderungen());
			return $this->getData($kzeichen)->getKassenzeichenInfo();
		}
		$kassenzeichenInfo = Mage::helper('paymentbase')->lesenKassenzeichenInfo($kzeichen);
		
		$this->setKassenzeichenInfo($kassenzeichenInfo);
		
		if ($this->isZpKonto()) {
			/*
			 * $delta_sum_debit_in gibt die Zahlungseingänge nach der Sollstellung der aktuellen Bestellung an  
			 */
			$this->setData(
					$kzeichen,
					new Varien_Object(
							array(
									'kassenzeichen_info' => $kassenzeichenInfo,
									'delta_sum_debit_in' => $this->_getDeltaBetrag(),
									'betrag_hauptforderungen' => $this->_getOrder()->getPayment()->getBetragHauptforderungen(),
							)
					)
			);
		}
		
		return  $kassenzeichenInfo;
	}
	/**
	 * Ordnet die Zahlungseingänge für ein Kassenzeichen einer Bestellung zu
	 * 
	 * Diese Funktion erweitert _processIncomingPayments() um die Unterstützung für Zahlpartnerkonten
	 *
	 * @return void
	 */
	protected function _processIncomingPayments() {
		
		if (!$this->isZpKonto()) {
			parent::_processIncomingPayments();
			return;
		}
		
		//Wenn ZP-Konto bereits komplett ausgeglichen wurde
    	if ($this->hasKassenzeichenInfo() && $this->getKassenzeichenInfo()->saldo <= 0.0) {
    		//Reset möglicher Teilzahlungen
    		$this->_getOrder()->setBaseTotalPaid(0);
    		$this->_getOrder()->setTotalPaid(0);
    		
    		if (!$this->getData($this->_getKassenzeichen())->hasOverPayment()) {
	    		if ($this->getKassenzeichenInfo()->saldo < 0.0 && $this->_notBalanced <= self::MAX_UNBALANCED) {
	    			Mage::getSingleton('adminhtml/session')->addNotice(
	    				Mage::helper('paymentbase')->__('The balance of invoice #%s for order #%s is %s', $this->getInvoice()->getIncrementId(), $this->_getOrder()->getIncrementId(), $this->getKassenzeichenInfo()->saldo)
	    			);
	    			$this->_notBalanced++;
	    		} elseif ($this->getKassenzeichenInfo()->saldo < 0.0 && $this->_notBalanced == self::MAX_UNBALANCED+1) {
	    			Mage::getSingleton('adminhtml/session')->addNotice(Mage::helper('paymentbase')->__('...'));
	    			$this->_notBalanced++;
	    		}
	    		if ($this->getKassenzeichenInfo()->saldo < 0.0) {
	    			$this->getInvoice()->addComment(Mage::helper('paymentbase')->__('The balance of this invoice is %s', $this->getKassenzeichenInfo()->saldo))
	    				->save()
	    			;
	    			$this->getData($this->_getKassenzeichen())->setOverPayment(true);
	    		}
    		}
    	
    		$orderStatus = $this->_setOrderStateAfterPayment($this->_getOrder());
    		$this->_getOrder()->setStatus($orderStatus);
    		//Hier Rechnungen noch auf bezahlt setzen!
    		//Muss nach State-Änderung der Order stehen!!
    		$this->_setInvoicePaymentStatus($this->_getOrder());
    		if ($this->getKassenzeichenInfo()->saldo < 0.0 && !$this->getData($this->_getKassenzeichen())->hasOverPayment()) {
    			$deltaPaid = $this->getKassenzeichenInfo()->betragZahlungseingaenge - $this->getKassenzeichenInfo()->betragHauptforderungen;
    			$this->_getOrder()->setBaseTotalPaid($this->_getOrder()->getBaseGrandTotal() + $deltaPaid);
    			/* $this->getKassenzeichenInfo()->betragZahlungseingaenge kommt als base price */
    			$this->_getOrder()->setTotalPaid($this->_getOrder()->getStore()->convertPrice($this->_getOrder()->getBaseGrandTotal() + $deltaPaid));
    		}
    		$this->_getOrder()->save();
    		$this->_paidKassenzeichen++;
    		$this->_grantedKassenzeichen[] = $this->_getKassenzeichen();
    	} elseif ($this->hasKassenzeichenInfo() && $this->getKassenzeichenInfo()->saldo > 0.0 /*&& $this->getKassenzeichenInfo()->saldo < $this->_getOrder()->getBaseGrandTotal()*/) {
    		//ZP-Konten: komplette Teilzahlung einer Bestellung
    		if ($this->getData($this->_getKassenzeichen())->getDeltaSumDebitIn() >= $this->_getOrder()->getBaseGrandTotal()) {
    			$orderStatus = $this->_setOrderStateAfterPayment($this->_getOrder());
    			$this->_getOrder()->setStatus($orderStatus);
    			//Hier Rechnungen noch auf bezahlt setzen!
    			//Muss nach State-Änderung der Order stehen!!
    			$this->_setInvoicePaymentStatus($this->_getOrder());
    			$this->_getOrder()->save();
    			$this->_paidKassenzeichen++;
    			$this->_grantedKassenzeichen[] = $this->_getKassenzeichen();
    			$this->getData($this->_getKassenzeichen())->setDeltaSumDebitIn(max($this->getData($this->_getKassenzeichen())->getDeltaSumDebitIn() - $this->_getOrder()->getBaseGrandTotal(), 0.0));
    		} elseif ($this->getData($this->_getKassenzeichen())->getDeltaSumDebitIn() > 0.0) {
    			//Nur für Teilzahlungen
    			if ($this->_notBalanced <= self::MAX_UNBALANCED) {
    				Mage::getSingleton('adminhtml/session')->addNotice(
	    				Mage::helper('paymentbase')->__(
	    					'The balance of invoice #%s for order #%s is %s',
	    					$this->getInvoice()->getIncrementId(),
	    					$this->_getOrder()->getIncrementId(),
	    					$this->_getOrder()->getBaseGrandTotal() - $this->getData($this->_getKassenzeichen())->getDeltaSumDebitIn()
	    				)
    				);
    				$this->_notBalanced++;
    			} elseif ($this->_notBalanced == self::MAX_UNBALANCED+1) {
    				Mage::getSingleton('adminhtml/session')->addNotice(Mage::helper('paymentbase')->__('...'));
    				$this->_notBalanced++;
    			}
    			$this->getInvoice()->addComment(
    					Mage::helper('paymentbase')->__('The balance of this invoice is %s', $this->_getOrder()->getBaseGrandTotal() - $this->getData($this->_getKassenzeichen())->getDeltaSumDebitIn())
    				)->save()
    			;
    			$this->_getOrder()->setBaseTotalPaid(min(max(0, $this->getData($this->_getKassenzeichen())->getDeltaSumDebitIn()), $this->_getOrder()->getBaseGrandTotal()));
    			/* $this->getKassenzeichenInfo()->betragZahlungseingaenge kommt als base price */
    			$this->_getOrder()->setTotalPaid(min(max(0, $this->_getOrder()->getStore()->convertPrice($this->getData($this->_getKassenzeichen())->getDeltaSumDebitIn())), $this->_getOrder()->getGrandTotal()));
    			 
    			$this->_getOrder()->save();
    			$this->getData($this->_getKassenzeichen())->setDeltaSumDebitIn(max($this->getData($this->_getKassenzeichen())->getDeltaSumDebitIn() - $this->_getOrder()->getBaseGrandTotal(), 0.0));
    		}
    	}
    }
}