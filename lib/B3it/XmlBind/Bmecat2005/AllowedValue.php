<?php
class B3it_XmlBind_Bmecat2005_AllowedValue extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var AllowedValueId */
	private $_AllowedValueId = null;	

	/* @var AllowedValueName */
	private $_AllowedValueNames = array();	

	/* @var AllowedValueVersion */
	private $_AllowedValueVersion = null;	

	/* @var AllowedValueShortname */
	private $_AllowedValueShortnames = array();	

	/* @var AllowedValueDescr */
	private $_AllowedValueDescrs = array();	

	/* @var AllowedValueSynonyms */
	private $_AllowedValueSynonyms = null;	

	/* @var AllowedValueSource */
	private $_AllowedValueSource = null;	

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
	 * @return B3it_XmlBind_Bmecat2005_AllowedValueId
	 */
	public function getAllowedValueId()
	{
		if($this->_AllowedValueId == null)
		{
			$this->_AllowedValueId = new B3it_XmlBind_Bmecat2005_AllowedValueId();
		}
		
		return $this->_AllowedValueId;
	}
	
	/**
	 * @param $value AllowedValueId
	 * @return B3it_XmlBind_Bmecat2005_AllowedValue extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setAllowedValueId($value)
	{
		$this->_AllowedValueId = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_AllowedValueName[]
	 */
	public function getAllAllowedValueName()
	{
		return $this->_AllowedValueNames;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_AllowedValueName and add it to list
	 * @return B3it_XmlBind_Bmecat2005_AllowedValueName
	 */
	public function getAllowedValueName()
	{
		$res = new B3it_XmlBind_Bmecat2005_AllowedValueName();
		$this->_AllowedValueNames[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value AllowedValueName[]
	 * @return B3it_XmlBind_Bmecat2005_AllowedValue extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setAllowedValueName($value)
	{
		$this->_AllowedValueName = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_AllowedValueVersion
	 */
	public function getAllowedValueVersion()
	{
		if($this->_AllowedValueVersion == null)
		{
			$this->_AllowedValueVersion = new B3it_XmlBind_Bmecat2005_AllowedValueVersion();
		}
		
		return $this->_AllowedValueVersion;
	}
	
	/**
	 * @param $value AllowedValueVersion
	 * @return B3it_XmlBind_Bmecat2005_AllowedValue extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setAllowedValueVersion($value)
	{
		$this->_AllowedValueVersion = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_AllowedValueShortname[]
	 */
	public function getAllAllowedValueShortname()
	{
		return $this->_AllowedValueShortnames;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_AllowedValueShortname and add it to list
	 * @return B3it_XmlBind_Bmecat2005_AllowedValueShortname
	 */
	public function getAllowedValueShortname()
	{
		$res = new B3it_XmlBind_Bmecat2005_AllowedValueShortname();
		$this->_AllowedValueShortnames[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value AllowedValueShortname[]
	 * @return B3it_XmlBind_Bmecat2005_AllowedValue extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setAllowedValueShortname($value)
	{
		$this->_AllowedValueShortname = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_AllowedValueDescr[]
	 */
	public function getAllAllowedValueDescr()
	{
		return $this->_AllowedValueDescrs;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_AllowedValueDescr and add it to list
	 * @return B3it_XmlBind_Bmecat2005_AllowedValueDescr
	 */
	public function getAllowedValueDescr()
	{
		$res = new B3it_XmlBind_Bmecat2005_AllowedValueDescr();
		$this->_AllowedValueDescrs[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value AllowedValueDescr[]
	 * @return B3it_XmlBind_Bmecat2005_AllowedValue extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setAllowedValueDescr($value)
	{
		$this->_AllowedValueDescr = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_AllowedValueSynonyms
	 */
	public function getAllowedValueSynonyms()
	{
		if($this->_AllowedValueSynonyms == null)
		{
			$this->_AllowedValueSynonyms = new B3it_XmlBind_Bmecat2005_AllowedValueSynonyms();
		}
		
		return $this->_AllowedValueSynonyms;
	}
	
	/**
	 * @param $value AllowedValueSynonyms
	 * @return B3it_XmlBind_Bmecat2005_AllowedValue extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setAllowedValueSynonyms($value)
	{
		$this->_AllowedValueSynonyms = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_AllowedValueSource
	 */
	public function getAllowedValueSource()
	{
		if($this->_AllowedValueSource == null)
		{
			$this->_AllowedValueSource = new B3it_XmlBind_Bmecat2005_AllowedValueSource();
		}
		
		return $this->_AllowedValueSource;
	}
	
	/**
	 * @param $value AllowedValueSource
	 * @return B3it_XmlBind_Bmecat2005_AllowedValue extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setAllowedValueSource($value)
	{
		$this->_AllowedValueSource = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('ALLOWED_VALUE');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_AllowedValueId != null){
			$this->_AllowedValueId->toXml($xml);
		}
		if($this->_AllowedValueNames != null){
			foreach($this->_AllowedValueNames as $item){
				$item->toXml($xml);
			}
		}
		if($this->_AllowedValueVersion != null){
			$this->_AllowedValueVersion->toXml($xml);
		}
		if($this->_AllowedValueShortnames != null){
			foreach($this->_AllowedValueShortnames as $item){
				$item->toXml($xml);
			}
		}
		if($this->_AllowedValueDescrs != null){
			foreach($this->_AllowedValueDescrs as $item){
				$item->toXml($xml);
			}
		}
		if($this->_AllowedValueSynonyms != null){
			$this->_AllowedValueSynonyms->toXml($xml);
		}
		if($this->_AllowedValueSource != null){
			$this->_AllowedValueSource->toXml($xml);
		}


		return $xml;
	}
}