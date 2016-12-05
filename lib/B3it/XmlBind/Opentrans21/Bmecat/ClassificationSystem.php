<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_ClassificationSystem
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystem extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystemName */
	private $__ClassificationSystemName = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystemFullname */
	private $__ClassificationSystemFullnameA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystemVersionDetails */
	private $__ClassificationSystemVersionDetails = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystemVersion */
	private $__ClassificationSystemVersion = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystemDescr */
	private $__ClassificationSystemDescrA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystemPartyIdref */
	private $__ClassificationSystemPartyIdref = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystemLevels */
	private $__ClassificationSystemLevels = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystemLevelNames */
	private $__ClassificationSystemLevelNames = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystemType */
	private $__ClassificationSystemType = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_AllowedValues */
	private $__AllowedValues = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_Units */
	private $__Units = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_FtGroups */
	private $__FtGroups = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystemFeatureTemplates */
	private $__ClassificationSystemFeatureTemplates = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroups */
	private $__ClassificationGroups = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystemName
	 */
	public function getClassificationSystemName()
	{
		if($this->__ClassificationSystemName == null)
		{
			$this->__ClassificationSystemName = new B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystemName();
		}
	
		return $this->__ClassificationSystemName;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystemName
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystem
	 */
	public function setClassificationSystemName($value)
	{
		$this->__ClassificationSystemName = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystemFullname and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystemFullname
	 */
	public function getClassificationSystemFullname()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystemFullname();
		$this->__ClassificationSystemFullnameA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystemFullname
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystem
	 */
	public function setClassificationSystemFullname($value)
	{
		$this->__ClassificationSystemFullnameA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystemFullname[]
	 */
	public function getAllClassificationSystemFullname()
	{
		return $this->__ClassificationSystemFullnameA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystemVersionDetails
	 */
	public function getClassificationSystemVersionDetails()
	{
		if($this->__ClassificationSystemVersionDetails == null)
		{
			$this->__ClassificationSystemVersionDetails = new B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystemVersionDetails();
		}
	
		return $this->__ClassificationSystemVersionDetails;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystemVersionDetails
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystem
	 */
	public function setClassificationSystemVersionDetails($value)
	{
		$this->__ClassificationSystemVersionDetails = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystemVersion
	 */
	public function getClassificationSystemVersion()
	{
		if($this->__ClassificationSystemVersion == null)
		{
			$this->__ClassificationSystemVersion = new B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystemVersion();
		}
	
		return $this->__ClassificationSystemVersion;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystemVersion
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystem
	 */
	public function setClassificationSystemVersion($value)
	{
		$this->__ClassificationSystemVersion = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystemDescr and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystemDescr
	 */
	public function getClassificationSystemDescr()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystemDescr();
		$this->__ClassificationSystemDescrA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystemDescr
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystem
	 */
	public function setClassificationSystemDescr($value)
	{
		$this->__ClassificationSystemDescrA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystemDescr[]
	 */
	public function getAllClassificationSystemDescr()
	{
		return $this->__ClassificationSystemDescrA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystemPartyIdref
	 */
	public function getClassificationSystemPartyIdref()
	{
		if($this->__ClassificationSystemPartyIdref == null)
		{
			$this->__ClassificationSystemPartyIdref = new B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystemPartyIdref();
		}
	
		return $this->__ClassificationSystemPartyIdref;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystemPartyIdref
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystem
	 */
	public function setClassificationSystemPartyIdref($value)
	{
		$this->__ClassificationSystemPartyIdref = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystemLevels
	 */
	public function getClassificationSystemLevels()
	{
		if($this->__ClassificationSystemLevels == null)
		{
			$this->__ClassificationSystemLevels = new B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystemLevels();
		}
	
		return $this->__ClassificationSystemLevels;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystemLevels
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystem
	 */
	public function setClassificationSystemLevels($value)
	{
		$this->__ClassificationSystemLevels = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystemLevelNames
	 */
	public function getClassificationSystemLevelNames()
	{
		if($this->__ClassificationSystemLevelNames == null)
		{
			$this->__ClassificationSystemLevelNames = new B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystemLevelNames();
		}
	
		return $this->__ClassificationSystemLevelNames;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystemLevelNames
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystem
	 */
	public function setClassificationSystemLevelNames($value)
	{
		$this->__ClassificationSystemLevelNames = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystemType
	 */
	public function getClassificationSystemType()
	{
		if($this->__ClassificationSystemType == null)
		{
			$this->__ClassificationSystemType = new B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystemType();
		}
	
		return $this->__ClassificationSystemType;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystemType
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystem
	 */
	public function setClassificationSystemType($value)
	{
		$this->__ClassificationSystemType = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_AllowedValues
	 */
	public function getAllowedValues()
	{
		if($this->__AllowedValues == null)
		{
			$this->__AllowedValues = new B3it_XmlBind_Opentrans21_Bmecat_AllowedValues();
		}
	
		return $this->__AllowedValues;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_AllowedValues
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystem
	 */
	public function setAllowedValues($value)
	{
		$this->__AllowedValues = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Units
	 */
	public function getUnits()
	{
		if($this->__Units == null)
		{
			$this->__Units = new B3it_XmlBind_Opentrans21_Bmecat_Units();
		}
	
		return $this->__Units;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Units
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystem
	 */
	public function setUnits($value)
	{
		$this->__Units = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FtGroups
	 */
	public function getFtGroups()
	{
		if($this->__FtGroups == null)
		{
			$this->__FtGroups = new B3it_XmlBind_Opentrans21_Bmecat_FtGroups();
		}
	
		return $this->__FtGroups;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_FtGroups
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystem
	 */
	public function setFtGroups($value)
	{
		$this->__FtGroups = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystemFeatureTemplates
	 */
	public function getClassificationSystemFeatureTemplates()
	{
		if($this->__ClassificationSystemFeatureTemplates == null)
		{
			$this->__ClassificationSystemFeatureTemplates = new B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystemFeatureTemplates();
		}
	
		return $this->__ClassificationSystemFeatureTemplates;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystemFeatureTemplates
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystem
	 */
	public function setClassificationSystemFeatureTemplates($value)
	{
		$this->__ClassificationSystemFeatureTemplates = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroups
	 */
	public function getClassificationGroups()
	{
		if($this->__ClassificationGroups == null)
		{
			$this->__ClassificationGroups = new B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroups();
		}
	
		return $this->__ClassificationGroups;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroups
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationSystem
	 */
	public function setClassificationGroups($value)
	{
		$this->__ClassificationGroups = $value;
		return $this;
	}





	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:CLASSIFICATION_SYSTEM');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:CLASSIFICATION_SYSTEM');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__ClassificationSystemName != null){
			$this->__ClassificationSystemName->toXml($xml);
		}
		if($this->__ClassificationSystemFullnameA != null){
			foreach($this->__ClassificationSystemFullnameA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__ClassificationSystemVersionDetails != null){
			$this->__ClassificationSystemVersionDetails->toXml($xml);
		}
		if($this->__ClassificationSystemVersion != null){
			$this->__ClassificationSystemVersion->toXml($xml);
		}
		if($this->__ClassificationSystemDescrA != null){
			foreach($this->__ClassificationSystemDescrA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__ClassificationSystemPartyIdref != null){
			$this->__ClassificationSystemPartyIdref->toXml($xml);
		}
		if($this->__ClassificationSystemLevels != null){
			$this->__ClassificationSystemLevels->toXml($xml);
		}
		if($this->__ClassificationSystemLevelNames != null){
			$this->__ClassificationSystemLevelNames->toXml($xml);
		}
		if($this->__ClassificationSystemType != null){
			$this->__ClassificationSystemType->toXml($xml);
		}
		if($this->__AllowedValues != null){
			$this->__AllowedValues->toXml($xml);
		}
		if($this->__Units != null){
			$this->__Units->toXml($xml);
		}
		if($this->__FtGroups != null){
			$this->__FtGroups->toXml($xml);
		}
		if($this->__ClassificationSystemFeatureTemplates != null){
			$this->__ClassificationSystemFeatureTemplates->toXml($xml);
		}
		if($this->__ClassificationGroups != null){
			$this->__ClassificationGroups->toXml($xml);
		}


		return $xml;
	}

}
