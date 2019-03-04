<?php
/**
 * Klasse für die StringList-Struktur an der ePayBL 3.x
 * 
 * @property string[] $stringList Array von Strings
 * 
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright	Copyright (c) 2017 B3 IT Systeme GmbH https://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Model_Webservice_Types_StringList extends Egovs_Paymentbase_Model_Webservice_Types_Abstract
{
	/**
	 * Konstruktor
	 * 
	 * @param string[] $stringList Liste von Strings
	 * 
	 * @return void
	 */
	public function __construct(
			$stringList = null
	) {
		if (is_string($stringList) || !is_array($stringList)) {
			$stringList = array($stringList);
		}
		
		$this->stringList = $stringList;
        
        parent::__construct();
	}
	
	/**
	 * Liefert die Längenbeschränkungen der Werte
	 *
	 * Längenbeschränkungen:<br/>
	 * <ul>
	 *  <li><strong>default</strong> = 255</li>
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
			default:
				$length = 0;
		}
		
		return $length;
	}
}