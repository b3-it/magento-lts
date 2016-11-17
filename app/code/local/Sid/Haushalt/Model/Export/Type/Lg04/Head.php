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
class Sid_Haushalt_Model_Export_Type_Lg04_Head extends Sid_Haushalt_Model_Export_Type_Lg04_Format
{
	protected $lineType = 'headline';

	
	
	
	
	/**
	 * Lg04 Index 2
	 * In diesem Feld wird die Person angegeben, die den Auftrag erstellt hat. Der Wert muss ein gültiger Benutzer sein, der für den Einkauf verantwortlich ist und dem die entsprechende Rolle zugewiesen wurde.
	 **/
	public function setAccountable($value)
	{
		if(strlen($value) > 25){
			$value = substr($value,0,25);
		}
		$this->setData('accountable',$value);
	}
	
	/**
	 * Lg04 Index 3
	 * Adresse des Lieferanten. Gilt nur für diverse Lieferanten.Andernfalls lassen Sie das Feld leer.
	 **/
	public function setAddress($value)
	{
		if(strlen($value) > 160){
			$value = substr($value,0,160);
		}
		$this->setData('address',$value);
	}
	
	/**
	 * Lg04 Index 7
	 * Dieses Feld wird für die Lieferantennummer verwendet, mit der der Lieferant in AGRESSO Kreditoren erfasst ist.Es muss eine gültige Lieferantennummer verwendet werden.
	 **/
	public function setAparId($value)
	{
		if(strlen($value) > 25){
			$value = substr($value,0,25);
		}
		$this->setData('apar_id',$value);
	}
	
	/**
	 * Lg04 Index 8
	 * AP/AR-Referenz
	 **/
	public function setAparGrId($value)
	{
		if(strlen($value) > 25){
			$value = substr($value,0,25);
		}
		$this->setData('apar_gr_id',$value);
	}
	
	/**
	 * Lg04 Index 9
	 * Name des Lieferanten. Gilt nur für diverse Lieferanten. Andernfalls lassen Sie das Feld leer.
	 **/
	public function setAparName($value)
	{
		if(strlen($value) > 255){
			$value = substr($value,0,255);
		}
		$this->setData('apar_name',$value);
	}
	
	/**
	 * Lg04 Index 12
	 * In diesem Feld wird die Attributnummer für Kategorie 1 angegeben. Dieses Feld kann mit einem gültigen Attribut eingerichtet werden oder leer bleiben. Wenn dieses Feld leer ist, wird der vom Parameter PO_ATT_ID_1 vorgegebene Standardwert verwendet.
	 **/
	public function setAtt1Id($value)
	{
		if(strlen($value) > 4){
			$value = substr($value,0,4);
		}
		$this->setData('att_1_id',$value);
	}
	
	/**
	 * Lg04 Index 13
	 * In diesem Feld wird die Attributnummer für Kategorie 2 angegeben. Dieses Feld kann mit einem gültigen Attribut eingerichtet werden oder leer bleiben. Wenn dieses Feld leer ist, wird der vom Parameter PO_ATT_ID_2 vorgegebene Standardwert verwendet.
	 **/
	public function setAtt2Id($value)
	{
		if(strlen($value) > 4){
			$value = substr($value,0,4);
		}
		$this->setData('att_2_id',$value);
	}
	
	/**
	 * Lg04 Index 14
	 * In diesem Feld wird die Attributnummer für Kategorie 3 angegeben. Dieses Feld kann mit einem gültigen Attribut eingerichtet werden oder leer bleiben. Wenn dieses Feld leer ist, wird der vom Parameter PO_ATT_ID_3 vorgegebene Standardwert verwendet.
	 **/
	public function setAtt3Id($value)
	{
		if(strlen($value) > 4){
			$value = substr($value,0,4);
		}
		$this->setData('att_3_id',$value);
	}
	
	/**
	 * Lg04 Index 15
	 * In diesem Feld wird die Attributnummer für Kategorie 4 angegeben. Dieses Feld kann mit einem gültigen Attribut eingerichtet werden oder leer bleiben. Wenn dieses Feld leer ist, wird der vom Parameter PO_ATT_ID_4 vorgegebene Standardwert verwendet.
	 **/
	public function setAtt4Id($value)
	{
		if(strlen($value) > 4){
			$value = substr($value,0,4);
		}
		$this->setData('att_4_id',$value);
	}
	
