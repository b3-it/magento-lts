<?php
/**
 * Klasse zum Untersuchen der Länge Buchungsliste
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright	Copyright (c) 2011 EDV Beratung Hempel
 * @copyright	Copyright (c) 2011 TRW-NET 
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Model_Cartlimit extends Egovs_Paymentbase_Model_Abstract
{
	private $__quote = null;

	
	protected function _getOrder() {
		
		return $this->__quote;
	}
	
	
	public function getAccountingListLength($quote)
	{
		if ($quote == null) {
			return 0;
		}
		
		$this->__quote = $quote;
		$res = $this->createAccountingListParts();
		return count($res);
		
	}
	
	/**
	 * Dummy zur nutzung der abstrakten Basisklasse
	 * 
	 * @param Varien_Object $payment Payment
	 * @param float         $amount  Betrag
	 * 
	 * @see Egovs_Paymentbase_Model_Abstract::_authorize($payment, $amount)
	 * 
	 * @return void
	 */
	protected function _authorize(Varien_Object $payment, $amount) {
		//dummy zur nutzung der abstrakten Basisklasse
	}
	
}