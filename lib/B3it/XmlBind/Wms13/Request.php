<?php
/**
 *
 * XML Bind  für WMS 1.3
 * @category   	B3it
 * @package    	B3it_XmlBind_Wms13_
 * @name       	Request
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Wms13_Request extends B3it_XmlBind_Wms13_XmlObject
{
	
	
	/* @var B3it_XmlBind_Wms13_Getcapabilities */
	private $__Getcapabilities = null;

	/* @var B3it_XmlBind_Wms13_Getmap */
	private $__Getmap = null;

	/* @var B3it_XmlBind_Wms13_Getfeatureinfo */
	private $__Getfeatureinfo = null;

	
	/* @var B3it_XmlBind_Wms13_Extendedoperation */
	private $__ExtendedoperationA = array();


	

	

	
	
	/**
	 * @return B3it_XmlBind_Wms13_Getcapabilities
	 */
	public function getGetcapabilities()
	{
		if($this->__Getcapabilities == null)
		{
			$this->__Getcapabilities = new B3it_XmlBind_Wms13_Getcapabilities();
		}
	
		return $this->__Getcapabilities;
	}
	
	/**
	 * @param $value B3it_XmlBind_Wms13_Getcapabilities
	 * @return B3it_XmlBind_Wms13_Request
	 */
	public function setGetcapabilities($value)
	{
		$this->__Getcapabilities = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Wms13_Getmap
	 */
	public function getGetmap()
	{
		if($this->__Getmap == null)
		{
			$this->__Getmap = new B3it_XmlBind_Wms13_Getmap();
		}
	
		return $this->__Getmap;
	}
	
	/**
	 * @param $value B3it_XmlBind_Wms13_Getmap
	 * @return B3it_XmlBind_Wms13_Request
	 */
	public function setGetmap($value)
	{
		$this->__Getmap = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Wms13_Getfeatureinfo
	 */
	public function getGetfeatureinfo()
	{
		if($this->__Getfeatureinfo == null)
		{
			$this->__Getfeatureinfo = new B3it_XmlBind_Wms13_Getfeatureinfo();
		}
	
		return $this->__Getfeatureinfo;
	}
	
	/**
	 * @param $value B3it_XmlBind_Wms13_Getfeatureinfo
	 * @return B3it_XmlBind_Wms13_Request
	 */
	public function setGetfeatureinfo($value)
	{
		$this->__Getfeatureinfo = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Wms13_Extendedoperation and add it to list
	 * @return B3it_XmlBind_Wms13_Extendedoperation
	 */
	public function getExtendedoperation()
	{
		$res = new B3it_XmlBind_Wms13_Extendedoperation();
		$this->__ExtendedoperationA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Wms13_Extendedoperation
	 * @return B3it_XmlBind_Wms13_Request
	 */
	public function setExtendedoperation($value)
	{
		$this->__ExtendedoperationA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Wms13_Extendedoperation[]
	 */
	public function getAllExtendedoperation()
	{
		return $this->__ExtendedoperationA;
	}







	public function toXml($xml)
	{
		$node = new DOMElement('Request');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__Getcapabilities != null){
			$this->__Getcapabilities->toXml($xml);
		}
		if($this->__Getmap != null){
			$this->__Getmap->toXml($xml);
		}
		if($this->__Getfeatureinfo != null){
			$this->__Getfeatureinfo->toXml($xml);
		}
		if($this->__ExtendedoperationA != null){
			foreach($this->__ExtendedoperationA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
