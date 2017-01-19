<?php
/**
 *
 * XML Bind  für WMS 1.3
 * @category   	B3it
 * @package    	B3it_XmlBind_Wms13_
 * @name       	Exception
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Wms13_Exception extends B3it_XmlBind_Wms13_XmlObject
{
	
	
	
	/* @var B3it_XmlBind_Wms13_Format */
	private $__FormatA = array();


	

	

	
	

	/**
	 * Create new B3it_XmlBind_Wms13_Format and add it to list
	 * @return B3it_XmlBind_Wms13_Format
	 */
	public function getFormat()
	{
		$res = new B3it_XmlBind_Wms13_Format();
		$this->__FormatA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Wms13_Format
	 * @return B3it_XmlBind_Wms13_Exception
	 */
	public function setFormat($value)
	{
		$this->__FormatA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Wms13_Format[]
	 */
	public function getAllFormat()
	{
		return $this->__FormatA;
	}







	public function toXml($xml)
	{
		$node = new DOMElement('Exception');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__FormatA != null){
			foreach($this->__FormatA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
