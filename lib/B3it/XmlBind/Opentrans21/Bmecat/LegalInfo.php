<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_LegalInfo
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_LegalInfo extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_AreaLegalInfo */
	private $__AreaLegalInfoA = array();


	

	

	
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_AreaLegalInfo and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_AreaLegalInfo
	 */
	public function getAreaLegalInfo()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_AreaLegalInfo();
		$this->__AreaLegalInfoA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_AreaLegalInfo
	 * @return B3it_XmlBind_Opentrans21_Bmecat_LegalInfo
	 */
	public function setAreaLegalInfo($value)
	{
		$this->__AreaLegalInfoA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_AreaLegalInfo[]
	 */
	public function getAllAreaLegalInfo()
	{
		return $this->__AreaLegalInfoA;
	}







	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:LEGAL_INFO');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:LEGAL_INFO');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__AreaLegalInfoA != null){
			foreach($this->__AreaLegalInfoA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
