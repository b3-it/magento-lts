<?php
/**
 * Klasse für Bank an der ePayBL
 * 
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright	Copyright (c) 2015 B3 IT Systeme GmbH
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 * 
 * @property string(8)  $BLZ Bankleitzahl
 * @property string(25) $name Bankname
 * @property string(11) $BIC BIC
 * @property boolean    $supportsSCT Flag ob die Bank SEPA Credit Transfer unterstützt.
 * @property boolean    $supportsSDD Flag ob die Bank SEPA Direct Debit für Privatkunden unterstützt.
 * @property boolean    $supportsB2B Flag ob die Bank SEPA Direct Debit für Firmenkunden unterstützt.
 * @property boolean    $supportsCOR1 Flag ob die Bank SEPA Direct Debit für Privatkunden mit verkürzter Laufzeit unterstützt.
 */
class Egovs_Paymentbase_Model_Webservice_Types_Bank
extends Egovs_Paymentbase_Model_Webservice_Types_Abstract
{
	/**
	 * Konstruktor
	 * 
	 * @param string|array $bic     BIC oder Array mit Parametern
	 * @param string 	   $name    Bankname
	 * 
	 * @return void
	 */
	public function Egovs_Paymentbase_Model_Webservice_Types_Bankverbindung(
			$bic = null,
			$name = null
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
				$this->BIC = $args[0];
				$this->name = $args[1];
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
	 *  <li>BLZ = 8</li>
	 *  <li>name = 60</li>
	 *  <li>BIC = 11</li>
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
			case 'BLZ':
				$length = 8;
				break;
			case 'BIC':
				$length = 11;
				break;
			case 'name':
				$length = 60;
				break;
			default:
				$length = 0;
		}
		
		return $length;
	}
	
	public function getBic() {
		return $this->BIC;
	}
	
	public function getBankname() {
		return $this->name;
	}
	
	public function getBLZ() {
		return $this->BLZ;
	}
}