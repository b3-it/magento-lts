<?php
class Egovs_Checkout_Helper_Addressformat extends Mage_Core_Helper_Abstract
{
	public function formatOneLine($address)
	{
		
		if($this->__isValid($address))
		{
			//$address['company'] = trim($address['company']. ' ' . $address['company2'] .' ' . $address['company3']);
			return $address->format('oneline');
		} 
		return Mage::helper('mpcheckout')->__('no valid Address given');
	}
	
	public function formatHtml($address)
	{
		
		if($this->__isValid($address))
		{
			//$address['company'] = trim($address['company']. ', ' . $address['company2'] .', ' . $address['company3'],', ');
			return $address->format('html');
		} 
		
		return Mage::helper('mpcheckout')->__('no valid Address given');
	}
	
	private function __isValid($address)
	{
		$res = 0;
		if($address == null) return false;
		
		foreach(array('lastname','street','city','postcode', 'company') as $key)
		{
			$tmp = $address->getData($key);
			if((isset($tmp)) && (strlen($tmp)>1)) $res++; 
		}
		
		return ($res >= 4);
	}
	
}