<?php
/**
 * Klasse für SEPA Mandat in ePayBL
 *
 * @property string(1)   $type Typ des Mandates. Erlaubt sind B für SDD-Core Basis (Privatkunden) und F für B2B-SDD (Firmenkunden) (Pflicht)
 * @property string(24)  $referenz Die Sepamandatreferenz des Mandates. (Pflicht)
 * TODO : Können 15 Zeichen stimmen?
 * @property string(100) $eShopKundenNr Kundennummer des Kunden dem das Mandat zugeordnet ist. (Pflicht)
 * @property string(120) $accountOwnerBankname Bankname des Kontoinhabers (Optional)
 * @property string(11)  $accountOwnerBic BIC des Kontoinhabers (Optional)
 * @property string(100) $accountOwnerCity Ort des Kontoinhabers (Optional)
 * @property boolean     $accountOwnerDiffers Gibt an, ob sich der Kontoinhaber vom ePayBL-Kunden unterscheidet, falls ja, muss der Kontoinhaber (bis auf die Sprache) komplett angegeben werden (Pflicht)
 * @property string(35)  $accountOwnerHousenumber Hausnummer des Kontoinhabers (Optional)
 * @property string(34)  $accountOwnerIban IBAN des Kontoinhabers (Optional)
 * @property string(50)  $accountOwnerLand Land des Kontoinhabers (Optional)
 * @property string(25)  $accountOwnerName Name des Kontoinhabers (Optional, mit Surname zusammen insgesamt nur 25 Zeichen erlaubt!)
 * @property string(10)  $accountOwnerSprache Sprache des Kontoinhabers (Optional)
 * @property string(100) $accountOwnerStreet Straße des Kontoinhabers (Optional)
 * @property string(25)  $accountOwnerSurname Vorname des Kontoinhabers (Optional, mit Name zusammen insgesamt nur 25 Zeichen erlaubt!)
 * @property string(10)  $accountOwnerZip Postleitzahl des Kontoinhabers (Optional)
 * @property string(8)   $bewirtschafterNr Gibt den Bewirtschafter an, dem das Mandat zugeordnet ist. (Pflicht)
 * @property date		 $cancellationDate Datum des Widerrufs (Optional)
 * @property string(200) $creditorESignature Elektronische Signatur des Kreditors (Optional)
 * @property string(10)  $datumUnterschrift Datum der Unterschrift auf dem schriftlichen Mandat. Erlaubt ist das Format dd.MM.yyyy. (Pflicht)
 * @property string(35)  $glaeubigerID Gläubiger ID des Mandanten. (Pflicht)
 * @property string      $land Land (Optional)
 * @property string(100) $ortUnterschrift Ort der Unterschrift auf dem schriftlichen Mandat. (Optional)
 * @property string(4)   $sequenceType Sequenztyp des Mandates, erlaubt sind FRST, RCUR, FNAL und OOFF. (Pflicht)
 * @property date        $dateOfLastUsage Datum der letzten Benutzung des Mandates. (Pflicht)
 * @property boolean     $aktiv true = Mandat ist aktiv. false = Mandat ist inaktiv (Pflicht)
 * @property string(25)  $abweichenderKontoinhaber Name des Kontoinhabers, wenn dieser vom Namen des Kunden bzw. vom Namen des Kontoinhabers abweicht. (Optional, nur bei externen Mandaten!)
 * @property Egovs_Paymentbase_Model_Webservice_Types_SepaAmendment $amendment Das Amendment des Sepamandates. (Optional)
 * @property int         $frequency Wird nicht benutzt. Für zukünftige Verwendung. (Optional)
 * @property float       $betrag Wird nicht benutzt. Für zukünftige Verwendung. (Optional)
 * 
 * <h3>Sequence Typen</h3>
 * 	<p>Grundsätzlich muss in der SEPA Lastschriftdatei auch der Sequence Type des zu Grunde liegenden SEPA Lastschriftmandats in der richtigen Reihenfolge der Lastschrifteinzüge angegeben werden. Fehlangaben können zur Nichteinlösung oder Verhinderung von Folgeeinzügen führen.</p>
 *	<table width="614" cellspacing="0" cellpadding="0" border="1" style="border-collapse: collapse; margin-left: -1.7pt;">
 *	    <tbody>
 *	        <tr>
 *	            <td width="161" valign="top" colspan="2" style="padding-bottom: 0cm; padding-left: 5.4pt; width: 120.5pt; padding-right: 5.4pt; padding-top: 0cm; border: #7ba0cd 1pt solid;">
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <strong><span style="font-family: 'Verdana','sans-serif'; color: #000066; font-size: 9pt;">Sequence Type</span></strong>
 *	                </p>
 *	            </td>
 *	            <td width="454" valign="top" style="border-bottom: #7ba0cd 1pt solid; border-left: medium none; padding-bottom: 0cm; padding-left: 5.4pt; width: 12cm; padding-right: 5.4pt; border-top: #7ba0cd 1pt solid; border-right: #7ba0cd 1pt solid; padding-top: 0cm;">
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <strong><span style="font-family: 'Verdana','sans-serif'; color: #000066; font-size: 9pt;">Beschreibung</span></strong>
 *	                </p>
 *	            </td>
 *	        </tr>
 *	
 *	        <tr>
 *	            <td width="57" valign="top" style="border-bottom: #7ba0cd 1pt solid; border-left: #7ba0cd 1pt solid; padding-bottom: 0cm; padding-left: 5.4pt; width: 42.55pt; padding-right: 5.4pt; background: none transparent scroll repeat 0% 0%; border-top: medium none; border-right: #7ba0cd 1pt solid; padding-top: 0cm;">
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <span>FRST</span>
 *	                </p>
 *	            </td>
 *	            <td width="104" valign="top" style="border-bottom: #7ba0cd 1pt solid; border-left: medium none; padding-bottom: 0cm; padding-left: 5.4pt; width: 77.95pt; padding-right: 5.4pt; background: none transparent scroll repeat 0% 0%; border-top: medium none; border-right: #7ba0cd 1pt solid; padding-top: 0cm;">
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <span>Erst</span>
 *	                </p>
 *	
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <span>Lastschrift</span>
 *	                </p>
 *	
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <span>&nbsp;</span>
 *	                </p>
 *	
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <span>first dd</span>
 *	                </p>
 *	
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <span>sequence</span>
 *	                </p>
 *	            </td>
 *	            <td width="454" valign="top" style="border-bottom: #7ba0cd 1pt solid; border-left: medium none; padding-bottom: 0cm; padding-left: 5.4pt; width: 12cm; padding-right: 5.4pt; background: none transparent scroll repeat 0% 0%; border-top: medium none; border-right: #7ba0cd 1pt solid; padding-top: 0cm;">
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <span>Erster Einzug einer Lastschrift, bei der das vom Zahler (Zahlungspflichtigen) erteilte Mandat
 *	                    (Einzugsermächtigung) für regelmäßige, vom Zahlungsempfänger angewiesene Lastschriften genutzt wird.</span>
 *	                </p>
 *	
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <span>&nbsp;</span>
 *	                </p>
 *	
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <span>DTA Textschlüsselergänzung im elektronischen Kontoauszug: 990</span>
 *	                </p>
 *	            </td>
 *	        </tr>
 *	
 *	        <tr>
 *	            <td width="57" valign="top" style="border-bottom: #7ba0cd 1pt solid; border-left: #7ba0cd 1pt solid; padding-bottom: 0cm; padding-left: 5.4pt; width: 42.55pt; padding-right: 5.4pt; background: none transparent scroll repeat 0% 0%; border-top: medium none; border-right: #7ba0cd 1pt solid; padding-top: 0cm;">
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <span>RCUR</span>
 *	                </p>
 *	            </td>
 *	            <td width="104" valign="top" style="border-bottom: #7ba0cd 1pt solid; border-left: medium none; padding-bottom: 0cm; padding-left: 5.4pt; width: 77.95pt; padding-right: 5.4pt; background: none transparent scroll repeat 0% 0%; border-top: medium none; border-right: #7ba0cd 1pt solid; padding-top: 0cm;">
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <span>Folge</span>
 *	                </p>
 *	
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <span>Lastschrift</span>
 *	                </p>
 *	
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <span>&nbsp;</span>
 *	                </p>
 *	
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <span>recurrent dd</span>
 *	                </p>
 *	
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <span>sequence</span>
 *	                </p>
 *	            </td>
 *	            <td width="454" valign="top" style="border-bottom: #7ba0cd 1pt solid; border-left: medium none; padding-bottom: 0cm; padding-left: 5.4pt; width: 12cm; padding-right: 5.4pt; background: none transparent scroll repeat 0% 0%; border-top: medium none; border-right: #7ba0cd 1pt solid; padding-top: 0cm;">
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <span>Folgelastschrift, bei der das vom Zahler (Zahlungspflichtigen) erteilte Mandat
 *	                    (Einzugsermächtigung) für regelmäßige, vom Zahlungsempfänger angewiesene Lastschriften genutzt wird.</span>
 *	                </p>
 *	
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <span>&nbsp;</span>
 *	                </p>
 *	
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <span>DTA Textschlüsselergänzung im elektronischen Kontoauszug: 991</span>
 *	                </p>
 *	            </td>
 *	        </tr>
 *	
 *	        <tr>
 *	            <td width="57" valign="top" style="border-bottom: #7ba0cd 1pt solid; border-left: #7ba0cd 1pt solid; padding-bottom: 0cm; padding-left: 5.4pt; width: 42.55pt; padding-right: 5.4pt; background: none transparent scroll repeat 0% 0%; border-top: medium none; border-right: #7ba0cd 1pt solid; padding-top: 0cm;">
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <span>OOFF</span>
 *	                </p>
 *	            </td>
 *	            <td width="104" valign="top" style="border-bottom: #7ba0cd 1pt solid; border-left: medium none; padding-bottom: 0cm; padding-left: 5.4pt; width: 77.95pt; padding-right: 5.4pt; background: none transparent scroll repeat 0% 0%; border-top: medium none; border-right: #7ba0cd 1pt solid; padding-top: 0cm;">
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <span lang="EN-US" xml:lang="EN-US">Einmal</span>
 *	                </p>
 *	
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <span lang="EN-US" xml:lang="EN-US">Lastschrift</span>
 *	                </p>
 *	
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <span lang="EN-US" xml:lang="EN-US">&nbsp;</span>
 *	                </p>
 *	
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <span lang="EN-US" xml:lang="EN-US">one-off dd</span>
 *	                </p>
 *	
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <span lang="EN-US" xml:lang="EN-US">sequence</span>
 *	                </p>
 *	            </td>
 *	            <td width="454" valign="top" style="border-bottom: #7ba0cd 1pt solid; border-left: medium none; padding-bottom: 0cm; padding-left: 5.4pt; width: 12cm; padding-right: 5.4pt; background: none transparent scroll repeat 0% 0%; border-top: medium none; border-right: #7ba0cd 1pt solid; padding-top: 0cm;">
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <span>Einmalige Lastschrift. Das vom Zahler (Zahlungspflichtigen) erteilte Einverständnis erfolgte für
 *	                    einen einzelnen Lastschrifteinzug.</span>
 *	                </p>
 *	
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <span>&nbsp;</span>
 *	                </p>
 *	
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <span>DTA Textschlüsselergänzung im elektronischen Kontoauszug: 992</span>
 *	                </p>
 *	            </td>
 *	        </tr>
 *	
 *	        <tr>
 *	            <td width="57" valign="top" style="border-bottom: #7ba0cd 1pt solid; border-left: #7ba0cd 1pt solid; padding-bottom: 0cm; padding-left: 5.4pt; width: 42.55pt; padding-right: 5.4pt; background: none transparent scroll repeat 0% 0%; border-top: medium none; border-right: #7ba0cd 1pt solid; padding-top: 0cm;">
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <span>FNAL</span>
 *	                </p>
 *	            </td>
 *	            <td width="104" valign="top" style="border-bottom: #7ba0cd 1pt solid; border-left: medium none; padding-bottom: 0cm; padding-left: 5.4pt; width: 77.95pt; padding-right: 5.4pt; background: none transparent scroll repeat 0% 0%; border-top: medium none; border-right: #7ba0cd 1pt solid; padding-top: 0cm;">
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <span>Letztmalige</span>
 *	                </p>
 *	
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <span>Lastschrift</span>
 *	                </p>
 *	
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <span>&nbsp;</span>
 *	                </p>
 *	
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <span>final dd</span>
 *	                </p>
 *	
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <span>sequence</span>
 *	                </p>
 *	            </td>
 *	            <td width="454" valign="top" style="border-bottom: #7ba0cd 1pt solid; border-left: medium none; padding-bottom: 0cm; padding-left: 5.4pt; width: 12cm; padding-right: 5.4pt; background: none transparent scroll repeat 0% 0%; border-top: medium none; border-right: #7ba0cd 1pt solid; padding-top: 0cm;">
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <span>Durch das Kennzeichen verzichtet der Zahlungsempfänger auf den Einzug weiterer Lastschrift,
 *	                    dieses kommt faktisch (aber nicht rechtlich) einer Mandatskündigung gleich.</span>
 *	                </p>
 *	
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <span>&nbsp;</span>
 *	                </p>
 *	
 *	                <p style="line-height: normal; margin-bottom: 0pt;">
 *	                    <span>DTA Textschlüsselergänzung im elektronischen Kontoauszug: 993</span>
 *	                </p>
 *	            </td>
 *	        </tr>
 *	    </tbody>
 *	</table>
 * <br/>
 * 
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2013 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Model_Webservice_Types_SepaMandat
extends Egovs_Paymentbase_Model_Webservice_Types_Abstract
implements Egovs_Paymentbase_Model_Sepa_Mandate_Interface_Adaptee
{
    /**
     * @deprecated since SEPA 3.0 - Es soll stattdessen 'RCUR' benutzt werden
     */
	const SEQUENCE_TYPE_FRST = 'FRST';
	const SEQUENCE_TYPE_RCUR = 'RCUR';
	const SEQUENCE_TYPE_FNAL = 'FNAL';
	const SEQUENCE_TYPE_OOFF = 'OOFF';
	
	const TYPE_SDD_CORE_BASE = 'B';
	const TYPE_B2B_SDD = 'F';
	/**
	 * Liefert die Längenbeschränkungen der Werte
	 *
	 * Längenbeschränkungen:<br/>
	 * <ul>
	 *  <li>type = 1</li>
	 *  <li><strong>default</strong> = 255</li>
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
			case 'type':
				$length = 1;
				break;
			case 'sequenceType':
				$length = 4;
				break;
			case 'bewirtschafterNr':
				$length = 8;
				break;
			case 'datumUnterschrift':
			case 'accountOwnerSprache':
			case 'accountOwnerZip':
				$length = 10;
				break;
			case 'accountOwnerBic':
				$length = 12;
				break;
			case 'referenz':
				$length = 26;
				break;
			case 'accountOwnerName':
			case 'accountOwnerSurname':
				$length = 25;
				break;
			case 'accountOwnerIban':
				$length = 34;
				break;
			case 'glaeubigerID':
			case 'accountOwnerHousenumber':
				$length = 35;
				break;
			case 'accountOwnerLand':
				$length = 50;
				break;
			case 'abweichenderKontoinhaber':
				$length = 70;
				break;
			case 'ortUnterschrift':
			case 'accountOwnerCity':
			case 'accountOwnerStreet':
				$length = 100;
				break;
			case 'accountOwnerBankname':
				$length = 120;
				break;
			case 'creditorESignature':
				$length = 120;
				break;
			default:
				$length = 255;
		}
	
		return $length;
	}
	
	/**
	 * Erstellt einen SoapVar als XSD_DATE
	 *
	 * @param string $value Wert
	 *
	 * @return SoapVar
	 */
	public function parseDateOfLastUsage($value) {
		return new SoapVar($value, XSD_DATE);
	}
	
	/**
	 * Erstellt einen SoapVar als XSD_DATE
	 *
	 * @param string $value Wert
	 *
	 * @return SoapVar
	 */
	public function parseCancellationDate($value) {
		return new SoapVar($value, XSD_DATE);
	}
	
	/**
	 * Erstellt einen SoapVar als XSD_BOOLEAN
	 *
	 * @param string $value Wert
	 *
	 * @return SoapVar|null Null wird bei einem Fehler zurückgegeben
	 */
	public function parseAktiv($value) {
		if ($value == true || $value == false) {
			return new SoapVar($value, XSD_BOOLEAN);
		}
	
		return null;
	}
	
	/**
	 * Erstellt einen SoapVar als XSD_DECIMAL
	 *
	 * @param string $value Wert
	 *
	 * @return SoapVar|null Null wird bei einem Fehler zurückgegeben
	 */
	public function parseBetrag($value) {
		if (is_numeric($value)) {
			return new SoapVar($value, XSD_DECIMAL);
		}
	
		return null;
	}
	
	/**
	 * Prüft ob der korrekte Wertebereich genutzt wird.
	 *
	 * @param string $value Wert
	 *
	 * @return SoapVar|null Null wird bei einem Fehler zurückgegeben
	 */
	public function parseType($value) {
		if ($value == self::TYPE_SDD_CORE_BASE || $value == self::TYPE_B2B_SDD) {
			return $value;
		}
	
		return null;
	}
	
	/**
	 * Prüft ob der korrekte Wertebereich genutzt wird.
	 *
	 * @param string $value Wert
	 *
	 * @return SoapVar|null Null wird bei einem Fehler zurückgegeben
	 */
	public function parseSequenceType($value) {
		if ($value == self::SEQUENCE_TYPE_FRST || $value == self::SEQUENCE_TYPE_RCUR || $value == self::SEQUENCE_TYPE_FNAL || $value == self::SEQUENCE_TYPE_OOFF) {
			return $value;
		}
	
		return null;
	}
	
	/**
	 * Gibt an ob das Mandat aktiv ist
	 *
	 * @return boolean
	 */
	public function isActive() {
		if ($this->aktiv instanceof SoapVar && isset($this->aktiv->enc_value)) {
			return $this->aktiv->enc_value;
		}
		return $this->aktiv == true ? true : false;
	}
	
	public function getCancellationDate() {
		if (!isset($this->cancellationDate)) {
			return null;
		}
		if ($this->cancellationDate instanceof SoapVar && isset($this->cancellationDate->enc_value)) {
			return new Zend_Date($this->cancellationDate->enc_value);
		}
	
		return null;
	}
	
	public function getReference() {
		return $this->referenz;
	}
	
	public function setCreditorId($id) {
		$this->glaeubigerID = $id;
	}
	public function getCreditorId() {
		return $this->glaeubigerID;
	}
	public function setSequenceType($type) {
		$this->sequenceType = $type;
	}
	public function getSequenceType() {
		return $this->sequenceType;
	}
	public function setType($type) {
		$this->type = $type;
	}
	public function getType() {
		return $this->type;
	}
	
	public function getAccountholderDiffers() {
		if (isset($this->accountOwnerDiffers)) {
			return $this->accountOwnerDiffers;
		}
		//FIXME : accountOwnerDiffers wird beim laden von ePayBL nie gesetzt => liegt an ePayBL!!
		if (isset($this->accountOwnerIban) && !empty($this->accountOwnerIban)) {
			$this->accountOwnerDiffers = true;
		} else {
			$this->accountOwnerDiffers = false;
		}
		
		return $this->accountOwnerDiffers;
	}

	/**
	 * Setzt Flag für abweichenden Kontoinhaber
	 * 
	 * @param bool $differs Abweichend oder nicht
	 * 
	 * @return void
	 * 
	 * @see Egovs_Paymentbase_Model_Sepa_Mandate_Interface_Adaptee::setAccountholderDiffers()
	 */
	public function setAccountholderDiffers($differs) {
		$this->accountOwnerDiffers = $differs;
	}
	
	/**
	 * Setzt den abweichenden Kontoinhaber
	 * 
	 * @param string $ak Abweichender Kontoinhaber
	 * 
	 * @return void
	 */
	public function setAbweichenderKontoinhaber($ak) {
		$ak = $this->_clipValue('abweichenderKontoinhaber', $ak);
		
		$this->abweichenderKontoinhaber = $ak;
	}
	
	public function getAccountholderBankname() {
		return $this->accountOwnerBankname;
	}
	public function setAccountholderBankname($bankname) {
		$this->accountOwnerBankname = $bankname;
	}
}