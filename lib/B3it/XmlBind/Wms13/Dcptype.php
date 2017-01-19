<?php
/**
 *
 * XML Bind  für WMS 1.3
 * @category   	B3it
 * @package    	B3it_XmlBind_Wms13_
 * @name       	Dcptype
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Wms13_Dcptype extends B3it_XmlBind_Wms13_XmlObject
{
	
	
	/* @var B3it_XmlBind_Wms13_Http */
	private $__Http = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Wms13_Http
	 */
	public function getHttp()
	{
		if($this->__Http == null)
		{
			$this->__Http = new B3it_XmlBind_Wms13_Http();
		}
	
		return $this->__Http;
	}
	
	/**
	 * @param $value B3it_XmlBind_Wms13_Http
	 * @return B3it_XmlBind_Wms13_Dcptype
	 */
	public function setHttp($value)
	{
		$this->__Http = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('DCPType');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__Http != null){
			$this->__Http->toXml($xml);
		}


		return $xml;
	}

}
