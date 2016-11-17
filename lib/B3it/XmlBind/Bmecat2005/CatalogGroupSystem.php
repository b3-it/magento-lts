<?php
class B3it_XmlBind_Bmecat2005_CatalogGroupSystem extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var GroupSystemId */
	private $_GroupSystemId = null;	

	/* @var GroupSystemName */
	private $_GroupSystemNames = array();	

	/* @var CatalogStructure */
	private $_CatalogStructures = array();	

	/* @var GroupSystemDescription */
	private $_GroupSystemDescriptions = array();	

	public function getAttribute($name){
		if(isset($this->_attributes[$name])){
			 return $this->_attributes[$name];
		}
		return null;
	}

	public function setAttribute($name,$value){
		$this->_attributes[$name] = $value;
		return $this;
	}



	/**
	 * @return B3it_XmlBind_Bmecat2005_GroupSystemId
	 */
	public function getGroupSystemId()
	{
		if($this->_GroupSystemId == null)
		{
			$this->_GroupSystemId = new B3it_XmlBind_Bmecat2005_GroupSystemId();
		}
		
		return $this->_GroupSystemId;
	}
	
	/**
	 * @param $value GroupSystemId
	 * @return B3it_XmlBind_Bmecat2005_CatalogGroupSystem extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setGroupSystemId($value)
	{
		$this->_GroupSystemId = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_GroupSystemName[]
	 */
	public function getAllGroupSystemName()
	{
		return $this->_GroupSystemNames;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_GroupSystemName and add it to list
	 * @return B3it_XmlBind_Bmecat2005_GroupSystemName
	 */
	public function getGroupSystemName()
	{
		$res = new B3it_XmlBind_Bmecat2005_GroupSystemName();
		$this->_GroupSystemNames[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value GroupSystemName[]
	 * @return B3it_XmlBind_Bmecat2005_CatalogGroupSystem extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setGroupSystemName($value)
	{
		$this->_GroupSystemName = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_CatalogStructure[]
	 */
	public function getAllCatalogStructure()
	{
		return $this->_CatalogStructures;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_CatalogStructure and add it to list
	 * @return B3it_XmlBind_Bmecat2005_CatalogStructure
	 */
	public function getCatalogStructure()
	{
		$res = new B3it_XmlBind_Bmecat2005_CatalogStructure();
		$this->_CatalogStructures[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value CatalogStructure[]
	 * @return B3it_XmlBind_Bmecat2005_CatalogGroupSystem extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setCatalogStructure($value)
	{
		$this->_CatalogStructure = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_GroupSystemDescription[]
	 */
	public function getAllGroupSystemDescription()
	{
		return $this->_GroupSystemDescriptions;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_GroupSystemDescription and add it to list
	 * @return B3it_XmlBind_Bmecat2005_GroupSystemDescription
	 */
	public function getGroupSystemDescription()
	{
		$res = new B3it_XmlBind_Bmecat2005_GroupSystemDescription();
		$this->_GroupSystemDescriptions[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value GroupSystemDescription[]
	 * @return B3it_XmlBind_Bmecat2005_CatalogGroupSystem extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setGroupSystemDescription($value)
	{
		$this->_GroupSystemDescription = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('CATALOG_GROUP_SYSTEM');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_GroupSystemId != null){
			$this->_GroupSystemId->toXml($xml);
		}
		if($this->_GroupSystemNames != null){
			foreach($this->_GroupSystemNames as $item){
				$item->toXml($xml);
			}
		}
		if($this->_CatalogStructures != null){
			foreach($this->_CatalogStructures as $item){
				$item->toXml($xml);
			}
		}
		if($this->_GroupSystemDescriptions != null){
			foreach($this->_GroupSystemDescriptions as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}
}