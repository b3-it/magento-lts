<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_PriceBase
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_PriceBase extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_PriceUnit */
	private $__PriceUnit = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_PriceUnitFactor */
	private $__PriceUnitFactor = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_PriceUnit
	 */
	public function getPriceUnit()
	{
		if($this->__PriceUnit == null)
		{
			$this->__PriceUnit = new B3it_XmlBind_Opentrans21_Bmecat_PriceUnit();
		}
	
		return $this->__PriceUnit;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_PriceUnit
	 * @return B3it_XmlBind_Opentrans21_Bmecat_PriceBase
	 */
	public function setPriceUnit($value)
	{
		$this->__PriceUnit = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_PriceUnitFactor
	 */
	public function getPriceUnitFactor()
	{
		if($this->__PriceUnitFactor == null)
		{
			$this->__PriceUnitFactor = new B3it_XmlBind_Opentrans21_Bmecat_PriceUnitFactor();
		}
	
		return $this->__PriceUnitFactor;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_PriceUnitFactor
	 * @return B3it_XmlBind_Opentrans21_Bmecat_PriceBase
	 */
	public function setPriceUnitFactor($value)
	{
		$this->__PriceUnitFactor = $value;
		return $this;
	}





	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:PRICE_BASE');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:PRICE_BASE');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__PriceUnit != null){
			$this->__PriceUnit->toXml($xml);
		}
		if($this->__PriceUnitFactor != null){
			$this->__PriceUnitFactor->toXml($xml);
		}


		return $xml;
	}

}
