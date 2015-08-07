<?php
/**
 * Klasse für SEPA Mandat Amendment in ePayBL
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2013 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 * 
 * @property string(35)  $madatReferenz Die Sepamandatreferenz des Mandates. (Pflicht)
 * @property string(100) $eShopKundenNr Kundennummer des Kunden dem das Mandat zugeordnet ist. (Pflicht)
 * @property string(11)  $bic BIC des Kontoinhabers (Optional)
 * @property string(34)  $iban IBAN des Kontoinhabers (Optional)
 * @property string(35)  $glaeubigerID Gläubiger ID des Mandanten. (Pflicht)
 * @property string      $kontoinhaber Name des Kontoinhabers, wenn dieser vom Namen des Kunden bzw. vom Namen des Kontoinhabers abweicht. (Optional)
 */
class Egovs_Paymentbase_Model_Webservice_Types_SepaAmendment extends Egovs_Paymentbase_Model_Webservice_Types_Abstract
{
	/**
	 * Liefert die Längenbeschränkungen der Werte
	 *
	 * Längenbeschränkungen:<br/>
	 * <ul>
	 *  <li>bic = 11</li>
	 *  <li>iban = 34</li>
	 *  <li>mandatReferenz = 35</li>
	 *  <li>glaeubigerID = 35</li>
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
			case 'bic':
				$length = 11;
				break;
			case 'iban':
				$length = 34;
				break;
			case 'mandatReferenz':
			case 'glaeubigerID':
				$length = 35;
				break;
			case 'eShopKundennummer':
				$length = 100;
				break;
			case 'kontoinhaber':
			default:
				$length = 1000;
		}
	
		return $length;
	}
}