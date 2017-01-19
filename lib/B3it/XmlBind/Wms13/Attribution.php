<?php
/**
 *
 * XML Bind  für WMS 1.3
 * @category   	B3it
 * @package    	B3it_XmlBind_Wms13_
 * @name       	Attribution
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Wms13_Attribution extends B3it_XmlBind_Wms13_XmlObject
{
	
	
	/* @var B3it_XmlBind_Wms13_Title */
	private $__Title = null;

	/* @var B3it_XmlBind_Wms13_Onlineresource */
	private $__Onlineresource = null;

	/* @var B3it_XmlBind_Wms13_Logourl */
	private $__Logourl = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Wms13_Title
	 */
	public function getTitle()
	{
		if($this->__Title == null)
		{
			$this->__Title = new B3it_XmlBind_Wms13_Title();
		}
	
		return $this->__Title;
	}
	
	/**
	 * @param $value B3it_XmlBind_Wms13_Title
	 * @return B3it_XmlBind_Wms13_Attribution
	 */
	public function setTitle($value)
	{
		$this->__Title = $value;
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
	 * @return B3it_XmlBind_Wms13_Attribution
	 */
	public function setOnlineresource($value)
	{
		$this->__Onlineresource = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Wms13_Logourl
	 */
	public function getLogourl()
	{
		if($this->__Logourl == null)
		{
			$this->__Logourl = new B3it_XmlBind_Wms13_Logourl();
		}
	
		return $this->__Logourl;
	}
	
	/**
	 * @param $value B3it_XmlBind_Wms13_Logourl
	 * @return B3it_XmlBind_Wms13_Attribution
	 */
	public function setLogourl($value)
	{
		$this->__Logourl = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('Attribution');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__Title != null){
			$this->__Title->toXml($xml);
		}
		if($this->__Onlineresource != null){
			$this->__Onlineresource->toXml($xml);
		}
		if($this->__Logourl != null){
			$this->__Logourl->toXml($xml);
		}


		return $xml;
	}

}
