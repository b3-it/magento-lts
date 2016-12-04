<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_IppInboundParams
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_IppInboundParams extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_IppParamDefinition */
	private $__IppParamDefinitionA = array();


	

	

	
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_IppParamDefinition and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppParamDefinition
	 */
	public function getIppParamDefinition()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_IppParamDefinition();
		$this->__IppParamDefinitionA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_IppParamDefinition
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppInboundParams
	 */
	public function setIppParamDefinition($value)
	{
		$this->__IppParamDefinitionA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_IppParamDefinition[]
	 */
	public function getAllIppParamDefinition()
	{
		return $this->__IppParamDefinitionA;
	}







	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:IPP_INBOUND_PARAMS');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:IPP_INBOUND_PARAMS');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__IppParamDefinitionA != null){
			foreach($this->__IppParamDefinitionA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
