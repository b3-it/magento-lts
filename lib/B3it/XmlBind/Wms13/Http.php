<?php
/**
 *
 * XML Bind  für WMS 1.3
 * @category   	B3it
 * @package    	B3it_XmlBind_Wms13_
 * @name       	Http
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Wms13_Http extends B3it_XmlBind_Wms13_XmlObject
{
	
	
	/* @var B3it_XmlBind_Wms13_Get */
	private $__Get = null;

	/* @var B3it_XmlBind_Wms13_Post */
	private $__Post = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Wms13_Get
	 */
	public function getGet()
	{
		if($this->__Get == null)
		{
			$this->__Get = new B3it_XmlBind_Wms13_Get();
		}
	
		return $this->__Get;
	}
	
	/**
	 * @param $value B3it_XmlBind_Wms13_Get
	 * @return B3it_XmlBind_Wms13_Http
	 */
	public function setGet($value)
	{
		$this->__Get = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Wms13_Post
	 */
	public function getPost()
	{
		if($this->__Post == null)
		{
			$this->__Post = new B3it_XmlBind_Wms13_Post();
		}
	
		return $this->__Post;
	}
	
	/**
	 * @param $value B3it_XmlBind_Wms13_Post
	 * @return B3it_XmlBind_Wms13_Http
	 */
	public function setPost($value)
	{
		$this->__Post = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('HTTP');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__Get != null){
			$this->__Get->toXml($xml);
		}
		if($this->__Post != null){
			$this->__Post->toXml($xml);
		}


		return $xml;
	}

}
