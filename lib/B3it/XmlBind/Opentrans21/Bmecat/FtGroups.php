<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_FtGroups
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_FtGroups extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_FtGroup */
	private $__FtGroupA = array();


	

	

	
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_FtGroup and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FtGroup
	 */
	public function getFtGroup()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_FtGroup();
		$this->__FtGroupA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_FtGroup
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FtGroups
	 */
	public function setFtGroup($value)
	{
		$this->__FtGroupA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FtGroup[]
	 */
	public function getAllFtGroup()
	{
		return $this->__FtGroupA;
	}







	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:FT_GROUPS');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:FT_GROUPS');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__FtGroupA != null){
			foreach($this->__FtGroupA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
