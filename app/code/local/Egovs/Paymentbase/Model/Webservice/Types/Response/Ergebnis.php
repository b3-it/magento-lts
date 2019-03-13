<?php
/**
 * Ergebnis
 *
 * Response von ePayBL 2.x oder 3.x
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright   Copyright (c) 2012 - 2017 B3 IT Systeme GmbH https://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 * 
 * @property string $EPaymentId Interne eindeutige ID des ePayment System, unter der der Request gespeichert wurde, der das Ergebniselement als Returnstruktur erzeugt hat. Sollte protokolliert werden und als Referenz gegenüber dem ePayment System verwendet werden.
 * @property date $EPaymenTimestamp Zeitpunkt zu welchem der aufrufende Request im ePayment-System gespeichert wurde
 * @property bool $istOk Status des Ergebnisses
 * 
 * @property Egovs_Paymentbase_Model_Webservice_Types_Text $text Enthält detaillierte Zusatzinformationen zum Vorgang; seit ePayBL 3.x
 * 
 * @property string(50)  $code     Detaillierter Fehlerstatus als Code; deprecated seit epayBL 3.x
 * @property string(250) $langText Ausführliche Fehlerbeschreibung; deprecated seit epayBL 3.x
 * @property string(30)  $kurzText Kurze Fehlerbeschreibung deprecated; seit epayBL 3.x
 * 
 */
class Egovs_Paymentbase_Model_Webservice_Types_Response_Ergebnis
{
	/**
	 * Gibt Code zurück
	 * 
	 * @return string|NULL
	 */
	public function getCode() {
		if (isset($this->code)) {
			return $this->code;
		}
		
		if (isset($this->text)) {
			return $this->text->code;
		}
		
		return null;
	}
	
	/**
	 * Liefert den Code als int
	 * 
	 * @return number
	 */
	public function getCodeAsInt() {
		return intval($this->getCode());
	}
	
	/**
	 * Gibt den kurzText zurück
	 * 
	 * @return string(30)|NULL
	 */
	public function getShortText() {
		if (isset($this->kurzText)) {
			return $this->kurzText;
		}
		
		if (isset($this->text) && isset($this->text->kurzText)) {
			return $this->text->kurzText;
		}
		
		return null;
	}
	
	public function getLongText() {
		if (isset($this->langText)) {
			return $this->langText;
		}
		
		if (isset($this->text) && isset($this->text->langText)) {
			return $this->text->langText;
		}
		
		return null;
	}
	
	/**
	 * Gibt istOk zurück
	 * 
	 * @return boolean
	 */
	public function isOk() {
		if (isset($this->istOk)) {
			return (bool) $this->istOk;
		}
		
		return false;
	}
	
	/**
	 * Setzt den Code
	 * 
	 * @param string $code
	 */
	public function setCode($code) {
		if (Mage::helper('paymentbase')->getEpayblVersionInUse() == Egovs_Paymentbase_Helper_Data::EPAYBL_3_X_VERSION) {
			if (!isset($this->text)) {
				$this->text = Mage::getModel('paymentbase/webservice_types_text');
			}
			$this->text->code = $code;
		} else {
			$this->code = $code;
		}
		return $this;
	}
	
	/**
	 * Setzt den kurzText
	 * 
	 * @param string $shortText
	 * 
	 * @return Egovs_Paymentbase_Model_Webservice_Types_Response_Ergebnis
	 */
	public function setShortText($shortText) {
		if (Mage::helper('paymentbase')->getEpayblVersionInUse() == Egovs_Paymentbase_Helper_Data::EPAYBL_3_X_VERSION) {
			if (!isset($this->text)) {
				$this->text = Mage::getModel('paymentbase/webservice_types_text');
			}
			$this->text->kurzText = $shortText;
		} else {
			$this->kurzText = $shortText;
		}
		return $this;
	}
	
	/**
	 * Setzt den langText
	 *
	 * @param string $longText
	 *
	 * @return Egovs_Paymentbase_Model_Webservice_Types_Response_Ergebnis
	 */
	public function setLongText($longText) {
		if (Mage::helper('paymentbase')->getEpayblVersionInUse() == Egovs_Paymentbase_Helper_Data::EPAYBL_3_X_VERSION) {
			if (!isset($this->text)) {
				$this->text = Mage::getModel('paymentbase/webservice_types_text');
			}
			$this->text->langText = $longText;
		} else {
			$this->langText = $longText;
		}
		return $this;
	}
}