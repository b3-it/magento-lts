<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_Formula
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_Formula extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_FormulaId */
	private $__FormulaId = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_FormulaVersion */
	private $__FormulaVersion = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_FormulaName */
	private $__FormulaNameA = array();

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_FormulaDescr */
	private $__FormulaDescrA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_FormulaSource */
	private $__FormulaSource = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_MimeInfo */
	private $__MimeInfo = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_FormulaFunction */
	private $__FormulaFunction = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_ParameterDefinitions */
	private $__ParameterDefinitions = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FormulaId
	 */
	public function getFormulaId()
	{
		if($this->__FormulaId == null)
		{
			$this->__FormulaId = new B3it_XmlBind_Opentrans21_Bmecat_FormulaId();
		}
	
		return $this->__FormulaId;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_FormulaId
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Formula
	 */
	public function setFormulaId($value)
	{
		$this->__FormulaId = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FormulaVersion
	 */
	public function getFormulaVersion()
	{
		if($this->__FormulaVersion == null)
		{
			$this->__FormulaVersion = new B3it_XmlBind_Opentrans21_Bmecat_FormulaVersion();
		}
	
		return $this->__FormulaVersion;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_FormulaVersion
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Formula
	 */
	public function setFormulaVersion($value)
	{
		$this->__FormulaVersion = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_FormulaName and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FormulaName
	 */
	public function getFormulaName()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_FormulaName();
		$this->__FormulaNameA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_FormulaName
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Formula
	 */
	public function setFormulaName($value)
	{
		$this->__FormulaNameA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FormulaName[]
	 */
	public function getAllFormulaName()
	{
		return $this->__FormulaNameA;
	}


	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_FormulaDescr and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FormulaDescr
	 */
	public function getFormulaDescr()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_FormulaDescr();
		$this->__FormulaDescrA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_FormulaDescr
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Formula
	 */
	public function setFormulaDescr($value)
	{
		$this->__FormulaDescrA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FormulaDescr[]
	 */
	public function getAllFormulaDescr()
	{
		return $this->__FormulaDescrA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FormulaSource
	 */
	public function getFormulaSource()
	{
		if($this->__FormulaSource == null)
		{
			$this->__FormulaSource = new B3it_XmlBind_Opentrans21_Bmecat_FormulaSource();
		}
	
		return $this->__FormulaSource;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_FormulaSource
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Formula
	 */
	public function setFormulaSource($value)
	{
		$this->__FormulaSource = $value;
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
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Formula
	 */
	public function setMimeInfo($value)
	{
		$this->__MimeInfo = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_FormulaFunction
	 */
	public function getFormulaFunction()
	{
		if($this->__FormulaFunction == null)
		{
			$this->__FormulaFunction = new B3it_XmlBind_Opentrans21_Bmecat_FormulaFunction();
		}
	
		return $this->__FormulaFunction;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_FormulaFunction
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Formula
	 */
	public function setFormulaFunction($value)
	{
		$this->__FormulaFunction = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ParameterDefinitions
	 */
	public function getParameterDefinitions()
	{
		if($this->__ParameterDefinitions == null)
		{
			$this->__ParameterDefinitions = new B3it_XmlBind_Opentrans21_Bmecat_ParameterDefinitions();
		}
	
		return $this->__ParameterDefinitions;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ParameterDefinitions
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Formula
	 */
	public function setParameterDefinitions($value)
	{
		$this->__ParameterDefinitions = $value;
		return $this;
	}





	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:FORMULA');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:FORMULA');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__FormulaId != null){
			$this->__FormulaId->toXml($xml);
		}
		if($this->__FormulaVersion != null){
			$this->__FormulaVersion->toXml($xml);
		}
		if($this->__FormulaNameA != null){
			foreach($this->__FormulaNameA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__FormulaDescrA != null){
			foreach($this->__FormulaDescrA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__FormulaSource != null){
			$this->__FormulaSource->toXml($xml);
		}
		if($this->__MimeInfo != null){
			$this->__MimeInfo->toXml($xml);
		}
		if($this->__FormulaFunction != null){
			$this->__FormulaFunction->toXml($xml);
		}
		if($this->__ParameterDefinitions != null){
			$this->__ParameterDefinitions->toXml($xml);
		}


		return $xml;
	}

}
