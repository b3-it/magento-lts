<?php
/**
 *
 * XML Bind  für WMS 1.3
 * @category   	B3it
 * @package    	B3it_XmlBind_Wms13_
 * @name       	WmsCapabilities
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Wms13_WmsCapabilities extends B3it_XmlBind_Wms13_XmlObject
{
	
	
	/* @var B3it_XmlBind_Wms13_Service */
	private $__Service = null;

	/* @var B3it_XmlBind_Wms13_Capability */
	private $__Capability = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Wms13_Service
	 */
	public function getService()
	{
		if($this->__Service == null)
		{
			$this->__Service = new B3it_XmlBind_Wms13_Service();
		}
	
		return $this->__Service;
	}
	
	/**
	 * @param $value B3it_XmlBind_Wms13_Service
	 * @return B3it_XmlBind_Wms13_WmsCapabilities
	 */
	public function setService($value)
	{
		$this->__Service = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Wms13_Capability
	 */
	public function getCapability()
	{
		if($this->__Capability == null)
		{
			$this->__Capability = new B3it_XmlBind_Wms13_Capability();
		}
	
		return $this->__Capability;
	}
	
	/**
	 * @param $value B3it_XmlBind_Wms13_Capability
	 * @return B3it_XmlBind_Wms13_WmsCapabilities
	 */
	public function setCapability($value)
	{
		$this->__Capability = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('WMS_Capabilities');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__Service != null){
			$this->__Service->toXml($xml);
		}
		if($this->__Capability != null){
			$this->__Capability->toXml($xml);
		}


		return $xml;
	}

}
