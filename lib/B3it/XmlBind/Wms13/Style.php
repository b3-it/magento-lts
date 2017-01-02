<?php
/**
 *
 * XML Bind  für WMS 1.3
 * @category   	B3it
 * @package    	B3it_XmlBind_Wms13_
 * @name       	Style
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Wms13_Style extends B3it_XmlBind_Wms13_XmlObject
{
	
	
	/* @var B3it_XmlBind_Wms13_Service_Name */
	private $__Name = null;

	/* @var B3it_XmlBind_Wms13_Title */
	private $__Title = null;

	/* @var B3it_XmlBind_Wms13_Abstract */
	private $__Abstract = null;

	
	/* @var B3it_XmlBind_Wms13_Legendurl */
	private $__LegendurlA = array();

	/* @var B3it_XmlBind_Wms13_Stylesheeturl */
	private $__Stylesheeturl = null;

	/* @var B3it_XmlBind_Wms13_Styleurl */
	private $__Styleurl = null;


	

	

	
	
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
	 * @return B3it_XmlBind_Wms13_Style
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
	 * @return B3it_XmlBind_Wms13_Style
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
	 * @return B3it_XmlBind_Wms13_Style
	 */
	public function setAbstract($value)
	{
		$this->__Abstract = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Wms13_Legendurl and add it to list
	 * @return B3it_XmlBind_Wms13_Legendurl
	 */
	public function getLegendurl()
	{
		$res = new B3it_XmlBind_Wms13_Legendurl();
		$this->__LegendurlA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Wms13_Legendurl
	 * @return B3it_XmlBind_Wms13_Style
	 */
	public function setLegendurl($value)
	{
		$this->__LegendurlA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Wms13_Legendurl[]
	 */
	public function getAllLegendurl()
	{
		return $this->__LegendurlA;
	}


	
	/**
	 * @return B3it_XmlBind_Wms13_Stylesheeturl
	 */
	public function getStylesheeturl()
	{
		if($this->__Stylesheeturl == null)
		{
			$this->__Stylesheeturl = new B3it_XmlBind_Wms13_Stylesheeturl();
		}
	
		return $this->__Stylesheeturl;
	}
	
	/**
	 * @param $value B3it_XmlBind_Wms13_Stylesheeturl
	 * @return B3it_XmlBind_Wms13_Style
	 */
	public function setStylesheeturl($value)
	{
		$this->__Stylesheeturl = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Wms13_Styleurl
	 */
	public function getStyleurl()
	{
		if($this->__Styleurl == null)
		{
			$this->__Styleurl = new B3it_XmlBind_Wms13_Styleurl();
		}
	
		return $this->__Styleurl;
	}
	
	/**
	 * @param $value B3it_XmlBind_Wms13_Styleurl
	 * @return B3it_XmlBind_Wms13_Style
	 */
	public function setStyleurl($value)
	{
		$this->__Styleurl = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('Style');
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
		if($this->__LegendurlA != null){
			foreach($this->__LegendurlA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__Stylesheeturl != null){
			$this->__Stylesheeturl->toXml($xml);
		}
		if($this->__Styleurl != null){
			$this->__Styleurl->toXml($xml);
		}


		return $xml;
	}

}
