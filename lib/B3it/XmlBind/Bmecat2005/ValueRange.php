<?php
class B3it_XmlBind_Bmecat2005_ValueRange extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var Startvalue */
	private $_Startvalue = null;	

	/* @var Endvalue */
	private $_Endvalue = null;	

	/* @var Intervalvalue */
	private $_Intervalvalue = null;	

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
	 * @return B3it_XmlBind_Bmecat2005_Startvalue
	 */
	public function getStartvalue()
	{
		if($this->_Startvalue == null)
		{
			$this->_Startvalue = new B3it_XmlBind_Bmecat2005_Startvalue();
		}
		
		return $this->_Startvalue;
	}
	
	/**
	 * @param $value Startvalue
	 * @return B3it_XmlBind_Bmecat2005_ValueRange extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setStartvalue($value)
	{
		$this->_Startvalue = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_Endvalue
	 */
	public function getEndvalue()
	{
		if($this->_Endvalue == null)
		{
			$this->_Endvalue = new B3it_XmlBind_Bmecat2005_Endvalue();
		}
		
		return $this->_Endvalue;
	}
	
	/**
	 * @param $value Endvalue
	 * @return B3it_XmlBind_Bmecat2005_ValueRange extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setEndvalue($value)
	{
		$this->_Endvalue = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_Intervalvalue
	 */
	public function getIntervalvalue()
	{
		if($this->_Intervalvalue == null)
		{
			$this->_Intervalvalue = new B3it_XmlBind_Bmecat2005_Intervalvalue();
		}
		
		return $this->_Intervalvalue;
	}
	
	/**
	 * @param $value Intervalvalue
	 * @return B3it_XmlBind_Bmecat2005_ValueRange extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setIntervalvalue($value)
	{
		$this->_Intervalvalue = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('VALUE_RANGE');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_Startvalue != null){
			$this->_Startvalue->toXml($xml);
		}
		if($this->_Endvalue != null){
			$this->_Endvalue->toXml($xml);
		}
		if($this->_Intervalvalue != null){
			$this->_Intervalvalue->toXml($xml);
		}


		return $xml;
	}
}