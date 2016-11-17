<?php
class B3it_XmlBind_Bmecat12_ClassificationGroup extends B3it_XmlBind_Bmecat12_XmlBind
{
	private $_attributes = array();



	/* @var ClassificationGroupId */
	private $_ClassificationGroupId = null;	

	/* @var ClassificationGroupName */
	private $_ClassificationGroupName = null;	

	/* @var ClassificationGroupDescr */
	private $_ClassificationGroupDescr = null;	

	/* @var ClassificationGroupSynonyms */
	private $_ClassificationGroupSynonyms = null;	

	/* @var ClassificationGroupFeatureTemplates */
	private $_ClassificationGroupFeatureTemplates = null;	

	/* @var ClassificationGroupParentId */
	private $_ClassificationGroupParentId = null;	

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
	 * @return B3it_XmlBind_Bmecat12_ClassificationGroupId
	 */
	public function getClassificationGroupId()
	{
		if($this->_ClassificationGroupId == null)
		{
			$this->_ClassificationGroupId = new B3it_XmlBind_Bmecat12_ClassificationGroupId();
		}
		
		return $this->_ClassificationGroupId;
	}
	
	/**
	 * @param $value ClassificationGroupId
	 * @return B3it_XmlBind_Bmecat12_ClassificationGroup extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setClassificationGroupId($value)
	{
		$this->_ClassificationGroupId = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_ClassificationGroupName
	 */
	public function getClassificationGroupName()
	{
		if($this->_ClassificationGroupName == null)
		{
			$this->_ClassificationGroupName = new B3it_XmlBind_Bmecat12_ClassificationGroupName();
		}
		
		return $this->_ClassificationGroupName;
	}
	
	/**
	 * @param $value ClassificationGroupName
	 * @return B3it_XmlBind_Bmecat12_ClassificationGroup extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setClassificationGroupName($value)
	{
		$this->_ClassificationGroupName = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_ClassificationGroupDescr
	 */
	public function getClassificationGroupDescr()
	{
		if($this->_ClassificationGroupDescr == null)
		{
			$this->_ClassificationGroupDescr = new B3it_XmlBind_Bmecat12_ClassificationGroupDescr();
		}
		
		return $this->_ClassificationGroupDescr;
	}
	
	/**
	 * @param $value ClassificationGroupDescr
	 * @return B3it_XmlBind_Bmecat12_ClassificationGroup extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setClassificationGroupDescr($value)
	{
		$this->_ClassificationGroupDescr = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_ClassificationGroupSynonyms
	 */
	public function getClassificationGroupSynonyms()
	{
		if($this->_ClassificationGroupSynonyms == null)
		{
			$this->_ClassificationGroupSynonyms = new B3it_XmlBind_Bmecat12_ClassificationGroupSynonyms();
		}
		
		return $this->_ClassificationGroupSynonyms;
	}
	
	/**
	 * @param $value ClassificationGroupSynonyms
	 * @return B3it_XmlBind_Bmecat12_ClassificationGroup extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setClassificationGroupSynonyms($value)
	{
		$this->_ClassificationGroupSynonyms = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_ClassificationGroupFeatureTemplates
	 */
	public function getClassificationGroupFeatureTemplates()
	{
		if($this->_ClassificationGroupFeatureTemplates == null)
		{
			$this->_ClassificationGroupFeatureTemplates = new B3it_XmlBind_Bmecat12_ClassificationGroupFeatureTemplates();
		}
		
		return $this->_ClassificationGroupFeatureTemplates;
	}
	
	/**
	 * @param $value ClassificationGroupFeatureTemplates
	 * @return B3it_XmlBind_Bmecat12_ClassificationGroup extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setClassificationGroupFeatureTemplates($value)
	{
		$this->_ClassificationGroupFeatureTemplates = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_ClassificationGroupParentId
	 */
	public function getClassificationGroupParentId()
	{
		if($this->_ClassificationGroupParentId == null)
		{
			$this->_ClassificationGroupParentId = new B3it_XmlBind_Bmecat12_ClassificationGroupParentId();
		}
		
		return $this->_ClassificationGroupParentId;
	}
	
	/**
	 * @param $value ClassificationGroupParentId
	 * @return B3it_XmlBind_Bmecat12_ClassificationGroup extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setClassificationGroupParentId($value)
	{
		$this->_ClassificationGroupParentId = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('CLASSIFICATION_GROUP');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_ClassificationGroupId != null){
			$this->_ClassificationGroupId->toXml($xml);
		}
		if($this->_ClassificationGroupName != null){
			$this->_ClassificationGroupName->toXml($xml);
		}
		if($this->_ClassificationGroupDescr != null){
			$this->_ClassificationGroupDescr->toXml($xml);
		}
		if($this->_ClassificationGroupSynonyms != null){
			$this->_ClassificationGroupSynonyms->toXml($xml);
		}
		if($this->_ClassificationGroupFeatureTemplates != null){
			$this->_ClassificationGroupFeatureTemplates->toXml($xml);
		}
		if($this->_ClassificationGroupParentId != null){
			$this->_ClassificationGroupParentId->toXml($xml);
		}


		return $xml;
	}
}