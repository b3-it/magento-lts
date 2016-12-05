<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_AreaRefs
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_AreaRefs extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_AreaIdref */
	private $__AreaIdrefA = array();


	

	

	
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_AreaIdref and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_AreaIdref
	 */
	public function getAreaIdref()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_AreaIdref();
		$this->__AreaIdrefA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_AreaIdref
	 * @return B3it_XmlBind_Opentrans21_Bmecat_AreaRefs
	 */
	public function setAreaIdref($value)
	{
		$this->__AreaIdrefA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_AreaIdref[]
	 */
	public function getAllAreaIdref()
	{
		return $this->__AreaIdrefA;
	}







	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:AREA_REFS');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:AREA_REFS');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__AreaIdrefA != null){
			foreach($this->__AreaIdrefA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
