<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_FtDependencies
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_FtDependencies extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_FtIdref */
	private $__FtIdrefA = array();


	

	

	
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_FtIdref and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FtIdref
	 */
	public function getFtIdref()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_FtIdref();
		$this->__FtIdrefA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_FtIdref
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FtDependencies
	 */
	public function setFtIdref($value)
	{
		$this->__FtIdrefA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FtIdref[]
	 */
	public function getAllFtIdref()
	{
		return $this->__FtIdrefA;
	}







	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:FT_DEPENDENCIES');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:FT_DEPENDENCIES');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__FtIdrefA != null){
			foreach($this->__FtIdrefA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
