<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_FtValue
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_FtValue extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_ValueIdref */
	private $__ValueIdref = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_ValueSimple */
	private $__ValueSimple = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_ValueText */
	private $__ValueText = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_ValueRange */
	private $__ValueRange = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_MimeInfo */
	private $__MimeInfo = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_ConfigInfo */
	private $__ConfigInfo = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_ValueOrder */
	private $__ValueOrder = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_DefaultFlag */
	private $__DefaultFlag = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ValueIdref
	 */
	public function getValueIdref()
	{
		if($this->__ValueIdref == null)
		{
			$this->__ValueIdref = new B3it_XmlBind_Opentrans21_Bmecat_ValueIdref();
		}
	
		return $this->__ValueIdref;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ValueIdref
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FtValue
	 */
	public function setValueIdref($value)
	{
		$this->__ValueIdref = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ValueSimple
	 */
	public function getValueSimple()
	{
		if($this->__ValueSimple == null)
		{
			$this->__ValueSimple = new B3it_XmlBind_Opentrans21_Bmecat_ValueSimple();
		}
	
		return $this->__ValueSimple;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ValueSimple
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FtValue
	 */
	public function setValueSimple($value)
	{
		$this->__ValueSimple = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ValueText
	 */
	public function getValueText()
	{
		if($this->__ValueText == null)
		{
			$this->__ValueText = new B3it_XmlBind_Opentrans21_Bmecat_ValueText();
		}
	
		return $this->__ValueText;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ValueText
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FtValue
	 */
	public function setValueText($value)
	{
		$this->__ValueText = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ValueRange
	 */
	public function getValueRange()
	{
		if($this->__ValueRange == null)
		{
			$this->__ValueRange = new B3it_XmlBind_Opentrans21_Bmecat_ValueRange();
		}
	
		return $this->__ValueRange;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ValueRange
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FtValue
	 */
	public function setValueRange($value)
	{
		$this->__ValueRange = $value;
		return $this;
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
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FtValue
	 */
	public function setMimeInfo($value)
	{
		$this->__MimeInfo = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ConfigInfo
	 */
	public function getConfigInfo()
	{
		if($this->__ConfigInfo == null)
		{
			$this->__ConfigInfo = new B3it_XmlBind_Opentrans21_Bmecat_ConfigInfo();
		}
	
		return $this->__ConfigInfo;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ConfigInfo
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FtValue
	 */
	public function setConfigInfo($value)
	{
		$this->__ConfigInfo = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ValueOrder
	 */
	public function getValueOrder()
	{
		if($this->__ValueOrder == null)
		{
			$this->__ValueOrder = new B3it_XmlBind_Opentrans21_Bmecat_ValueOrder();
		}
	
		return $this->__ValueOrder;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ValueOrder
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FtValue
	 */
	public function setValueOrder($value)
	{
		$this->__ValueOrder = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_DefaultFlag
	 */
	public function getDefaultFlag()
	{
		if($this->__DefaultFlag == null)
		{
			$this->__DefaultFlag = new B3it_XmlBind_Opentrans21_Bmecat_DefaultFlag();
		}
	
		return $this->__DefaultFlag;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_DefaultFlag
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FtValue
	 */
	public function setDefaultFlag($value)
	{
		$this->__DefaultFlag = $value;
		return $this;
	}





	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:FT_VALUE');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:FT_VALUE');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__ValueIdref != null){
			$this->__ValueIdref->toXml($xml);
		}
		if($this->__ValueSimple != null){
			$this->__ValueSimple->toXml($xml);
		}
		if($this->__ValueText != null){
			$this->__ValueText->toXml($xml);
		}
		if($this->__ValueRange != null){
			$this->__ValueRange->toXml($xml);
		}
		if($this->__MimeInfo != null){
			$this->__MimeInfo->toXml($xml);
		}
		if($this->__ConfigInfo != null){
			$this->__ConfigInfo->toXml($xml);
		}
		if($this->__ValueOrder != null){
			$this->__ValueOrder->toXml($xml);
		}
		if($this->__DefaultFlag != null){
			$this->__DefaultFlag->toXml($xml);
		}


		return $xml;
	}

}
