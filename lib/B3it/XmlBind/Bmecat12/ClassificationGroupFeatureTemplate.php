<?php
class B3it_XmlBind_Bmecat12_ClassificationGroupFeatureTemplate extends B3it_XmlBind_Bmecat12_XmlBind
{
	private $_attributes = array();



	/* @var FtIdref */
	private $_FtIdref = null;	

	/* @var FtMandatory */
	private $_FtMandatory = null;	

	/* @var FtDatatype */
	private $_FtDatatype = null;	

	/* @var FtUnit */
	private $_FtUnit = null;	

	/* @var FtOrder */
	private $_FtOrder = null;	

	/* @var FtAllowedValues */
	private $_FtAllowedValues = null;	

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
	 * @return B3it_XmlBind_Bmecat12_FtIdref
	 */
	public function getFtIdref()
	{
		if($this->_FtIdref == null)
		{
			$this->_FtIdref = new B3it_XmlBind_Bmecat12_FtIdref();
		}
		
		return $this->_FtIdref;
	}
	
	/**
	 * @param $value FtIdref
	 * @return B3it_XmlBind_Bmecat12_ClassificationGroupFeatureTemplate extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setFtIdref($value)
	{
		$this->_FtIdref = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_FtMandatory
	 */
	public function getFtMandatory()
	{
		if($this->_FtMandatory == null)
		{
			$this->_FtMandatory = new B3it_XmlBind_Bmecat12_FtMandatory();
		}
		
		return $this->_FtMandatory;
	}
	
	/**
	 * @param $value FtMandatory
	 * @return B3it_XmlBind_Bmecat12_ClassificationGroupFeatureTemplate extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setFtMandatory($value)
	{
		$this->_FtMandatory = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_FtDatatype
	 */
	public function getFtDatatype()
	{
		if($this->_FtDatatype == null)
		{
			$this->_FtDatatype = new B3it_XmlBind_Bmecat12_FtDatatype();
		}
		
		return $this->_FtDatatype;
	}
	
	/**
	 * @param $value FtDatatype
	 * @return B3it_XmlBind_Bmecat12_ClassificationGroupFeatureTemplate extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setFtDatatype($value)
	{
		$this->_FtDatatype = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_FtUnit
	 */
	public function getFtUnit()
	{
		if($this->_FtUnit == null)
		{
			$this->_FtUnit = new B3it_XmlBind_Bmecat12_FtUnit();
		}
		
		return $this->_FtUnit;
	}
	
	/**
	 * @param $value FtUnit
	 * @return B3it_XmlBind_Bmecat12_ClassificationGroupFeatureTemplate extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setFtUnit($value)
	{
		$this->_FtUnit = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_FtOrder
	 */
	public function getFtOrder()
	{
		if($this->_FtOrder == null)
		{
			$this->_FtOrder = new B3it_XmlBind_Bmecat12_FtOrder();
		}
		
		return $this->_FtOrder;
	}
	
	/**
	 * @param $value FtOrder
	 * @return B3it_XmlBind_Bmecat12_ClassificationGroupFeatureTemplate extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setFtOrder($value)
	{
		$this->_FtOrder = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_FtAllowedValues
	 */
	public function getFtAllowedValues()
	{
		if($this->_FtAllowedValues == null)
		{
			$this->_FtAllowedValues = new B3it_XmlBind_Bmecat12_FtAllowedValues();
		}
		
		return $this->_FtAllowedValues;
	}
	
	/**
	 * @param $value FtAllowedValues
	 * @return B3it_XmlBind_Bmecat12_ClassificationGroupFeatureTemplate extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setFtAllowedValues($value)
	{
		$this->_FtAllowedValues = $value;
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
		if($this->_FtUnit != null){
			$this->_FtUnit->toXml($xml);
		}
		if($this->_FtOrder != null){
			$this->_FtOrder->toXml($xml);
		}
		if($this->_FtAllowedValues != null){
			$this->_FtAllowedValues->toXml($xml);
		}


		return $xml;
	}
}