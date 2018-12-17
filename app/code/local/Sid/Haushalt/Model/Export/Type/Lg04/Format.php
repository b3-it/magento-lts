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
class Sid_Haushalt_Model_Export_Type_Lg04_Format extends Sid_Haushalt_Model_Export_Abstract
{
	protected $lineType = '';
	
	private $_FieldsAsAssoc = null;
	
	
	/**
	 * Gibt die Daten des Objektes als LG04 Zeile zurück
	 * @return NULL[]|string[]
	 */
	public function getFormatedData()
	{
	
		$result = array();
		foreach($this->getFields() as $idx => $field)
		{
			if($this->getData($field['name']) != null)
			{
				$result[] = $this->getFormatedValue($idx,$this->getData($field['name']),$this->lineType);
			}else{
				$result[] = $this->getFormatedValue($idx,"");
			}
			
		}
		
	
		return $result;
	}
	
	
	
	
	private function getFormatedValue($idx, $value, $satzType = null)
	{
		$def  = $this->getField($idx);
		if($satzType != null){
			if($def[$satzType] == false){
				$value = "";
			}
		}
		$value = trim($value);
		$value = substr($value,0,$def['laenge']);
		while(strlen($value) < $def['laenge']){
			$value .= ' ';
		}
	
		return $value;
	}
	
	private function getField($idx)
	{
		if($this->_FieldsAsAssoc == null)
		{
			$this->getFields();
		}
	
		return $this->_FieldsAsAssoc[$idx];
	}
	
	
	private function getFields()
	{
		if($this->_FieldsAsAssoc == null)
		{
			$this->_FieldsAsAssoc = array();
			$head = array('nr','name','art','headline','posline','textline','laenge','von','bis','text');
            $iMax = count($head);
			foreach($this->_getFieldDescription() as  $idx => $field)
			{
				$line = array();
				for($i =0; $i < $iMax; $i++)
				{
					$line[$head[$i]] = $field[$i];
				}
				$this->_FieldsAsAssoc[$idx] = $line;
			}
		}
	
		return $this->_FieldsAsAssoc;
	}
	
