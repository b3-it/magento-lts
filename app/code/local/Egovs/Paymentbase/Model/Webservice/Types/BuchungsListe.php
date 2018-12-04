<?php
/**
 * Klasse für Buchungslisten an der ePayBL
 * 
 * @property float betrag Betrag der Hauptforderung zum aktuellen Zahlungsvorgang. (15,2)
 * @property string(3) waehrungkennzeichen Momentan ist nur 'EUR' vorgesehen. (3 Zeichen)
 * @property DateTime faelligkeitsdatum Das Fälligkeitsdatum steuert innerhalb von ZÜV,
 * 	wann eine ausstehende Zahlungsanforderung in Abhängigkeit vom Mahnkennzeichen gemahnt wird.
 * 	Im ePayment System wird dieses Datum nicht ausgewertet.
 * @property array buchungen Liste der Buchungen zu einer Zahlungsanforderung. (Optional)
 * 	Hierdurch wird die Sachkontenverbuchung im HKR gesteuert. Sollte die Zahlungsanforderung nur auf
 * 	einem Titel/Objekt verbucht werden, besteht das Array nur aus einem Element.
 * @property string(8) bewirtschafterNr Gibt den Bewirtschafter an, unter dem im ZÜV die überstellte Zahlungsüberwachung
 * 	eingestellt werden soll.
 * @property string(5) kennzeichenMahnverfahren Das Feld wird analog zum Kennzeichen Mahnverfahren aus der F15 Dokumentation belegt.
 * @property string(30) kassenzeichen (Optional) Je nach Mandantenkonfiguration wird im ePayment System das Kassenzeichen ermittelt
 * 	und in der Ergebnisstruktur zurückgeliefert. Sollte das Kassenzeichen bei der Anlieferung mitgegeben werden, muss es eine Länge
 * 	zwischen 2 - 30 alphanumerischen Zeichen haben (Standard 12 Zeichen). Ist für den Bewirtschafter die Verwendung des
 * 	HKR-Prüfziffernverfahren konfiguriert, so muss das Kassenzeichen numerisch sein und die letzte Ziffer muss nach dem
 *  HKR-Prüfziffernverfahren berechnet sein.
 * @property string(30) eShopTransaktionsNr Der Mandant hat die Möglichkeit zu jeder Transaktion eine eindeutige Nr zu übermitteln. (Optional)
 * 	Anhand dieser kann über den Webservice Report überprüft werden, ob die Transaktion im ePayment erfolgreich gespeichert ist.
 * 	Das Feld wird nur zurückgeliefert, wenn es in der Original-Anfrage vorhanden war.
 * 
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright   Copyright (c) 2012 - 2016 B3 IT Systeme GmbH https://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Model_Webservice_Types_BuchungsListe extends Egovs_Paymentbase_Model_Webservice_Types_Abstract
{
	/**
	 * Konstruktor
	 * 
	 * @param float  $betrag                   Betrag
	 * @param string $waehrungskennzeichen     Währungskennzeichen
	 * @param string $faelligkeitsdatum        Datum der Fälligkeit im Format: YYYY-MM-ddTHH:MM:SSZ
	 * @param array  $buchungen                BuchungList
	 * @param string $bewirtschafterNr         Bewirtschafternummer
	 * @param string $kennzeichenMahnverfahren Kennzeichen für Mahnverfahren
	 * @param string $kassenzeichen            Kassenzeichen
	 * @param string $eShopTransaktionsNr      Transaktionsnummer
	 */
	public function __construct(
			$betrag = 0.0,
			$waehrungskennzeichen = 'EUR',
			$faelligkeitsdatum = '1970-01-01T00:00:00Z',
			$buchungen = null,
			$bewirtschafterNr = '',
			$kennzeichenMahnverfahren = '',
			$kassenzeichen = null,
			$eShopTransaktionsNr = null
	) {
        // betrag auf zwei nachkommastellen runden
        $betrag = round($betrag, 2);

        $this->betrag = new SoapVar($betrag, XSD_DECIMAL);
        $this->waehrungskennzeichen = $waehrungskennzeichen;
        $this->faelligkeitsdatum = new SoapVar($faelligkeitsdatum, XSD_DATETIME);
        $this->buchungen = $buchungen;
        $this->bewirtschafterNr = $bewirtschafterNr;
        $this->kennzeichenMahnverfahren = $kennzeichenMahnverfahren;
        
        if ($kassenzeichen !== null ) {
           $this->kassenzeichen = $kassenzeichen;
        }
           
		if (isset($eShopTransaktionsNr)) {
        	$this->EShopTransaktionsNr= $eShopTransaktionsNr;
		}
		parent::__construct();
	}
	
	/**
	 * Liefert die Längenbeschränkungen der Werte
	 *
	 * Längenbeschränkungen:<br/>
	 * <ul>
	 *  <li>waehrungkennzeichen = 3</li>
	 *  <li>kennzeichenMahnverfahren = 5</li>
	 *  <li>bewirtschafterNr = 8</li>
	 *  <li>kassenzeichen = 30</li>
	 *  <li>eShopTransaktionsNr = 30</li>
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
			case 'waehrungkennzeichen':
				$length = 3;
				break;
			case 'kennzeichenMahnverfahren':
				$length = 5;
			case 'bewirtschafterNr':
				$length = 8;
			case 'kassenzeichen':
			case 'eShopTransaktionsNr':
				$length = 30;
				break;
			default:
				$length = 1000;
		}
		
		return $length;
	}
}