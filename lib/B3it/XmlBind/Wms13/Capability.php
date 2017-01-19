<?php
/**
 *
 * XML Bind  für WMS 1.3
 * @category   	B3it
 * @package    	B3it_XmlBind_Wms13_
 * @name       	Capability
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Wms13_Capability extends B3it_XmlBind_Wms13_XmlObject
{
	
	
	/* @var B3it_XmlBind_Wms13_Request */
	private $__Request = null;

	/* @var B3it_XmlBind_Wms13_Exception */
	private $__Exception = null;

	
	/* @var B3it_XmlBind_Wms13_Extendedcapabilities */
	private $__ExtendedcapabilitiesA = array();

	/* @var B3it_XmlBind_Wms13_Layer */
	private $__Layer = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Wms13_Request
	 */
	public function getRequest()
	{
		if($this->__Request == null)
		{
			$this->__Request = new B3it_XmlBind_Wms13_Request();
		}
	
		return $this->__Request;
	}
	
	/**
	 * @param $value B3it_XmlBind_Wms13_Request
	 * @return B3it_XmlBind_Wms13_Capability
	 */
	public function setRequest($value)
	{
		$this->__Request = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Wms13_Exception
	 */
	public function getException()
	{
		if($this->__Exception == null)
		{
			$this->__Exception = new B3it_XmlBind_Wms13_Exception();
		}
	
		return $this->__Exception;
	}
	
	/**
	 * @param $value B3it_XmlBind_Wms13_Exception
	 * @return B3it_XmlBind_Wms13_Capability
	 */
	public function setException($value)
	{
		$this->__Exception = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Wms13_Extendedcapabilities and add it to list
	 * @return B3it_XmlBind_Wms13_Extendedcapabilities
	 */
	public function getExtendedcapabilities()
	{
		$res = new B3it_XmlBind_Wms13_Extendedcapabilities();
		$this->__ExtendedcapabilitiesA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Wms13_Extendedcapabilities
	 * @return B3it_XmlBind_Wms13_Capability
	 */
	public function setExtendedcapabilities($value)
	{
		$this->__ExtendedcapabilitiesA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Wms13_Extendedcapabilities[]
	 */
	public function getAllExtendedcapabilities()
	{
		return $this->__ExtendedcapabilitiesA;
	}


	
	/**
	 * @return B3it_XmlBind_Wms13_Layer
	 */
	public function getLayer()
	{
		if($this->__Layer == null)
		{
			$this->__Layer = new B3it_XmlBind_Wms13_Layer();
		}
	
		return $this->__Layer;
	}
	
	/**
	 * @param $value B3it_XmlBind_Wms13_Layer
	 * @return B3it_XmlBind_Wms13_Capability
	 */
	public function setLayer($value)
	{
		$this->__Layer = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('Capability');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__Request != null){
			$this->__Request->toXml($xml);
		}
		if($this->__Exception != null){
			$this->__Exception->toXml($xml);
		}
		if($this->__ExtendedcapabilitiesA != null){
			foreach($this->__ExtendedcapabilitiesA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__Layer != null){
			$this->__Layer->toXml($xml);
		}


		return $xml;
	}

}
