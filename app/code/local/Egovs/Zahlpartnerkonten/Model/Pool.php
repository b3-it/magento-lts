<?php
/**
 * Basisklasse für gemeinsam genutzte Methoden zur ePayment-Kommunikation im Saferpay-Verfahren (Kreditkarte/Giropay).
 *
 * @category	Egovs
 * @package		Egovs_Zahlpartnerkonten
 * @author		Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @author		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2012-2013 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 * 
 * @method String getKassenzeichen
 * @method String getMandant
 * @method String getBewirtschafter
 * @method int    getCustomerId
 * @method String getCustomerName
 * @method String getCustomerCompany
 * @method String getCustomerStreet
 * @method String getCustomerCity
 * @method String getCustomerPostcode
 * @method String getLastPayment
 * @method int    getStatus
 * @method String getEmail
 * @method String getComment
 */
class Egovs_Zahlpartnerkonten_Model_Pool extends Mage_Core_Model_Abstract
{
	/**
	 * Konstruktor
	 * 
	 * @return void
	 * 
	 * @see Varien_Object::_construct()
	 */
    protected function _construct() {
        parent::_construct();
        $this->_init('zpkonten/pool');
    }
    
    /**
     * Konfiguration prüfen
     * 
     * @return Egovs_Zahlpartnerkonten_Model_Pool
     */
    public function validate() {
    	if (strlen(Mage::getStoreConfig('payment_services/paymentbase/bewirtschafternr')) <= 0) {
    		Mage::throwException(Mage::helper('zpkonten')->__('Bewirtschafter is missing.'));
    	}
    	 
    	if (strlen(Mage::getStoreConfig('payment_services/paymentbase/mandantnr')) <= 0) {
    		Mage::throwException(Mage::helper('zpkonten')->__('Mandant is missing.'));
    	} 

    	$length = Mage::getStoreConfig('payment_services/paymentbase/zpkonten_length');
    	$prefix = Mage::getStoreConfig('payment_services/paymentbase/mandanten_kz_prefix');
    	
    	if (strlen($prefix) >= intval($length)) {
    		Mage::throwException(Mage::helper('zpkonten')->__('Prefix is too long.'));
    	}
    	
    	return $this;
    }
    
    /**
     * Kassenzeichen anlegen
     * 
     * @param int $value Kassenzeichenwert
     * 
     * @return Egovs_Zahlpartnerkonten_Model_Pool
     */
    public function createKassenzeichen($value) {
    	$this->setData('status', Egovs_Zahlpartnerkonten_Model_Status::STATUS_NEW);
    	$this->setData('bewirtschafter', Mage::getStoreConfig('payment_services/paymentbase/bewirtschafternr'));
    	$this->setData('mandant', Mage::getStoreConfig('payment_services/paymentbase/mandantnr'));
    	$this->setData('currency', Mage::getStoreConfig('currency/options/base'));
    	

    	$length = Mage::getStoreConfig('payment_services/paymentbase/zpkonten_length');
    	$prefix = Mage::getStoreConfig('payment_services/paymentbase/mandanten_kz_prefix');
    	
    	$diff = $length - strlen($prefix);
    	$kz = $prefix;
    	if ($diff > 0) {
    		$kz .= sprintf("%0".$diff."d", $value);
    	} else {
    		$kz .= $value;
    	}
    	
	    
    	if (Mage::getStoreConfig('payment_services/paymentbase/zpkonten_checksum')) {
	    	$kz .= $this->_pruefziffer($kz);
    	}
    	$this->setData('kassenzeichen', $kz);
    	return $this;
    }
    
