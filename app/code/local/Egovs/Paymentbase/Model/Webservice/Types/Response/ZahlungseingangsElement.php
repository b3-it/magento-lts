<?php
/**
 * Zahlungseingangselement für ePayBL
 *
 * Response von ePayBL
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright	Copyright (c) 2017 B3 IT Systeme GmbH https://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 * 
 * @property float      $ergebnis      Ergebnis
 * @property DateTime   $buchungsDatum Buchungsdatum
 * @property string(15) $EShopKundenNr ePayBL Kundennummer
 * @property string(30) $kassenzeichen Kassenzeichen
 * @property string(3)  $waehrung      Währung
 */
class Egovs_Paymentbase_Model_Webservice_Types_Response_ZahlungseingangsElement
{
}