<?php
class B3it_XmlBind_Bmecat12_Typedatetime extends B3it_XmlBind_Bmecat12_XmlBind
{
	private $_attributes = array();



	/* @var Date */
	private $_Date = null;	

	/* @var Time */
	private $_Time = null;	

	/* @var Timezone */
	private $_Timezone = null;	

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
	 * @return B3it_XmlBind_Bmecat12_Date
	 */
	public function getDate()
	{
		if($this->_Date == null)
		{
			$this->_Date = new B3it_XmlBind_Bmecat12_Date();
		}
		
		return $this->_Date;
	}
	
	/**
	 * @param $value Date
	 * @return B3it_XmlBind_Bmecat12_Typedatetime extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setDate($value)
	{
		$this->_Date = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_Time
	 */
	public function getTime()
	{
		if($this->_Time == null)
		{
			$this->_Time = new B3it_XmlBind_Bmecat12_Time();
		}
		
		return $this->_Time;
	}
	
	/**
	 * @param $value Time
	 * @return B3it_XmlBind_Bmecat12_Typedatetime extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setTime($value)
	{
		$this->_Time = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_Timezone
	 */
	public function getTimezone()
	{
		if($this->_Timezone == null)
		{
			$this->_Timezone = new B3it_XmlBind_Bmecat12_Timezone();
		}
		
		return $this->_Timezone;
	}
	
	/**
	 * @param $value Timezone
	 * @return B3it_XmlBind_Bmecat12_Typedatetime extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setTimezone($value)
	{
		$this->_Timezone = $value;
		return $this;
	}
	public function toXml($xml){
		if($this->_Date != null){
			$this->_Date->toXml($xml);
		}
		if($this->_Time != null){
			$this->_Time->toXml($xml);
		}
		if($this->_Timezone != null){
			$this->_Timezone->toXml($xml);
		}

		return $xml;
	}
}