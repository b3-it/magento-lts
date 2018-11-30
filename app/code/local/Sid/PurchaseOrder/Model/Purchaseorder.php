<?php
/**
 * SID Bezahlmodul
 * 
 * Modul operiert ohne ePayBL
 *
 * @category	Sid
 * @package		Sid_PurchaseOrder
 * @author 		Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2013 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_PurchaseOrder_Model_Purchaseorder extends Mage_Payment_Model_Method_Purchaseorder
{
	protected $_infoBlockType = 'sidpurchaseorder/info';
	
	/**
	 * unique internal payment method identifier
	 *
	 * @var string [a-z0-9_]
	 */
	protected $_code = 'sidpurchaseorder';

	/**
	 * Can authorize online?
	 */
	protected $_canAuthorize            = true;

	/**
	 * Can capture funds online?
	 */
	protected $_canCapture              = true;

	/**
	 * Can capture partial amounts online?
	 */
	protected $_canCapturePartial       = false;

	/**
	 * Can refund online?
	 */
	protected $_canRefund               = false;

	/**
	 * Can void transactions online?
	 */
	protected $_canVoid                 = true;

	/**
	 * Can use this payment method in administration panel?
	 */
	protected $_canUseInternal          = true;

	/**
	 * Can show this payment method as an option on checkout payment page?
	 */
	protected $_canUseCheckout          = true;

	/**
	 * Is this payment method suitable for multi-shipping checkout?
	 */
	protected $_canUseForMultishipping  = true;

	/**
	 * Can save credit card information for future processing?
	 */
	protected $_canSaveCc = false;
	
	/**
	 * Capture payment
	 *
	 * @param Varien_Object $payment Payment
	 * @param float         $amount  Betrag
	 * 
	 * @return  Mage_Payment_Model_Method_Abstract
	 */
	public function capture(Varien_Object $payment, $amount) {
		parent::capture($payment, $amount);
	
		return $this;
	}
}