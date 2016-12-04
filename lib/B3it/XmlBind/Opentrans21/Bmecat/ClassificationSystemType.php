<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_ClassificationSystemType
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystemType extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_GroupidHierarchy */
	private $__GroupidHierarchy = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_MappingType */
	private $__MappingType = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_MappingLevel */
	private $__MappingLevel = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_Balancedtree */
	private $__Balancedtree = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_Inheritance */
	private $__Inheritance = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_GroupidHierarchy
	 */
	public function getGroupidHierarchy()
	{
		if($this->__GroupidHierarchy == null)
		{
			$this->__GroupidHierarchy = new B3it_XmlBind_Opentrans21_Bmecat_GroupidHierarchy();
		}
	
		return $this->__GroupidHierarchy;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_GroupidHierarchy
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystemType
	 */
	public function setGroupidHierarchy($value)
	{
		$this->__GroupidHierarchy = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_MappingType
	 */
	public function getMappingType()
	{
		if($this->__MappingType == null)
		{
			$this->__MappingType = new B3it_XmlBind_Opentrans21_Bmecat_MappingType();
		}
	
		return $this->__MappingType;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_MappingType
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystemType
	 */
	public function setMappingType($value)
	{
		$this->__MappingType = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_MappingLevel
	 */
	public function getMappingLevel()
	{
		if($this->__MappingLevel == null)
		{
			$this->__MappingLevel = new B3it_XmlBind_Opentrans21_Bmecat_MappingLevel();
		}
	
		return $this->__MappingLevel;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_MappingLevel
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystemType
	 */
	public function setMappingLevel($value)
	{
		$this->__MappingLevel = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Balancedtree
	 */
	public function getBalancedtree()
	{
		if($this->__Balancedtree == null)
		{
			$this->__Balancedtree = new B3it_XmlBind_Opentrans21_Bmecat_Balancedtree();
		}
	
		return $this->__Balancedtree;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Balancedtree
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystemType
	 */
	public function setBalancedtree($value)
	{
		$this->__Balancedtree = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Inheritance
	 */
	public function getInheritance()
	{
		if($this->__Inheritance == null)
		{
			$this->__Inheritance = new B3it_XmlBind_Opentrans21_Bmecat_Inheritance();
		}
	
		return $this->__Inheritance;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Inheritance
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystemType
	 */
	public function setInheritance($value)
	{
		$this->__Inheritance = $value;
		return $this;
	}





	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:CLASSIFICATION_SYSTEM_TYPE');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:CLASSIFICATION_SYSTEM_TYPE');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__GroupidHierarchy != null){
			$this->__GroupidHierarchy->toXml($xml);
		}
		if($this->__MappingType != null){
			$this->__MappingType->toXml($xml);
		}
		if($this->__MappingLevel != null){
			$this->__MappingLevel->toXml($xml);
		}
		if($this->__Balancedtree != null){
			$this->__Balancedtree->toXml($xml);
		}
		if($this->__Inheritance != null){
			$this->__Inheritance->toXml($xml);
		}


		return $xml;
	}

}
