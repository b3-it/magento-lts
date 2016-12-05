<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_IppAuthentificationInfo
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_IppAuthentificationInfo extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_Authentification */
	private $__AuthentificationA = array();


	

	

	
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_Authentification and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Authentification
	 */
	public function getAuthentification()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_Authentification();
		$this->__AuthentificationA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Authentification
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppAuthentificationInfo
	 */
	public function setAuthentification($value)
	{
		$this->__AuthentificationA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Authentification[]
	 */
	public function getAllAuthentification()
	{
		return $this->__AuthentificationA;
	}







	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:IPP_AUTHENTIFICATION_INFO');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:IPP_AUTHENTIFICATION_INFO');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__AuthentificationA != null){
			foreach($this->__AuthentificationA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
