<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_CatalogStructure
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_CatalogStructure extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_GroupId */
	private $__GroupId = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_GroupName */
	private $__GroupNameA = array();

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_GroupDescription */
	private $__GroupDescriptionA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_ParentId */
	private $__ParentId = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_GroupOrder */
	private $__GroupOrder = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_MimeInfo */
	private $__MimeInfo = null;

	/* @var B3it_XmlBind_Opentrans21_CatalogStructure_Bmecat_UserDefinedExtensions */
	private $__UserDefinedExtensions = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_Keyword */
	private $__KeywordA = array();


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_GroupId
	 */
	public function getGroupId()
	{
		if($this->__GroupId == null)
		{
			$this->__GroupId = new B3it_XmlBind_Opentrans21_Bmecat_GroupId();
		}
	
		return $this->__GroupId;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_GroupId
	 * @return B3it_XmlBind_Opentrans21_Bmecat_CatalogStructure
	 */
	public function setGroupId($value)
	{
		$this->__GroupId = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_GroupName and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_GroupName
	 */
	public function getGroupName()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_GroupName();
		$this->__GroupNameA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_GroupName
	 * @return B3it_XmlBind_Opentrans21_Bmecat_CatalogStructure
	 */
	public function setGroupName($value)
	{
		$this->__GroupNameA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_GroupName[]
	 */
	public function getAllGroupName()
	{
		return $this->__GroupNameA;
	}


	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_GroupDescription and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_GroupDescription
	 */
	public function getGroupDescription()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_GroupDescription();
		$this->__GroupDescriptionA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_GroupDescription
	 * @return B3it_XmlBind_Opentrans21_Bmecat_CatalogStructure
	 */
	public function setGroupDescription($value)
	{
		$this->__GroupDescriptionA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_GroupDescription[]
	 */
	public function getAllGroupDescription()
	{
		return $this->__GroupDescriptionA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ParentId
	 */
	public function getParentId()
	{
		if($this->__ParentId == null)
		{
			$this->__ParentId = new B3it_XmlBind_Opentrans21_Bmecat_ParentId();
		}
	
		return $this->__ParentId;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ParentId
	 * @return B3it_XmlBind_Opentrans21_Bmecat_CatalogStructure
	 */
	public function setParentId($value)
	{
		$this->__ParentId = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_GroupOrder
	 */
	public function getGroupOrder()
	{
		if($this->__GroupOrder == null)
		{
			$this->__GroupOrder = new B3it_XmlBind_Opentrans21_Bmecat_GroupOrder();
		}
	
		return $this->__GroupOrder;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_GroupOrder
	 * @return B3it_XmlBind_Opentrans21_Bmecat_CatalogStructure
	 */
	public function setGroupOrder($value)
	{
		$this->__GroupOrder = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_MimeInfo
	 */
	public function getMimeInfo()
	{
		if($this->__MimeInfo == null)
		{
			$this->__MimeInfo = new B3it_XmlBind_Opentrans21_Bmecat_MimeInfo();
		}
	
		return $this->__MimeInfo;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_MimeInfo
	 * @return B3it_XmlBind_Opentrans21_Bmecat_CatalogStructure
	 */
	public function setMimeInfo($value)
	{
		$this->__MimeInfo = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_CatalogStructure_Bmecat_UserDefinedExtensions
	 */
	public function getUserDefinedExtensions()
	{
		if($this->__UserDefinedExtensions == null)
		{
			$this->__UserDefinedExtensions = new B3it_XmlBind_Opentrans21_CatalogStructure_Bmecat_UserDefinedExtensions();
		}
	
		return $this->__UserDefinedExtensions;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_CatalogStructure_Bmecat_UserDefinedExtensions
	 * @return B3it_XmlBind_Opentrans21_Bmecat_CatalogStructure
	 */
	public function setUserDefinedExtensions($value)
	{
		$this->__UserDefinedExtensions = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_Keyword and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Keyword
	 */
	public function getKeyword()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_Keyword();
		$this->__KeywordA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Keyword
	 * @return B3it_XmlBind_Opentrans21_Bmecat_CatalogStructure
	 */
	public function setKeyword($value)
	{
		$this->__KeywordA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Keyword[]
	 */
	public function getAllKeyword()
	{
		return $this->__KeywordA;
	}







	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:CATALOG_STRUCTURE');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:CATALOG_STRUCTURE');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__GroupId != null){
			$this->__GroupId->toXml($xml);
		}
		if($this->__GroupNameA != null){
			foreach($this->__GroupNameA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__GroupDescriptionA != null){
			foreach($this->__GroupDescriptionA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__ParentId != null){
			$this->__ParentId->toXml($xml);
		}
		if($this->__GroupOrder != null){
			$this->__GroupOrder->toXml($xml);
		}
		if($this->__MimeInfo != null){
			$this->__MimeInfo->toXml($xml);
		}
		if($this->__UserDefinedExtensions != null){
			$this->__UserDefinedExtensions->toXml($xml);
		}
		if($this->__KeywordA != null){
			foreach($this->__KeywordA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
