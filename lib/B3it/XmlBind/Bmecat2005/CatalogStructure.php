<?php
class B3it_XmlBind_Bmecat2005_CatalogStructure extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var GroupId */
	private $_GroupId = null;	

	/* @var GroupName */
	private $_GroupNames = array();	

	/* @var GroupDescription */
	private $_GroupDescriptions = array();	

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
	 * @return B3it_XmlBind_Bmecat2005_GroupId
	 */
	public function getGroupId()
	{
		if($this->_GroupId == null)
		{
			$this->_GroupId = new B3it_XmlBind_Bmecat2005_GroupId();
		}
		
		return $this->_GroupId;
	}
	
	/**
	 * @param $value GroupId
	 * @return B3it_XmlBind_Bmecat2005_CatalogStructure extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setGroupId($value)
	{
		$this->_GroupId = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_GroupName[]
	 */
	public function getAllGroupName()
	{
		return $this->_GroupNames;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_GroupName and add it to list
	 * @return B3it_XmlBind_Bmecat2005_GroupName
	 */
	public function getGroupName()
	{
		$res = new B3it_XmlBind_Bmecat2005_GroupName();
		$this->_GroupNames[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value GroupName[]
	 * @return B3it_XmlBind_Bmecat2005_CatalogStructure extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setGroupName($value)
	{
		$this->_GroupName = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_GroupDescription[]
	 */
	public function getAllGroupDescription()
	{
		return $this->_GroupDescriptions;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_GroupDescription and add it to list
	 * @return B3it_XmlBind_Bmecat2005_GroupDescription
	 */
	public function getGroupDescription()
	{
		$res = new B3it_XmlBind_Bmecat2005_GroupDescription();
		$this->_GroupDescriptions[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value GroupDescription[]
	 * @return B3it_XmlBind_Bmecat2005_CatalogStructure extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setGroupDescription($value)
	{
		$this->_GroupDescription = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ParentId
	 */
	public function getParentId()
	{
		if($this->_ParentId == null)
		{
			$this->_ParentId = new B3it_XmlBind_Bmecat2005_ParentId();
		}
		
		return $this->_ParentId;
	}
	
	/**
	 * @param $value ParentId
	 * @return B3it_XmlBind_Bmecat2005_CatalogStructure extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setParentId($value)
	{
		$this->_ParentId = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_GroupOrder
	 */
	public function getGroupOrder()
	{
		if($this->_GroupOrder == null)
		{
			$this->_GroupOrder = new B3it_XmlBind_Bmecat2005_GroupOrder();
		}
		
		return $this->_GroupOrder;
	}
	
	/**
	 * @param $value GroupOrder
	 * @return B3it_XmlBind_Bmecat2005_CatalogStructure extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setGroupOrder($value)
	{
		$this->_GroupOrder = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_MimeInfo
	 */
	public function getMimeInfo()
	{
		if($this->_MimeInfo == null)
		{
			$this->_MimeInfo = new B3it_XmlBind_Bmecat2005_MimeInfo();
		}
		
		return $this->_MimeInfo;
	}
	
	/**
	 * @param $value MimeInfo
	 * @return B3it_XmlBind_Bmecat2005_CatalogStructure extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setMimeInfo($value)
	{
		$this->_MimeInfo = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_CatalogStructure_UserDefinedExtensions
	 */
	public function getUserDefinedExtensions()
	{
		if($this->_UserDefinedExtensions == null)
		{
			$this->_UserDefinedExtensions = new B3it_XmlBind_Bmecat2005_CatalogStructure_UserDefinedExtensions();
		}
		
		return $this->_UserDefinedExtensions;
	}
	
	/**
	 * @param $value UserDefinedExtensions
	 * @return B3it_XmlBind_Bmecat2005_CatalogStructure extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setUserDefinedExtensions($value)
	{
		$this->_UserDefinedExtensions = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_Keyword[]
	 */
	public function getAllKeyword()
	{
		return $this->_Keywords;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_Keyword and add it to list
	 * @return B3it_XmlBind_Bmecat2005_Keyword
	 */
	public function getKeyword()
	{
		$res = new B3it_XmlBind_Bmecat2005_Keyword();
		$this->_Keywords[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value Keyword[]
	 * @return B3it_XmlBind_Bmecat2005_CatalogStructure extends B3it_XmlBind_Bmecat2005_XmlBind
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
		if($this->_GroupNames != null){
			foreach($this->_GroupNames as $item){
				$item->toXml($xml);
			}
		}
		if($this->_GroupDescriptions != null){
			foreach($this->_GroupDescriptions as $item){
				$item->toXml($xml);
			}
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