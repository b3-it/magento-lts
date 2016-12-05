<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_IppDefinitions
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_IppDefinitions extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_IppDefinition */
	private $__IppDefinitionA = array();


	

	

	
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_IppDefinition and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppDefinition
	 */
	public function getIppDefinition()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_IppDefinition();
		$this->__IppDefinitionA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_IppDefinition
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppDefinitions
	 */
	public function setIppDefinition($value)
	{
		$this->__IppDefinitionA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppDefinition[]
	 */
	public function getAllIppDefinition()
	{
		return $this->__IppDefinitionA;
	}







	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:IPP_DEFINITIONS');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:IPP_DEFINITIONS');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__IppDefinitionA != null){
			foreach($this->__IppDefinitionA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
