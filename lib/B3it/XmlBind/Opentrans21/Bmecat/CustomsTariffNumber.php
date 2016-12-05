<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_CustomsTariffNumber
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_CustomsTariffNumber extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_CustomsNumber */
	private $__CustomsNumber = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_Territory */
	private $__TerritoryA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_AreaRefs */
	private $__AreaRefs = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_CustomsNumber
	 */
	public function getCustomsNumber()
	{
		if($this->__CustomsNumber == null)
		{
			$this->__CustomsNumber = new B3it_XmlBind_Opentrans21_Bmecat_CustomsNumber();
		}
	
		return $this->__CustomsNumber;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_CustomsNumber
	 * @return B3it_XmlBind_Opentrans21_Bmecat_CustomsTariffNumber
	 */
	public function setCustomsNumber($value)
	{
		$this->__CustomsNumber = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_Territory and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Territory
	 */
	public function getTerritory()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_Territory();
		$this->__TerritoryA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Territory
	 * @return B3it_XmlBind_Opentrans21_Bmecat_CustomsTariffNumber
	 */
	public function setTerritory($value)
	{
		$this->__TerritoryA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Territory[]
	 */
	public function getAllTerritory()
	{
		return $this->__TerritoryA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_AreaRefs
	 */
	public function getAreaRefs()
	{
		if($this->__AreaRefs == null)
		{
			$this->__AreaRefs = new B3it_XmlBind_Opentrans21_Bmecat_AreaRefs();
		}
	
		return $this->__AreaRefs;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_AreaRefs
	 * @return B3it_XmlBind_Opentrans21_Bmecat_CustomsTariffNumber
	 */
	public function setAreaRefs($value)
	{
		$this->__AreaRefs = $value;
		return $this;
	}





	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:CUSTOMS_TARIFF_NUMBER');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:CUSTOMS_TARIFF_NUMBER');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__CustomsNumber != null){
			$this->__CustomsNumber->toXml($xml);
		}
		if($this->__TerritoryA != null){
			foreach($this->__TerritoryA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__AreaRefs != null){
			$this->__AreaRefs->toXml($xml);
		}


		return $xml;
	}

}
