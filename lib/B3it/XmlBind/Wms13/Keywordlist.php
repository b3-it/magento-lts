<?php
/**
 *
 * XML Bind  für WMS 1.3
 * @category   	B3it
 * @package    	B3it_XmlBind_Wms13_
 * @name       	Keywordlist
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Wms13_Keywordlist extends B3it_XmlBind_Wms13_XmlObject
{
	
	
	
	/* @var B3it_XmlBind_Wms13_Keyword */
	private $__KeywordA = array();


	

	

	
	

	/**
	 * Create new B3it_XmlBind_Wms13_Keyword and add it to list
	 * @return B3it_XmlBind_Wms13_Keyword
	 */
	public function getKeyword()
	{
		$res = new B3it_XmlBind_Wms13_Keyword();
		$this->__KeywordA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Wms13_Keyword
	 * @return B3it_XmlBind_Wms13_Keywordlist
	 */
	public function setKeyword($value)
	{
		$this->__KeywordA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Wms13_Keyword[]
	 */
	public function getAllKeyword()
	{
		return $this->__KeywordA;
	}







	public function toXml($xml)
	{
		$node = new DOMElement('KeywordList');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__KeywordA != null){
			foreach($this->__KeywordA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
