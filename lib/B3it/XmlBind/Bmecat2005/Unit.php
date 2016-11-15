<?php
class B3it_XmlBind_Bmecat2005_Unit extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var UnitId */
	private $_UnitId = null;	

	/* @var UnitName */
	private $_UnitNames = array();	

	/* @var UnitShortname */
	private $_UnitShortnames = array();	

	/* @var UnitDescr */
	private $_UnitDescrs = array();	

	/* @var UnitCode */
	private $_UnitCode = null;	

	/* @var UnitUri */
	private $_UnitUri = null;	

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
	 * @return B3it_XmlBind_Bmecat2005_UnitId
	 */
	public function getUnitId()
	{
		if($this->_UnitId == null)
		{
			$this->_UnitId = new B3it_XmlBind_Bmecat2005_UnitId();
		}
		
		return $this->_UnitId;
	}
	
	/**
	 * @param $value UnitId
	 * @return B3it_XmlBind_Bmecat2005_Unit extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setUnitId($value)
	{
		$this->_UnitId = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_UnitName[]
	 */
	public function getAllUnitName()
	{
		return $this->_UnitNames;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_UnitName and add it to list
	 * @return B3it_XmlBind_Bmecat2005_UnitName
	 */
	public function getUnitName()
	{
		$res = new B3it_XmlBind_Bmecat2005_UnitName();
		$this->_UnitNames[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value UnitName[]
	 * @return B3it_XmlBind_Bmecat2005_Unit extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setUnitName($value)
	{
		$this->_UnitName = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_UnitShortname[]
	 */
	public function getAllUnitShortname()
	{
		return $this->_UnitShortnames;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_UnitShortname and add it to list
	 * @return B3it_XmlBind_Bmecat2005_UnitShortname
	 */
	public function getUnitShortname()
	{
		$res = new B3it_XmlBind_Bmecat2005_UnitShortname();
		$this->_UnitShortnames[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value UnitShortname[]
	 * @return B3it_XmlBind_Bmecat2005_Unit extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setUnitShortname($value)
	{
		$this->_UnitShortname = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_UnitDescr[]
	 */
	public function getAllUnitDescr()
	{
		return $this->_UnitDescrs;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_UnitDescr and add it to list
	 * @return B3it_XmlBind_Bmecat2005_UnitDescr
	 */
	public function getUnitDescr()
	{
		$res = new B3it_XmlBind_Bmecat2005_UnitDescr();
		$this->_UnitDescrs[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value UnitDescr[]
	 * @return B3it_XmlBind_Bmecat2005_Unit extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setUnitDescr($value)
	{
		$this->_UnitDescr = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_UnitCode
	 */
	public function getUnitCode()
	{
		if($this->_UnitCode == null)
		{
			$this->_UnitCode = new B3it_XmlBind_Bmecat2005_UnitCode();
		}
		
		return $this->_UnitCode;
	}
	
	/**
	 * @param $value UnitCode
	 * @return B3it_XmlBind_Bmecat2005_Unit extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setUnitCode($value)
	{
		$this->_UnitCode = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_UnitUri
	 */
	public function getUnitUri()
	{
		if($this->_UnitUri == null)
		{
			$this->_UnitUri = new B3it_XmlBind_Bmecat2005_UnitUri();
		}
		
		return $this->_UnitUri;
	}
	
	/**
	 * @param $value UnitUri
	 * @return B3it_XmlBind_Bmecat2005_Unit extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setUnitUri($value)
	{
		$this->_UnitUri = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('UNIT');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_UnitId != null){
			$this->_UnitId->toXml($xml);
		}
		if($this->_UnitNames != null){
			foreach($this->_UnitNames as $item){
				$item->toXml($xml);
			}
		}
		if($this->_UnitShortnames != null){
			foreach($this->_UnitShortnames as $item){
				$item->toXml($xml);
			}
		}
		if($this->_UnitDescrs != null){
			foreach($this->_UnitDescrs as $item){
				$item->toXml($xml);
			}
		}
		if($this->_UnitCode != null){
			$this->_UnitCode->toXml($xml);
		}
		if($this->_UnitUri != null){
			$this->_UnitUri->toXml($xml);
		}


		return $xml;
	}
}