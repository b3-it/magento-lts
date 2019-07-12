<?php
/**
 * Klasse für Bankverbindungen an der ePayBL
 * 
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2012 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 * 
 * @property Egovs_Paymentbase_Model_Webservice_Types_Text $status Aktueller Status (Optional)
 * @property string(8) $BLZ Bankleitzahl
 * @property string(25) $kontoinhaber Kontoinhaber (Optional)
 * @property string(10) $kontoNr Kontonummer
 * @property string(11) $BIC BIC
 * @property string(34) $IBAN IBAN
 * @property Egovs_Paymentbase_Model_Webservice_Types_Text $validationStatus Ergbnis der Bankverbindungsprüfung
 * @property string(4) $pin PIN der Bankverbindung
 */
class Egovs_Paymentbase_Model_Webservice_Types_Bankverbindung
extends Egovs_Paymentbase_Model_Webservice_Types_Abstract
implements Egovs_Paymentbase_Model_Sepa_Bankaccount
{
	/**
	 * Konstruktor
	 * 
	 * @param string|array $blz     Bankleitzahl oder Array mit Parametern
	 * @param string 	   $kontoNr Kontonummer
	 * 
	 * @return void
	 */
	public function Egovs_Paymentbase_Model_Webservice_Types_Bankverbindung(
			$blz = null,
			$kontoNr = null
	) {
		$args = func_get_args();
		Mage::log(sprintf("%s called...", __METHOD__), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
		switch (count($args)) {
			case 1:
				if (is_array($args[0])) {
					foreach ($args[0] as $k => $v) {
						$this->$k = $v;
					}
				}
				break;
			case 2:
				$this->BLZ = $args[0];
				$this->kontoNr = $args[1];
				break;
			default:
		}
		
        
        parent::Egovs_Paymentbase_Model_Webservice_Types_Abstract();
	}
	
	/**
	 * Liefert die Längenbeschränkungen der Werte
	 *
	 * Längenbeschränkungen:<br/>
	 * <ul>
	 *  <li>pin = 4</li>
	 *  <li>BLZ = 8</li>
	 *  <li>kontoNr = 10</li>
	 *  <li>BIC = 11</li>
	 *  <li>kontoinhaber = 25</li>
	 *  <li>IBAN = 34</li>
	 *  <li><strong>default</strong> = 0</li>
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
			case 'pin':
				$length = 4;
				break;
			case 'BLZ':
				$length = 8;
				break;
			case 'kontoNr':
				$length = 10;
				break;
			case 'BIC':
				$length = 11;
				break;
			case 'kontoinhaber':
				$length = 25;
				break;
			case 'IBAN':
				$length = 34;
				break;
			default:
				$length = 0;
		}
		
		return $length;
	}
	
	public function getIban() {
		return $this->IBAN;
	}
	public function setIban($iban) {
		$this->IBAN = $iban;
		return $this;
	}
	public function getBic() {
		return $this->BIC;
	}
	public function setBic($bic) {
		$this->BIC = $bic;
		return $this;
	}
	
	public function getBankname($bic = null) {
		if (!$bic) {
			$bic = $this->getBic();
		}
		return Egovs_Paymentbase_Model_SepaDebit::getBankname($bic);
	}
}