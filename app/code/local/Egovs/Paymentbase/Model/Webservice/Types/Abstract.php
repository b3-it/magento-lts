<?php
/**
 * Abstrakte Basisklasse für ePayBL Typen
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2012-2013 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
abstract class Egovs_Paymentbase_Model_Webservice_Types_Abstract
{
	protected $_soapNameSpace = 'http://www.bff.bund.de/ePayment';
	
	/**
	 * Dummy Konstruktor
	 * 
	 * Hat hier keine Funktionalität
	 * 
	 * @return void
	 */
	public function __construct() {
		
	}
	
	/**
	 * Abstrakte Methode um die maximale Länge von Parameterwerten festzulegen.
	 * 
	 * @param string $name Name
	 * 
	 * @return int
	 */
	protected abstract function _getParamLength($name); /* {
		switch ($name) {
			default:
				$length = 100;
		}
		
		return $length;
	}*/
	
	/**
	 * Gibt die maximale Länge von Parameterwerten zurück.
	 *
	 * @param string $name Name
	 *
	 * @return int
	 */
	public function getParamLength($name) {
		return $this->_getParamLength($name);
	}
	
	/**
	 * Wandelt den Anfangsbuchstaben eines Wortes in einen Großbuchstaben um
	 * 
	 * @param string $name Name
	 * 
	 * @return string
	 */
	protected function _camelize($name) {
		return uc_words($name, '');
	}
	
	/**
	 * Magic-Methode Wertzuweisungen für nicht existende Properties
	 * 
	 * <strong>Ist die Property einmal gesetzt, so wird diese Methode nicht mehr ausgeführt!</strong>
	 * Strings werden immer in UTF-8 umgewandelt
	 * 
	 * @param string $name  Name
	 * @param string $value Wert
	 * 
	 * @return void
	 */
	public function __set($name, $value) {
		$value = $this->_clipValue($name, $value);
		
		$this->$name = $value;
	}
	
	/**
	 * Beschneidet den Value auf die entsprechende Länge von _getParamLength
	 * 
	 * @param string|number $value
	 * 
	 * @return string
	 */
	protected function _clipValue($name, $value) {
		$length = $this->_getParamLength($name);
		
		if (isset($value) && (is_string($value) || is_numeric($value)) && mb_strlen($value, 'UTF-8') > $length) {
			$value = mb_substr($value, 0, $length, 'UTF-8');
		}
		if (is_string($value)) {
			if (mb_check_encoding($value, 'UTF-8')) {
				$value = html_entity_decode($value, ENT_QUOTES, 'UTF-8');
			} else {
				$value = html_entity_decode($value, ENT_QUOTES, 'ISO-8859-1');
				$value = utf8_encode($value);
			}
				
			$value = mb_ereg_replace("\n", ' ', $value);
		}
		$camelized = $this->_camelize($name);
		if (method_exists($this, sprintf('parse%s', $camelized))) {
			$value = call_user_func(array($this, sprintf('parse%s', $camelized)), $value);
		}
		
		if (!isset($value)) {
			return;
		}
		
		return $value;
	}
	
	/**
	 * Liefert den Wert zu $name
	 * 
	 * Falls der Wert von $name eine Instanz von Egovs_Paymentbase_Model_Webservice_Types_Abstract ist,
	 * so wird dort die toSoap Funktion aufgerufen.
	 * 
	 * @param string $name Name
	 * 
	 * @return mixed|NULL
	 * 
	 * @see ::toSoap
	 */
	public function __get($name) {
		if (isset($this->$name)) {
			if (($this->$name) instanceof Egovs_Paymentbase_Model_Webservice_Types_Abstract) {
				return call_user_func(array($this,'toSoap'));
			}
			return $this->$name;
		}
	
		return null;
	}
	
	/**
	 * Liefert den letzten Teil des Klassennamens
	 * 
	 * @return string
	 */
	public function getShortClassname() {
		$className = get_class($this);
		$pos = strrpos($className, '_');
		if ($pos !== false) {
			$pos++;
		} else {
			$pos = 0;
		}
		$className = substr($className, $pos);
		
		return $className;
	}
	
	/**
	 * Klassen zum Anpassen der Funktionalität von {@link toSoap()}
	 * 
	 * @param SoapVar &$soapVar SoapVar Instanz
	 * 
	 * @return Egovs_Paymentbase_Model_Webservice_Types_Abstract
	 * 
	 * @see toSoap()
	 */
	protected function _toSoap(&$soapVar) {
		$props = get_object_vars($this);
		foreach ($props as $key => $value) {
			if ($value instanceof Egovs_Paymentbase_Model_Webservice_Types_Abstract) {
				$value = $value->toSoap();
			} elseif (is_array($value)) {
				foreach ($value as $k => $item) {
					if ($item instanceof Egovs_Paymentbase_Model_Webservice_Types_Abstract) {
						$value[$k] = $item->toSoap();
					}
				}
			} else {
				continue;
			}			
			
			$this->$key = $value;
		}
		return $this;
	}
	
	/**
	 * Wandelt den Wert dieses Typs in SoapVar um
	 * 
	 * <strong>Template-Methode</strong><br/>
	 * Um das Verhalten anzupassen muss {@link _toSoap()} überschrieben werden!
	 * 
	 * @return SoapVar
	 */
	public final function toSoap() {
		$soapVar = new SoapVar($this, SOAP_ENC_OBJECT, $this->getShortClassname(), $this->_soapNameSpace);
		$this->_toSoap($soapVar);
		
		return $soapVar;
	}
}