	/**
	 * Lg04 Index 16
	 * In diesem Feld wird die Attributnummer für Kategorie 5 angegeben. Dieses Feld kann mit einem gültigen Attribut eingerichtet werden oder leer bleiben. Wenn dieses Feld leer ist, wird der vom Parameter PO_ATT_ID_5 vorgegebene Standardwert verwendet.
	 **/
	public function setAtt5Id($value)
	{
		if(strlen($value) > 4){
			$value = substr($value,0,4);
		}
		$this->setData('att_5_id',$value);
	}
	
	/**
	 * Lg04 Index 17
	 * In diesem Feld wird die Attributnummer für Kategorie 6 angegeben. Dieses Feld kann mit einem gültigen Attribut eingerichtet werden oder leer bleiben. Wenn dieses Feld leer ist, wird der vom Parameter PO_ATT_ID_6 vorgegebene Standardwert verwendet.
	 **/
	public function setAtt6Id($value)
	{
		if(strlen($value) > 4){
			$value = substr($value,0,4);
		}
		$this->setData('att_6_id',$value);
	}
	
	/**
	 * Lg04 Index 18
	 * In diesem Feld wird die Attributnummer für Kategorie 7 angegeben. Dieses Feld kann mit einem gültigen Attribut eingerichtet werden oder leer bleiben. Wenn dieses Feld leer ist, wird der vom Parameter PO_ATT_ID_7 vorgegebene Standardwert verwendet.
	 **/
	public function setAtt7Id($value)
	{
		if(strlen($value) > 4){
			$value = substr($value,0,4);
		}
		$this->setData('att_7_id',$value);
	}
	
