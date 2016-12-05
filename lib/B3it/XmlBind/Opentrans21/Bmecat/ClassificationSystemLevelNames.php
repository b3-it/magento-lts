<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_ClassificationSystemLevelNames
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystemLevelNames extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystemLevelName */
	private $__ClassificationSystemLevelNameA = array();


	

	

	
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystemLevelName and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystemLevelName
	 */
	public function getClassificationSystemLevelName()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystemLevelName();
		$this->__ClassificationSystemLevelNameA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystemLevelName
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystemLevelNames
	 */
	public function setClassificationSystemLevelName($value)
	{
		$this->__ClassificationSystemLevelNameA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystemLevelName[]
	 */
	public function getAllClassificationSystemLevelName()
	{
		return $this->__ClassificationSystemLevelNameA;
	}







	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:CLASSIFICATION_SYSTEM_LEVEL_NAMES');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:CLASSIFICATION_SYSTEM_LEVEL_NAMES');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__ClassificationSystemLevelNameA != null){
			foreach($this->__ClassificationSystemLevelNameA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
