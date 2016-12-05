<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_ParameterDefinitions
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_ParameterDefinitions extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_ParameterDefinition */
	private $__ParameterDefinitionA = array();


	

	

	
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_ParameterDefinition and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ParameterDefinition
	 */
	public function getParameterDefinition()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_ParameterDefinition();
		$this->__ParameterDefinitionA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ParameterDefinition
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ParameterDefinitions
	 */
	public function setParameterDefinition($value)
	{
		$this->__ParameterDefinitionA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ParameterDefinition[]
	 */
	public function getAllParameterDefinition()
	{
		return $this->__ParameterDefinitionA;
	}







	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:PARAMETER_DEFINITIONS');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:PARAMETER_DEFINITIONS');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__ParameterDefinitionA != null){
			foreach($this->__ParameterDefinitionA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
