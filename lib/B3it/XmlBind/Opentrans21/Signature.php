<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Signature
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Signature extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Mime */
	private $__Mime = null;

	/* @var B3it_XmlBind_Opentrans21_SignatureInOriginal */
	private $__SignatureInOriginal = null;

	/* @var B3it_XmlBind_Opentrans21_XmlSignature */
	private $__XmlSignature = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Mime
	 */
	public function getMime()
	{
		if($this->__Mime == null)
		{
			$this->__Mime = new B3it_XmlBind_Opentrans21_Mime();
		}
	
		return $this->__Mime;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Mime
	 * @return B3it_XmlBind_Opentrans21_Signature
	 */
	public function setMime($value)
	{
		$this->__Mime = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_SignatureInOriginal
	 */
	public function getSignatureInOriginal()
	{
		if($this->__SignatureInOriginal == null)
		{
			$this->__SignatureInOriginal = new B3it_XmlBind_Opentrans21_SignatureInOriginal();
		}
	
		return $this->__SignatureInOriginal;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_SignatureInOriginal
	 * @return B3it_XmlBind_Opentrans21_Signature
	 */
	public function setSignatureInOriginal($value)
	{
		$this->__SignatureInOriginal = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_XmlSignature
	 */
	public function getXmlSignature()
	{
		if($this->__XmlSignature == null)
		{
			$this->__XmlSignature = new B3it_XmlBind_Opentrans21_XmlSignature();
		}
	
		return $this->__XmlSignature;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_XmlSignature
	 * @return B3it_XmlBind_Opentrans21_Signature
	 */
	public function setXmlSignature($value)
	{
		$this->__XmlSignature = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('SIGNATURE');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__Mime != null){
			$this->__Mime->toXml($xml);
		}
		if($this->__SignatureInOriginal != null){
			$this->__SignatureInOriginal->toXml($xml);
		}
		if($this->__XmlSignature != null){
			$this->__XmlSignature->toXml($xml);
		}


		return $xml;
	}

}
