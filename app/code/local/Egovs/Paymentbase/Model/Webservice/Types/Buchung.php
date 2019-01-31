<?php
/**
 * Klasse für Buchungen an der ePayBL
 * 
 * @property string haushaltsstelle Analog F15 Buchungszeile. Dient zur Steuerung der Sachkontenverbuchung im HKR Verfahren (10 Zeichen)
 * @property string objektnummer Analog F15 Buchungszeile. Dient zur Steuerung der Sachkontenverbuchung im HKR Verfahren. ((10 Zeichen) Optional)
 * @property string buchungstext Pflicht Der Text darf nur aus den Zeichen AZ0-9,.:/+& -*$%ÄÖÜß bestehen (120 Zeichen)
 * @property float betrag Betrag zur Titelverbuchung. Die Summe aller Beträge im Array muss gleich dem Betrag der Buchungsliste sein. ((15,2) Optional)
 * @property string belegNr Je nach Mandantenkonfiguration wird im ePayment System die Belegnummer ermittelt und in der Ergebnisstruktur zurückgeliefert. Wird die Belegnummer mitgeliefert, muss sie aus 8 Ziffern bestehen (ggf. mit führenden '0' auffüllen) und eindeutig im Belegnummernkreis des Bewirtschafters sein. (8 Zeichen Optional)
 * @property href In diesem Feld kann eine Buchungsreferenz von der Fachanwendung entgegengenommen werden. Diese wird als sogenannter Rucksackdatensatz an das ZÜV übermittelt. Weitere Details siehe Change Request 58. ((100 Zeichen) Optional)
 * 
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright	Copyright (c) 2012 - 2018 B3 IT Systeme GmbH - https://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Model_Webservice_Types_Buchung extends Egovs_Paymentbase_Model_Webservice_Types_Abstract
{
    // Länge des Buchungs-Textes
    const LENGTH_BUCHUNGSTEXT    = 120;

    // Länge für Haushaltstelle und ObjektNummer
    const LENGTH_HAUSHALT_OBJECT = 10;

    // Länge für HREF
    const LENGTH_DEFAULT_HREF = 100;

    // Default-Wert für Feld-Länge
    CONST LENGTH_DEFAULT = 1000;

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
	
	public function getParamLength($name = '')
    {
        return $this->_getParamLength($name);
    }
	
	/**
	 * Liefert die Längenbeschränkungen der Werte
	 *
	 * Längenbeschränkungen:<br/>
	 * <ul>
	 *  <li>belegNr = 8</li>
	 *  <li>haushaltsstelle = 10</li>
	 *  <li>objektnummer = 10</li>
	 *  <li>buchungstext = 120</li>
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
				$length = self::LENGTH_HAUSHALT_OBJECT;
				// TODO Disabled bug fix for validate length till ZV_AM-1196 is implemented
				//break;
			case 'buchungstext':
				$length = self::LENGTH_BUCHUNGSTEXT;
				break;
			case 'href':
				if ($ml = Mage::getStoreConfig('payment_services/paymentbase/href_max_length')) {
					$length = intval($ml);
					$length = min($length, 255);
					$length = max(0, $length);
				} else {
					$length = self::LENGTH_DEFAULT_HREF;
				}
				
				break;
			default:
				$length = self::LENGTH_DEFAULT;
		}
		
		return $length;
	}
}