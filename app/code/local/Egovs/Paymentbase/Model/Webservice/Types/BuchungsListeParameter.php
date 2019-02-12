<?php
/**
 * Klasse für Parameterwerte - Paare
 *
 * SäHO Erweiterung
 *
 * @property string $name Key-Name
 * @property string $wert Key-Wert
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright	Copyright (c) 2012 EDV Beratung Hempel
 * @copyright	Copyright (c) 2012 TRW-NET
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Model_Webservice_Types_BuchungsListeParameter extends Egovs_Paymentbase_Model_Webservice_Types_Abstract
{
	/**
	 * Fehlerkonstante für fehlenden Namen
	 * 
	 * @var string
	 */
	const MISSING_NAME = 00001;
	
	/**
	 * Fehlerkonstante für fehlerhaften Wert
	 * 
	 * @var string
	 */
	const VALUE_VALIDATE = 00002;
	
	/**
	 * Konstruktor
	 * 
	 * @param string $name Parametername
	 * @param string $wert Wert
	 * 
	 * @throws Exception Bei fehlenden Namen oder fehlerhaftem Wert (kein String oder > 300)
	 */
	public function __construct ($name, $wert) {
		if (empty($name) || !is_string($name) || strlen($name) > 100) {
			throw new Exception("Name can't be empty or longer than 100 characters", self::MISSING_NAME);
		}
		 
		if ((!is_numeric($wert) && !is_string($wert)) || strlen($wert) > 300) {
			throw new Exception("Value must be type of String and length can't be greater than 300", self::VALUE_VALIDATE);
		}
		 
		$this->name = $name;
		$this->wert = (string) $wert;
		parent::__construct();
	}
	
	/**
	 * Liefert die Längenbeschränkungen der Werte
	 *
	 * Längenbeschränkungen:<br/>
	 * <ul>
	 *  <li>name = 100</li>
	 *  <li>wert = 300</li>
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
			case 'name':
				$length = 100;
				break;
			case 'wert':
				$length = 300;
				break;
			default:
				$length = 0;
		}
	
		return $length;
	}
}
