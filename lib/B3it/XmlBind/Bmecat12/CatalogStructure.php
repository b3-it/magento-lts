<?php
class B3it_XmlBind_Bmecat12_CatalogStructure extends B3it_XmlBind_Bmecat12_XmlBind
{
	private $_attributes = array();



	/* @var GroupId */
	private $_GroupId = null;	

	/* @var GroupName */
	private $_GroupName = null;	

	/* @var GroupDescription */
	private $_GroupDescription = null;	

	/* @var ParentId */
	private $_ParentId = null;	

	/* @var GroupOrder */
	private $_GroupOrder = null;	

	/* @var MimeInfo */
	private $_MimeInfo = null;	

	/* @var CatalogStructure_UserDefinedExtensions */
	private $_UserDefinedExtensions = null;	

	/* @var Keyword */
	private $_Keywords = array();	

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
	 * @return B3it_XmlBind_Bmecat12_GroupId
	 */
	public function getGroupId()
	{
		if($this->_GroupId == null)
		{
			$this->_GroupId = new B3it_XmlBind_Bmecat12_GroupId();
		}
		
		return $this->_GroupId;
	}
	
	/**
	 * @param $value GroupId
	 * @return B3it_XmlBind_Bmecat12_CatalogStructure extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setGroupId($value)
	{
		$this->_GroupId = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_GroupName
	 */
	public function getGroupName()
	{
		if($this->_GroupName == null)
		{
			$this->_GroupName = new B3it_XmlBind_Bmecat12_GroupName();
		}
		
		return $this->_GroupName;
	}
	
	/**
	 * @param $value GroupName
	 * @return B3it_XmlBind_Bmecat12_CatalogStructure extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setGroupName($value)
	{
		$this->_GroupName = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_GroupDescription
	 */
	public function getGroupDescription()
	{
		if($this->_GroupDescription == null)
		{
			$this->_GroupDescription = new B3it_XmlBind_Bmecat12_GroupDescription();
		}
		
		return $this->_GroupDescription;
	}
	
	/**
	 * @param $value GroupDescription
	 * @return B3it_XmlBind_Bmecat12_CatalogStructure extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setGroupDescription($value)
	{
		$this->_GroupDescription = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_ParentId
	 */
	public function getParentId()
	{
		if($this->_ParentId == null)
		{
			$this->_ParentId = new B3it_XmlBind_Bmecat12_ParentId();
		}
		
		return $this->_ParentId;
	}
	
	/**
	 * @param $value ParentId
	 * @return B3it_XmlBind_Bmecat12_CatalogStructure extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setParentId($value)
	{
		$this->_ParentId = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_GroupOrder
	 */
	public function getGroupOrder()
	{
		if($this->_GroupOrder == null)
		{
			$this->_GroupOrder = new B3it_XmlBind_Bmecat12_GroupOrder();
		}
		
		return $this->_GroupOrder;
	}
	
	/**
	 * @param $value GroupOrder
	 * @return B3it_XmlBind_Bmecat12_CatalogStructure extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setGroupOrder($value)
	{
		$this->_GroupOrder = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_MimeInfo
	 */
	public function getMimeInfo()
	{
		if($this->_MimeInfo == null)
		{
			$this->_MimeInfo = new B3it_XmlBind_Bmecat12_MimeInfo();
		}
		
		return $this->_MimeInfo;
	}
	
	/**
	 * @param $value MimeInfo
	 * @return B3it_XmlBind_Bmecat12_CatalogStructure extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setMimeInfo($value)
	{
		$this->_MimeInfo = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_CatalogStructure_UserDefinedExtensions
	 */
	public function getUserDefinedExtensions()
	{
		if($this->_UserDefinedExtensions == null)
		{
			$this->_UserDefinedExtensions = new B3it_XmlBind_Bmecat12_CatalogStructure_UserDefinedExtensions();
		}
		
		return $this->_UserDefinedExtensions;
	}
	
	/**
	 * @param $value UserDefinedExtensions
	 * @return B3it_XmlBind_Bmecat12_CatalogStructure extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setUserDefinedExtensions($value)
	{
		$this->_UserDefinedExtensions = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_Keyword[]
	 */
	public function getAllKeyword()
	{
		return $this->_Keywords;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat12_Keyword and add it to list
	 * @return B3it_XmlBind_Bmecat12_Keyword
	 */
	public function getKeyword()
	{
		$res = new B3it_XmlBind_Bmecat12_Keyword();
		$this->_Keywords[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value Keyword[]
	 * @return B3it_XmlBind_Bmecat12_CatalogStructure extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setKeyword($value)
	{
		$this->_Keyword = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('CATALOG_STRUCTURE');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_GroupId != null){
			$this->_GroupId->toXml($xml);
		}
		if($this->_GroupName != null){
			$this->_GroupName->toXml($xml);
		}
		if($this->_GroupDescription != null){
			$this->_GroupDescription->toXml($xml);
		}
		if($this->_ParentId != null){
			$this->_ParentId->toXml($xml);
		}
		if($this->_GroupOrder != null){
			$this->_GroupOrder->toXml($xml);
		}
		if($this->_MimeInfo != null){
			$this->_MimeInfo->toXml($xml);
		}
		if($this->_UserDefinedExtensions != null){
			$this->_UserDefinedExtensions->toXml($xml);
		}
		if($this->_Keywords != null){
			foreach($this->_Keywords as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}
}