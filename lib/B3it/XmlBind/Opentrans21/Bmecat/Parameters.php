<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_Parameters
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_Parameters extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_Parameter */
	private $__ParameterA = array();


	

	

	
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_Parameter and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Parameter
	 */
	public function getParameter()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_Parameter();
		$this->__ParameterA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Parameter
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Parameters
	 */
	public function setParameter($value)
	{
		$this->__ParameterA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Parameter[]
	 */
	public function getAllParameter()
	{
		return $this->__ParameterA;
	}







	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:PARAMETERS');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:PARAMETERS');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__ParameterA != null){
			foreach($this->__ParameterA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
