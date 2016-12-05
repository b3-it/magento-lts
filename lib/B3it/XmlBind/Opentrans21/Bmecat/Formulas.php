<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_Formulas
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_Formulas extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_Formula */
	private $__FormulaA = array();


	

	

	
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_Formula and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Formula
	 */
	public function getFormula()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_Formula();
		$this->__FormulaA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Formula
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Formulas
	 */
	public function setFormula($value)
	{
		$this->__FormulaA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Formula[]
	 */
	public function getAllFormula()
	{
		return $this->__FormulaA;
	}







	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:FORMULAS');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:FORMULAS');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__FormulaA != null){
			foreach($this->__FormulaA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
