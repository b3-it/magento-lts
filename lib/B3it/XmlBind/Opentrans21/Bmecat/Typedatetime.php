<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_Typedatetime
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_Typedatetime extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_Date */
	private $__Date = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_Time */
	private $__Time = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_Timezone */
	private $__Timezone = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Date
	 */
	public function getDate()
	{
		if($this->__Date == null)
		{
			$this->__Date = new B3it_XmlBind_Opentrans21_Bmecat_Date();
		}
	
		return $this->__Date;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Date
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Typedatetime
	 */
	public function setDate($value)
	{
		$this->__Date = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Time
	 */
	public function getTime()
	{
		if($this->__Time == null)
		{
			$this->__Time = new B3it_XmlBind_Opentrans21_Bmecat_Time();
		}
	
		return $this->__Time;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Time
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Typedatetime
	 */
	public function setTime($value)
	{
		$this->__Time = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Timezone
	 */
	public function getTimezone()
	{
		if($this->__Timezone == null)
		{
			$this->__Timezone = new B3it_XmlBind_Opentrans21_Bmecat_Timezone();
		}
	
		return $this->__Timezone;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Timezone
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Typedatetime
	 */
	public function setTimezone($value)
	{
		$this->__Timezone = $value;
		return $this;
	}





	public function toXml($xml)
	{
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__Date != null){
			$this->__Date->toXml($xml);
		}
		if($this->__Time != null){
			$this->__Time->toXml($xml);
		}
		if($this->__Timezone != null){
			$this->__Timezone->toXml($xml);
		}


		return $xml;
	}

}
