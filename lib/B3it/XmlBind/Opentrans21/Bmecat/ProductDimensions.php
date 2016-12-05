<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_ProductDimensions
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_ProductDimensions extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_Volume */
	private $__Volume = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_Weight */
	private $__Weight = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_Length */
	private $__Length = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_Width */
	private $__Width = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_Depth */
	private $__Depth = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Volume
	 */
	public function getVolume()
	{
		if($this->__Volume == null)
		{
			$this->__Volume = new B3it_XmlBind_Opentrans21_Bmecat_Volume();
		}
	
		return $this->__Volume;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Volume
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ProductDimensions
	 */
	public function setVolume($value)
	{
		$this->__Volume = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Weight
	 */
	public function getWeight()
	{
		if($this->__Weight == null)
		{
			$this->__Weight = new B3it_XmlBind_Opentrans21_Bmecat_Weight();
		}
	
		return $this->__Weight;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Weight
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ProductDimensions
	 */
	public function setWeight($value)
	{
		$this->__Weight = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Length
	 */
	public function getLength()
	{
		if($this->__Length == null)
		{
			$this->__Length = new B3it_XmlBind_Opentrans21_Bmecat_Length();
		}
	
		return $this->__Length;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Length
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ProductDimensions
	 */
	public function setLength($value)
	{
		$this->__Length = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Width
	 */
	public function getWidth()
	{
		if($this->__Width == null)
		{
			$this->__Width = new B3it_XmlBind_Opentrans21_Bmecat_Width();
		}
	
		return $this->__Width;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Width
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ProductDimensions
	 */
	public function setWidth($value)
	{
		$this->__Width = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Depth
	 */
	public function getDepth()
	{
		if($this->__Depth == null)
		{
			$this->__Depth = new B3it_XmlBind_Opentrans21_Bmecat_Depth();
		}
	
		return $this->__Depth;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Depth
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ProductDimensions
	 */
	public function setDepth($value)
	{
		$this->__Depth = $value;
		return $this;
	}





	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:PRODUCT_DIMENSIONS');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:PRODUCT_DIMENSIONS');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__Volume != null){
			$this->__Volume->toXml($xml);
		}
		if($this->__Weight != null){
			$this->__Weight->toXml($xml);
		}
		if($this->__Length != null){
			$this->__Length->toXml($xml);
		}
		if($this->__Width != null){
			$this->__Width->toXml($xml);
		}
		if($this->__Depth != null){
			$this->__Depth->toXml($xml);
		}


		return $xml;
	}

}
