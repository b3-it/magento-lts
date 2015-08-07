<?php
/**
 * Klasse für Parameterlisten
 *
 * SäHO Erweiterung
 *
 * @property array $buchungsListeParameter Parameter
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright	Copyright (c) 2012 EDV Beratung Hempel
 * @copyright	Copyright (c) 2012 TRW-NET
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Model_Webservice_Types_BuchungsListeParameterSet extends Egovs_Paymentbase_Model_Webservice_Types_Abstract
{
	/**
	 * Konstruktor
	 * 
	 * @param array<Egovs_Paymentbase_Model_Webservice_Types_BuchungsListeParameter>|array<Key,Value> $buchungsListeParameter Array von Buchungslistenparametern
	 * 
	 * @throws Exception
	 */
	public function Egovs_Paymentbase_Model_Webservice_Types_BuchungsListeParameterSet ( $buchungsListeParameter = array()) {
		$p = array();
		//is associative array
		if (array_keys($buchungsListeParameter) !== range(0, count($buchungsListeParameter) -1)) {
			foreach ($buchungsListeParameter as $key => $value) {
				$p[] = new Egovs_Paymentbase_Model_Webservice_Types_BuchungsListeParameter($key, $value);
			}
		} elseif (is_array($buchungsListeParameter)) {
			foreach ($buchungsListeParameter as $item) {
				if (!($item instanceof Egovs_Paymentbase_Model_Webservice_Types_BuchungsListeParameter)) {
					throw new Exception("Item $item must be type of BuchungsListeParameter");
				}
			}
		}
		if (!empty($p)) {
			$buchungsListeParameter = $p;
		}
		if (!is_array($buchungsListeParameter)) {
			if (empty($buchungsListeParameter)) {
				$this->buchungsListeParameter = array();
				return;
			}
			$buchungsListeParameter = new Egovs_Paymentbase_Model_Webservice_Types_BuchungsListeParameter($buchungsListeParameter, '');
			$buchungsListeParameter = array($buchungsListeParameter);
		}
		
		$this->buchungsListeParameter = $buchungsListeParameter;
// 		parent::SoapVar($buchungsListeParameter, SOAP_ENC_OBJECT, 'BuchungsListeParameterSet', Egovs_Paymentbase_Model_Webservice_PaymentServices::EPAYMENT_NAMESPACE);
// 		$this->enc_value = $this;
// 		$this->enc_type = SOAP_ENC_OBJECT;
// 		$this->enc_stype = 'BuchungsListeParameterSet';
// 		$this->enc_ns = Egovs_Paymentbase_Model_Webservice_PaymentServices::EPAYMENT_NAMESPACE;
		parent::Egovs_Paymentbase_Model_Webservice_Types_Abstract();
	}
	
	/**
	 * Prüft ob es Buchungslistenparameter gibt
	 * 
	 * @return boolean
	 */
	public function isEmpty() {
		if (!isset($this->buchungsListeParameter) || empty($this->buchungsListeParameter)) {
			return true;
		}
		
		return false;
	}
	
	/**
	 * Liefert die Längenbeschränkungen der Werte
	 *
	 * <strong>Liefert hier immer 0</strong>
	 *
	 * @param string $name Parametername
	 *
	 * @return 0
	 *
	 * @see Egovs_Paymentbase_Model_Webservice_Types_Abstract::_getParamLength()
	 */
	protected function _getParamLength($name) {
		return 0;
	}
}

