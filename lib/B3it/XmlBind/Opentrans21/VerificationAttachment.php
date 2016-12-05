<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	VerificationAttachment
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_VerificationAttachment extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Mime */
	private $__Mime = null;


	

	

	
	
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
	 * @return B3it_XmlBind_Opentrans21_VerificationAttachment
	 */
	public function setMime($value)
	{
		$this->__Mime = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('VERIFICATION_ATTACHMENT');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__Mime != null){
			$this->__Mime->toXml($xml);
		}


		return $xml;
	}

}
