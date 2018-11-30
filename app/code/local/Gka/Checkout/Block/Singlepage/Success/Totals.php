<?php

class Gka_Checkout_Block_Singlepage_Success_Totals extends Mage_Sales_Block_Order_Totals
{
	/**
	 * Ist die verwendete Zahlart Barzahlung
	 * @return boolean
	 */
	public function isCashPayment()
	{
		return ($this->getOrder()->getPayment()->getMethod() == 'epaybl_cashpayment' ? 1 : 0);
	}
	
	
	/**
	 * der Name der Zahlart
	 */
	public function getPaymentTitle()
	{
		$info = $this->getOrder()->getPayment()->getMethodInstance();
		 
		return $info->getTitle();
	}
	
	/**
	 * der übergebene Betrag
	 * @return string
	 */
	public function getGivenAmount()
	{
		$order = $this->getOrder();
		$ga = $order->getPayment()->getGivenAmount();
		return $order->formatPrice($ga);
	}
	
	/**
	 * der Wechslegelt Betrag
	 * @return string
	 */
	public function getChangeAmount()
	{
		$order = $this->getOrder();
		$ga = $order->getPayment()->getGivenAmount();
		$total = $order->getGrandTotal();
		return $order->formatPrice($ga - $total);
	}
	
	
}
