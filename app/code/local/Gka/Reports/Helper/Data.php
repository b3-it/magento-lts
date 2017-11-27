<?php
/**
 *  Reports Helper
 *  @category Gka
 *  @package  Gka_Reports
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */ 
class Gka_Reports_Helper_Data extends Mage_Core_Helper_Abstract
{
	/**
	* Liefert ein Options-Array (PaymentCode => PaymentTitel) zurück
	*
	* @return array
	*/
	public function getActivePaymentMethods()
	{
		$payments = Mage::getSingleton('payment/config')->getActiveMethods();
	
		$methods = array();
	
		foreach ($payments as $paymentCode=>$paymentModel) {
			$paymentTitle = Mage::getStoreConfig('payment/'.$paymentCode.'/title');
			$methods[$paymentCode] = $this->__($paymentTitle);
		}
	
		asort($methods);
	
		return $methods;
	}
}