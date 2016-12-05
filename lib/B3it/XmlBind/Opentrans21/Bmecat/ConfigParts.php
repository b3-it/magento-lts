<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_ConfigParts
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_ConfigParts extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_PartAlternative */
	private $__PartAlternativeA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_PartSelectionType */
	private $__PartSelectionType = null;


	

	

	
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_PartAlternative and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_PartAlternative
	 */
	public function getPartAlternative()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_PartAlternative();
		$this->__PartAlternativeA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_PartAlternative
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ConfigParts
	 */
	public function setPartAlternative($value)
	{
		$this->__PartAlternativeA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_PartAlternative[]
	 */
	public function getAllPartAlternative()
	{
		return $this->__PartAlternativeA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_PartSelectionType
	 */
	public function getPartSelectionType()
	{
		if($this->__PartSelectionType == null)
		{
			$this->__PartSelectionType = new B3it_XmlBind_Opentrans21_Bmecat_PartSelectionType();
		}
	
		return $this->__PartSelectionType;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_PartSelectionType
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ConfigParts
	 */
	public function setPartSelectionType($value)
	{
		$this->__PartSelectionType = $value;
		return $this;
	}





	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:CONFIG_PARTS');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:CONFIG_PARTS');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__PartAlternativeA != null){
			foreach($this->__PartAlternativeA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__PartSelectionType != null){
			$this->__PartSelectionType->toXml($xml);
		}


		return $xml;
	}

}