	private function _getFieldDescription()
	{
		$lg04 = array() ;
	
		//$lg04[Nr] = array('Nr','Interner Name','Art',false,false,false,'Länge','Von','Bis','Text');
		$lg04[1] = array('1','account','c25',false,true,false,'25','1','25','Dieses Feld gibt das zu verwendende Kosten-/Bestandskonto an. Es muss sich hierbei um ein gültiges Konto handeln. Wenn dieses Feld leer bleibt, wird das Konto verwendet, das für diese Artikelgruppe definiert wurde.');
		$lg04[2] = array('2','accountable','c25',true,false,false,'25','26','50','In diesem Feld wird die Person angegeben, die den Auftrag erstellt hat. Der Wert muss ein gültiger Benutzer sein, der für den Einkauf verantwortlich ist und dem die entsprechende Rolle zugewiesen wurde.');
		$lg04[3] = array('3','address','c160',true,false,false,'160','51','210','Adresse des Lieferanten. Gilt nur für diverse Lieferanten.Andernfalls lassen Sie das Feld leer.');
		$lg04[4] = array('4','allocation_key','i2',false,true,false,'2','211','212','Ein Schlüssel, der angibt, wie der Betrag auf mehrere Perioden aufgeteilt wird.Das Feld kann leer bleiben.');
		$lg04[5] = array('5','amount','money',false,true,false,'20','213','232','In diesem Feld wird der Nettogesamtbetrag für die Auftragszeile in der Hauswährung angegeben. Diese Angabe wird verwendet, wenn amount_set auf 1 gesetzt ist. Andernfalls wird die Preistabelle verwendet (*100 wird eingegeben).');
		$lg04[6] = array('6','amount_set','i1',false,true,false,'1','233','233','In diesem Feld wird der Nettogesamtbetrag für jede Auftragszeile in der Hauswährung angegeben. Diese Angabe wird verwendet, wenn amount_set auf 1 gesetzt ist. Andernfalls wird die Preistabelle verwendet (*100 wird eingegeben). Wenn in der Datei ein Währungsbetrag angegeben ist, dann wird der Betrag aus dem Währungskurs berechnet, der in der mandantenspezifischen Tabelle für die Wechselkurse angegeben ist.');
		$lg04[7] = array('7','apar_id','c25',true,false,false,'25','234','258','Dieses Feld wird für die Lieferantennummer verwendet, mit der der Lieferant in AGRESSO Kreditoren erfasst ist.Es muss eine gültige Lieferantennummer verwendet werden.');
		$lg04[8] = array('8','apar_gr_id','c25',true,false,false,'25','259','283','AP/AR-Referenz');
		$lg04[9] = array('9','apar_name','c25',true,false,false,'255','284','538','Name des Lieferanten. Gilt nur für diverse Lieferanten. Andernfalls lassen Sie das Feld leer.');
		$lg04[10] = array('10','art_descr','c25',false,true,false,'255','539','793','Dieses Feld enthält eine kurze Beschreibung des Artikels. Wenn dieses Feld leer ist, wird die in der Artikeltabelle von Agresso angegebene Beschreibung verwendet.');
		$lg04[11] = array('11','article','c25',false,true,false,'25','794','818','In diesem Feld wird der Artikelschlüssel angegeben. Bei dem hier eingegebenen Schlüssel muss es sich um einen in Agresso definierten gültigen Artikelschlüssel handeln. Dieser Artikelschlüssel kann durch eine Relation automatisch ausgelöst werden.');
		$lg04[12] = array('12','att_1_id','c4',true,false,false,'4','819','822','In diesem Feld wird die Attributnummer für Kategorie 1 angegeben. Dieses Feld kann mit einem gültigen Attribut eingerichtet werden oder leer bleiben. Wenn dieses Feld leer ist, wird der vom Parameter PO_ATT_ID_1 vorgegebene Standardwert verwendet.');
		$lg04[13] = array('13','att_2_id','c4',true,false,false,'4','823','826','In diesem Feld wird die Attributnummer für Kategorie 2 angegeben. Dieses Feld kann mit einem gültigen Attribut eingerichtet werden oder leer bleiben. Wenn dieses Feld leer ist, wird der vom Parameter PO_ATT_ID_2 vorgegebene Standardwert verwendet.');
		$lg04[14] = array('14','att_3_id','c4',true,false,false,'4','827','830','In diesem Feld wird die Attributnummer für Kategorie 3 angegeben. Dieses Feld kann mit einem gültigen Attribut eingerichtet werden oder leer bleiben. Wenn dieses Feld leer ist, wird der vom Parameter PO_ATT_ID_3 vorgegebene Standardwert verwendet.');
		$lg04[15] = array('15','att_4_id','c4',true,false,false,'4','831','834','In diesem Feld wird die Attributnummer für Kategorie 4 angegeben. Dieses Feld kann mit einem gültigen Attribut eingerichtet werden oder leer bleiben. Wenn dieses Feld leer ist, wird der vom Parameter PO_ATT_ID_4 vorgegebene Standardwert verwendet.');
		$lg04[16] = array('16','att_5_id','c4',true,false,false,'4','835','838','In diesem Feld wird die Attributnummer für Kategorie 5 angegeben. Dieses Feld kann mit einem gültigen Attribut eingerichtet werden oder leer bleiben. Wenn dieses Feld leer ist, wird der vom Parameter PO_ATT_ID_5 vorgegebene Standardwert verwendet.');
		$lg04[17] = array('17','att_6_id','c4',true,false,false,'4','839','842','In diesem Feld wird die Attributnummer für Kategorie 6 angegeben. Dieses Feld kann mit einem gültigen Attribut eingerichtet werden oder leer bleiben. Wenn dieses Feld leer ist, wird der vom Parameter PO_ATT_ID_6 vorgegebene Standardwert verwendet.');
		$lg04[18] = array('18','att_7_id','c4',true,false,false,'4','843','846','In diesem Feld wird die Attributnummer für Kategorie 7 angegeben. Dieses Feld kann mit einem gültigen Attribut eingerichtet werden oder leer bleiben. Wenn dieses Feld leer ist, wird der vom Parameter PO_ATT_ID_7 vorgegebene Standardwert verwendet.');
		$lg04[19] = array('19','bank_account','c25',true,false,false,'35','847','881','Bankkontonummer des Lieferanten. Gilt nur für diverse Lieferanten.Andernfalls lassen Sie das Feld leer.');
		$lg04[20] = array('20','batch_id','c25',true,true,true,'25','882','906','In diesem Feld wird die Batch-Nummer für die Übertragung angegeben.');
		$lg04[21] = array('21','client','c25',true,true,true,'25','907','931','In diesem Feld wird der Firmenschlüssel angegeben.');
		$lg04[22] = array('22','client_ref','c25',true,false,false,'25','932','956','Das Unternehmen des betreffenden Belegs. Das Feld kann leer bleiben.');
		$lg04[23] = array('23','confirm_date','date',true,false,false,'8','957','964','In diesem Feld wird das Datum der Auftragsbestätigung angegeben. Wenn der Auftrag noch nicht bestätigt wurde, muss dieses Feld leer bleiben.');
		$lg04[24] = array('24','control','c1',true,false,false,'1','965','965','Die Art der anzuwendenden Rechnungskontrolle. Wenn dieses Feld leer ist, wird der Standardwert abgerufen aus den Systemparametern DEF_OVERRUN_PCT_V, DEF_OVERRUN_PCT_Q oder DEF_OVERRUN_PCT_A.');
		$lg04[25] = array('25','cur_amount','money',false,true,false,'20','966','985','Dieses Feld listet den Nettogesamtbetrag für die Auftragszeile in der Fremdwährung auf. Diese Angabe wird verwendet, wenn amount_set auf 1 gesetzt ist. Andernfalls wird die Preistabelle verwendet (*100 wird eingegeben). Wenn in der Datei ein Währungsbetrag angegeben ist, dann wird der Betrag aus dem Währungskurs berechnet, der in der mandantenspezifischen Tabelle für die Wechselkurse angegeben ist.');
		$lg04[26] = array('26','currency','c25',false,false,false,'25','986','1010','In diesem Feld wird die Auftragswährung angegeben. Der hier eingegebene Wert wird anhand der für Lieferanten definierten festen Währungen geprüft. Die Währung wird anhand der Tabellen für Währungsschlüssel und Währungskurse geprüft.');
		$lg04[27] = array('27','del_met_descr','c25',true,false,false,'255','1011','1265','Dieses Feld enthält eine Beschreibung der Lieferart. Wenn dieses Feld leer ist, wird die Beschreibung für deliv_method verwendet.');
		$lg04[28] = array('28','del_term_descr','c25',true,false,false,'255','1266','1520','Dieses Feld enthält eine Beschreibung der Lieferbedingungen. Wenn dieses Feld leer ist, wird die Beschreibung für deliv_terms verwendet.');
		$lg04[29] = array('29','deliv_addr','c25',true,false,false,'255','1521','1775','Dieses Feld enthält die Lieferadresse. Format: drei Zeilen mit maximal je 40 Zeichen.');
		$lg04[30] = array('30','deliv_attention','c50',true,false,false,'50','1776','1825','Dieses Feld enthält freien Text und kann leer bleiben.');
		$lg04[31] = array('31','deliv_countr','c25',true,false,false,'25','1826','1850','Nicht verwendet bei Bestellungen.');
		$lg04[32] = array('32','deliv_date','date',true,true,false,'8','1851','1858','Dieses Feld enthält das Lieferdatum. Wenn dieses Feld leer ist, wird das Auftragsdatum verwendet.');
		$lg04[33] = array('33','deliv_method','c25',true,false,false,'25','1859','1883','Dieses Feld enthält die Lieferart. Der eingegebene Wert muss ein für das Attribut LIEFMETH (D3) gültiger Attributwert sein. Wenn das Feld leer ist, wird die Methode anhand einer Lieferantenrelation abgerufen oder, wenn keine Relation dieser Art definiert wurde, aus dem Systemparameter DEF_PO_DELIV_MET.');
		$lg04[34] = array('34','deliv_terms','c25',true,false,false,'25','1884','1908','Dieses Feld enthält die Lieferbedingungen. Der eingegebene Wert muss ein für das Attribut LIEFBED (D2) gültiger Attributwert sein. Wenn das Feld leer ist, werden die Bedingungen anhand einer Lieferantenrelation abgerufen oder, wenn keine Relation dieser Art definiert wurde, aus dem Systemparameter DEF_PO_DELIV_TERM.');
		$lg04[35] = array('35','dim_1','c25',false,true,false,'25','1909','1933','"Dieses Feld enthält einen Wert für die Kontierungskategorie 1. Dieser Wert wird anhand der Kontierungsregel geprüft. Standardwerte werden aus folgenden Quellen abgerufen:Auftragskopf, wenn die Attribut-ID übereinstimmtArtikelrelation, falls definiert"');
		$lg04[36] = array('36','dim_2','c25',false,true,false,'25','1934','1958','"Dieses Feld enthält einen Wert für die Kontierungskategorie 2. Dieser Wert wird anhand der Kontierungsregel geprüft. Standardwerte werden aus folgenden Quellen abgerufen:Auftragskopf, wenn die Attribut-ID übereinstimmtArtikelrelation, falls definiert"');
		$lg04[37] = array('37','dim_3','c25',false,true,false,'25','1959','1983','"Dieses Feld enthält einen Wert für die Kontierungskategorie 3. Dieser Wert wird anhand der Kontierungsregel geprüft. Standardwerte werden aus folgenden Quellen abgerufen:Auftragskopf, wenn die Attribut-ID übereinstimmtArtikelrelation, falls definiert"');
		$lg04[38] = array('38','dim_4','c25',false,true,false,'25','1984','2008','"Dieses Feld enthält einen Wert für die Kontierungskategorie 4. Dieser Wert wird anhand der Kontierungsregel geprüft. Standardwerte werden aus folgenden Quellen abgerufen:Auftragskopf, wenn die Attribut-ID übereinstimmtArtikelrelation, falls definiert"');
		$lg04[39] = array('39','dim_5','c25',false,true,false,'25','2009','2033','"Dieses Feld enthält einen Wert für die Kontierungskategorie 5. Dieser Wert wird anhand der Kontierungsregel geprüft. Standardwerte werden aus folgenden Quellen abgerufen:Auftragskopf, wenn die Attribut-ID übereinstimmtArtikelrelation, falls definiert"');
		$lg04[40] = array('40','dim_6','c25',false,true,false,'25','2034','2058','"Dieses Feld enthält einen Wert für die Kontierungskategorie 6. Dieser Wert wird anhand der Kontierungsregel geprüft. Standardwerte werden aus folgenden Quellen abgerufen:Auftragskopf, wenn die Attribut-ID übereinstimmtArtikelrelation, falls definiert"');
		$lg04[41] = array('41','dim_7','c25',false,true,false,'25','2059','2083','"Dieses Feld enthält einen Wert für die Kontierungskategorie 7. Dieser Wert wird anhand der Kontierungsregel geprüft. Standardwerte werden aus folgenden Quellen abgerufen:Auftragskopf, wenn die Attribut-ID übereinstimmtArtikelrelation, falls definiert"');
		$lg04[42] = array('42','dim_value_1','c25',true,false,false,'25','2084','2108','');
		$lg04[43] = array('43','dim_value_2','c25',true,false,false,'25','2109','2133','Dieses Feld enthält einen Wert für die Kategorie 2 des Auftragskopfs. Dieser wird anhand des in att_id_2 definierten Attributs geprüft.Dieses Feld kann leer bleiben.');
		$lg04[44] = array('44','dim_value_3','c25',true,false,false,'25','2134','2158','Dieses Feld enthält einen Wert für die Kategorie 3 des Auftragskopfs. Dieser wird anhand des in att_id_3 definierten Attributs geprüft.Dieses Feld kann leer bleiben.');
		$lg04[45] = array('45','dim_value_4','c25',true,false,false,'25','2159','2183','Dieses Feld enthält einen Wert für die Kategorie 4 des Auftragskopfs. Dieser wird anhand des in att_id_4 definierten Attributs geprüft.Dieses Feld kann leer bleiben.');
		$lg04[46] = array('46','dim_value_5','c25',true,false,false,'25','2184','2208','Dieses Feld enthält einen Wert für die Kategorie 5 des Auftragskopfs. Dieser wird anhand des in att_id_5 definierten Attributs geprüft.Dieses Feld kann leer bleiben.');
		$lg04[47] = array('47','dim_value_6','c25',true,false,false,'25','2209','2233','Dieses Feld enthält einen Wert für die Kategorie 6 des Auftragskopfs. Dieser wird anhand des in att_id_6 definierten Attributs geprüft.Dieses Feld kann leer bleiben.');
		$lg04[48] = array('48','dim_value_7','c25',true,false,false,'25','2234','2258','Dieses Feld enthält einen Wert für die Kategorie 7 des Auftragskopfs. Dieser wird anhand des in att_id_7 definierten Attributs geprüft.Dieses Feld kann leer bleiben.');
		$lg04[49] = array('49','discount','money',false,true,false,'20','2259','2278','In diesem Feld wird der Rabatt für die Auftragszeile angegeben. Der Wert muss mit 100 multipliziert werden. (Beispiel: 10 muss als 1000 eingeben werden.) Wenn amount_set auf 0 gesetzt ist, wird die Rabattmatrix von Agresso verwendet.');
		$lg04[50] = array('50','disc_percent','float',false,true,false,'20','2279','2298','Dieses Feld enthält den prozentualen Rabatt für die Auftragszeile. Der Wert muss mit 100 multipliziert werden. (Beispiel: 5,5 % muss als 550 eingeben werden.) Wenn amount_set auf 0 gesetzt ist, wird die Rabattmatrix von Agresso verwendet.');
		$lg04[51] = array('51','ean','c50',true,false,false,'50','2299','2348','EAN-Code.');
		$lg04[52] = array('52','exch_rate','float',true,true,false,'20','2349','2368','Dieses Feld wird nicht verwendet und muss leer bleiben.');
		$lg04[53] = array('53','ext_ord_ref','c100',true,false,false,'100','2369','2468','Dieses Feld enthält eine externe Referenz für den Auftrag und wird nicht geprüft.');
		$lg04[54] = array('54','intrule_id','c25',true,false,false,'25','2469','2493','Nicht verwendet für Bestellungen.Lassen Sie das Feld leer.');
		$lg04[55] = array('55','line_no','i4',false,true,true,'4','2494','2497','Dieses Feld enthält die Zeilen-/Positionsnummer. Artikel-/Textzeilen müssen Werte im Bereich von 1 bis 9999 aufweisen, und Auftragskopfzeilen müssen den Wert 0 aufweisen.');
		$lg04[56] = array('56','location','c12',false,true,false,'12','2498','2509','Dieses Feld enthält den standardmäßigen Lagerplatz für Wareneingänge. Dabei muss es sich um einen gültigen Lagerplatz des ausgewählten Lagers handeln.');
		$lg04[57] = array('57','long_info1','c120',true,false,false,'120','2510','2629','Dieses Feld enthält Text, der oben auf den Auftrag gedruckt wird. Wenn das Feld leer ist, wird der Standardtext anhand des Systemparameters DEF_PO_LONG_INFO1 abgerufen.');
		$lg04[58] = array('58','long_info2','c120',true,false,false,'120','2630','2749','Dieses Feld enthält Text, der oben auf den Auftrag gedruckt wird. Wenn das Feld leer ist, wird der Standardtext anhand des Systemparameters DEF_PO_LONG_INFO2 abgerufen.');
		$lg04[59] = array('59','lot','c160',false,true,false,'10','2750','2759','Dieses Feld enthält die standardmäßige Charge für Wareneingänge. Dabei muss es sich um eine gültige Charge für den ausgewählten Artikel handeln. Dieser Wert ist nur für Artikel relevant, die in Chargen verwaltet werden.');
		$lg04[60] = array('60','main_apar_id','c25',true,false,false,'25','2760','2784','Dieses Feld enthält die Lieferantennummer für den zu fakturierenden Lieferanten. Wenn dieses Feld leer ist, wird die Firma verwendet.');
		$lg04[61] = array('61','mark_attention','c50',true,false,false,'50','2785','2834','Bestimmung für eine zusätzliche Lieferadresse.Kann leer bleiben.');
		$lg04[62] = array('62','mark_ctry_cd','c25',true,false,false,'25','2835','2859','Länderschlüssel für Bestimmungsadresse. Muss ein gültiger Länderschlüssel sein.');
		$lg04[63] = array('63','markings','c25',true,false,false,'255','2860','3114','Bestimmungsadresse für Versand der Bestellung. Freier Text. Kann leer bleiben.');
		$lg04[64] = array('64','obs_date','date',true,false,false,'8','3115','3122','Dieses Feld kann verwendet werden, um zusätzliche Datumsinformationen einzugeben. Es kann auch leer bleiben.');
		$lg04[65] = array('65','order_date','date',true,false,false,'8','3123','3130','Dieses Feld enthält das Auftragsdatum. Wenn dieses Feld leer ist, wird das aktuelle Datum verwendet.');
		$lg04[66] = array('66','order_id','bigint',true,true,true,'15','3131','3145','Dieses Feld enthält die Auftragsnummer, die im Bereich von x bis n liegen muss (n>=0). Anhand eines Listenparameters wird gesteuert, ob diese Auftragsnummer beibehalten wird oder eine von Agresso zugewiesene Nummer verwendet wird. Wenn die Auftragsnummer beibehalten werden soll, darf sie noch nicht verwendet worden sein.');
		$lg04[67] = array('67','order_type','c2',true,false,false,'2','3146','3147','Dieses Feld enthält die Auftragsart. Informationen zu den gültigen Werten und zur Verarbeitung dieser Werte finden Sie in der Dokumentation zu AGRESSO Einkauf. Die Auftragsart kann durch einen Listenparameter gesteuert werden. Wenn dieses Feld leer ist, wird der durch den Systemparameter DEF_TREAT_PURCHASE vorgegebene Standardwert verwendet.');
		$lg04[68] = array('68','pay_method','c2',true,false,false,'2','3148','3149','Dieses Feld enthält die Zahlungsart. Das Feld kann leer bleiben.');
		$lg04[69] = array('69','pay_temp_id','c4',false,true,false,'4','3150','3153','Nicht verwendet für Bestellungen.Lassen Sie das Feld leer.');
		$lg04[70] = array('70','period','int',true,true,false,'6','3154','3159','In diesem Feld wird die Auftragsperiode angegeben. Der hier eingegebene Wert kann durch einen Berichtsparameter überschrieben werden.');
		$lg04[71] = array('71','place','c40',true,false,false,'40','3160','3199','Ort des Lieferanten. Gilt nur für diverse Lieferanten. Andernfalls lassen Sie das Feld leer.');
		$lg04[72] = array('72','province','c40',true,false,false,'40','3200','3239','Kreis des Lieferanten. Gilt nur für diverse Lieferanten.Andernfalls lassen Sie das Feld leer.');
		$lg04[73] = array('73','rel_value','c25',false,true,false,'25','3240','3264','Dieses Feld kann einen Relationswert für einen Artikel enthalten. Hiermit wird die Verwendung der Artikelnummern der Übernahmedatei anstelle des Artikelschlüssels ausgelöst, sofern diese Werte unterschiedlich sind. Die verwendete Relation muss beim Anfordern des Serverprozesses als Parameter angegeben werden.');
		$lg04[74] = array('74','responsible','c25',true,false,false,'25','3265','3289','In diesem Feld wird die für die Auftragsfreigabe verantwortliche Person angegeben. Der Wert muss ein gültiger Benutzer sein, der für den Einkauf verantwortlich ist und dem die entsprechende Rolle zugewiesen wurde.');
		$lg04[75] = array('75','responsible2','c25',true,false,false,'25','3290','3314','In diesem Feld wird die für die Erstellung des Auftrags verantwortliche Person angegeben. Der Wert muss ein gültiger Benutzer sein, der bei Einkäufen als Anforderer fungiert und dem die entsprechende Rolle zugewiesen ist.');
		$lg04[76] = array('76','sequence_no','i8',false,true,true,'8','3315','3322','"Laufende Nummer, die als Zeilennummer der Textdetails verwendet wird.1-n  Fortlaufend nummerierte Textzeile für den Artikel.0  Artikelzeile."');
		$lg04[77] = array('77','sequence_ref','i8',true,false,false,'8','3323','3330','Laufende Nummer der betreffenden Belegnummer.Das Feld kann leer bleiben.');
		$lg04[78] = array('78','serial_no','c20',false,true,false,'20','3331','3350','Die Seriennummer. Dieser Wert ist nur für Artikel relevant, die mit Seriennummern verwaltet werden.Das Feld kann leer bleiben.');
		$lg04[79] = array('79','short_info','c60',false,false,true,'60','3351','3410','Beschreibender Text für Textdetails. (Kann leer bleiben.)');
		$lg04[80] = array('80','status','c1',true,true,false,'1','3411','3411','"Status des Auftragskopfs bzw. der Auftragspositionen. Wenn dieses Feld leer ist, wird N verwendet.N NormalP  Geparkt"');
		$lg04[81] = array('81','sup_article','c50',false,false,false,'50','3412','3461','Der Artikelschlüssel des Lieferanten.');
		$lg04[82] = array('82','tax_code','c25',false,true,false,'25','3462','3486','Steuerschlüssel. Es muss sich um einen gültigen Steuerschlüssel für das Konto und die Bestellung handeln (siehe Verkaufsaufträge). Wenn dieses Feld leer ist, wird der Standardwert aus der Relation für Artikel/Kontierungsregel abgerufen.');
		$lg04[83] = array('83','tax_system','c2',false,true,false,'25','3487','3511','Steuersystem. Es muss sich um ein im System definiertes gültiges Steuersystem handeln.Das Feld kann leer gelassen werden.');
		$lg04[84] = array('84','template_id','i8',true,true,false,'8','3512','3519','Kontierungsvorlage. Wenn eine Vorlage verwendet wird, muss dieses Feld den Schlüssel dieser Vorlage enthalten.Das Feld kann leer gelassen werden.');
		$lg04[85] = array('85','terms_id','c25',true,false,false,'25','3520','3544','Zahlungsbedingungen. Dabei muss es sich um einen gültigen Wert handeln. Wenn dieses Feld leer ist, werden die Bedingungen aus der Lieferantentabelle verwendet.');
		$lg04[86] = array('86','text1','c100',true,false,false,'100','3545','3644','Freitext 1. Keine Kontrolle, das Feld kann leer bleiben.');
		$lg04[87] = array('87','text2','c100',true,false,false,'100','3645','3744','Freitext 2. Keine Kontrolle, das Feld kann leer bleiben.');
		$lg04[88] = array('88','text3','c100',true,false,false,'100','3745','3844','Freitext 3. Keine Kontrolle, das Feld kann leer bleiben.');
		$lg04[89] = array('89','text4','c100',true,false,false,'100','3845','3944','Freitext 4. Keine Kontrolle, das Feld kann leer bleiben.');
		$lg04[90] = array('90','trans_type','c2',true,true,true,'2','3945','3946','Die Belegart. Für Bestellungen muss hier der Wert 41 angegeben werden.');
		$lg04[91] = array('91','unit_code','c3',false,true,false,'3','3947','3949','Einheitenschlüssel, gültig für den Artikel. Wenn dieses Feld leer ist, wird die Standardeinheit des Artikels verwendet.');
		$lg04[92] = array('92','unit_descr','c25',false,true,false,'255','3950','4204','Beschreibung der Einheit. Wenn dieses Feld leer ist, wird standardmäßig die Beschreibung der Einheit verwendet.');
		$lg04[93] = array('93','unit_price','float',false,true,false,'20','4205','4224','Preis pro Einheit. Wenn dieser Wert leer gelassen wird,???');
		$lg04[94] = array('94','value_1','float',false,true,false,'20','4225','4244','Anzahl der Einheiten. Wenn dieses Feld leer ist, wird der Standardwert 1,0 verwendet. (Der Wert muss mit 100 multipliziert werden, beispielsweise wird 2,5 als 250 eingegeben.)');
		$lg04[95] = array('95','voucher_ref','bigint',true,false,false,'15','4245','4259','Die Nummer der betreffenden Rechnung. Das Feld kann leer gelassen werden.');
		$lg04[96] = array('96','voucher_type','c25',true,true,true,'25','4260','4284','Nummernart für die Bestellung. Dieser Wert wird verwendet, wenn der Serverprozess eine Auftragsnummer zuweist.Dieser Wert kann als Berichtsparameter eingegeben werden.');
		$lg04[97] = array('97','warehouse','c25',false,true,false,'25','4285','4309','Das Lager, dem die Artikel hinzugefügt bzw. entnommen werden (abhängig von der Bestellart).Es muss sich hierbei um ein gültiges Lager handeln.');
		$lg04[98] = array('98','zip_code','c15',true,false,false,'15','4310','4324','Postleitzahl des Lieferanten. Gilt nur für diverse Lieferanten.Andernfalls lassen Sie das Feld leer.');
	
		return $lg04;
	}
	
	
}