<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_IppPriceTypes
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_IppPriceTypes extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_PriceType */
	private $__PriceTypeA = array();


	

	

	
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_PriceType and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_PriceType
	 */
	public function getPriceType()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_PriceType();
		$this->__PriceTypeA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_PriceType
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppPriceTypes
	 */
	public function setPriceType($value)
	{
		$this->__PriceTypeA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_PriceType[]
	 */
	public function getAllPriceType()
	{
		return $this->__PriceTypeA;
	}







	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:IPP_PRICE_TYPES');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:IPP_PRICE_TYPES');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__PriceTypeA != null){
			foreach($this->__PriceTypeA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
