<?php

/**
 *  Exportklasse für Haushalt
 *  @category Sid
 *  @package  Sid_Haushalt
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_Haushalt_Model_Export_Type_Lg04_Pos extends Sid_Haushalt_Model_Export_Type_Lg04_Format
{
	
	protected $lineType = 'posline';
	
	
	

	/**
	 * Lg04 Index 1
	 * Dieses Feld gibt das zu verwendende Kosten-/Bestandskonto an. Es muss sich hierbei um ein gültiges Konto handeln. Wenn dieses Feld leer bleibt, wird das Konto verwendet, das für diese Artikelgruppe definiert wurde.
	 **/
	public function setAccount($value)
	{
		if(strlen($value) > 25){
			$value = substr($value,0,25);
		}
		$this->setData('account',$value);
	}
	
	/**
	 * Lg04 Index 4
	 * Ein Schlüssel, der angibt, wie der Betrag auf mehrere Perioden aufgeteilt wird.Das Feld kann leer bleiben.
	 **/
	public function setAllocationKey($value)
	{
		if(strlen($value) > 2){
			$value = substr($value,0,2);
		}
		$this->setData('allocation_key',$value);
	}
	
	/**
	 * Lg04 Index 5
	 * In diesem Feld wird der Nettogesamtbetrag für die Auftragszeile in der Hauswährung angegeben. Diese Angabe wird verwendet, wenn amount_set auf 1 gesetzt ist. Andernfalls wird die Preistabelle verwendet (*100 wird eingegeben).
	 **/
	public function setAmount($value)
	{
		if(strlen($value) > 20){
			$value = substr($value,0,20);
		}
		$this->setData('amount',$value);
	}
	
	/**
	 * Lg04 Index 6
	 * In diesem Feld wird der Nettogesamtbetrag für jede Auftragszeile in der Hauswährung angegeben. Diese Angabe wird verwendet, wenn amount_set auf 1 gesetzt ist. Andernfalls wird die Preistabelle verwendet (*100 wird eingegeben). Wenn in der Datei ein Währungsbetrag angegeben ist, dann wird der Betrag aus dem Währungskurs berechnet, der in der mandantenspezifischen Tabelle für die Wechselkurse angegeben ist.
	 **/
	public function setAmountSet($value)
	{
		if(strlen($value) > 1){
			$value = substr($value,0,1);
		}
		$this->setData('amount_set',$value);
	}
	
	/**
	 * Lg04 Index 10
	 * Dieses Feld enthält eine kurze Beschreibung des Artikels. Wenn dieses Feld leer ist, wird die in der Artikeltabelle von Agresso angegebene Beschreibung verwendet.
	 **/
	public function setArtDescr($value)
	{
		if(strlen($value) > 255){
			$value = substr($value,0,255);
		}
		$this->setData('art_descr',$value);
	}
	
	/**
	 * Lg04 Index 11
	 * In diesem Feld wird der Artikelschlüssel angegeben. Bei dem hier eingegebenen Schlüssel muss es sich um einen in Agresso definierten gültigen Artikelschlüssel handeln. Dieser Artikelschlüssel kann durch eine Relation automatisch ausgelöst werden.
	 **/
	public function setArticle($value)
	{
		if(strlen($value) > 25){
			$value = substr($value,0,25);
		}
		$this->setData('article',$value);
	}
	
	/**
	 * Lg04 Index 20
	 * In diesem Feld wird die Batch-Nummer für die Übertragung angegeben.
	 **/
	public function setBatchId($value)
	{
		if(strlen($value) > 25){
			$value = substr($value,0,25);
		}
		$this->setData('batch_id',$value);
	}
	
	/**
	 * Lg04 Index 21
	 * In diesem Feld wird der Firmenschlüssel angegeben.
	 **/
	public function setClient($value)
	{
		if(strlen($value) > 25){
			$value = substr($value,0,25);
		}
		$this->setData('client',$value);
	}
	
	/**
	 * Lg04 Index 25
	 * Dieses Feld listet den Nettogesamtbetrag für die Auftragszeile in der Fremdwährung auf. Diese Angabe wird verwendet, wenn amount_set auf 1 gesetzt ist. Andernfalls wird die Preistabelle verwendet (*100 wird eingegeben). Wenn in der Datei ein Währungsbetrag angegeben ist, dann wird der Betrag aus dem Währungskurs berechnet, der in der mandantenspezifischen Tabelle für die Wechselkurse angegeben ist.
	 **/
	public function setCurAmount($value)
	{
		if(strlen($value) > 20){
			$value = substr($value,0,20);
		}
		$this->setData('cur_amount',$value);
	}
	
	/**
	 * Lg04 Index 26
	 * In diesem Feld wird die Auftragswährung angegeben. Der hier eingegebene Wert wird anhand der für Lieferanten definierten festen Währungen geprüft. Die Währung wird anhand der Tabellen für Währungsschlüssel und Währungskurse geprüft.
	 **/
	public function setCurrency($value)
	{
		if(strlen($value) > 25){
			$value = substr($value,0,25);
		}
		$this->setData('currency',$value);
	}
	
	/**
	 * Lg04 Index 32
	 * Dieses Feld enthält das Lieferdatum. Wenn dieses Feld leer ist, wird das Auftragsdatum verwendet.
	 **/
	public function setDelivDate($value)
	{
		if(strlen($value) > 8){
			$value = substr($value,0,8);
		}
		$this->setData('deliv_date',$value);
	}
	
	/**
	 * Lg04 Index 35
	 * "Dieses Feld enthält einen Wert für die Kontierungskategorie 1. Dieser Wert wird anhand der Kontierungsregel geprüft. Standardwerte werden aus folgenden Quellen abgerufen:Auftragskopf, wenn die Attribut-ID übereinstimmtArtikelrelation, falls definiert"
	 **/
	public function setDim1($value)
	{
		if(strlen($value) > 25){
			$value = substr($value,0,25);
		}
		$this->setData('dim_1',$value);
	}
	
	/**
	 * Lg04 Index 36
	 * "Dieses Feld enthält einen Wert für die Kontierungskategorie 2. Dieser Wert wird anhand der Kontierungsregel geprüft. Standardwerte werden aus folgenden Quellen abgerufen:Auftragskopf, wenn die Attribut-ID übereinstimmtArtikelrelation, falls definiert"
	 **/
	public function setDim2($value)
	{
		if(strlen($value) > 25){
			$value = substr($value,0,25);
		}
		$this->setData('dim_2',$value);
	}
	
	/**
	 * Lg04 Index 37
	 * "Dieses Feld enthält einen Wert für die Kontierungskategorie 3. Dieser Wert wird anhand der Kontierungsregel geprüft. Standardwerte werden aus folgenden Quellen abgerufen:Auftragskopf, wenn die Attribut-ID übereinstimmtArtikelrelation, falls definiert"
	 **/
	public function setDim3($value)
	{
		if(strlen($value) > 25){
			$value = substr($value,0,25);
		}
		$this->setData('dim_3',$value);
	}
	
	/**
	 * Lg04 Index 38
	 * "Dieses Feld enthält einen Wert für die Kontierungskategorie 4. Dieser Wert wird anhand der Kontierungsregel geprüft. Standardwerte werden aus folgenden Quellen abgerufen:Auftragskopf, wenn die Attribut-ID übereinstimmtArtikelrelation, falls definiert"
	 **/
	public function setDim4($value)
	{
		if(strlen($value) > 25){
			$value = substr($value,0,25);
		}
		$this->setData('dim_4',$value);
	}
	
	/**
	 * Lg04 Index 39
	 * "Dieses Feld enthält einen Wert für die Kontierungskategorie 5. Dieser Wert wird anhand der Kontierungsregel geprüft. Standardwerte werden aus folgenden Quellen abgerufen:Auftragskopf, wenn die Attribut-ID übereinstimmtArtikelrelation, falls definiert"
	 **/
	public function setDim5($value)
	{
		if(strlen($value) > 25){
			$value = substr($value,0,25);
		}
		$this->setData('dim_5',$value);
	}
	
	/**
	 * Lg04 Index 40
	 * "Dieses Feld enthält einen Wert für die Kontierungskategorie 6. Dieser Wert wird anhand der Kontierungsregel geprüft. Standardwerte werden aus folgenden Quellen abgerufen:Auftragskopf, wenn die Attribut-ID übereinstimmtArtikelrelation, falls definiert"
	 **/
	public function setDim6($value)
	{
		if(strlen($value) > 25){
			$value = substr($value,0,25);
		}
		$this->setData('dim_6',$value);
	}
	
	/**
	 * Lg04 Index 41
	 * "Dieses Feld enthält einen Wert für die Kontierungskategorie 7. Dieser Wert wird anhand der Kontierungsregel geprüft. Standardwerte werden aus folgenden Quellen abgerufen:Auftragskopf, wenn die Attribut-ID übereinstimmtArtikelrelation, falls definiert"
	 **/
	public function setDim7($value)
	{
		if(strlen($value) > 25){
			$value = substr($value,0,25);
		}
		$this->setData('dim_7',$value);
	}
	
	/**
	 * Lg04 Index 49
	 * In diesem Feld wird der Rabatt für die Auftragszeile angegeben. Der Wert muss mit 100 multipliziert werden. (Beispiel: 10 muss als 1000 eingeben werden.) Wenn amount_set auf 0 gesetzt ist, wird die Rabattmatrix von Agresso verwendet.
	 **/
	public function setDiscount($value)
	{
		if(strlen($value) > 20){
			$value = substr($value,0,20);
		}
		$this->setData('discount',$value);
	}
	
	/**
	 * Lg04 Index 50
	 * Dieses Feld enthält den prozentualen Rabatt für die Auftragszeile. Der Wert muss mit 100 multipliziert werden. (Beispiel: 5,5 % muss als 550 eingeben werden.) Wenn amount_set auf 0 gesetzt ist, wird die Rabattmatrix von Agresso verwendet.
	 **/
	public function setDiscPercent($value)
	{
		if(strlen($value) > 20){
			$value = substr($value,0,20);
		}
		$this->setData('disc_percent',$value);
	}
	
	/**
	 * Lg04 Index 52
	 * Dieses Feld wird nicht verwendet und muss leer bleiben.
	 **/
	public function setExchRate($value)
	{
		if(strlen($value) > 20){
			$value = substr($value,0,20);
		}
		$this->setData('exch_rate',$value);
	}
	
	/**
	 * Lg04 Index 55
	 * Dieses Feld enthält die Zeilen-/Positionsnummer. Artikel-/Textzeilen müssen Werte im Bereich von 1 bis 9999 aufweisen, und Auftragskopfzeilen müssen den Wert 0 aufweisen.
	 **/
	public function setLineNo($value)
	{
		if(strlen($value) > 4){
			$value = substr($value,0,4);
		}
		$this->setData('line_no',$value);
	}
	
	/**
	 * Lg04 Index 56
	 * Dieses Feld enthält den standardmäßigen Lagerplatz für Wareneingänge. Dabei muss es sich um einen gültigen Lagerplatz des ausgewählten Lagers handeln.
	 **/
	public function setLocation($value)
	{
		if(strlen($value) > 12){
			$value = substr($value,0,12);
		}
		$this->setData('location',$value);
	}
	
	/**
	 * Lg04 Index 59
	 * Dieses Feld enthält die standardmäßige Charge für Wareneingänge. Dabei muss es sich um eine gültige Charge für den ausgewählten Artikel handeln. Dieser Wert ist nur für Artikel relevant, die in Chargen verwaltet werden.
	 **/
	public function setLot($value)
	{
		if(strlen($value) > 10){
			$value = substr($value,0,10);
		}
		$this->setData('lot',$value);
	}
	
	/**
	 * Lg04 Index 66
	 * Dieses Feld enthält die Auftragsnummer, die im Bereich von x bis n liegen muss (n>=0). Anhand eines Listenparameters wird gesteuert, ob diese Auftragsnummer beibehalten wird oder eine von Agresso zugewiesene Nummer verwendet wird. Wenn die Auftragsnummer beibehalten werden soll, darf sie noch nicht verwendet worden sein.
	 **/
	public function setOrderId($value)
	{
		if(strlen($value) > 15){
			$value = substr($value,0,15);
		}
		$this->setData('order_id',$value);
	}
	
	/**
	 * Lg04 Index 69
	 * Nicht verwendet für Bestellungen.Lassen Sie das Feld leer.
	 **/
	public function setPayTempId($value)
	{
		if(strlen($value) > 4){
			$value = substr($value,0,4);
		}
		$this->setData('pay_temp_id',$value);
	}
	
	/**
	 * Lg04 Index 70
	 * In diesem Feld wird die Auftragsperiode angegeben. Der hier eingegebene Wert kann durch einen Berichtsparameter überschrieben werden.
	 **/
	public function setPeriod($value)
	{
		if(strlen($value) > 6){
			$value = substr($value,0,6);
		}
		$this->setData('period',$value);
	}
	
	/**
	 * Lg04 Index 73
	 * Dieses Feld kann einen Relationswert für einen Artikel enthalten. Hiermit wird die Verwendung der Artikelnummern der Übernahmedatei anstelle des Artikelschlüssels ausgelöst, sofern diese Werte unterschiedlich sind. Die verwendete Relation muss beim Anfordern des Serverprozesses als Parameter angegeben werden.
	 **/
	public function setRelValue($value)
	{
		if(strlen($value) > 25){
			$value = substr($value,0,25);
		}
		$this->setData('rel_value',$value);
	}
	
	/**
	 * Lg04 Index 76
	 * "Laufende Nummer, die als Zeilennummer der Textdetails verwendet wird.1-n  Fortlaufend nummerierte Textzeile für den Artikel.0  Artikelzeile."
	 **/
	public function setSequenceNo($value)
	{
		if(strlen($value) > 8){
			$value = substr($value,0,8);
		}
		$this->setData('sequence_no',$value);
	}
	
	/**
	 * Lg04 Index 78
	 * Die Seriennummer. Dieser Wert ist nur für Artikel relevant, die mit Seriennummern verwaltet werden.Das Feld kann leer bleiben.
	 **/
	public function setSerialNo($value)
	{
		if(strlen($value) > 20){
			$value = substr($value,0,20);
		}
		$this->setData('serial_no',$value);
	}
	
	/**
	 * Lg04 Index 80
	 * "Status des Auftragskopfs bzw. der Auftragspositionen. Wenn dieses Feld leer ist, wird N verwendet.N NormalP Geparkt"
	 **/
	public function setStatus($value)
	{
		if(strlen($value) > 1){
			$value = substr($value,0,1);
		}
		$this->setData('status',$value);
	}
	
	/**
	 * Lg04 Index 82
	 * Steuerschlüssel. Es muss sich um einen gültigen Steuerschlüssel für das Konto und die Bestellung handeln (siehe Verkaufsaufträge). Wenn dieses Feld leer ist, wird der Standardwert aus der Relation für Artikel/Kontierungsregel abgerufen.
	 **/
	public function setTaxCode($value)
	{
		if(strlen($value) > 25){
			$value = substr($value,0,25);
		}
		$this->setData('tax_code',$value);
	}
	
	/**
	 * Lg04 Index 83
	 * Steuersystem. Es muss sich um ein im System definiertes gültiges Steuersystem handeln.Das Feld kann leer gelassen werden.
	 **/
	public function setTaxSystem($value)
	{
		if(strlen($value) > 25){
			$value = substr($value,0,25);
		}
		$this->setData('tax_system',$value);
	}
	
	/**
	 * Lg04 Index 84
	 * Kontierungsvorlage. Wenn eine Vorlage verwendet wird, muss dieses Feld den Schlüssel dieser Vorlage enthalten.Das Feld kann leer gelassen werden.
	 **/
	public function setTemplateId($value)
	{
		if(strlen($value) > 8){
			$value = substr($value,0,8);
		}
		$this->setData('template_id',$value);
	}
	
	/**
	 * Lg04 Index 90
	 * Die Belegart. Für Bestellungen muss hier der Wert 41 angegeben werden.
	 **/
	public function setTransType($value)
	{
		if(strlen($value) > 2){
			$value = substr($value,0,2);
		}
		$this->setData('trans_type',$value);
	}
	
	/**
	 * Lg04 Index 91
	 * Einheitenschlüssel, gültig für den Artikel. Wenn dieses Feld leer ist, wird die Standardeinheit des Artikels verwendet.
	 **/
	public function setUnitCode($value)
	{
		if(strlen($value) > 3){
			$value = substr($value,0,3);
		}
		$this->setData('unit_code',$value);
	}
	
	/**
	 * Lg04 Index 92
	 * Beschreibung der Einheit. Wenn dieses Feld leer ist, wird standardmäßig die Beschreibung der Einheit verwendet.
	 **/
	public function setUnitDescr($value)
	{
		if(strlen($value) > 255){
			$value = substr($value,0,255);
		}
		$this->setData('unit_descr',$value);
	}
	
	/**
	 * Lg04 Index 93
	 * Preis pro Einheit. Wenn dieser Wert leer gelassen wird,???
	 **/
	public function setUnitPrice($value)
	{
		if(strlen($value) > 20){
			$value = substr($value,0,20);
		}
		$this->setData('unit_price',$value);
	}
	
	/**
	 * Lg04 Index 94
	 * Anzahl der Einheiten. Wenn dieses Feld leer ist, wird der Standardwert 1,0 verwendet. (Der Wert muss mit 100 multipliziert werden, beispielsweise wird 2,5 als 250 eingegeben.)
	 **/
	public function setValue1($value)
	{
		if(strlen($value) > 20){
			$value = substr($value,0,20);
		}
		$this->setData('value_1',$value);
	}
	
	/**
	 * Lg04 Index 96
	 * Nummernart für die Bestellung. Dieser Wert wird verwendet, wenn der Serverprozess eine Auftragsnummer zuweist.Dieser Wert kann als Berichtsparameter eingegeben werden.
	 **/
	public function setVoucherType($value)
	{
		if(strlen($value) > 25){
			$value = substr($value,0,25);
		}
		$this->setData('voucher_type',$value);
	}
	
	/**
	 * Lg04 Index 97
	 * Das Lager, dem die Artikel hinzugefügt bzw. entnommen werden (abhängig von der Bestellart).Es muss sich hierbei um ein gültiges Lager handeln.
	 **/
	public function setWarehouse($value)
	{
		if(strlen($value) > 25){
			$value = substr($value,0,25);
		}
		$this->setData('warehouse',$value);
	}
	
}