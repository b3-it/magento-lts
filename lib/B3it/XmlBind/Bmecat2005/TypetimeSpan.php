<?php
class B3it_XmlBind_Bmecat2005_TypetimeSpan extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var TimeBase */
	private $_TimeBase = null;	

	/* @var TimeValueDuration */
	private $_TimeValueDuration = null;	

	/* @var TimeValueInterval */
	private $_TimeValueInterval = null;	

	/* @var TimeValueStart */
	private $_TimeValueStart = null;	

	/* @var TimeValueEnd */
	private $_TimeValueEnd = null;	

	/* @var SubTimeSpans */
	private $_SubTimeSpanss = array();	

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
	 * @return B3it_XmlBind_Bmecat2005_TimeBase
	 */
	public function getTimeBase()
	{
		if($this->_TimeBase == null)
		{
			$this->_TimeBase = new B3it_XmlBind_Bmecat2005_TimeBase();
		}
		
		return $this->_TimeBase;
	}
	
	/**
	 * @param $value TimeBase
	 * @return B3it_XmlBind_Bmecat2005_TypetimeSpan extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setTimeBase($value)
	{
		$this->_TimeBase = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_TimeValueDuration
	 */
	public function getTimeValueDuration()
	{
		if($this->_TimeValueDuration == null)
		{
			$this->_TimeValueDuration = new B3it_XmlBind_Bmecat2005_TimeValueDuration();
		}
		
		return $this->_TimeValueDuration;
	}
	
	/**
	 * @param $value TimeValueDuration
	 * @return B3it_XmlBind_Bmecat2005_TypetimeSpan extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setTimeValueDuration($value)
	{
		$this->_TimeValueDuration = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_TimeValueInterval
	 */
	public function getTimeValueInterval()
	{
		if($this->_TimeValueInterval == null)
		{
			$this->_TimeValueInterval = new B3it_XmlBind_Bmecat2005_TimeValueInterval();
		}
		
		return $this->_TimeValueInterval;
	}
	
	/**
	 * @param $value TimeValueInterval
	 * @return B3it_XmlBind_Bmecat2005_TypetimeSpan extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setTimeValueInterval($value)
	{
		$this->_TimeValueInterval = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_TimeValueStart
	 */
	public function getTimeValueStart()
	{
		if($this->_TimeValueStart == null)
		{
			$this->_TimeValueStart = new B3it_XmlBind_Bmecat2005_TimeValueStart();
		}
		
		return $this->_TimeValueStart;
	}
	
	/**
	 * @param $value TimeValueStart
	 * @return B3it_XmlBind_Bmecat2005_TypetimeSpan extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setTimeValueStart($value)
	{
		$this->_TimeValueStart = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_TimeValueEnd
	 */
	public function getTimeValueEnd()
	{
		if($this->_TimeValueEnd == null)
		{
			$this->_TimeValueEnd = new B3it_XmlBind_Bmecat2005_TimeValueEnd();
		}
		
		return $this->_TimeValueEnd;
	}
	
	/**
	 * @param $value TimeValueEnd
	 * @return B3it_XmlBind_Bmecat2005_TypetimeSpan extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setTimeValueEnd($value)
	{
		$this->_TimeValueEnd = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_SubTimeSpans[]
	 */
	public function getAllSubTimeSpans()
	{
		return $this->_SubTimeSpanss;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_SubTimeSpans and add it to list
	 * @return B3it_XmlBind_Bmecat2005_SubTimeSpans
	 */
	public function getSubTimeSpans()
	{
		$res = new B3it_XmlBind_Bmecat2005_SubTimeSpans();
		$this->_SubTimeSpanss[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value SubTimeSpans[]
	 * @return B3it_XmlBind_Bmecat2005_TypetimeSpan extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setSubTimeSpans($value)
	{
		$this->_SubTimeSpans = $value;
		return $this;
	}
	public function toXml($xml){
		if($this->_TimeBase != null){
			$this->_TimeBase->toXml($xml);
		}
		if($this->_TimeValueDuration != null){
			$this->_TimeValueDuration->toXml($xml);
		}
		if($this->_TimeValueInterval != null){
			$this->_TimeValueInterval->toXml($xml);
		}
		if($this->_TimeValueStart != null){
			$this->_TimeValueStart->toXml($xml);
		}
		if($this->_TimeValueEnd != null){
			$this->_TimeValueEnd->toXml($xml);
		}
		if($this->_SubTimeSpanss != null){
			foreach($this->_SubTimeSpanss as $item){
				$item->toXml($xml);
			}
		}

		return $xml;
	}
}