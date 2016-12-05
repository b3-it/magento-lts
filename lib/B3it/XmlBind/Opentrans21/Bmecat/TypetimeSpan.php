<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_TypetimeSpan
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_TypetimeSpan extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_TimeBase */
	private $__TimeBase = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_TimeValueDuration */
	private $__TimeValueDuration = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_TimeValueInterval */
	private $__TimeValueInterval = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_TimeValueStart */
	private $__TimeValueStart = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_TimeValueEnd */
	private $__TimeValueEnd = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_SubTimeSpans */
	private $__SubTimeSpansA = array();


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_TimeBase
	 */
	public function getTimeBase()
	{
		if($this->__TimeBase == null)
		{
			$this->__TimeBase = new B3it_XmlBind_Opentrans21_Bmecat_TimeBase();
		}
	
		return $this->__TimeBase;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_TimeBase
	 * @return B3it_XmlBind_Opentrans21_Bmecat_TypetimeSpan
	 */
	public function setTimeBase($value)
	{
		$this->__TimeBase = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_TimeValueDuration
	 */
	public function getTimeValueDuration()
	{
		if($this->__TimeValueDuration == null)
		{
			$this->__TimeValueDuration = new B3it_XmlBind_Opentrans21_Bmecat_TimeValueDuration();
		}
	
		return $this->__TimeValueDuration;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_TimeValueDuration
	 * @return B3it_XmlBind_Opentrans21_Bmecat_TypetimeSpan
	 */
	public function setTimeValueDuration($value)
	{
		$this->__TimeValueDuration = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_TimeValueInterval
	 */
	public function getTimeValueInterval()
	{
		if($this->__TimeValueInterval == null)
		{
			$this->__TimeValueInterval = new B3it_XmlBind_Opentrans21_Bmecat_TimeValueInterval();
		}
	
		return $this->__TimeValueInterval;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_TimeValueInterval
	 * @return B3it_XmlBind_Opentrans21_Bmecat_TypetimeSpan
	 */
	public function setTimeValueInterval($value)
	{
		$this->__TimeValueInterval = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_TimeValueStart
	 */
	public function getTimeValueStart()
	{
		if($this->__TimeValueStart == null)
		{
			$this->__TimeValueStart = new B3it_XmlBind_Opentrans21_Bmecat_TimeValueStart();
		}
	
		return $this->__TimeValueStart;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_TimeValueStart
	 * @return B3it_XmlBind_Opentrans21_Bmecat_TypetimeSpan
	 */
	public function setTimeValueStart($value)
	{
		$this->__TimeValueStart = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_TimeValueEnd
	 */
	public function getTimeValueEnd()
	{
		if($this->__TimeValueEnd == null)
		{
			$this->__TimeValueEnd = new B3it_XmlBind_Opentrans21_Bmecat_TimeValueEnd();
		}
	
		return $this->__TimeValueEnd;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_TimeValueEnd
	 * @return B3it_XmlBind_Opentrans21_Bmecat_TypetimeSpan
	 */
	public function setTimeValueEnd($value)
	{
		$this->__TimeValueEnd = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_SubTimeSpans and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_SubTimeSpans
	 */
	public function getSubTimeSpans()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_SubTimeSpans();
		$this->__SubTimeSpansA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_SubTimeSpans
	 * @return B3it_XmlBind_Opentrans21_Bmecat_TypetimeSpan
	 */
	public function setSubTimeSpans($value)
	{
		$this->__SubTimeSpansA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_SubTimeSpans[]
	 */
	public function getAllSubTimeSpans()
	{
		return $this->__SubTimeSpansA;
	}







	public function toXml($xml)
	{
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__TimeBase != null){
			$this->__TimeBase->toXml($xml);
		}
		if($this->__TimeValueDuration != null){
			$this->__TimeValueDuration->toXml($xml);
		}
		if($this->__TimeValueInterval != null){
			$this->__TimeValueInterval->toXml($xml);
		}
		if($this->__TimeValueStart != null){
			$this->__TimeValueStart->toXml($xml);
		}
		if($this->__TimeValueEnd != null){
			$this->__TimeValueEnd->toXml($xml);
		}
		if($this->__SubTimeSpansA != null){
			foreach($this->__SubTimeSpansA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
