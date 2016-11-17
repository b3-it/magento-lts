<?php
class B3it_XmlBind_Bmecat2005_ClassificationSystemType extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var GroupidHierarchy */
	private $_GroupidHierarchy = null;	

	/* @var MappingType */
	private $_MappingType = null;	

	/* @var MappingLevel */
	private $_MappingLevel = null;	

	/* @var Balancedtree */
	private $_Balancedtree = null;	

	/* @var Inheritance */
	private $_Inheritance = null;	

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
	 * @return B3it_XmlBind_Bmecat2005_GroupidHierarchy
	 */
	public function getGroupidHierarchy()
	{
		if($this->_GroupidHierarchy == null)
		{
			$this->_GroupidHierarchy = new B3it_XmlBind_Bmecat2005_GroupidHierarchy();
		}
		
		return $this->_GroupidHierarchy;
	}
	
	/**
	 * @param $value GroupidHierarchy
	 * @return B3it_XmlBind_Bmecat2005_ClassificationSystemType extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setGroupidHierarchy($value)
	{
		$this->_GroupidHierarchy = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_MappingType
	 */
	public function getMappingType()
	{
		if($this->_MappingType == null)
		{
			$this->_MappingType = new B3it_XmlBind_Bmecat2005_MappingType();
		}
		
		return $this->_MappingType;
	}
	
	/**
	 * @param $value MappingType
	 * @return B3it_XmlBind_Bmecat2005_ClassificationSystemType extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setMappingType($value)
	{
		$this->_MappingType = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_MappingLevel
	 */
	public function getMappingLevel()
	{
		if($this->_MappingLevel == null)
		{
			$this->_MappingLevel = new B3it_XmlBind_Bmecat2005_MappingLevel();
		}
		
		return $this->_MappingLevel;
	}
	
	/**
	 * @param $value MappingLevel
	 * @return B3it_XmlBind_Bmecat2005_ClassificationSystemType extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setMappingLevel($value)
	{
		$this->_MappingLevel = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_Balancedtree
	 */
	public function getBalancedtree()
	{
		if($this->_Balancedtree == null)
		{
			$this->_Balancedtree = new B3it_XmlBind_Bmecat2005_Balancedtree();
		}
		
		return $this->_Balancedtree;
	}
	
	/**
	 * @param $value Balancedtree
	 * @return B3it_XmlBind_Bmecat2005_ClassificationSystemType extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setBalancedtree($value)
	{
		$this->_Balancedtree = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_Inheritance
	 */
	public function getInheritance()
	{
		if($this->_Inheritance == null)
		{
			$this->_Inheritance = new B3it_XmlBind_Bmecat2005_Inheritance();
		}
		
		return $this->_Inheritance;
	}
	
	/**
	 * @param $value Inheritance
	 * @return B3it_XmlBind_Bmecat2005_ClassificationSystemType extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setInheritance($value)
	{
		$this->_Inheritance = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('CLASSIFICATION_SYSTEM_TYPE');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_GroupidHierarchy != null){
			$this->_GroupidHierarchy->toXml($xml);
		}
		if($this->_MappingType != null){
			$this->_MappingType->toXml($xml);
		}
		if($this->_MappingLevel != null){
			$this->_MappingLevel->toXml($xml);
		}
		if($this->_Balancedtree != null){
			$this->_Balancedtree->toXml($xml);
		}
		if($this->_Inheritance != null){
			$this->_Inheritance->toXml($xml);
		}


		return $xml;
	}
}