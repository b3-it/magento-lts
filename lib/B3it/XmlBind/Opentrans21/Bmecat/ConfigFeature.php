<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_ConfigFeature
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_ConfigFeature extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_Fref */
	private $__Fref = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_Ftemplate */
	private $__Ftemplate = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_MimeInfo */
	private $__MimeInfo = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Fref
	 */
	public function getFref()
	{
		if($this->__Fref == null)
		{
			$this->__Fref = new B3it_XmlBind_Opentrans21_Bmecat_Fref();
		}
	
		return $this->__Fref;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Fref
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ConfigFeature
	 */
	public function setFref($value)
	{
		$this->__Fref = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Ftemplate
	 */
	public function getFtemplate()
	{
		if($this->__Ftemplate == null)
		{
			$this->__Ftemplate = new B3it_XmlBind_Opentrans21_Bmecat_Ftemplate();
		}
	
		return $this->__Ftemplate;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Ftemplate
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ConfigFeature
	 */
	public function setFtemplate($value)
	{
		$this->__Ftemplate = $value;
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
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ConfigFeature
	 */
	public function setMimeInfo($value)
	{
		$this->__MimeInfo = $value;
		return $this;
	}





	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:CONFIG_FEATURE');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:CONFIG_FEATURE');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__Fref != null){
			$this->__Fref->toXml($xml);
		}
		if($this->__Ftemplate != null){
			$this->__Ftemplate->toXml($xml);
		}
		if($this->__MimeInfo != null){
			$this->__MimeInfo->toXml($xml);
		}


		return $xml;
	}

}
