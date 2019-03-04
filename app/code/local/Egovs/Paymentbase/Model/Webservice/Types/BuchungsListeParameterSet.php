<?php
/**
 * Klasse für Parameterlisten
 *
 * SäHO Erweiterung
 *
 * @property array                                                               $buchungsListeParameter     Parameter für ePayBL 2.x
 * @property Egovs_Paymentbase_Model_Webservice_Types_BuchungsListeParameterList $buchungsListeParameterList Parameter für ePayBL 3.x
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright	Copyright (c) 2012 -2017 B3 IT Systeme GmbH https://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Model_Webservice_Types_BuchungsListeParameterSet extends Egovs_Paymentbase_Model_Webservice_Types_Abstract
{
	/**
	 * Konstruktor
	 * 
	 * @param Egovs_Paymentbase_Model_Webservice_Types_BuchungsListeParameterList|array<Egovs_Paymentbase_Model_Webservice_Types_BuchungsListeParameter>|array<Key,Value> $buchungsListeParameter BuchungsListeParameterList für ePayBL 3.x sonst Array von Buchungslistenparametern
	 * 
	 * @throws Exception
	 */
	public function __construct ( $buchungsListeParameter = array()) {
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
				$buchungsListeParameter = array();
			} else {
				$buchungsListeParameter = new Egovs_Paymentbase_Model_Webservice_Types_BuchungsListeParameter($buchungsListeParameter, '');
				$buchungsListeParameter = array($buchungsListeParameter);
			}
		}
		if (Mage::helper('paymentbase')->getEpayblVersionInUse() == Egovs_Paymentbase_Helper_Data::EPAYBL_3_X_VERSION) {
			$buchungsListeParameter = new Egovs_Paymentbase_Model_Webservice_Types_BuchungsListeParameterList($buchungsListeParameter);
			
			$this->buchungsListeParameterList = $buchungsListeParameter;
		} else {
			/*
			 * ePayBL 2.x
			 */
			$this->buchungsListeParameter = $buchungsListeParameter;
		}
		parent::__construct();
	}
	
	/**
	 * Prüft ob es Buchungslistenparameter gibt
	 * 
	 * @return boolean
	 */
	public function isEmpty() {
		if (Mage::helper('paymentbase')->getEpayblVersionInUse() == Egovs_Paymentbase_Helper_Data::EPAYBL_3_X_VERSION) {
			if (!isset($this->buchungsListeParameterList) || $this->buchungsListeParameterList->isEmpty()) {
				return true;
			}
		} elseif (!isset($this->buchungsListeParameter) || empty($this->buchungsListeParameter)) {
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
	 * @return bool|false|int
	 *
	 * @see Egovs_Paymentbase_Model_Webservice_Types_Abstract::_getParamLength()
	 */
	protected function _getParamLength($name) {
		return 0;
	}
}

