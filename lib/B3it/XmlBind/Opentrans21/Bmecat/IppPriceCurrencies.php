<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_IppPriceCurrencies
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_IppPriceCurrencies extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_PriceCurrency */
	private $__PriceCurrencyA = array();


	

	

	
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_PriceCurrency and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_PriceCurrency
	 */
	public function getPriceCurrency()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_PriceCurrency();
		$this->__PriceCurrencyA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_PriceCurrency
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppPriceCurrencies
	 */
	public function setPriceCurrency($value)
	{
		$this->__PriceCurrencyA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_PriceCurrency[]
	 */
	public function getAllPriceCurrency()
	{
		return $this->__PriceCurrencyA;
	}







	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:IPP_PRICE_CURRENCIES');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:IPP_PRICE_CURRENCIES');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__PriceCurrencyA != null){
			foreach($this->__PriceCurrencyA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
