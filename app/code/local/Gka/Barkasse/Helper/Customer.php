<?php
/**
  *
  * @category   	Gka Barkasse
  * @package    	Gka_Barkasse
  * @name       	Gka_Barkasse_Helper_Customer
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */
class Gka_Barkasse_Helper_Customer extends Mage_Customer_Helper_Data
{
	/**
	 * Retrieve customer account page url
	 *
	 * @return string
	 */
	public function getAccountUrl()
	{
		$store = Mage::app()->getStore();
		$cash = Mage::getStoreConfig('payment/epaybl_cashpayment/active', $store->getId());
		if(Mage::getStoreConfig('payment/epaybl_cashpayment/active', $store->getId()) == 1){
			return $this->_getUrl('gka_barkasse/kassenbuch_journal/index');
		}
		return $this->_getUrl('customer/account');
	}
	
	/**
	 * Retrieve customer logout url
	 *
	 * @return string
	 */
	public function getLogoutUrl()
	{
		$customer = $this->getCustomer();
		$model = null;
		if($customer && $customer->getId()){
			$model  = Mage::getModel('gka_barkasse/kassenbuch_journal')->getOpenJournal();
		}
		 
		if ($model &&  $model->getId())
		{
			return $this->_getUrl('gka_barkasse/kassenbuch_journal/prelogout');
		}
		
		return $this->_getUrl('customer/account/logout');
	}
}
