<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_Authentification
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_Authentification extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_Login */
	private $__Login = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_Password */
	private $__Password = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Login
	 */
	public function getLogin()
	{
		if($this->__Login == null)
		{
			$this->__Login = new B3it_XmlBind_Opentrans21_Bmecat_Login();
		}
	
		return $this->__Login;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Login
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Authentification
	 */
	public function setLogin($value)
	{
		$this->__Login = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Password
	 */
	public function getPassword()
	{
		if($this->__Password == null)
		{
			$this->__Password = new B3it_XmlBind_Opentrans21_Bmecat_Password();
		}
	
		return $this->__Password;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Password
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Authentification
	 */
	public function setPassword($value)
	{
		$this->__Password = $value;
		return $this;
	}





	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:AUTHENTIFICATION');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:AUTHENTIFICATION');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__Login != null){
			$this->__Login->toXml($xml);
		}
		if($this->__Password != null){
			$this->__Password->toXml($xml);
		}


		return $xml;
	}

}
