<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Wms13_
 * @name       	ExGeographicboundingbox
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Wms13_ExGeographicboundingbox extends B3it_XmlBind_Wms13_XmlObject
{
	
	
	/* @var B3it_XmlBind_Wms13_ExGeographicboundingbox_Westboundlongitude */
	private $__Westboundlongitude = null;

	/* @var B3it_XmlBind_Wms13_ExGeographicboundingbox_Eastboundlongitude */
	private $__Eastboundlongitude = null;

	/* @var B3it_XmlBind_Wms13_ExGeographicboundingbox_Southboundlatitude */
	private $__Southboundlatitude = null;

	/* @var B3it_XmlBind_Wms13_ExGeographicboundingbox_Northboundlatitude */
	private $__Northboundlatitude = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Wms13_ExGeographicboundingbox_Westboundlongitude
	 */
	public function getWestboundlongitude()
	{
		if($this->__Westboundlongitude == null)
		{
			$this->__Westboundlongitude = new B3it_XmlBind_Wms13_ExGeographicboundingbox_Westboundlongitude();
		}
	
		return $this->__Westboundlongitude;
	}
	
	/**
	 * @param $value B3it_XmlBind_Wms13_ExGeographicboundingbox_Westboundlongitude
	 * @return B3it_XmlBind_Wms13_ExGeographicboundingbox
	 */
	public function setWestboundlongitude($value)
	{
		$this->__Westboundlongitude = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Wms13_ExGeographicboundingbox_Eastboundlongitude
	 */
	public function getEastboundlongitude()
	{
		if($this->__Eastboundlongitude == null)
		{
			$this->__Eastboundlongitude = new B3it_XmlBind_Wms13_ExGeographicboundingbox_Eastboundlongitude();
		}
	
		return $this->__Eastboundlongitude;
	}
	
	/**
	 * @param $value B3it_XmlBind_Wms13_ExGeographicboundingbox_Eastboundlongitude
	 * @return B3it_XmlBind_Wms13_ExGeographicboundingbox
	 */
	public function setEastboundlongitude($value)
	{
		$this->__Eastboundlongitude = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Wms13_ExGeographicboundingbox_Southboundlatitude
	 */
	public function getSouthboundlatitude()
	{
		if($this->__Southboundlatitude == null)
		{
			$this->__Southboundlatitude = new B3it_XmlBind_Wms13_ExGeographicboundingbox_Southboundlatitude();
		}
	
		return $this->__Southboundlatitude;
	}
	
	/**
	 * @param $value B3it_XmlBind_Wms13_ExGeographicboundingbox_Southboundlatitude
	 * @return B3it_XmlBind_Wms13_ExGeographicboundingbox
	 */
	public function setSouthboundlatitude($value)
	{
		$this->__Southboundlatitude = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Wms13_ExGeographicboundingbox_Northboundlatitude
	 */
	public function getNorthboundlatitude()
	{
		if($this->__Northboundlatitude == null)
		{
			$this->__Northboundlatitude = new B3it_XmlBind_Wms13_ExGeographicboundingbox_Northboundlatitude();
		}
	
		return $this->__Northboundlatitude;
	}
	
	/**
	 * @param $value B3it_XmlBind_Wms13_ExGeographicboundingbox_Northboundlatitude
	 * @return B3it_XmlBind_Wms13_ExGeographicboundingbox
	 */
	public function setNorthboundlatitude($value)
	{
		$this->__Northboundlatitude = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('EX_GeographicBoundingBox');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__Westboundlongitude != null){
			$this->__Westboundlongitude->toXml($xml);
		}
		if($this->__Eastboundlongitude != null){
			$this->__Eastboundlongitude->toXml($xml);
		}
		if($this->__Southboundlatitude != null){
			$this->__Southboundlatitude->toXml($xml);
		}
		if($this->__Northboundlatitude != null){
			$this->__Northboundlatitude->toXml($xml);
		}


		return $xml;
	}

}
