<?php
class B3it_XmlBind_Bmecat12_ClassificationSystem extends B3it_XmlBind_Bmecat12_XmlBind
{
	private $_attributes = array();



	/* @var ClassificationSystemName */
	private $_ClassificationSystemName = null;	

	/* @var ClassificationSystemFullname */
	private $_ClassificationSystemFullname = null;	

	/* @var ClassificationSystemVersion */
	private $_ClassificationSystemVersion = null;	

	/* @var ClassificationSystemDescr */
	private $_ClassificationSystemDescr = null;	

	/* @var ClassificationSystemLevels */
	private $_ClassificationSystemLevels = null;	

	/* @var ClassificationSystemLevelNames */
	private $_ClassificationSystemLevelNames = null;	

	/* @var AllowedValues */
	private $_AllowedValues = null;	

	/* @var Units */
	private $_Units = null;	

	/* @var ClassificationSystemFeatureTemplates */
	private $_ClassificationSystemFeatureTemplates = null;	

	/* @var ClassificationGroups */
	private $_ClassificationGroups = null;	

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
	 * @return B3it_XmlBind_Bmecat12_ClassificationSystemName
	 */
	public function getClassificationSystemName()
	{
		if($this->_ClassificationSystemName == null)
		{
			$this->_ClassificationSystemName = new B3it_XmlBind_Bmecat12_ClassificationSystemName();
		}
		
		return $this->_ClassificationSystemName;
	}
	
	/**
	 * @param $value ClassificationSystemName
	 * @return B3it_XmlBind_Bmecat12_ClassificationSystem extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setClassificationSystemName($value)
	{
		$this->_ClassificationSystemName = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_ClassificationSystemFullname
	 */
	public function getClassificationSystemFullname()
	{
		if($this->_ClassificationSystemFullname == null)
		{
			$this->_ClassificationSystemFullname = new B3it_XmlBind_Bmecat12_ClassificationSystemFullname();
		}
		
		return $this->_ClassificationSystemFullname;
	}
	
	/**
	 * @param $value ClassificationSystemFullname
	 * @return B3it_XmlBind_Bmecat12_ClassificationSystem extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setClassificationSystemFullname($value)
	{
		$this->_ClassificationSystemFullname = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_ClassificationSystemVersion
	 */
	public function getClassificationSystemVersion()
	{
		if($this->_ClassificationSystemVersion == null)
		{
			$this->_ClassificationSystemVersion = new B3it_XmlBind_Bmecat12_ClassificationSystemVersion();
		}
		
		return $this->_ClassificationSystemVersion;
	}
	
	/**
	 * @param $value ClassificationSystemVersion
	 * @return B3it_XmlBind_Bmecat12_ClassificationSystem extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setClassificationSystemVersion($value)
	{
		$this->_ClassificationSystemVersion = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_ClassificationSystemDescr
	 */
	public function getClassificationSystemDescr()
	{
		if($this->_ClassificationSystemDescr == null)
		{
			$this->_ClassificationSystemDescr = new B3it_XmlBind_Bmecat12_ClassificationSystemDescr();
		}
		
		return $this->_ClassificationSystemDescr;
	}
	
	/**
	 * @param $value ClassificationSystemDescr
	 * @return B3it_XmlBind_Bmecat12_ClassificationSystem extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setClassificationSystemDescr($value)
	{
		$this->_ClassificationSystemDescr = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_ClassificationSystemLevels
	 */
	public function getClassificationSystemLevels()
	{
		if($this->_ClassificationSystemLevels == null)
		{
			$this->_ClassificationSystemLevels = new B3it_XmlBind_Bmecat12_ClassificationSystemLevels();
		}
		
		return $this->_ClassificationSystemLevels;
	}
	
