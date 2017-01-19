<?php
/**
 *
 * XML Bind  für WMS 1.3
 * @category   	B3it
 * @package    	B3it_XmlBind_Wms13_
 * @name       	Stylesheeturl
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Wms13_Stylesheeturl extends B3it_XmlBind_Wms13_XmlObject
{
	
	
	/* @var B3it_XmlBind_Wms13_Format */
	private $__Format = null;

	/* @var B3it_XmlBind_Wms13_Onlineresource */
	private $__Onlineresource = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Wms13_Format
	 */
	public function getFormat()
	{
		if($this->__Format == null)
		{
			$this->__Format = new B3it_XmlBind_Wms13_Format();
		}
	
		return $this->__Format;
	}
	
	/**
	 * @param $value B3it_XmlBind_Wms13_Format
	 * @return B3it_XmlBind_Wms13_Stylesheeturl
	 */
	public function setFormat($value)
	{
		$this->__Format = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Wms13_Onlineresource
	 */
	public function getOnlineresource()
	{
		if($this->__Onlineresource == null)
		{
			$this->__Onlineresource = new B3it_XmlBind_Wms13_Onlineresource();
		}
	
		return $this->__Onlineresource;
	}
	
	/**
	 * @param $value B3it_XmlBind_Wms13_Onlineresource
	 * @return B3it_XmlBind_Wms13_Stylesheeturl
	 */
	public function setOnlineresource($value)
	{
		$this->__Onlineresource = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('StyleSheetURL');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__Format != null){
			$this->__Format->toXml($xml);
		}
		if($this->__Onlineresource != null){
			$this->__Onlineresource->toXml($xml);
		}


		return $xml;
	}

}
