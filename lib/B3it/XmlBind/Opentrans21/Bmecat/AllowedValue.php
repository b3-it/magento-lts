<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_AllowedValue
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_AllowedValue extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_AllowedValueId */
	private $__AllowedValueId = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_AllowedValueName */
	private $__AllowedValueNameA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_AllowedValueVersion */
	private $__AllowedValueVersion = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_AllowedValueShortname */
	private $__AllowedValueShortnameA = array();

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_AllowedValueDescr */
	private $__AllowedValueDescrA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_AllowedValueSynonyms */
	private $__AllowedValueSynonyms = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_AllowedValueSource */
	private $__AllowedValueSource = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_AllowedValueId
	 */
	public function getAllowedValueId()
	{
		if($this->__AllowedValueId == null)
		{
			$this->__AllowedValueId = new B3it_XmlBind_Opentrans21_Bmecat_AllowedValueId();
		}
	
		return $this->__AllowedValueId;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_AllowedValueId
	 * @return B3it_XmlBind_Opentrans21_Bmecat_AllowedValue
	 */
	public function setAllowedValueId($value)
	{
		$this->__AllowedValueId = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_AllowedValueName and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_AllowedValueName
	 */
	public function getAllowedValueName()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_AllowedValueName();
		$this->__AllowedValueNameA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_AllowedValueName
	 * @return B3it_XmlBind_Opentrans21_Bmecat_AllowedValue
	 */
	public function setAllowedValueName($value)
	{
		$this->__AllowedValueNameA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_AllowedValueName[]
	 */
	public function getAllAllowedValueName()
	{
		return $this->__AllowedValueNameA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_AllowedValueVersion
	 */
	public function getAllowedValueVersion()
	{
		if($this->__AllowedValueVersion == null)
		{
			$this->__AllowedValueVersion = new B3it_XmlBind_Opentrans21_Bmecat_AllowedValueVersion();
		}
	
		return $this->__AllowedValueVersion;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_AllowedValueVersion
	 * @return B3it_XmlBind_Opentrans21_Bmecat_AllowedValue
	 */
	public function setAllowedValueVersion($value)
	{
		$this->__AllowedValueVersion = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_AllowedValueShortname and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_AllowedValueShortname
	 */
	public function getAllowedValueShortname()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_AllowedValueShortname();
		$this->__AllowedValueShortnameA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_AllowedValueShortname
	 * @return B3it_XmlBind_Opentrans21_Bmecat_AllowedValue
	 */
	public function setAllowedValueShortname($value)
	{
		$this->__AllowedValueShortnameA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_AllowedValueShortname[]
	 */
	public function getAllAllowedValueShortname()
	{
		return $this->__AllowedValueShortnameA;
	}


	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_AllowedValueDescr and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_AllowedValueDescr
	 */
	public function getAllowedValueDescr()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_AllowedValueDescr();
		$this->__AllowedValueDescrA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_AllowedValueDescr
	 * @return B3it_XmlBind_Opentrans21_Bmecat_AllowedValue
	 */
	public function setAllowedValueDescr($value)
	{
		$this->__AllowedValueDescrA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_AllowedValueDescr[]
	 */
	public function getAllAllowedValueDescr()
	{
		return $this->__AllowedValueDescrA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_AllowedValueSynonyms
	 */
	public function getAllowedValueSynonyms()
	{
		if($this->__AllowedValueSynonyms == null)
		{
			$this->__AllowedValueSynonyms = new B3it_XmlBind_Opentrans21_Bmecat_AllowedValueSynonyms();
		}
	
		return $this->__AllowedValueSynonyms;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_AllowedValueSynonyms
	 * @return B3it_XmlBind_Opentrans21_Bmecat_AllowedValue
	 */
	public function setAllowedValueSynonyms($value)
	{
		$this->__AllowedValueSynonyms = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_AllowedValueSource
	 */
	public function getAllowedValueSource()
	{
		if($this->__AllowedValueSource == null)
		{
			$this->__AllowedValueSource = new B3it_XmlBind_Opentrans21_Bmecat_AllowedValueSource();
		}
	
		return $this->__AllowedValueSource;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_AllowedValueSource
	 * @return B3it_XmlBind_Opentrans21_Bmecat_AllowedValue
	 */
	public function setAllowedValueSource($value)
	{
		$this->__AllowedValueSource = $value;
		return $this;
	}





	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:ALLOWED_VALUE');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:ALLOWED_VALUE');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__AllowedValueId != null){
			$this->__AllowedValueId->toXml($xml);
		}
		if($this->__AllowedValueNameA != null){
			foreach($this->__AllowedValueNameA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__AllowedValueVersion != null){
			$this->__AllowedValueVersion->toXml($xml);
		}
		if($this->__AllowedValueShortnameA != null){
			foreach($this->__AllowedValueShortnameA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__AllowedValueDescrA != null){
			foreach($this->__AllowedValueDescrA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__AllowedValueSynonyms != null){
			$this->__AllowedValueSynonyms->toXml($xml);
		}
		if($this->__AllowedValueSource != null){
			$this->__AllowedValueSource->toXml($xml);
		}


		return $xml;
	}

}
