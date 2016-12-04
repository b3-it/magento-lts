<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_FtValues
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_FtValues extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_FtValue */
	private $__FtValueA = array();


	

	

	
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_FtValue and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FtValue
	 */
	public function getFtValue()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_FtValue();
		$this->__FtValueA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_FtValue
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FtValues
	 */
	public function setFtValue($value)
	{
		$this->__FtValueA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FtValue[]
	 */
	public function getAllFtValue()
	{
		return $this->__FtValueA;
	}







	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:FT_VALUES');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:FT_VALUES');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__FtValueA != null){
			foreach($this->__FtValueA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
