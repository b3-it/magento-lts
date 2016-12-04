<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_Area
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_Area extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_AreaId */
	private $__AreaId = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_AreaName */
	private $__AreaNameA = array();

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_AreaDescr */
	private $__AreaDescrA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_Territories */
	private $__Territories = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_AreaId
	 */
	public function getAreaId()
	{
		if($this->__AreaId == null)
		{
			$this->__AreaId = new B3it_XmlBind_Opentrans21_Bmecat_AreaId();
		}
	
		return $this->__AreaId;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_AreaId
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Area
	 */
	public function setAreaId($value)
	{
		$this->__AreaId = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_AreaName and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_AreaName
	 */
	public function getAreaName()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_AreaName();
		$this->__AreaNameA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_AreaName
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Area
	 */
	public function setAreaName($value)
	{
		$this->__AreaNameA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_AreaName[]
	 */
	public function getAllAreaName()
	{
		return $this->__AreaNameA;
	}


	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_AreaDescr and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_AreaDescr
	 */
	public function getAreaDescr()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_AreaDescr();
		$this->__AreaDescrA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_AreaDescr
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Area
	 */
	public function setAreaDescr($value)
	{
		$this->__AreaDescrA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_AreaDescr[]
	 */
	public function getAllAreaDescr()
	{
		return $this->__AreaDescrA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Territories
	 */
	public function getTerritories()
	{
		if($this->__Territories == null)
		{
			$this->__Territories = new B3it_XmlBind_Opentrans21_Bmecat_Territories();
		}
	
		return $this->__Territories;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Territories
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Area
	 */
	public function setTerritories($value)
	{
		$this->__Territories = $value;
		return $this;
	}





	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:AREA');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:AREA');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__AreaId != null){
			$this->__AreaId->toXml($xml);
		}
		if($this->__AreaNameA != null){
			foreach($this->__AreaNameA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__AreaDescrA != null){
			foreach($this->__AreaDescrA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__Territories != null){
			$this->__Territories->toXml($xml);
		}


		return $xml;
	}

}
