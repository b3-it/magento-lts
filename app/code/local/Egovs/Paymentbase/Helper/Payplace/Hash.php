<?php 
/**
 * Basishelperklasse für gemeinsam genutzte Methoden für Payplace.
 *
 * Bildung eines Key zu validierung der Kommunikation 
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright	Copyright (c) 2014 B3-IT Systeme GmbH
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Helper_Payplace_Hash extends Mage_Core_Helper_Abstract
{
	public function getHash($OrderId, $BewirtschafterNr, $Kassenzeichen, $Amount, $Currency)
	{
		$value =  $OrderId.$BewirtschafterNr.$Kassenzeichen. $Amount. $Currency.Mage::helper('paymentbase')->getSalt();
		$_hash = 'id'.hash('sha256',$value);
		//Mage::log(sprintf("payplace::hash:Hash: %s\nOrderID:%s, BewirtschafterNr:%s, Kassenzeichen: %s, Amount: %s, Currency: %s", $_hash, $OrderId, $BewirtschafterNr, $Kassenzeichen, $Amount, $Currency), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
		
		return $_hash;
	}
	
	
	
	public function getHash4Order(Mage_Sales_Model_Order $order)
	{
		$OrderId = $order->getId(); 
		$BewirtschafterNr = Mage::helper('paymentbase')->getBewirtschafterNr();
		$Kassenzeichen = $order->getPayment()->getKassenzeichen();
		$Amount = intval($order->getBaseGrandTotal() * 100);
		$Currency = $order->getBaseCurrencyCode();
		return $this->getHash($OrderId, $BewirtschafterNr, $Kassenzeichen, $Amount, $Currency);
	}
	
	
}

?>