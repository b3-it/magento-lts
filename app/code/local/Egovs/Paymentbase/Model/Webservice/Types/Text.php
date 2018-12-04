<?php
/**
 * Klasse für die Textstruktur an der ePayBL
 * 
 * @property string(50) $code Detaillierter Status
 * @property string(250) $langText Beschreibung des Status in Langform (Optional)
 * @property string(30) $kurzText Beschreibung des Status in Kurzform (Optional)
 * @property sprache(5) $sprache Sprache der Textmeldung. Die Information wird nach dem Alpha-2 Standard gemäß ISO 639
 * 
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2012 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Model_Webservice_Types_Text extends Egovs_Paymentbase_Model_Webservice_Types_Abstract
{
	/**
	 * Konstruktor
	 * 
	 * @param string $code    Code
	 * @param string $sprache Sprache
	 * 
	 * @return void
	 */
	public function __construct(
			$code = null,
			$sprache = null
	) {
		$this->code = $code;
        $this->sprache = $sprache;
        
        parent::__construct();
	}
	
	/**
	 * Liefert die Längenbeschränkungen der Werte
	 *
	 * Längenbeschränkungen:<br/>
	 * <ul>
	 *  <li>sprache = 5</li>
	 *  <li>kurzText = 30</li>
	 *  <li>code = 50</li>
	 *  <li>langText = 250</li>
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
			case 'sprache':
				$length = 5;
				break;
			case 'kurzText':
				$length = 30;
				break;
			case 'code':
				$length = 50;
				break;
			case 'langText':
				$length = 250;
				break;
			default:
				$length = 0;
		}
		
		return $length;
	}
}