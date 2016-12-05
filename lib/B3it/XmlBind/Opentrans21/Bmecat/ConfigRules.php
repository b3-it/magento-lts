<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_ConfigRules
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_ConfigRules extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_Term */
	private $__TermA = array();


	

	

	
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_Term and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Term
	 */
	public function getTerm()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_Term();
		$this->__TermA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Term
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ConfigRules
	 */
	public function setTerm($value)
	{
		$this->__TermA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Term[]
	 */
	public function getAllTerm()
	{
		return $this->__TermA;
	}







	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:CONFIG_RULES');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:CONFIG_RULES');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__TermA != null){
			foreach($this->__TermA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
