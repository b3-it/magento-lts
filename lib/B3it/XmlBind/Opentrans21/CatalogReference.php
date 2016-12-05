<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	CatalogReference
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_CatalogReference extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_CatalogId */
	private $__CatalogId = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_CatalogVersion */
	private $__CatalogVersion = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_CatalogName */
	private $__CatalogName = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_CatalogId
	 */
	public function getCatalogId()
	{
		if($this->__CatalogId == null)
		{
			$this->__CatalogId = new B3it_XmlBind_Opentrans21_Bmecat_CatalogId();
		}
	
		return $this->__CatalogId;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_CatalogId
	 * @return B3it_XmlBind_Opentrans21_CatalogReference
	 */
	public function setCatalogId($value)
	{
		$this->__CatalogId = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_CatalogVersion
	 */
	public function getCatalogVersion()
	{
		if($this->__CatalogVersion == null)
		{
			$this->__CatalogVersion = new B3it_XmlBind_Opentrans21_Bmecat_CatalogVersion();
		}
	
		return $this->__CatalogVersion;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_CatalogVersion
	 * @return B3it_XmlBind_Opentrans21_CatalogReference
	 */
	public function setCatalogVersion($value)
	{
		$this->__CatalogVersion = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_CatalogName
	 */
	public function getCatalogName()
	{
		if($this->__CatalogName == null)
		{
			$this->__CatalogName = new B3it_XmlBind_Opentrans21_Bmecat_CatalogName();
		}
	
		return $this->__CatalogName;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_CatalogName
	 * @return B3it_XmlBind_Opentrans21_CatalogReference
	 */
	public function setCatalogName($value)
	{
		$this->__CatalogName = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('CATALOG_REFERENCE');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__CatalogId != null){
			$this->__CatalogId->toXml($xml);
		}
		if($this->__CatalogVersion != null){
			$this->__CatalogVersion->toXml($xml);
		}
		if($this->__CatalogName != null){
			$this->__CatalogName->toXml($xml);
		}


		return $xml;
	}

}
