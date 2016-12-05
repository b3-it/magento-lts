<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_Unit
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_Unit extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_UnitId */
	private $__UnitId = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_UnitName */
	private $__UnitNameA = array();

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_UnitShortname */
	private $__UnitShortnameA = array();

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_UnitDescr */
	private $__UnitDescrA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_UnitCode */
	private $__UnitCode = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_UnitUri */
	private $__UnitUri = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_UnitId
	 */
	public function getUnitId()
	{
		if($this->__UnitId == null)
		{
			$this->__UnitId = new B3it_XmlBind_Opentrans21_Bmecat_UnitId();
		}
	
		return $this->__UnitId;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_UnitId
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Unit
	 */
	public function setUnitId($value)
	{
		$this->__UnitId = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_UnitName and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_UnitName
	 */
	public function getUnitName()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_UnitName();
		$this->__UnitNameA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_UnitName
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Unit
	 */
	public function setUnitName($value)
	{
		$this->__UnitNameA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_UnitName[]
	 */
	public function getAllUnitName()
	{
		return $this->__UnitNameA;
	}


	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_UnitShortname and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_UnitShortname
	 */
	public function getUnitShortname()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_UnitShortname();
		$this->__UnitShortnameA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_UnitShortname
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Unit
	 */
	public function setUnitShortname($value)
	{
		$this->__UnitShortnameA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_UnitShortname[]
	 */
	public function getAllUnitShortname()
	{
		return $this->__UnitShortnameA;
	}


	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_UnitDescr and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_UnitDescr
	 */
	public function getUnitDescr()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_UnitDescr();
		$this->__UnitDescrA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_UnitDescr
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Unit
	 */
	public function setUnitDescr($value)
	{
		$this->__UnitDescrA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_UnitDescr[]
	 */
	public function getAllUnitDescr()
	{
		return $this->__UnitDescrA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_UnitCode
	 */
	public function getUnitCode()
	{
		if($this->__UnitCode == null)
		{
			$this->__UnitCode = new B3it_XmlBind_Opentrans21_Bmecat_UnitCode();
		}
	
		return $this->__UnitCode;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_UnitCode
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Unit
	 */
	public function setUnitCode($value)
	{
		$this->__UnitCode = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_UnitUri
	 */
	public function getUnitUri()
	{
		if($this->__UnitUri == null)
		{
			$this->__UnitUri = new B3it_XmlBind_Opentrans21_Bmecat_UnitUri();
		}
	
		return $this->__UnitUri;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_UnitUri
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Unit
	 */
	public function setUnitUri($value)
	{
		$this->__UnitUri = $value;
		return $this;
	}





	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:UNIT');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:UNIT');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__UnitId != null){
			$this->__UnitId->toXml($xml);
		}
		if($this->__UnitNameA != null){
			foreach($this->__UnitNameA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__UnitShortnameA != null){
			foreach($this->__UnitShortnameA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__UnitDescrA != null){
			foreach($this->__UnitDescrA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__UnitCode != null){
			$this->__UnitCode->toXml($xml);
		}
		if($this->__UnitUri != null){
			$this->__UnitUri->toXml($xml);
		}


		return $xml;
	}

}
