<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_ClassificationGroupFeatureTemplate
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupFeatureTemplate extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_FtIdref */
	private $__FtIdref = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_FtMandatory */
	private $__FtMandatory = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_FtDatatype */
	private $__FtDatatype = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_FtUnitIdref */
	private $__FtUnitIdref = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_FtUnit */
	private $__FtUnit = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_FtOrder */
	private $__FtOrder = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_FtAllowedValues */
	private $__FtAllowedValues = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_FtValues */
	private $__FtValues = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_FtValency */
	private $__FtValency = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_FtSymbol */
	private $__FtSymbolA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_FtSynonyms */
	private $__FtSynonyms = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_MimeInfo */
	private $__MimeInfo = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_FtSource */
	private $__FtSource = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_FtNote */
	private $__FtNoteA = array();

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_FtRemark */
	private $__FtRemarkA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_FtDependencies */
	private $__FtDependencies = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FtIdref
	 */
	public function getFtIdref()
	{
		if($this->__FtIdref == null)
		{
			$this->__FtIdref = new B3it_XmlBind_Opentrans21_Bmecat_FtIdref();
		}
	
		return $this->__FtIdref;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_FtIdref
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupFeatureTemplate
	 */
	public function setFtIdref($value)
	{
		$this->__FtIdref = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FtMandatory
	 */
	public function getFtMandatory()
	{
		if($this->__FtMandatory == null)
		{
			$this->__FtMandatory = new B3it_XmlBind_Opentrans21_Bmecat_FtMandatory();
		}
	
		return $this->__FtMandatory;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_FtMandatory
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupFeatureTemplate
	 */
	public function setFtMandatory($value)
	{
		$this->__FtMandatory = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FtDatatype
	 */
	public function getFtDatatype()
	{
		if($this->__FtDatatype == null)
		{
			$this->__FtDatatype = new B3it_XmlBind_Opentrans21_Bmecat_FtDatatype();
		}
	
		return $this->__FtDatatype;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_FtDatatype
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupFeatureTemplate
	 */
	public function setFtDatatype($value)
	{
		$this->__FtDatatype = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FtUnitIdref
	 */
	public function getFtUnitIdref()
	{
		if($this->__FtUnitIdref == null)
		{
			$this->__FtUnitIdref = new B3it_XmlBind_Opentrans21_Bmecat_FtUnitIdref();
		}
	
		return $this->__FtUnitIdref;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_FtUnitIdref
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupFeatureTemplate
	 */
	public function setFtUnitIdref($value)
	{
		$this->__FtUnitIdref = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FtUnit
	 */
	public function getFtUnit()
	{
		if($this->__FtUnit == null)
		{
			$this->__FtUnit = new B3it_XmlBind_Opentrans21_Bmecat_FtUnit();
		}
	
		return $this->__FtUnit;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_FtUnit
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupFeatureTemplate
	 */
	public function setFtUnit($value)
	{
		$this->__FtUnit = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FtOrder
	 */
	public function getFtOrder()
	{
		if($this->__FtOrder == null)
		{
			$this->__FtOrder = new B3it_XmlBind_Opentrans21_Bmecat_FtOrder();
		}
	
		return $this->__FtOrder;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_FtOrder
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupFeatureTemplate
	 */
	public function setFtOrder($value)
	{
		$this->__FtOrder = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FtAllowedValues
	 */
	public function getFtAllowedValues()
	{
		if($this->__FtAllowedValues == null)
		{
			$this->__FtAllowedValues = new B3it_XmlBind_Opentrans21_Bmecat_FtAllowedValues();
		}
	
		return $this->__FtAllowedValues;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_FtAllowedValues
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupFeatureTemplate
	 */
	public function setFtAllowedValues($value)
	{
		$this->__FtAllowedValues = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FtValues
	 */
	public function getFtValues()
	{
		if($this->__FtValues == null)
		{
			$this->__FtValues = new B3it_XmlBind_Opentrans21_Bmecat_FtValues();
		}
	
		return $this->__FtValues;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_FtValues
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupFeatureTemplate
	 */
	public function setFtValues($value)
	{
		$this->__FtValues = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FtValency
	 */
	public function getFtValency()
	{
		if($this->__FtValency == null)
		{
			$this->__FtValency = new B3it_XmlBind_Opentrans21_Bmecat_FtValency();
		}
	
		return $this->__FtValency;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_FtValency
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupFeatureTemplate
	 */
	public function setFtValency($value)
	{
		$this->__FtValency = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_FtSymbol and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FtSymbol
	 */
	public function getFtSymbol()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_FtSymbol();
		$this->__FtSymbolA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_FtSymbol
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupFeatureTemplate
	 */
	public function setFtSymbol($value)
	{
		$this->__FtSymbolA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FtSymbol[]
	 */
	public function getAllFtSymbol()
	{
		return $this->__FtSymbolA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FtSynonyms
	 */
	public function getFtSynonyms()
	{
		if($this->__FtSynonyms == null)
		{
			$this->__FtSynonyms = new B3it_XmlBind_Opentrans21_Bmecat_FtSynonyms();
		}
	
		return $this->__FtSynonyms;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_FtSynonyms
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupFeatureTemplate
	 */
	public function setFtSynonyms($value)
	{
		$this->__FtSynonyms = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_MimeInfo
	 */
	public function getMimeInfo()
	{
		if($this->__MimeInfo == null)
		{
			$this->__MimeInfo = new B3it_XmlBind_Opentrans21_Bmecat_MimeInfo();
		}
	
		return $this->__MimeInfo;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_MimeInfo
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupFeatureTemplate
	 */
	public function setMimeInfo($value)
	{
		$this->__MimeInfo = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FtSource
	 */
	public function getFtSource()
	{
		if($this->__FtSource == null)
		{
			$this->__FtSource = new B3it_XmlBind_Opentrans21_Bmecat_FtSource();
		}
	
		return $this->__FtSource;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_FtSource
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupFeatureTemplate
	 */
	public function setFtSource($value)
	{
		$this->__FtSource = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_FtNote and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FtNote
	 */
	public function getFtNote()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_FtNote();
		$this->__FtNoteA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_FtNote
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupFeatureTemplate
	 */
	public function setFtNote($value)
	{
		$this->__FtNoteA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FtNote[]
	 */
	public function getAllFtNote()
	{
		return $this->__FtNoteA;
	}


	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_FtRemark and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FtRemark
	 */
	public function getFtRemark()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_FtRemark();
		$this->__FtRemarkA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_FtRemark
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupFeatureTemplate
	 */
	public function setFtRemark($value)
	{
		$this->__FtRemarkA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FtRemark[]
	 */
	public function getAllFtRemark()
	{
		return $this->__FtRemarkA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FtDependencies
	 */
	public function getFtDependencies()
	{
		if($this->__FtDependencies == null)
		{
			$this->__FtDependencies = new B3it_XmlBind_Opentrans21_Bmecat_FtDependencies();
		}
	
		return $this->__FtDependencies;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_FtDependencies
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ClassificationGroupFeatureTemplate
	 */
	public function setFtDependencies($value)
	{
		$this->__FtDependencies = $value;
		return $this;
	}





	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:CLASSIFICATION_GROUP_FEATURE_TEMPLATE');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:CLASSIFICATION_GROUP_FEATURE_TEMPLATE');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__FtIdref != null){
			$this->__FtIdref->toXml($xml);
		}
		if($this->__FtMandatory != null){
			$this->__FtMandatory->toXml($xml);
		}
		if($this->__FtDatatype != null){
			$this->__FtDatatype->toXml($xml);
		}
		if($this->__FtUnitIdref != null){
			$this->__FtUnitIdref->toXml($xml);
		}
		if($this->__FtUnit != null){
			$this->__FtUnit->toXml($xml);
		}
		if($this->__FtOrder != null){
			$this->__FtOrder->toXml($xml);
		}
		if($this->__FtAllowedValues != null){
			$this->__FtAllowedValues->toXml($xml);
		}
		if($this->__FtValues != null){
			$this->__FtValues->toXml($xml);
		}
		if($this->__FtValency != null){
			$this->__FtValency->toXml($xml);
		}
		if($this->__FtSymbolA != null){
			foreach($this->__FtSymbolA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__FtSynonyms != null){
			$this->__FtSynonyms->toXml($xml);
		}
		if($this->__MimeInfo != null){
			$this->__MimeInfo->toXml($xml);
		}
		if($this->__FtSource != null){
			$this->__FtSource->toXml($xml);
		}
		if($this->__FtNoteA != null){
			foreach($this->__FtNoteA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__FtRemarkA != null){
			foreach($this->__FtRemarkA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__FtDependencies != null){
			$this->__FtDependencies->toXml($xml);
		}


		return $xml;
	}

}
