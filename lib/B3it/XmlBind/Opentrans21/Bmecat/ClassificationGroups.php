<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_ClassificationGroups
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroups extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroup */
	private $__ClassificationGroupA = array();


	

	

	
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroup and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroup
	 */
	public function getClassificationGroup()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroup();
		$this->__ClassificationGroupA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroup
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroups
	 */
	public function setClassificationGroup($value)
	{
		$this->__ClassificationGroupA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroup[]
	 */
	public function getAllClassificationGroup()
	{
		return $this->__ClassificationGroupA;
	}







	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:CLASSIFICATION_GROUPS');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:CLASSIFICATION_GROUPS');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__ClassificationGroupA != null){
			foreach($this->__ClassificationGroupA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
