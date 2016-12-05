<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_AllowedValues
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_AllowedValues extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_AllowedValue */
	private $__AllowedValueA = array();


	

	

	
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_AllowedValue and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_AllowedValue
	 */
	public function getAllowedValue()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_AllowedValue();
		$this->__AllowedValueA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_AllowedValue
	 * @return B3it_XmlBind_Opentrans21_Bmecat_AllowedValues
	 */
	public function setAllowedValue($value)
	{
		$this->__AllowedValueA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_AllowedValue[]
	 */
	public function getAllAllowedValue()
	{
		return $this->__AllowedValueA;
	}







	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:ALLOWED_VALUES');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:ALLOWED_VALUES');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__AllowedValueA != null){
			foreach($this->__AllowedValueA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