	/**
	 * @param $value ClassificationSystemLevels
	 * @return B3it_XmlBind_Bmecat12_ClassificationSystem extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setClassificationSystemLevels($value)
	{
		$this->_ClassificationSystemLevels = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_ClassificationSystemLevelNames
	 */
	public function getClassificationSystemLevelNames()
	{
		if($this->_ClassificationSystemLevelNames == null)
		{
			$this->_ClassificationSystemLevelNames = new B3it_XmlBind_Bmecat12_ClassificationSystemLevelNames();
		}
		
		return $this->_ClassificationSystemLevelNames;
	}
	
	/**
	 * @param $value ClassificationSystemLevelNames
	 * @return B3it_XmlBind_Bmecat12_ClassificationSystem extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setClassificationSystemLevelNames($value)
	{
		$this->_ClassificationSystemLevelNames = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_AllowedValues
	 */
	public function getAllowedValues()
	{
		if($this->_AllowedValues == null)
		{
			$this->_AllowedValues = new B3it_XmlBind_Bmecat12_AllowedValues();
		}
		
		return $this->_AllowedValues;
	}
	
	/**
	 * @param $value AllowedValues
	 * @return B3it_XmlBind_Bmecat12_ClassificationSystem extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setAllowedValues($value)
	{
		$this->_AllowedValues = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_Units
	 */
	public function getUnits()
	{
		if($this->_Units == null)
		{
			$this->_Units = new B3it_XmlBind_Bmecat12_Units();
		}
		
		return $this->_Units;
	}
	
	/**
	 * @param $value Units
	 * @return B3it_XmlBind_Bmecat12_ClassificationSystem extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setUnits($value)
	{
		$this->_Units = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_ClassificationSystemFeatureTemplates
	 */
	public function getClassificationSystemFeatureTemplates()
	{
		if($this->_ClassificationSystemFeatureTemplates == null)
		{
			$this->_ClassificationSystemFeatureTemplates = new B3it_XmlBind_Bmecat12_ClassificationSystemFeatureTemplates();
		}
		
		return $this->_ClassificationSystemFeatureTemplates;
	}
	
	/**
	 * @param $value ClassificationSystemFeatureTemplates
	 * @return B3it_XmlBind_Bmecat12_ClassificationSystem extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setClassificationSystemFeatureTemplates($value)
	{
		$this->_ClassificationSystemFeatureTemplates = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_ClassificationGroups
	 */
	public function getClassificationGroups()
	{
		if($this->_ClassificationGroups == null)
		{
			$this->_ClassificationGroups = new B3it_XmlBind_Bmecat12_ClassificationGroups();
		}
		
		return $this->_ClassificationGroups;
	}
	
	/**
	 * @param $value ClassificationGroups
	 * @return B3it_XmlBind_Bmecat12_ClassificationSystem extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setClassificationGroups($value)
	{
		$this->_ClassificationGroups = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('CLASSIFICATION_SYSTEM');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_ClassificationSystemName != null){
			$this->_ClassificationSystemName->toXml($xml);
		}
		if($this->_ClassificationSystemFullname != null){
			$this->_ClassificationSystemFullname->toXml($xml);
		}
		if($this->_ClassificationSystemVersion != null){
			$this->_ClassificationSystemVersion->toXml($xml);
		}
		if($this->_ClassificationSystemDescr != null){
			$this->_ClassificationSystemDescr->toXml($xml);
		}
		if($this->_ClassificationSystemLevels != null){
			$this->_ClassificationSystemLevels->toXml($xml);
		}
		if($this->_ClassificationSystemLevelNames != null){
			$this->_ClassificationSystemLevelNames->toXml($xml);
		}
		if($this->_AllowedValues != null){
			$this->_AllowedValues->toXml($xml);
		}
		if($this->_Units != null){
			$this->_Units->toXml($xml);
		}
		if($this->_ClassificationSystemFeatureTemplates != null){
			$this->_ClassificationSystemFeatureTemplates->toXml($xml);
		}
		if($this->_ClassificationGroups != null){
			$this->_ClassificationGroups->toXml($xml);
		}


		return $xml;
	}
}