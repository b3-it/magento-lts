<?php
class B3it_XmlBind_Bmecat2005_Formula extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var FormulaId */
	private $_FormulaId = null;	

	/* @var FormulaVersion */
	private $_FormulaVersion = null;	

	/* @var FormulaName */
	private $_FormulaNames = array();	

	/* @var FormulaDescr */
	private $_FormulaDescrs = array();	

	/* @var FormulaSource */
	private $_FormulaSource = null;	

	/* @var MimeInfo */
	private $_MimeInfo = null;	

	/* @var FormulaFunction */
	private $_FormulaFunction = null;	

	/* @var ParameterDefinitions */
	private $_ParameterDefinitions = null;	

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
	 * @return B3it_XmlBind_Bmecat2005_FormulaId
	 */
	public function getFormulaId()
	{
		if($this->_FormulaId == null)
		{
			$this->_FormulaId = new B3it_XmlBind_Bmecat2005_FormulaId();
		}
		
		return $this->_FormulaId;
	}
	
	/**
	 * @param $value FormulaId
	 * @return B3it_XmlBind_Bmecat2005_Formula extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setFormulaId($value)
	{
		$this->_FormulaId = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_FormulaVersion
	 */
	public function getFormulaVersion()
	{
		if($this->_FormulaVersion == null)
		{
			$this->_FormulaVersion = new B3it_XmlBind_Bmecat2005_FormulaVersion();
		}
		
		return $this->_FormulaVersion;
	}
	
	/**
	 * @param $value FormulaVersion
	 * @return B3it_XmlBind_Bmecat2005_Formula extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setFormulaVersion($value)
	{
		$this->_FormulaVersion = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_FormulaName[]
	 */
	public function getAllFormulaName()
	{
		return $this->_FormulaNames;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_FormulaName and add it to list
	 * @return B3it_XmlBind_Bmecat2005_FormulaName
	 */
	public function getFormulaName()
	{
		$res = new B3it_XmlBind_Bmecat2005_FormulaName();
		$this->_FormulaNames[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value FormulaName[]
	 * @return B3it_XmlBind_Bmecat2005_Formula extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setFormulaName($value)
	{
		$this->_FormulaName = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_FormulaDescr[]
	 */
	public function getAllFormulaDescr()
	{
		return $this->_FormulaDescrs;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_FormulaDescr and add it to list
	 * @return B3it_XmlBind_Bmecat2005_FormulaDescr
	 */
	public function getFormulaDescr()
	{
		$res = new B3it_XmlBind_Bmecat2005_FormulaDescr();
		$this->_FormulaDescrs[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value FormulaDescr[]
	 * @return B3it_XmlBind_Bmecat2005_Formula extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setFormulaDescr($value)
	{
		$this->_FormulaDescr = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_FormulaSource
	 */
	public function getFormulaSource()
	{
		if($this->_FormulaSource == null)
		{
			$this->_FormulaSource = new B3it_XmlBind_Bmecat2005_FormulaSource();
		}
		
		return $this->_FormulaSource;
	}
	
	/**
	 * @param $value FormulaSource
	 * @return B3it_XmlBind_Bmecat2005_Formula extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setFormulaSource($value)
	{
		$this->_FormulaSource = $value;
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
	 * @return B3it_XmlBind_Bmecat2005_Formula extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setMimeInfo($value)
	{
		$this->_MimeInfo = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_FormulaFunction
	 */
	public function getFormulaFunction()
	{
		if($this->_FormulaFunction == null)
		{
			$this->_FormulaFunction = new B3it_XmlBind_Bmecat2005_FormulaFunction();
		}
		
		return $this->_FormulaFunction;
	}
	
	/**
	 * @param $value FormulaFunction
	 * @return B3it_XmlBind_Bmecat2005_Formula extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setFormulaFunction($value)
	{
		$this->_FormulaFunction = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ParameterDefinitions
	 */
	public function getParameterDefinitions()
	{
		if($this->_ParameterDefinitions == null)
		{
			$this->_ParameterDefinitions = new B3it_XmlBind_Bmecat2005_ParameterDefinitions();
		}
		
		return $this->_ParameterDefinitions;
	}
	
	/**
	 * @param $value ParameterDefinitions
	 * @return B3it_XmlBind_Bmecat2005_Formula extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setParameterDefinitions($value)
	{
		$this->_ParameterDefinitions = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('FORMULA');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_FormulaId != null){
			$this->_FormulaId->toXml($xml);
		}
		if($this->_FormulaVersion != null){
			$this->_FormulaVersion->toXml($xml);
		}
		if($this->_FormulaNames != null){
			foreach($this->_FormulaNames as $item){
				$item->toXml($xml);
			}
		}
		if($this->_FormulaDescrs != null){
			foreach($this->_FormulaDescrs as $item){
				$item->toXml($xml);
			}
		}
		if($this->_FormulaSource != null){
			$this->_FormulaSource->toXml($xml);
		}
		if($this->_MimeInfo != null){
			$this->_MimeInfo->toXml($xml);
		}
		if($this->_FormulaFunction != null){
			$this->_FormulaFunction->toXml($xml);
		}
		if($this->_ParameterDefinitions != null){
			$this->_ParameterDefinitions->toXml($xml);
		}


		return $xml;
	}
}