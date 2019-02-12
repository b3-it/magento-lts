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
 * @property string(8)  $blz Bankleitzahl
 * @property string(25) $name Bankname
 * @property string(11) $bic BIC
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
	public function __construct(
			$bic = null,
			$name = null
	) {
		$args = func_get_args();
		Mage::log(sprintf("%s called...", __METHOD__), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
		switch (count($args)) {
			case 1:
				if (is_array($args[0])) {
					foreach ($args[0] as $k => $v) {
						if (stripos($k, 'bic') !== false) {
							if (Mage::helper('paymentbase')->getEpayblVersionInUse() == Egovs_Paymentbase_Helper_Data::EPAYBL_3_X_VERSION) {
								$this->bic = $v;
							} else {
								//ePayBL 2.x
								$this->BIC = $v;
							}
						} elseif (stripos($k, 'blz') !== false) {
							if (Mage::helper('paymentbase')->getEpayblVersionInUse() == Egovs_Paymentbase_Helper_Data::EPAYBL_3_X_VERSION) {
								$this->blz = $v;
							} else {
								//ePayBL 2.x
								$this->BLZ = $v;
							}
						} else {
							$this->{$k} = $v;
						}
					}
				}
				break;
			case 2:
				if (Mage::helper('paymentbase')->getEpayblVersionInUse() == Egovs_Paymentbase_Helper_Data::EPAYBL_3_X_VERSION) {
					$this->bic = $args[0];
				} else {
					//ePayBL 2.x
					$this->BIC = $args[0];
				}
				$this->name = $args[1];
				break;
			default:
		}
		
        
        parent::__construct();
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
			case 'blz':
				$length = 8;
				break;
			case 'BIC':
			case 'bic':
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
		if (Mage::helper('paymentbase')->getEpayblVersionInUse() == Egovs_Paymentbase_Helper_Data::EPAYBL_3_X_VERSION) {
			return $this->bic;
		}
		
		//ePayBL 2.x
		return $this->BIC;
	}
	
	public function getBankname() {
		return $this->name;
	}
	
	public function getBLZ() {
		if (Mage::helper('paymentbase')->getEpayblVersionInUse() == Egovs_Paymentbase_Helper_Data::EPAYBL_3_X_VERSION) {
			return $this->blz;
		}
		
		//ePayBL 2.x
		return $this->BLZ;
	}
}