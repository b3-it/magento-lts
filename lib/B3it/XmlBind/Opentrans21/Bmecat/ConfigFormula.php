<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_ConfigFormula
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_ConfigFormula extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_FormulaIdref */
	private $__FormulaIdref = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_Parameters */
	private $__Parameters = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FormulaIdref
	 */
	public function getFormulaIdref()
	{
		if($this->__FormulaIdref == null)
		{
			$this->__FormulaIdref = new B3it_XmlBind_Opentrans21_Bmecat_FormulaIdref();
		}
	
		return $this->__FormulaIdref;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_FormulaIdref
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ConfigFormula
	 */
	public function setFormulaIdref($value)
	{
		$this->__FormulaIdref = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Parameters
	 */
	public function getParameters()
	{
		if($this->__Parameters == null)
		{
			$this->__Parameters = new B3it_XmlBind_Opentrans21_Bmecat_Parameters();
		}
	
		return $this->__Parameters;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Parameters
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ConfigFormula
	 */
	public function setParameters($value)
	{
		$this->__Parameters = $value;
		return $this;
	}





	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:CONFIG_FORMULA');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:CONFIG_FORMULA');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__FormulaIdref != null){
			$this->__FormulaIdref->toXml($xml);
		}
		if($this->__Parameters != null){
			$this->__Parameters->toXml($xml);
		}


		return $xml;
	}

}
