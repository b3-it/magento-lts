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
 * @property bool $istOK Status des Ergebnisses
 * 
 * @property Egovs_Paymentbase_Model_Webservice_Types_Text $text Enthält detaillierte Zusatzinformationen zum Vorgang; seit ePayBL 3.x
 * 
 * @property string $code Detaillerter Fehlerstatus als Code; deprecated seit epayBL 3.x
 * @property string $langText Ausführliche Fehlerbeschreibung; deprecated seit epayBL 3.x
 * @property string $kurzText Kurze Fehlerbeschreibung deprecated; seit epayBL 3.x
 * 
 */
class Egovs_Paymentbase_Model_Webservice_Types_Response_Ergebnis
{
}