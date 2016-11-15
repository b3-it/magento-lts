<?php
class B3it_XmlBind_Bmecat2005_ClassificationGroupFeatureTemplate extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var FtIdref */
	private $_FtIdref = null;	

	/* @var FtMandatory */
	private $_FtMandatory = null;	

	/* @var FtDatatype */
	private $_FtDatatype = null;	

	/* @var FtUnitIdref */
	private $_FtUnitIdref = null;	

	/* @var FtUnit */
	private $_FtUnit = null;	

	/* @var FtOrder */
	private $_FtOrder = null;	

	/* @var FtAllowedValues */
	private $_FtAllowedValues = null;	

	/* @var FtValues */
	private $_FtValues = null;	

	/* @var FtValency */
	private $_FtValency = null;	

	/* @var FtSymbol */
	private $_FtSymbols = array();	

	/* @var FtSynonyms */
	private $_FtSynonyms = null;	

	/* @var MimeInfo */
	private $_MimeInfo = null;	

	/* @var FtSource */
	private $_FtSource = null;	

	/* @var FtNote */
	private $_FtNotes = array();	

	/* @var FtRemark */
	private $_FtRemarks = array();	

	/* @var FtDependencies */
	private $_FtDependencies = null;	

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
	 * @return B3it_XmlBind_Bmecat2005_FtIdref
	 */
	public function getFtIdref()
	{
		if($this->_FtIdref == null)
		{
			$this->_FtIdref = new B3it_XmlBind_Bmecat2005_FtIdref();
		}
		
		return $this->_FtIdref;
	}
	
	/**
	 * @param $value FtIdref
	 * @return B3it_XmlBind_Bmecat2005_ClassificationGroupFeatureTemplate extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setFtIdref($value)
	{
		$this->_FtIdref = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_FtMandatory
	 */
	public function getFtMandatory()
	{
		if($this->_FtMandatory == null)
		{
			$this->_FtMandatory = new B3it_XmlBind_Bmecat2005_FtMandatory();
		}
		
		return $this->_FtMandatory;
	}
	
	/**
	 * @param $value FtMandatory
	 * @return B3it_XmlBind_Bmecat2005_ClassificationGroupFeatureTemplate extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setFtMandatory($value)
	{
		$this->_FtMandatory = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_FtDatatype
	 */
	public function getFtDatatype()
	{
		if($this->_FtDatatype == null)
		{
			$this->_FtDatatype = new B3it_XmlBind_Bmecat2005_FtDatatype();
		}
		
		return $this->_FtDatatype;
	}
	
	/**
	 * @param $value FtDatatype
	 * @return B3it_XmlBind_Bmecat2005_ClassificationGroupFeatureTemplate extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setFtDatatype($value)
	{
		$this->_FtDatatype = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_FtUnitIdref
	 */
	public function getFtUnitIdref()
	{
		if($this->_FtUnitIdref == null)
		{
			$this->_FtUnitIdref = new B3it_XmlBind_Bmecat2005_FtUnitIdref();
		}
		
		return $this->_FtUnitIdref;
	}
	
	/**
	 * @param $value FtUnitIdref
	 * @return B3it_XmlBind_Bmecat2005_ClassificationGroupFeatureTemplate extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setFtUnitIdref($value)
	{
		$this->_FtUnitIdref = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_FtUnit
	 */
	public function getFtUnit()
	{
		if($this->_FtUnit == null)
		{
			$this->_FtUnit = new B3it_XmlBind_Bmecat2005_FtUnit();
		}
		
		return $this->_FtUnit;
	}
	
	/**
	 * @param $value FtUnit
	 * @return B3it_XmlBind_Bmecat2005_ClassificationGroupFeatureTemplate extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setFtUnit($value)
	{
		$this->_FtUnit = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_FtOrder
	 */
	public function getFtOrder()
	{
		if($this->_FtOrder == null)
		{
			$this->_FtOrder = new B3it_XmlBind_Bmecat2005_FtOrder();
		}
		
		return $this->_FtOrder;
	}
	
	/**
	 * @param $value FtOrder
	 * @return B3it_XmlBind_Bmecat2005_ClassificationGroupFeatureTemplate extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setFtOrder($value)
	{
		$this->_FtOrder = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_FtAllowedValues
	 */
	public function getFtAllowedValues()
	{
		if($this->_FtAllowedValues == null)
		{
			$this->_FtAllowedValues = new B3it_XmlBind_Bmecat2005_FtAllowedValues();
		}
		
		return $this->_FtAllowedValues;
	}
	
	/**
	 * @param $value FtAllowedValues
	 * @return B3it_XmlBind_Bmecat2005_ClassificationGroupFeatureTemplate extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setFtAllowedValues($value)
	{
		$this->_FtAllowedValues = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_FtValues
	 */
	public function getFtValues()
	{
		if($this->_FtValues == null)
		{
			$this->_FtValues = new B3it_XmlBind_Bmecat2005_FtValues();
		}
		
		return $this->_FtValues;
	}
	
	/**
	 * @param $value FtValues
	 * @return B3it_XmlBind_Bmecat2005_ClassificationGroupFeatureTemplate extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setFtValues($value)
	{
		$this->_FtValues = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_FtValency
	 */
	public function getFtValency()
	{
		if($this->_FtValency == null)
		{
			$this->_FtValency = new B3it_XmlBind_Bmecat2005_FtValency();
		}
		
		return $this->_FtValency;
	}
	
	/**
	 * @param $value FtValency
	 * @return B3it_XmlBind_Bmecat2005_ClassificationGroupFeatureTemplate extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setFtValency($value)
	{
		$this->_FtValency = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_FtSymbol[]
	 */
	public function getAllFtSymbol()
	{
		return $this->_FtSymbols;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_FtSymbol and add it to list
	 * @return B3it_XmlBind_Bmecat2005_FtSymbol
	 */
	public function getFtSymbol()
	{
		$res = new B3it_XmlBind_Bmecat2005_FtSymbol();
		$this->_FtSymbols[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value FtSymbol[]
	 * @return B3it_XmlBind_Bmecat2005_ClassificationGroupFeatureTemplate extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setFtSymbol($value)
	{
		$this->_FtSymbol = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_FtSynonyms
	 */
	public function getFtSynonyms()
	{
		if($this->_FtSynonyms == null)
		{
			$this->_FtSynonyms = new B3it_XmlBind_Bmecat2005_FtSynonyms();
		}
		
		return $this->_FtSynonyms;
	}
	
	/**
	 * @param $value FtSynonyms
	 * @return B3it_XmlBind_Bmecat2005_ClassificationGroupFeatureTemplate extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setFtSynonyms($value)
	{
		$this->_FtSynonyms = $value;
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
	 * @return B3it_XmlBind_Bmecat2005_ClassificationGroupFeatureTemplate extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setMimeInfo($value)
	{
		$this->_MimeInfo = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_FtSource
	 */
	public function getFtSource()
	{
		if($this->_FtSource == null)
		{
			$this->_FtSource = new B3it_XmlBind_Bmecat2005_FtSource();
		}
		
		return $this->_FtSource;
	}
	
	/**
	 * @param $value FtSource
	 * @return B3it_XmlBind_Bmecat2005_ClassificationGroupFeatureTemplate extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setFtSource($value)
	{
		$this->_FtSource = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_FtNote[]
	 */
	public function getAllFtNote()
	{
		return $this->_FtNotes;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_FtNote and add it to list
	 * @return B3it_XmlBind_Bmecat2005_FtNote
	 */
	public function getFtNote()
	{
		$res = new B3it_XmlBind_Bmecat2005_FtNote();
		$this->_FtNotes[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value FtNote[]
	 * @return B3it_XmlBind_Bmecat2005_ClassificationGroupFeatureTemplate extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setFtNote($value)
	{
		$this->_FtNote = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_FtRemark[]
	 */
	public function getAllFtRemark()
	{
		return $this->_FtRemarks;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_FtRemark and add it to list
	 * @return B3it_XmlBind_Bmecat2005_FtRemark
	 */
	public function getFtRemark()
	{
		$res = new B3it_XmlBind_Bmecat2005_FtRemark();
		$this->_FtRemarks[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value FtRemark[]
	 * @return B3it_XmlBind_Bmecat2005_ClassificationGroupFeatureTemplate extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setFtRemark($value)
	{
		$this->_FtRemark = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_FtDependencies
	 */
	public function getFtDependencies()
	{
		if($this->_FtDependencies == null)
		{
			$this->_FtDependencies = new B3it_XmlBind_Bmecat2005_FtDependencies();
		}
		
		return $this->_FtDependencies;
	}
	
	/**
	 * @param $value FtDependencies
	 * @return B3it_XmlBind_Bmecat2005_ClassificationGroupFeatureTemplate extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setFtDependencies($value)
	{
		$this->_FtDependencies = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('CLASSIFICATION_GROUP_FEATURE_TEMPLATE');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_FtIdref != null){
			$this->_FtIdref->toXml($xml);
		}
		if($this->_FtMandatory != null){
			$this->_FtMandatory->toXml($xml);
		}
		if($this->_FtDatatype != null){
			$this->_FtDatatype->toXml($xml);
		}
		if($this->_FtUnitIdref != null){
			$this->_FtUnitIdref->toXml($xml);
		}
		if($this->_FtUnit != null){
			$this->_FtUnit->toXml($xml);
		}
		if($this->_FtOrder != null){
			$this->_FtOrder->toXml($xml);
		}
		if($this->_FtAllowedValues != null){
			$this->_FtAllowedValues->toXml($xml);
		}
		if($this->_FtValues != null){
			$this->_FtValues->toXml($xml);
		}
		if($this->_FtValency != null){
			$this->_FtValency->toXml($xml);
		}
		if($this->_FtSymbols != null){
			foreach($this->_FtSymbols as $item){
				$item->toXml($xml);
			}
		}
		if($this->_FtSynonyms != null){
			$this->_FtSynonyms->toXml($xml);
		}
		if($this->_MimeInfo != null){
			$this->_MimeInfo->toXml($xml);
		}
		if($this->_FtSource != null){
			$this->_FtSource->toXml($xml);
		}
		if($this->_FtNotes != null){
			foreach($this->_FtNotes as $item){
				$item->toXml($xml);
			}
		}
		if($this->_FtRemarks != null){
			foreach($this->_FtRemarks as $item){
				$item->toXml($xml);
			}
		}
		if($this->_FtDependencies != null){
			$this->_FtDependencies->toXml($xml);
		}


		return $xml;
	}
}