    /**
     * Bestehendes Kassenzeichen finden oder neues zurueckgeben
     * 
     * @param Mage_Customer_Model_Customer $customer Kunde
     * @param array 					   $data     ['mandant','bewirtschafter','currency','paymentmethod'] Daten
     * 
     * @return Egovs_Zahlpartnerkonten_Model_Pool
     */
    public function findKassenzeichen($customer, $data) {
    	//laden
    	$kz = $this->getCollection()->loadKassenzeichen($customer, $data);
    	//falls nicht gefunden
    	if (!$kz) {
    		//den ersten freien finden
    		$kz = $this->getCollection()->nextKassenzeichen($customer, $data);
    		$this->testFreeLimit($data);
    	}
    	
    	if (!$kz) {
    		//falls keinen gefunden
    		Mage::log(Mage::helper('zpkonten')->__("No free Kassenzeichen found"), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
    		$gc = Mage::helper('zpkonten')->getGeneralContact();
    		Mage::throwException(Mage::helper('paymentbase')->__('TEXT_PROCESS_ERROR_STANDARD', $gc['mail']));
    	}
    	
    	//für "einfache" Nutzer wird das Kassenzeichen auf benutzt gesetzt
    	if (!$this->_isUseZpkonto($customer)) {
    			$kz->setData('status', Egovs_Zahlpartnerkonten_Model_Status::STATUS_USED);	
    	}
    	 
    	
    	//kundendaten füllen
    	if (!$customer || $customer->isEmpty()) {
	    	$quote = Mage::getSingleton('checkout/session')->getQuote();
	    	if ($quote instanceof Mage_Sales_Model_Quote) {
	    		$address = $quote->getBillingAddress();
	    		$kz->setData('customer_name', $address->getName());
	    		$kz->setData('customer_company', $address->getCompany());
	    	}
    	} else {
    		$kz->setData('customer_name', $customer->getFirstname().' '.$customer->getLastname());
    		$kz->setData('customer_company', $customer->getCompany());
    	}
    			
		//sollte erst der Saldo geprüft werden? Bevor der Wert überschrieben wird?
		//$kz->setData('last_payment',$data['paymentmethod']);
		$kz->save();
		
		if (!isset($address)) {
			$address = $customer->getDefaultBillingAddress();
		}
		
		if (!$address) {
			$quote = Mage::getSingleton('checkout/session')->getQuote();
			if ($quote instanceof Mage_Sales_Model_Quote) {
				$address = $quote->getBillingAddress();
			}
		}
		
		if ($address) {
			$kz->setData('customer_street', $address->getStreetFull());
			$kz->setData('customer_city', $address->getCity());
			$kz->setData('customer_postcode', $address->getPostcode());
		}
  		$kz->save();
  		
  		
  		
    	return $kz;
    	
    }   
    
    /**
     * Prüfen ob genügend freie Kassenzeichen vorhanden sind
     * 
     * @param array $data Daten
     * 
     * @return Egovs_Zahlpartnerkonten_Model_Pool
     */
    public function testFreeLimit($data) {
    	//pruefen ob noch genug freie kassenzeichen vorhanden
  		try {
  			$soll = Mage::getStoreConfig('payment_services/paymentbase/zpkonten_pool_limit');
  			$ist = $this->getCollection()->countFreeKassenzeichen($data);
  			$data['actual'] = $ist;
  			if ($ist <= $soll) {
  				$this->sendMail($data);
  			}	
  		} catch (Exception $ex) {
  			Mage::log($ex->getMessage(), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);	
  		}
  		return $this;
    }
    
    /**
     * Kassenzeichen unterschritten Mail senden
     * 
     * @param array $data Daten
     * 
     * @return Egovs_Zahlpartnerkonten_Model_Pool
     */
    public function sendMail($data) {
    	$body = "Die erforderliche Menge an freien Kassenzeichen ist unterschritten.\n";
		$body .= "mandant = ".$data['mandant']."\n";
		$body .= "bewirtschafter = ".$data['bewirtschafter']."\n";
		$body .= Mage::helper('zpkonten')->__("currency")." = ".$data['currency']."\n";
		$body .= Mage::helper('zpkonten')->__('actual count = %s', $data['actual'])."\n";

		Mage::helper('zpkonten')->sendMailToAdmin($body, 'Zahlpartnerkonten Pool');

		return $this;
    }
    
    
    /**
     * Prüfziffer berechnen
     * 
     * @param int $value Kassenzeichen
     * 
     * @return int
     */
	protected function _pruefziffer($value) {
		$arr = str_split($value);
	    $sum = 0;
	    for ($i = 0, $iMax = count($arr); $i < $iMax; $i++) {
		
			$w = $this->_wertigkeit(count($arr) - $i);
			$m = $arr[$i] * $w;
			$r = $m % 9;
			if ($r == 0) {
				$r = 9;
			}
			if ($m == 0) {
				$r = 0;
			}
			$sum += $r;
			//echo $arr[$i] ."*".$w."=" .$m." [$r]"."<br>";
		}
		$z = $sum % 10;
		$p = 10 - $z;
		if ($p > 9) {
			$p = 0;
		}
		
		return $p;
	}
	
	/**
	 * Prüft ob der Kunde ZP-Konten nutzt
	 * 
	 * @param Mage_Customer_Model_Customer &$customer Kunden-Objekt
	 * 
	 * @return bool
	 */
	protected function _isUseZpkonto(&$customer) {
		return Mage::helper('zpkonten')->isUseZpkonto($customer);
	}
	
	/**
	 * Wertigkeit berechnen
	 * 
	 * @param int $pos Pos
	 * 
	 * @return int
	 */
	protected function _wertigkeit($pos) {
		$res = pow(2, $pos);
		while ($res > 9) {
			$res = $this->_quersumme($res);
		}
		return $res;
	}
	
	/**
	 * Quersumme berechnen
	 * 
	 * @param int $value Wert
	 * 
	 * @return int
	 */
	protected function _quersumme($value) {
	      $arr = str_split((int)$value);
	      $r = 0;
	      foreach ($arr as $v) {
	      	$r += $v;
	      }
			
	      return $r;
	}
	
	/**
	 * Pooleintrag über customer laden
	 *
	 * @param int|Mage_Customer_Model_Customer $customer Kunde
	 * 
	 * @return  Egovs_Zahlpartnerkonten_Model_Pool
	 */
	public function loadByCustomer($customer) {
		$this->_getResource()->loadByCustomer($this, $customer);
		return $this;
	}
	/**
	 * Pooleintrag über Kassenzeichen, Mandant, Bewirtschafter laden
	 *
	 * @param string $kz             Kassenzeichen
     * @param string $mandant        Mandant
     * @param string $bewirtschafter Bewirtschafter
	 *
	 * @return  Egovs_Zahlpartnerkonten_Model_Pool
	 */
	public function loadByKzMandantBewirtschafter($kz, $mandant, $bewirtschafter) {
		$this->_getResource()->loadByKzMandantBewirtschafter($this, $kz, $mandant, $bewirtschafter);
		return $this;
	}
}