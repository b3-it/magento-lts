<?php
class B3it_XmlBind_Bmecat2005_ParameterBasics extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var ParameterName */
	private $_ParameterNames = array();	

	/* @var ParameterDescr */
	private $_ParameterDescrs = array();	

	/* @var ParameterUnit */
	private $_ParameterUnits = array();	

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
	 * @return B3it_XmlBind_Bmecat2005_ParameterName[]
	 */
	public function getAllParameterName()
	{
		return $this->_ParameterNames;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_ParameterName and add it to list
	 * @return B3it_XmlBind_Bmecat2005_ParameterName
	 */
	public function getParameterName()
	{
		$res = new B3it_XmlBind_Bmecat2005_ParameterName();
		$this->_ParameterNames[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value ParameterName[]
	 * @return B3it_XmlBind_Bmecat2005_ParameterBasics extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setParameterName($value)
	{
		$this->_ParameterName = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ParameterDescr[]
	 */
	public function getAllParameterDescr()
	{
		return $this->_ParameterDescrs;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_ParameterDescr and add it to list
	 * @return B3it_XmlBind_Bmecat2005_ParameterDescr
	 */
	public function getParameterDescr()
	{
		$res = new B3it_XmlBind_Bmecat2005_ParameterDescr();
		$this->_ParameterDescrs[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value ParameterDescr[]
	 * @return B3it_XmlBind_Bmecat2005_ParameterBasics extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setParameterDescr($value)
	{
		$this->_ParameterDescr = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ParameterUnit[]
	 */
	public function getAllParameterUnit()
	{
		return $this->_ParameterUnits;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_ParameterUnit and add it to list
	 * @return B3it_XmlBind_Bmecat2005_ParameterUnit
	 */
	public function getParameterUnit()
	{
		$res = new B3it_XmlBind_Bmecat2005_ParameterUnit();
		$this->_ParameterUnits[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value ParameterUnit[]
	 * @return B3it_XmlBind_Bmecat2005_ParameterBasics extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setParameterUnit($value)
	{
		$this->_ParameterUnit = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('PARAMETER_BASICS');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_ParameterNames != null){
			foreach($this->_ParameterNames as $item){
				$item->toXml($xml);
			}
		}
		if($this->_ParameterDescrs != null){
			foreach($this->_ParameterDescrs as $item){
				$item->toXml($xml);
			}
		}
		if($this->_ParameterUnits != null){
			foreach($this->_ParameterUnits as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}
}