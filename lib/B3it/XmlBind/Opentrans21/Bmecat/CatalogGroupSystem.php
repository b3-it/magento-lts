<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_CatalogGroupSystem
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_CatalogGroupSystem extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_GroupSystemId */
	private $__GroupSystemId = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_GroupSystemName */
	private $__GroupSystemNameA = array();

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_CatalogStructure */
	private $__CatalogStructureA = array();

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_GroupSystemDescription */
	private $__GroupSystemDescriptionA = array();


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_GroupSystemId
	 */
	public function getGroupSystemId()
	{
		if($this->__GroupSystemId == null)
		{
			$this->__GroupSystemId = new B3it_XmlBind_Opentrans21_Bmecat_GroupSystemId();
		}
	
		return $this->__GroupSystemId;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_GroupSystemId
	 * @return B3it_XmlBind_Opentrans21_Bmecat_CatalogGroupSystem
	 */
	public function setGroupSystemId($value)
	{
		$this->__GroupSystemId = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_GroupSystemName and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_GroupSystemName
	 */
	public function getGroupSystemName()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_GroupSystemName();
		$this->__GroupSystemNameA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_GroupSystemName
	 * @return B3it_XmlBind_Opentrans21_Bmecat_CatalogGroupSystem
	 */
	public function setGroupSystemName($value)
	{
		$this->__GroupSystemNameA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_GroupSystemName[]
	 */
	public function getAllGroupSystemName()
	{
		return $this->__GroupSystemNameA;
	}


	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_CatalogStructure and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_CatalogStructure
	 */
	public function getCatalogStructure()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_CatalogStructure();
		$this->__CatalogStructureA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_CatalogStructure
	 * @return B3it_XmlBind_Opentrans21_Bmecat_CatalogGroupSystem
	 */
	public function setCatalogStructure($value)
	{
		$this->__CatalogStructureA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_CatalogStructure[]
	 */
	public function getAllCatalogStructure()
	{
		return $this->__CatalogStructureA;
	}


	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_GroupSystemDescription and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_GroupSystemDescription
	 */
	public function getGroupSystemDescription()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_GroupSystemDescription();
		$this->__GroupSystemDescriptionA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_GroupSystemDescription
	 * @return B3it_XmlBind_Opentrans21_Bmecat_CatalogGroupSystem
	 */
	public function setGroupSystemDescription($value)
	{
		$this->__GroupSystemDescriptionA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_GroupSystemDescription[]
	 */
	public function getAllGroupSystemDescription()
	{
		return $this->__GroupSystemDescriptionA;
	}







	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:CATALOG_GROUP_SYSTEM');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:CATALOG_GROUP_SYSTEM');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__GroupSystemId != null){
			$this->__GroupSystemId->toXml($xml);
		}
		if($this->__GroupSystemNameA != null){
			foreach($this->__GroupSystemNameA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__CatalogStructureA != null){
			foreach($this->__CatalogStructureA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__GroupSystemDescriptionA != null){
			foreach($this->__GroupSystemDescriptionA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
