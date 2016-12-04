<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_FtFacets
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_FtFacets extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_FtFacet */
	private $__FtFacetA = array();


	

	

	
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_FtFacet and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FtFacet
	 */
	public function getFtFacet()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_FtFacet();
		$this->__FtFacetA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_FtFacet
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FtFacets
	 */
	public function setFtFacet($value)
	{
		$this->__FtFacetA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FtFacet[]
	 */
	public function getAllFtFacet()
	{
		return $this->__FtFacetA;
	}







	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:FT_FACETS');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:FT_FACETS');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__FtFacetA != null){
			foreach($this->__FtFacetA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
