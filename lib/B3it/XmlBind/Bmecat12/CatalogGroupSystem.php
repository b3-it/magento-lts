<?php
class B3it_XmlBind_Bmecat12_CatalogGroupSystem extends B3it_XmlBind_Bmecat12_XmlBind
{
	private $_attributes = array();



	/* @var GroupSystemId */
	private $_GroupSystemId = null;	

	/* @var GroupSystemName */
	private $_GroupSystemName = null;	

	/* @var CatalogStructure */
	private $_CatalogStructures = array();	

	/* @var GroupSystemDescription */
	private $_GroupSystemDescription = null;	

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
	 * @return B3it_XmlBind_Bmecat12_GroupSystemId
	 */
	public function getGroupSystemId()
	{
		if($this->_GroupSystemId == null)
		{
			$this->_GroupSystemId = new B3it_XmlBind_Bmecat12_GroupSystemId();
		}
		
		return $this->_GroupSystemId;
	}
	
	/**
	 * @param $value GroupSystemId
	 * @return B3it_XmlBind_Bmecat12_CatalogGroupSystem extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setGroupSystemId($value)
	{
		$this->_GroupSystemId = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_GroupSystemName
	 */
	public function getGroupSystemName()
	{
		if($this->_GroupSystemName == null)
		{
			$this->_GroupSystemName = new B3it_XmlBind_Bmecat12_GroupSystemName();
		}
		
		return $this->_GroupSystemName;
	}
	
	/**
	 * @param $value GroupSystemName
	 * @return B3it_XmlBind_Bmecat12_CatalogGroupSystem extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setGroupSystemName($value)
	{
		$this->_GroupSystemName = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_CatalogStructure[]
	 */
	public function getAllCatalogStructure()
	{
		return $this->_CatalogStructures;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat12_CatalogStructure and add it to list
	 * @return B3it_XmlBind_Bmecat12_CatalogStructure
	 */
	public function getCatalogStructure()
	{
		$res = new B3it_XmlBind_Bmecat12_CatalogStructure();
		$this->_CatalogStructures[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value CatalogStructure[]
	 * @return B3it_XmlBind_Bmecat12_CatalogGroupSystem extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setCatalogStructure($value)
	{
		$this->_CatalogStructure = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_GroupSystemDescription
	 */
	public function getGroupSystemDescription()
	{
		if($this->_GroupSystemDescription == null)
		{
			$this->_GroupSystemDescription = new B3it_XmlBind_Bmecat12_GroupSystemDescription();
		}
		
		return $this->_GroupSystemDescription;
	}
	
	/**
	 * @param $value GroupSystemDescription
	 * @return B3it_XmlBind_Bmecat12_CatalogGroupSystem extends B3it_XmlBind_Bmecat12_XmlBind
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
		if($this->_GroupSystemName != null){
			$this->_GroupSystemName->toXml($xml);
		}
		if($this->_CatalogStructures != null){
			foreach($this->_CatalogStructures as $item){
				$item->toXml($xml);
			}
		}
		if($this->_GroupSystemDescription != null){
			$this->_GroupSystemDescription->toXml($xml);
		}


		return $xml;
	}
}