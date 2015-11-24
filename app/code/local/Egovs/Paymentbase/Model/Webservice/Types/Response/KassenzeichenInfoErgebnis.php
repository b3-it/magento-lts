<?php
/**
 * KassenzeichenInfoErgebnis
 *
 * Response von ePayBL
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright	Copyright (c) 2012 - 2015 B3 IT Systeme GmbH <http://www.b3-it.de>
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 * 
 * @property string 													$kassenzeichen 				Kassenzeichen
 * @property string 													$EShopKundenNr 				Interne vom eShop System vergebene eindeutige Nr zum Kunden, dem das Kassenzeichen zugeordnet ist.
 * @property string 													$vorname 					Vorname des Kunden
 * @property string 													$name						Nachname des Kunden
 * @property string 													$zahlverfahren				Aktuelles Zahlverfahren des Kassenzeichens.
 * @property float 														$betragZahlungseingaenge	Der Betrag, aller Zahlungseingänge zu diesem Kassenzeichen.
 * @property float 														$betragHauptforderungen		Der Betrag, aller Hauptforderungen zu diesem Kassenzeichen.
 * @property float 														$betragRuecklastschriften	Der Betrag, aller Rücklastschriften zu diesem Kassenzeichen.
 * @property float 														$betragLastschriften		Der Betrag, aller Lastschriften zu diesem Kassenzeichen.
 * @property float 														$betragSonstigeBuchungen	Der Betrag, aller sonstigen Buchungen zu diesem Kassenzeichen.
 * @property float 														$betragStornos				Der Betrag, aller Stornos zu diesem Kassenzeichen.
 * @property float 														$saldo						Der aktuelle Saldo zu diesem Kassenzeichen.
 * @property string 													$waehrung					Momentan konstant 'EUR'
 * @property Text 														$paypageStatus				Die Textstruktur beinhaltet den aktuellen Paypage Status des Kassenzeichens im ePayment System.
 * @property Egovs_Paymentbase_Model_Webservice_Types_Response_Ergebnis $ergebnis					Ergebnisstruktur
 */
class Egovs_Paymentbase_Model_Webservice_Types_Response_KassenzeichenInfoErgebnis
{
}