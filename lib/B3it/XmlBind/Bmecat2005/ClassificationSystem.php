<?php
class B3it_XmlBind_Bmecat2005_ClassificationSystem extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var ClassificationSystemName */
	private $_ClassificationSystemName = null;	

	/* @var ClassificationSystemFullname */
	private $_ClassificationSystemFullnames = array();	

	/* @var ClassificationSystemVersionDetails */
	private $_ClassificationSystemVersionDetails = null;	

	/* @var ClassificationSystemVersion */
	private $_ClassificationSystemVersion = null;	

	/* @var ClassificationSystemDescr */
	private $_ClassificationSystemDescrs = array();	

	/* @var ClassificationSystemPartyIdref */
	private $_ClassificationSystemPartyIdref = null;	

	/* @var ClassificationSystemLevels */
	private $_ClassificationSystemLevels = null;	

	/* @var ClassificationSystemLevelNames */
	private $_ClassificationSystemLevelNames = null;	

	/* @var ClassificationSystemType */
	private $_ClassificationSystemType = null;	

	/* @var AllowedValues */
	private $_AllowedValues = null;	

	/* @var Units */
	private $_Units = null;	

	/* @var FtGroups */
	private $_FtGroups = null;	

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
	 * @return B3it_XmlBind_Bmecat2005_ClassificationSystemName
	 */
	public function getClassificationSystemName()
	{
		if($this->_ClassificationSystemName == null)
		{
			$this->_ClassificationSystemName = new B3it_XmlBind_Bmecat2005_ClassificationSystemName();
		}
		
		return $this->_ClassificationSystemName;
	}
	
	/**
	 * @param $value ClassificationSystemName
	 * @return B3it_XmlBind_Bmecat2005_ClassificationSystem extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setClassificationSystemName($value)
	{
		$this->_ClassificationSystemName = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ClassificationSystemFullname[]
	 */
	public function getAllClassificationSystemFullname()
	{
		return $this->_ClassificationSystemFullnames;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_ClassificationSystemFullname and add it to list
	 * @return B3it_XmlBind_Bmecat2005_ClassificationSystemFullname
	 */
	public function getClassificationSystemFullname()
	{
		$res = new B3it_XmlBind_Bmecat2005_ClassificationSystemFullname();
		$this->_ClassificationSystemFullnames[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value ClassificationSystemFullname[]
	 * @return B3it_XmlBind_Bmecat2005_ClassificationSystem extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setClassificationSystemFullname($value)
	{
		$this->_ClassificationSystemFullname = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ClassificationSystemVersionDetails
	 */
	public function getClassificationSystemVersionDetails()
	{
		if($this->_ClassificationSystemVersionDetails == null)
		{
			$this->_ClassificationSystemVersionDetails = new B3it_XmlBind_Bmecat2005_ClassificationSystemVersionDetails();
		}
		
		return $this->_ClassificationSystemVersionDetails;
	}
	
	/**
	 * @param $value ClassificationSystemVersionDetails
	 * @return B3it_XmlBind_Bmecat2005_ClassificationSystem extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setClassificationSystemVersionDetails($value)
	{
		$this->_ClassificationSystemVersionDetails = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ClassificationSystemVersion
	 */
	public function getClassificationSystemVersion()
	{
		if($this->_ClassificationSystemVersion == null)
		{
			$this->_ClassificationSystemVersion = new B3it_XmlBind_Bmecat2005_ClassificationSystemVersion();
		}
		
		return $this->_ClassificationSystemVersion;
	}
	
	/**
	 * @param $value ClassificationSystemVersion
	 * @return B3it_XmlBind_Bmecat2005_ClassificationSystem extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setClassificationSystemVersion($value)
	{
		$this->_ClassificationSystemVersion = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ClassificationSystemDescr[]
	 */
	public function getAllClassificationSystemDescr()
	{
		return $this->_ClassificationSystemDescrs;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_ClassificationSystemDescr and add it to list
	 * @return B3it_XmlBind_Bmecat2005_ClassificationSystemDescr
	 */
	public function getClassificationSystemDescr()
	{
		$res = new B3it_XmlBind_Bmecat2005_ClassificationSystemDescr();
		$this->_ClassificationSystemDescrs[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value ClassificationSystemDescr[]
	 * @return B3it_XmlBind_Bmecat2005_ClassificationSystem extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setClassificationSystemDescr($value)
	{
		$this->_ClassificationSystemDescr = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ClassificationSystemPartyIdref
	 */
	public function getClassificationSystemPartyIdref()
	{
		if($this->_ClassificationSystemPartyIdref == null)
		{
			$this->_ClassificationSystemPartyIdref = new B3it_XmlBind_Bmecat2005_ClassificationSystemPartyIdref();
		}
		
		return $this->_ClassificationSystemPartyIdref;
	}
	
	/**
	 * @param $value ClassificationSystemPartyIdref
	 * @return B3it_XmlBind_Bmecat2005_ClassificationSystem extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setClassificationSystemPartyIdref($value)
	{
		$this->_ClassificationSystemPartyIdref = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ClassificationSystemLevels
	 */
	public function getClassificationSystemLevels()
	{
		if($this->_ClassificationSystemLevels == null)
		{
			$this->_ClassificationSystemLevels = new B3it_XmlBind_Bmecat2005_ClassificationSystemLevels();
		}
		
		return $this->_ClassificationSystemLevels;
	}
	
	/**
	 * @param $value ClassificationSystemLevels
	 * @return B3it_XmlBind_Bmecat2005_ClassificationSystem extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setClassificationSystemLevels($value)
	{
		$this->_ClassificationSystemLevels = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ClassificationSystemLevelNames
	 */
	public function getClassificationSystemLevelNames()
	{
		if($this->_ClassificationSystemLevelNames == null)
		{
			$this->_ClassificationSystemLevelNames = new B3it_XmlBind_Bmecat2005_ClassificationSystemLevelNames();
		}
		
		return $this->_ClassificationSystemLevelNames;
	}
	
	/**
	 * @param $value ClassificationSystemLevelNames
	 * @return B3it_XmlBind_Bmecat2005_ClassificationSystem extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setClassificationSystemLevelNames($value)
	{
		$this->_ClassificationSystemLevelNames = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ClassificationSystemType
	 */
	public function getClassificationSystemType()
	{
		if($this->_ClassificationSystemType == null)
		{
			$this->_ClassificationSystemType = new B3it_XmlBind_Bmecat2005_ClassificationSystemType();
		}
		
		return $this->_ClassificationSystemType;
	}
	
	/**
	 * @param $value ClassificationSystemType
	 * @return B3it_XmlBind_Bmecat2005_ClassificationSystem extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setClassificationSystemType($value)
	{
		$this->_ClassificationSystemType = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_AllowedValues
	 */
	public function getAllowedValues()
	{
		if($this->_AllowedValues == null)
		{
			$this->_AllowedValues = new B3it_XmlBind_Bmecat2005_AllowedValues();
		}
		
		return $this->_AllowedValues;
	}
	
	/**
	 * @param $value AllowedValues
	 * @return B3it_XmlBind_Bmecat2005_ClassificationSystem extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setAllowedValues($value)
	{
		$this->_AllowedValues = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_Units
	 */
	public function getUnits()
	{
		if($this->_Units == null)
		{
			$this->_Units = new B3it_XmlBind_Bmecat2005_Units();
		}
		
		return $this->_Units;
	}
	
	/**
	 * @param $value Units
	 * @return B3it_XmlBind_Bmecat2005_ClassificationSystem extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setUnits($value)
	{
		$this->_Units = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_FtGroups
	 */
	public function getFtGroups()
	{
		if($this->_FtGroups == null)
		{
			$this->_FtGroups = new B3it_XmlBind_Bmecat2005_FtGroups();
		}
		
		return $this->_FtGroups;
	}
	
	/**
	 * @param $value FtGroups
	 * @return B3it_XmlBind_Bmecat2005_ClassificationSystem extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setFtGroups($value)
	{
		$this->_FtGroups = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ClassificationSystemFeatureTemplates
	 */
	public function getClassificationSystemFeatureTemplates()
	{
		if($this->_ClassificationSystemFeatureTemplates == null)
		{
			$this->_ClassificationSystemFeatureTemplates = new B3it_XmlBind_Bmecat2005_ClassificationSystemFeatureTemplates();
		}
		
		return $this->_ClassificationSystemFeatureTemplates;
	}
	
	/**
	 * @param $value ClassificationSystemFeatureTemplates
	 * @return B3it_XmlBind_Bmecat2005_ClassificationSystem extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setClassificationSystemFeatureTemplates($value)
	{
		$this->_ClassificationSystemFeatureTemplates = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ClassificationGroups
	 */
	public function getClassificationGroups()
	{
		if($this->_ClassificationGroups == null)
		{
			$this->_ClassificationGroups = new B3it_XmlBind_Bmecat2005_ClassificationGroups();
		}
		
		return $this->_ClassificationGroups;
	}
	
	/**
	 * @param $value ClassificationGroups
	 * @return B3it_XmlBind_Bmecat2005_ClassificationSystem extends B3it_XmlBind_Bmecat2005_XmlBind
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
		if($this->_ClassificationSystemFullnames != null){
			foreach($this->_ClassificationSystemFullnames as $item){
				$item->toXml($xml);
			}
		}
		if($this->_ClassificationSystemVersionDetails != null){
			$this->_ClassificationSystemVersionDetails->toXml($xml);
		}
		if($this->_ClassificationSystemVersion != null){
			$this->_ClassificationSystemVersion->toXml($xml);
		}
		if($this->_ClassificationSystemDescrs != null){
			foreach($this->_ClassificationSystemDescrs as $item){
				$item->toXml($xml);
			}
		}
		if($this->_ClassificationSystemPartyIdref != null){
			$this->_ClassificationSystemPartyIdref->toXml($xml);
		}
		if($this->_ClassificationSystemLevels != null){
			$this->_ClassificationSystemLevels->toXml($xml);
		}
		if($this->_ClassificationSystemLevelNames != null){
			$this->_ClassificationSystemLevelNames->toXml($xml);
		}
		if($this->_ClassificationSystemType != null){
			$this->_ClassificationSystemType->toXml($xml);
		}
		if($this->_AllowedValues != null){
			$this->_AllowedValues->toXml($xml);
		}
		if($this->_Units != null){
			$this->_Units->toXml($xml);
		}
		if($this->_FtGroups != null){
			$this->_FtGroups->toXml($xml);
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