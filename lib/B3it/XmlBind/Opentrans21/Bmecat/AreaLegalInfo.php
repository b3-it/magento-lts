<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_AreaLegalInfo
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_AreaLegalInfo extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_Territory */
	private $__TerritoryA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_AreaRefs */
	private $__AreaRefs = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_LegalText */
	private $__LegalTextA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_MimeInfo */
	private $__MimeInfo = null;


	

	

	
	

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
	 * @return B3it_XmlBind_Opentrans21_Bmecat_AreaLegalInfo
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
	 * @return B3it_XmlBind_Opentrans21_Bmecat_AreaLegalInfo
	 */
	public function setAreaRefs($value)
	{
		$this->__AreaRefs = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_LegalText and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_LegalText
	 */
	public function getLegalText()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_LegalText();
		$this->__LegalTextA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_LegalText
	 * @return B3it_XmlBind_Opentrans21_Bmecat_AreaLegalInfo
	 */
	public function setLegalText($value)
	{
		$this->__LegalTextA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_LegalText[]
	 */
	public function getAllLegalText()
	{
		return $this->__LegalTextA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_MimeInfo
	 */
	public function getMimeInfo()
	{
		if($this->__MimeInfo == null)
		{
			$this->__MimeInfo = new B3it_XmlBind_Opentrans21_Bmecat_MimeInfo();
		}
	
		return $this->__MimeInfo;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_MimeInfo
	 * @return B3it_XmlBind_Opentrans21_Bmecat_AreaLegalInfo
	 */
	public function setMimeInfo($value)
	{
		$this->__MimeInfo = $value;
		return $this;
	}





	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:AREA_LEGAL_INFO');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:AREA_LEGAL_INFO');
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
		if($this->__LegalTextA != null){
			foreach($this->__LegalTextA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__MimeInfo != null){
			$this->__MimeInfo->toXml($xml);
		}


		return $xml;
	}

}