	/**
	 * Lg04 Index 19
	 * Bankkontonummer des Lieferanten. Gilt nur für diverse Lieferanten.Andernfalls lassen Sie das Feld leer.
	 **/
	public function setBankAccount($value)
	{
		if(strlen($value) > 35){
			$value = substr($value,0,35);
		}
		$this->setData('bank_account',$value);
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
	 * Lg04 Index 22
	 * Das Unternehmen des betreffenden Belegs. Das Feld kann leer bleiben.
	 **/
	public function setClientRef($value)
	{
		if(strlen($value) > 25){
			$value = substr($value,0,25);
		}
		$this->setData('client_ref',$value);
	}
	
	/**
	 * Lg04 Index 23
	 * In diesem Feld wird das Datum der Auftragsbestätigung angegeben. Wenn der Auftrag noch nicht bestätigt wurde, muss dieses Feld leer bleiben.
	 **/
	public function setConfirmDate($value)
	{
		if(strlen($value) > 8){
			$value = substr($value,0,8);
		}
		$this->setData('confirm_date',$value);
	}
	
	/**
	 * Lg04 Index 24
	 * Die Art der anzuwendenden Rechnungskontrolle. Wenn dieses Feld leer ist, wird der Standardwert abgerufen aus den Systemparametern DEF_OVERRUN_PCT_V, DEF_OVERRUN_PCT_Q oder DEF_OVERRUN_PCT_A.
	 **/
	public function setControl($value)
	{
		if(strlen($value) > 1){
			$value = substr($value,0,1);
		}
		$this->setData('control',$value);
	}
	
	/**
	 * Lg04 Index 27
	 * Dieses Feld enthält eine Beschreibung der Lieferart. Wenn dieses Feld leer ist, wird die Beschreibung für deliv_method verwendet.
	 **/
	public function setDelMetDescr($value)
	{
		if(strlen($value) > 255){
			$value = substr($value,0,255);
		}
		$this->setData('del_met_descr',$value);
	}
	
	/**
	 * Lg04 Index 28
	 * Dieses Feld enthält eine Beschreibung der Lieferbedingungen. Wenn dieses Feld leer ist, wird die Beschreibung für deliv_terms verwendet.
	 **/
	public function setDelTermDescr($value)
	{
		if(strlen($value) > 255){
			$value = substr($value,0,255);
		}
		$this->setData('del_term_descr',$value);
	}
	
	/**
	 * Lg04 Index 29
	 * Dieses Feld enthält die Lieferadresse. Format: drei Zeilen mit maximal je 40 Zeichen.
	 **/
	public function setDelivAddr($value)
	{
		if(strlen($value) > 255){
			$value = substr($value,0,255);
		}
		$this->setData('deliv_addr',$value);
	}
	
	/**
	 * Lg04 Index 30
	 * Dieses Feld enthält freien Text und kann leer bleiben.
	 **/
	public function setDelivAttention($value)
	{
		if(strlen($value) > 50){
			$value = substr($value,0,50);
		}
		$this->setData('deliv_attention',$value);
	}
	
	/**
	 * Lg04 Index 31
	 * Nicht verwendet bei Bestellungen.
	 **/
	public function setDelivCountr($value)
	{
		if(strlen($value) > 25){
			$value = substr($value,0,25);
		}
		$this->setData('deliv_countr',$value);
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
	 * Lg04 Index 33
	 * Dieses Feld enthält die Lieferart. Der eingegebene Wert muss ein für das Attribut LIEFMETH (D3) gültiger Attributwert sein. Wenn das Feld leer ist, wird die Methode anhand einer Lieferantenrelation abgerufen oder, wenn keine Relation dieser Art definiert wurde, aus dem Systemparameter DEF_PO_DELIV_MET.
	 **/
	public function setDelivMethod($value)
	{
		if(strlen($value) > 25){
			$value = substr($value,0,25);
		}
		$this->setData('deliv_method',$value);
	}
	
	/**
	 * Lg04 Index 34
	 * Dieses Feld enthält die Lieferbedingungen. Der eingegebene Wert muss ein für das Attribut LIEFBED (D2) gültiger Attributwert sein. Wenn das Feld leer ist, werden die Bedingungen anhand einer Lieferantenrelation abgerufen oder, wenn keine Relation dieser Art definiert wurde, aus dem Systemparameter DEF_PO_DELIV_TERM.
	 **/
	public function setDelivTerms($value)
	{
		if(strlen($value) > 25){
			$value = substr($value,0,25);
		}
		$this->setData('deliv_terms',$value);
	}
	
	/**
	 * Lg04 Index 42
	 *
	 **/
	public function setDimValue1($value)
	{
		if(strlen($value) > 25){
			$value = substr($value,0,25);
		}
		$this->setData('dim_value_1',$value);
	}
	
	/**
	 * Lg04 Index 43
	 * Dieses Feld enthält einen Wert für die Kategorie 2 des Auftragskopfs. Dieser wird anhand des in att_id_2 definierten Attributs geprüft.Dieses Feld kann leer bleiben.
	 **/
	public function setDimValue2($value)
	{
		if(strlen($value) > 25){
			$value = substr($value,0,25);
		}
		$this->setData('dim_value_2',$value);
	}
	
	/**
	 * Lg04 Index 44
	 * Dieses Feld enthält einen Wert für die Kategorie 3 des Auftragskopfs. Dieser wird anhand des in att_id_3 definierten Attributs geprüft.Dieses Feld kann leer bleiben.
	 **/
	public function setDimValue3($value)
	{
		if(strlen($value) > 25){
			$value = substr($value,0,25);
		}
		$this->setData('dim_value_3',$value);
	}
	
	/**
	 * Lg04 Index 45
	 * Dieses Feld enthält einen Wert für die Kategorie 4 des Auftragskopfs. Dieser wird anhand des in att_id_4 definierten Attributs geprüft.Dieses Feld kann leer bleiben.
	 **/
	public function setDimValue4($value)
	{
		if(strlen($value) > 25){
			$value = substr($value,0,25);
		}
		$this->setData('dim_value_4',$value);
	}
	
	/**
	 * Lg04 Index 46
	 * Dieses Feld enthält einen Wert für die Kategorie 5 des Auftragskopfs. Dieser wird anhand des in att_id_5 definierten Attributs geprüft.Dieses Feld kann leer bleiben.
	 **/
	public function setDimValue5($value)
	{
		if(strlen($value) > 25){
			$value = substr($value,0,25);
		}
		$this->setData('dim_value_5',$value);
	}
	
	/**
	 * Lg04 Index 47
	 * Dieses Feld enthält einen Wert für die Kategorie 6 des Auftragskopfs. Dieser wird anhand des in att_id_6 definierten Attributs geprüft.Dieses Feld kann leer bleiben.
	 **/
	public function setDimValue6($value)
	{
		if(strlen($value) > 25){
			$value = substr($value,0,25);
		}
		$this->setData('dim_value_6',$value);
	}
	
	/**
	 * Lg04 Index 48
	 * Dieses Feld enthält einen Wert für die Kategorie 7 des Auftragskopfs. Dieser wird anhand des in att_id_7 definierten Attributs geprüft.Dieses Feld kann leer bleiben.
	 **/
	public function setDimValue7($value)
	{
		if(strlen($value) > 25){
			$value = substr($value,0,25);
		}
		$this->setData('dim_value_7',$value);
	}
	
	/**
	 * Lg04 Index 51
	 * EAN-Code.
	 **/
	public function setEan($value)
	{
		if(strlen($value) > 50){
			$value = substr($value,0,50);
		}
		$this->setData('ean',$value);
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
	 * Lg04 Index 53
	 * Dieses Feld enthält eine externe Referenz für den Auftrag und wird nicht geprüft.
	 **/
	public function setExtOrdRef($value)
	{
		if(strlen($value) > 100){
			$value = substr($value,0,100);
		}
		$this->setData('ext_ord_ref',$value);
	}
	
	/**
	 * Lg04 Index 54
	 * Nicht verwendet für Bestellungen.Lassen Sie das Feld leer.
	 **/
	public function setIntruleId($value)
	{
		if(strlen($value) > 25){
			$value = substr($value,0,25);
		}
		$this->setData('intrule_id',$value);
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
	 * Lg04 Index 57
	 * Dieses Feld enthält Text, der oben auf den Auftrag gedruckt wird. Wenn das Feld leer ist, wird der Standardtext anhand des Systemparameters DEF_PO_LONG_INFO1 abgerufen.
	 **/
	public function setLongInfo1($value)
	{
		if(strlen($value) > 120){
			$value = substr($value,0,120);
		}
		$this->setData('long_info1',$value);
	}
	
	/**
	 * Lg04 Index 58
	 * Dieses Feld enthält Text, der oben auf den Auftrag gedruckt wird. Wenn das Feld leer ist, wird der Standardtext anhand des Systemparameters DEF_PO_LONG_INFO2 abgerufen.
	 **/
	public function setLongInfo2($value)
	{
		if(strlen($value) > 120){
			$value = substr($value,0,120);
		}
		$this->setData('long_info2',$value);
	}
	
	/**
	 * Lg04 Index 60
	 * Dieses Feld enthält die Lieferantennummer für den zu fakturierenden Lieferanten. Wenn dieses Feld leer ist, wird die Firma verwendet.
	 **/
	public function setMainAparId($value)
	{
		if(strlen($value) > 25){
			$value = substr($value,0,25);
		}
		$this->setData('main_apar_id',$value);
	}
	
	/**
	 * Lg04 Index 61
	 * Bestimmung für eine zusätzliche Lieferadresse.Kann leer bleiben.
	 **/
	public function setMarkAttention($value)
	{
		if(strlen($value) > 50){
			$value = substr($value,0,50);
		}
		$this->setData('mark_attention',$value);
	}
	
	/**
	 * Lg04 Index 62
	 * Länderschlüssel für Bestimmungsadresse. Muss ein gültiger Länderschlüssel sein.
	 **/
	public function setMarkCtryCd($value)
	{
		if(strlen($value) > 25){
			$value = substr($value,0,25);
		}
		$this->setData('mark_ctry_cd',$value);
	}
	
	/**
	 * Lg04 Index 63
	 * Bestimmungsadresse für Versand der Bestellung. Freier Text. Kann leer bleiben.
	 **/
	public function setMarkings($value)
	{
		if(strlen($value) > 255){
			$value = substr($value,0,255);
		}
		$this->setData('markings',$value);
	}
	
	/**
	 * Lg04 Index 64
	 * Dieses Feld kann verwendet werden, um zusätzliche Datumsinformationen einzugeben. Es kann auch leer bleiben.
	 **/
	public function setObsDate($value)
	{
		if(strlen($value) > 8){
			$value = substr($value,0,8);
		}
		$this->setData('obs_date',$value);
	}
	
	/**
	 * Lg04 Index 65
	 * Dieses Feld enthält das Auftragsdatum. Wenn dieses Feld leer ist, wird das aktuelle Datum verwendet.
	 **/
	public function setOrderDate($value)
	{
		if(strlen($value) > 8){
			$value = substr($value,0,8);
		}
		$this->setData('order_date',$value);
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
	 * Lg04 Index 67
	 * Dieses Feld enthält die Auftragsart. Informationen zu den gültigen Werten und zur Verarbeitung dieser Werte finden Sie in der Dokumentation zu AGRESSO Einkauf. Die Auftragsart kann durch einen Listenparameter gesteuert werden. Wenn dieses Feld leer ist, wird der durch den Systemparameter DEF_TREAT_PURCHASE vorgegebene Standardwert verwendet.
	 **/
	public function setOrderType($value)
	{
		if(strlen($value) > 2){
			$value = substr($value,0,2);
		}
		$this->setData('order_type',$value);
	}
	
	/**
	 * Lg04 Index 68
	 * Dieses Feld enthält die Zahlungsart. Das Feld kann leer bleiben.
	 **/
	public function setPayMethod($value)
	{
		if(strlen($value) > 2){
			$value = substr($value,0,2);
		}
		$this->setData('pay_method',$value);
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
	 * Lg04 Index 71
	 * Ort des Lieferanten. Gilt nur für diverse Lieferanten. Andernfalls lassen Sie das Feld leer.
	 **/
	public function setPlace($value)
	{
		if(strlen($value) > 40){
			$value = substr($value,0,40);
		}
		$this->setData('place',$value);
	}
	
	/**
	 * Lg04 Index 72
	 * Kreis des Lieferanten. Gilt nur für diverse Lieferanten.Andernfalls lassen Sie das Feld leer.
	 **/
	public function setProvince($value)
	{
		if(strlen($value) > 40){
			$value = substr($value,0,40);
		}
		$this->setData('province',$value);
	}
	
	/**
	 * Lg04 Index 74
	 * In diesem Feld wird die für die Auftragsfreigabe verantwortliche Person angegeben. Der Wert muss ein gültiger Benutzer sein, der für den Einkauf verantwortlich ist und dem die entsprechende Rolle zugewiesen wurde.
	 **/
	public function setResponsible($value)
	{
		if(strlen($value) > 25){
			$value = substr($value,0,25);
		}
		$this->setData('responsible',$value);
	}
	
	/**
	 * Lg04 Index 75
	 * In diesem Feld wird die für die Erstellung des Auftrags verantwortliche Person angegeben. Der Wert muss ein gültiger Benutzer sein, der bei Einkäufen als Anforderer fungiert und dem die entsprechende Rolle zugewiesen ist.
	 **/
	public function setResponsible2($value)
	{
		if(strlen($value) > 25){
			$value = substr($value,0,25);
		}
		$this->setData('responsible2',$value);
	}
	
	/**
	 * Lg04 Index 77
	 * Laufende Nummer der betreffenden Belegnummer.Das Feld kann leer bleiben.
	 **/
	public function setSequenceRef($value)
	{
		if(strlen($value) > 8){
			$value = substr($value,0,8);
		}
		$this->setData('sequence_ref',$value);
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
	 * Lg04 Index 85
	 * Zahlungsbedingungen. Dabei muss es sich um einen gültigen Wert handeln. Wenn dieses Feld leer ist, werden die Bedingungen aus der Lieferantentabelle verwendet.
	 **/
	public function setTermsId($value)
	{
		if(strlen($value) > 25){
			$value = substr($value,0,25);
		}
		$this->setData('terms_id',$value);
	}
	
	/**
	 * Lg04 Index 86
	 * Freitext 1. Keine Kontrolle, das Feld kann leer bleiben.
	 **/
	public function setText1($value)
	{
		if(strlen($value) > 100){
			$value = substr($value,0,100);
		}
		$this->setData('text1',$value);
	}
	
	/**
	 * Lg04 Index 87
	 * Freitext 2. Keine Kontrolle, das Feld kann leer bleiben.
	 **/
	public function setText2($value)
	{
		if(strlen($value) > 100){
			$value = substr($value,0,100);
		}
		$this->setData('text2',$value);
	}
	
	/**
	 * Lg04 Index 88
	 * Freitext 3. Keine Kontrolle, das Feld kann leer bleiben.
	 **/
	public function setText3($value)
	{
		if(strlen($value) > 100){
			$value = substr($value,0,100);
		}
		$this->setData('text3',$value);
	}
	
	/**
	 * Lg04 Index 89
	 * Freitext 4. Keine Kontrolle, das Feld kann leer bleiben.
	 **/
	public function setText4($value)
	{
		if(strlen($value) > 100){
			$value = substr($value,0,100);
		}
		$this->setData('text4',$value);
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
	 * Lg04 Index 95
	 * Die Nummer der betreffenden Rechnung. Das Feld kann leer gelassen werden.
	 **/
	public function setVoucherRef($value)
	{
		if(strlen($value) > 15){
			$value = substr($value,0,15);
		}
		$this->setData('voucher_ref',$value);
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
	 * Lg04 Index 98
	 * Postleitzahl des Lieferanten. Gilt nur für diverse Lieferanten.Andernfalls lassen Sie das Feld leer.
	 **/
	public function setZipCode($value)
	{
		if(strlen($value) > 15){
			$value = substr($value,0,15);
		}
		$this->setData('zip_code',$value);
	}
	
}