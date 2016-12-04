<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_FtAllowedValues
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_FtAllowedValues extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_AllowedValueIdref */
	private $__AllowedValueIdrefA = array();


	

	

	
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_AllowedValueIdref and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_AllowedValueIdref
	 */
	public function getAllowedValueIdref()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_AllowedValueIdref();
		$this->__AllowedValueIdrefA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_AllowedValueIdref
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FtAllowedValues
	 */
	public function setAllowedValueIdref($value)
	{
		$this->__AllowedValueIdrefA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_AllowedValueIdref[]
	 */
	public function getAllAllowedValueIdref()
	{
		return $this->__AllowedValueIdrefA;
	}







	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:FT_ALLOWED_VALUES');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:FT_ALLOWED_VALUES');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__AllowedValueIdrefA != null){
			foreach($this->__AllowedValueIdrefA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
