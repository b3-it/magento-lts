<?php
/**
 *
 * XML Bind  für WMS 1.3
 * @category   	B3it
 * @package    	B3it_XmlBind_Wms13_
 * @name       	Service
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Wms13_Service extends B3it_XmlBind_Wms13_XmlObject
{
	
	
	/* @var B3it_XmlBind_Wms13_Service_Name */
	private $__Name = null;

	/* @var B3it_XmlBind_Wms13_Title */
	private $__Title = null;

	/* @var B3it_XmlBind_Wms13_Abstract */
	private $__Abstract = null;

	/* @var B3it_XmlBind_Wms13_Keywordlist */
	private $__Keywordlist = null;

	/* @var B3it_XmlBind_Wms13_Onlineresource */
	private $__Onlineresource = null;

	/* @var B3it_XmlBind_Wms13_Contactinformation */
	private $__Contactinformation = null;

	/* @var B3it_XmlBind_Wms13_Fees */
	private $__Fees = null;

	/* @var B3it_XmlBind_Wms13_Accessconstraints */
	private $__Accessconstraints = null;

	/* @var B3it_XmlBind_Wms13_Layerlimit */
	private $__Layerlimit = null;

	/* @var B3it_XmlBind_Wms13_Maxwidth */
	private $__Maxwidth = null;

	/* @var B3it_XmlBind_Wms13_Maxheight */
	private $__Maxheight = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Wms13_Service_Name
	 */
	public function getName()
	{
		if($this->__Name == null)
		{
			$this->__Name = new B3it_XmlBind_Wms13_Service_Name();
		}
	
		return $this->__Name;
	}
	
	/**
	 * @param $value B3it_XmlBind_Wms13_Service_Name
	 * @return B3it_XmlBind_Wms13_Service
	 */
	public function setName($value)
	{
		$this->__Name = $value;
		return $this;
	}
	
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
	 * @return B3it_XmlBind_Wms13_Service
	 */
	public function setTitle($value)
	{
		$this->__Title = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Wms13_Abstract
	 */
	public function getAbstract()
	{
		if($this->__Abstract == null)
		{
			$this->__Abstract = new B3it_XmlBind_Wms13_Abstract();
		}
	
		return $this->__Abstract;
	}
	
	/**
	 * @param $value B3it_XmlBind_Wms13_Abstract
	 * @return B3it_XmlBind_Wms13_Service
	 */
	public function setAbstract($value)
	{
		$this->__Abstract = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Wms13_Keywordlist
	 */
	public function getKeywordlist()
	{
		if($this->__Keywordlist == null)
		{
			$this->__Keywordlist = new B3it_XmlBind_Wms13_Keywordlist();
		}
	
		return $this->__Keywordlist;
	}
	
	/**
	 * @param $value B3it_XmlBind_Wms13_Keywordlist
	 * @return B3it_XmlBind_Wms13_Service
	 */
	public function setKeywordlist($value)
	{
		$this->__Keywordlist = $value;
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
	 * @return B3it_XmlBind_Wms13_Service
	 */
	public function setOnlineresource($value)
	{
		$this->__Onlineresource = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Wms13_Contactinformation
	 */
	public function getContactinformation()
	{
		if($this->__Contactinformation == null)
		{
			$this->__Contactinformation = new B3it_XmlBind_Wms13_Contactinformation();
		}
	
		return $this->__Contactinformation;
	}
	
	/**
	 * @param $value B3it_XmlBind_Wms13_Contactinformation
	 * @return B3it_XmlBind_Wms13_Service
	 */
	public function setContactinformation($value)
	{
		$this->__Contactinformation = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Wms13_Fees
	 */
	public function getFees()
	{
		if($this->__Fees == null)
		{
			$this->__Fees = new B3it_XmlBind_Wms13_Fees();
		}
	
		return $this->__Fees;
	}
	
	/**
	 * @param $value B3it_XmlBind_Wms13_Fees
	 * @return B3it_XmlBind_Wms13_Service
	 */
	public function setFees($value)
	{
		$this->__Fees = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Wms13_Accessconstraints
	 */
	public function getAccessconstraints()
	{
		if($this->__Accessconstraints == null)
		{
			$this->__Accessconstraints = new B3it_XmlBind_Wms13_Accessconstraints();
		}
	
		return $this->__Accessconstraints;
	}
	
	/**
	 * @param $value B3it_XmlBind_Wms13_Accessconstraints
	 * @return B3it_XmlBind_Wms13_Service
	 */
	public function setAccessconstraints($value)
	{
		$this->__Accessconstraints = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Wms13_Layerlimit
	 */
	public function getLayerlimit()
	{
		if($this->__Layerlimit == null)
		{
			$this->__Layerlimit = new B3it_XmlBind_Wms13_Layerlimit();
		}
	
		return $this->__Layerlimit;
	}
	
	/**
	 * @param $value B3it_XmlBind_Wms13_Layerlimit
	 * @return B3it_XmlBind_Wms13_Service
	 */
	public function setLayerlimit($value)
	{
		$this->__Layerlimit = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Wms13_Maxwidth
	 */
	public function getMaxwidth()
	{
		if($this->__Maxwidth == null)
		{
			$this->__Maxwidth = new B3it_XmlBind_Wms13_Maxwidth();
		}
	
		return $this->__Maxwidth;
	}
	
	/**
	 * @param $value B3it_XmlBind_Wms13_Maxwidth
	 * @return B3it_XmlBind_Wms13_Service
	 */
	public function setMaxwidth($value)
	{
		$this->__Maxwidth = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Wms13_Maxheight
	 */
	public function getMaxheight()
	{
		if($this->__Maxheight == null)
		{
			$this->__Maxheight = new B3it_XmlBind_Wms13_Maxheight();
		}
	
		return $this->__Maxheight;
	}
	
	/**
	 * @param $value B3it_XmlBind_Wms13_Maxheight
	 * @return B3it_XmlBind_Wms13_Service
	 */
	public function setMaxheight($value)
	{
		$this->__Maxheight = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('Service');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__Name != null){
			$this->__Name->toXml($xml);
		}
		if($this->__Title != null){
			$this->__Title->toXml($xml);
		}
		if($this->__Abstract != null){
			$this->__Abstract->toXml($xml);
		}
		if($this->__Keywordlist != null){
			$this->__Keywordlist->toXml($xml);
		}
		if($this->__Onlineresource != null){
			$this->__Onlineresource->toXml($xml);
		}
		if($this->__Contactinformation != null){
			$this->__Contactinformation->toXml($xml);
		}
		if($this->__Fees != null){
			$this->__Fees->toXml($xml);
		}
		if($this->__Accessconstraints != null){
			$this->__Accessconstraints->toXml($xml);
		}
		if($this->__Layerlimit != null){
			$this->__Layerlimit->toXml($xml);
		}
		if($this->__Maxwidth != null){
			$this->__Maxwidth->toXml($xml);
		}
		if($this->__Maxheight != null){
			$this->__Maxheight->toXml($xml);
		}


		return $xml;
	}

}
