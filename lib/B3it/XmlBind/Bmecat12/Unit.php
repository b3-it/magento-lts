<?php
class B3it_XmlBind_Bmecat12_Unit extends B3it_XmlBind_Bmecat12_XmlBind
{
	private $_attributes = array();



	/* @var UnitId */
	private $_UnitId = null;	

	/* @var UnitName */
	private $_UnitName = null;	

	/* @var UnitDescr */
	private $_UnitDescr = null;	

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
	 * @return B3it_XmlBind_Bmecat12_UnitId
	 */
	public function getUnitId()
	{
		if($this->_UnitId == null)
		{
			$this->_UnitId = new B3it_XmlBind_Bmecat12_UnitId();
		}
		
		return $this->_UnitId;
	}
	
	/**
	 * @param $value UnitId
	 * @return B3it_XmlBind_Bmecat12_Unit extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setUnitId($value)
	{
		$this->_UnitId = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_UnitName
	 */
	public function getUnitName()
	{
		if($this->_UnitName == null)
		{
			$this->_UnitName = new B3it_XmlBind_Bmecat12_UnitName();
		}
		
		return $this->_UnitName;
	}
	
	/**
	 * @param $value UnitName
	 * @return B3it_XmlBind_Bmecat12_Unit extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setUnitName($value)
	{
		$this->_UnitName = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_UnitDescr
	 */
	public function getUnitDescr()
	{
		if($this->_UnitDescr == null)
		{
			$this->_UnitDescr = new B3it_XmlBind_Bmecat12_UnitDescr();
		}
		
		return $this->_UnitDescr;
	}
	
	/**
	 * @param $value UnitDescr
	 * @return B3it_XmlBind_Bmecat12_Unit extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setUnitDescr($value)
	{
		$this->_UnitDescr = $value;
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
		if($this->_UnitName != null){
			$this->_UnitName->toXml($xml);
		}
		if($this->_UnitDescr != null){
			$this->_UnitDescr->toXml($xml);
		}


		return $xml;
	}
}