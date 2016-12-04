<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_ClassificationGroupSynonyms
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupSynonyms extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_Synonym */
	private $__SynonymA = array();


	

	

	
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_Synonym and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Synonym
	 */
	public function getSynonym()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_Synonym();
		$this->__SynonymA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Synonym
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupSynonyms
	 */
	public function setSynonym($value)
	{
		$this->__SynonymA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Synonym[]
	 */
	public function getAllSynonym()
	{
		return $this->__SynonymA;
	}







	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:CLASSIFICATION_GROUP_SYNONYMS');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:CLASSIFICATION_GROUP_SYNONYMS');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__SynonymA != null){
			foreach($this->__SynonymA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
