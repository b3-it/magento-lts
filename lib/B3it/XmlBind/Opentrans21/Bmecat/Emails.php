<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_Emails
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_Emails extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_Email */
	private $__Email = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_PublicKey */
	private $__PublicKeyA = array();


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Email
	 */
	public function getEmail()
	{
		if($this->__Email == null)
		{
			$this->__Email = new B3it_XmlBind_Opentrans21_Bmecat_Email();
		}
	
		return $this->__Email;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Email
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Emails
	 */
	public function setEmail($value)
	{
		$this->__Email = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_PublicKey and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_PublicKey
	 */
	public function getPublicKey()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_PublicKey();
		$this->__PublicKeyA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_PublicKey
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Emails
	 */
	public function setPublicKey($value)
	{
		$this->__PublicKeyA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_PublicKey[]
	 */
	public function getAllPublicKey()
	{
		return $this->__PublicKeyA;
	}







	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:EMAILS');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:EMAILS');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__Email != null){
			$this->__Email->toXml($xml);
		}
		if($this->__PublicKeyA != null){
			foreach($this->__PublicKeyA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
