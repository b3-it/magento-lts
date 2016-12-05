<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_ConfigFormulas
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_ConfigFormulas extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_ConfigFormula */
	private $__ConfigFormula = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ConfigFormula
	 */
	public function getConfigFormula()
	{
		if($this->__ConfigFormula == null)
		{
			$this->__ConfigFormula = new B3it_XmlBind_Opentrans21_Bmecat_ConfigFormula();
		}
	
		return $this->__ConfigFormula;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ConfigFormula
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ConfigFormulas
	 */
	public function setConfigFormula($value)
	{
		$this->__ConfigFormula = $value;
		return $this;
	}





	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:CONFIG_FORMULAS');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:CONFIG_FORMULAS');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__ConfigFormula != null){
			$this->__ConfigFormula->toXml($xml);
		}


		return $xml;
	}

}
