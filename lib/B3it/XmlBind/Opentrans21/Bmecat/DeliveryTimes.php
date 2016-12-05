<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_DeliveryTimes
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_DeliveryTimes extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_Territory */
	private $__TerritoryA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_AreaRefs */
	private $__AreaRefs = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_TimeSpan */
	private $__TimeSpanA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_Leadtime */
	private $__Leadtime = null;


	

	

	
	

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
	 * @return B3it_XmlBind_Opentrans21_Bmecat_DeliveryTimes
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
	 * @return B3it_XmlBind_Opentrans21_Bmecat_DeliveryTimes
	 */
	public function setAreaRefs($value)
	{
		$this->__AreaRefs = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_TimeSpan and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_TimeSpan
	 */
	public function getTimeSpan()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_TimeSpan();
		$this->__TimeSpanA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_TimeSpan
	 * @return B3it_XmlBind_Opentrans21_Bmecat_DeliveryTimes
	 */
	public function setTimeSpan($value)
	{
		$this->__TimeSpanA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_TimeSpan[]
	 */
	public function getAllTimeSpan()
	{
		return $this->__TimeSpanA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Leadtime
	 */
	public function getLeadtime()
	{
		if($this->__Leadtime == null)
		{
			$this->__Leadtime = new B3it_XmlBind_Opentrans21_Bmecat_Leadtime();
		}
	
		return $this->__Leadtime;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Leadtime
	 * @return B3it_XmlBind_Opentrans21_Bmecat_DeliveryTimes
	 */
	public function setLeadtime($value)
	{
		$this->__Leadtime = $value;
		return $this;
	}





	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:DELIVERY_TIMES');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:DELIVERY_TIMES');
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
		if($this->__AreaRefs != null){
			$this->__AreaRefs->toXml($xml);
		}
		if($this->__TimeSpanA != null){
			foreach($this->__TimeSpanA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__Leadtime != null){
			$this->__Leadtime->toXml($xml);
		}


		return $xml;
	}

}
