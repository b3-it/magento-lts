<?php
/**
 * Klasse für Buchungen an der ePayBL
 * 
 * @property string haushaltsstelle Analog F15 Buchungszeile. Dient zur Steuerung der Sachkontenverbuchung im HKR Verfahren (10 Zeichen)
 * @property string objektnummer Analog F15 Buchungszeile. Dient zur Steuerung der Sachkontenverbuchung im HKR Verfahren. ((10 Zeichen) Optional)
 * @property string buchungstext Pflicht Der Text darf nur aus den Zeichen AZ0-9,.:/+& -*$%ÄÖÜß bestehen (21 Zeichen)
 * @property float betrag Betrag zur Titelverbuchung. Die Summe aller Beträge im Array muss gleich dem Betrag der Buchungsliste sein. ((15,2) Optional)
 * @property string belegNr Je nach Mandantenkonfiguration wird im ePayment System die Belegnummer ermittelt und in der Ergebnisstruktur zurückgeliefert. Wird die Belegnummer mitgeliefert, muss sie aus 8 Ziffern bestehen (ggf. mit führenden '0' auffüllen) und eindeutig im Belegnummernkreis des Bewirtschafters sein. (8 Zeichen Optional)
 * @property href In diesem Feld kann eine Buchungsreferenz von der Fachanwendung entgegengenommen werden. Diese wird als sogenannter Rucksackdatensatz an das ZÜV übermittelt. Weitere Details siehe Change Request 58. ((100 Zeichen) Optional)
 * 
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2012 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Model_Webservice_Types_Buchung extends Egovs_Paymentbase_Model_Webservice_Types_Abstract
{
	/**
	 * Konstruktor
	 * 
	 * @param string $haushaltsstelle Haushaltsstelle
	 * @param string $objektnummer    Objektnummer
	 * @param string $buchungstext    Buchungstext
	 * @param number $betrag          Betrag
	 * @param string $belegNr         Belegnummer
	 * @param string $href            HREF
	 * 
	 * @return void
	 */
	public function Egovs_Paymentbase_Model_Webservice_Types_Buchung(
			$haushaltsstelle,
			$objektnummer = '',
			$buchungstext = '',
			$betrag = 0,
			$belegNr = null,
			$href = null
	) {
		// betrag auf zwei nachkommastellen runden
		$betrag = round($betrag, 2);		 
	
		$this->haushaltsstelle = $haushaltsstelle;
		
		if (isset($objektnummer)) {
			$this->objektnummer = $objektnummer;
		}
		$this->buchungstext = $buchungstext;
		if (isset($betrag)) {
			$this->betrag = new SoapVar($betrag, XSD_DECIMAL);
		}
	
		if (isset($belegNr)) {
			$this->belegNr = (string) $belegNr;
		}
		
		if (isset($href)) {
			$this->href = $href;
		}
		parent::Egovs_Paymentbase_Model_Webservice_Types_Abstract();
	}
	
	/**
	 * Liefert die Längenbeschränkungen der Werte
	 *
	 * Längenbeschränkungen:<br/>
	 * <ul>
	 *  <li>belegNr = 8</li>
	 *  <li>haushaltsstelle = 10</li>
	 *  <li>objektnummer = 10</li>
	 *  <li>buchungstext = 21</li>
	 *  <li>HREF = 255</li>
	 *  <li><strong>default</strong> = 1000</li>
	 * </ul>
	 *
	 * @param string $name Parametername
	 *
	 * @return int
	 *
	 * @see Egovs_Paymentbase_Model_Webservice_Types_Abstract::_getParamLength()
	 */
	protected function _getParamLength($name) {
		switch ($name) {
			case 'belegNr':
				$length = 8;
				break;
			case 'haushaltsstelle':
			case 'objektnummer':
				$length = 10;
			case 'buchungstext':
				$length = 21;
				break;
			case 'href':
				if ($ml = Mage::getStoreConfig('payment_services/paymentbase/href_max_length')) {
					$length = intval($ml);
					$length = min($length, 255);
					$length = max(0, $length);
				} else {
					$length = 100;
				}
				
				break;
			default:
				$length = 1000;
		}
		
		return $length;
	}
}