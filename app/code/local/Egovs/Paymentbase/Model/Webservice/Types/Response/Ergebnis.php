<?php
/**
 * Ergebnis
 *
 * Response von ePayBL
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2012 - 2013 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 * 
 * @property bool $istOK Status des Ergebnisses
 * @property string $code Detaillerter Fehlerstatus als Code
 * @property string $langText Ausführliche Fehlerbeschreibung
 * @property string $kurzText Kurze Fehlerbeschreibung
 * @property string $EPaymentId Interne eindeutige ID des ePayment System, unter der der Request gespeichert wurde, der das Ergebniselement als Returnstruktur erzeugt hat. Sollte protokolliert werden und als Referenz gegenüber dem ePayment System verwendet werden.
 * @property date $EPaymenTimestamp Zeitpunkt zu welchem der aufrufende Request im ePayment-System gespeichert wurde
 */
class Egovs_Paymentbase_Model_Webservice_Types_Response_Ergebnis
{
}