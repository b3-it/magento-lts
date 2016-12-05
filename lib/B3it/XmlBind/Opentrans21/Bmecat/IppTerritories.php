<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_IppTerritories
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_IppTerritories extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_Territory */
	private $__TerritoryA = array();


	

	

	
	

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
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppTerritories
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







	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:IPP_TERRITORIES');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:IPP_TERRITORIES');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__TerritoryA != null){
			foreach($this->__TerritoryA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
