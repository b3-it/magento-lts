<?php
class B3it_XmlBind_Bmecat2005_IppInbound extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var IppInboundFormat */
	private $_IppInboundFormat = null;	

	/* @var IppInboundParams */
	private $_IppInboundParams = null;	

	/* @var IppResponseTime */
	private $_IppResponseTime = null;	

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
	 * @return B3it_XmlBind_Bmecat2005_IppInboundFormat
	 */
	public function getIppInboundFormat()
	{
		if($this->_IppInboundFormat == null)
		{
			$this->_IppInboundFormat = new B3it_XmlBind_Bmecat2005_IppInboundFormat();
		}
		
		return $this->_IppInboundFormat;
	}
	
	/**
	 * @param $value IppInboundFormat
	 * @return B3it_XmlBind_Bmecat2005_IppInbound extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setIppInboundFormat($value)
	{
		$this->_IppInboundFormat = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_IppInboundParams
	 */
	public function getIppInboundParams()
	{
		if($this->_IppInboundParams == null)
		{
			$this->_IppInboundParams = new B3it_XmlBind_Bmecat2005_IppInboundParams();
		}
		
		return $this->_IppInboundParams;
	}
	
	/**
	 * @param $value IppInboundParams
	 * @return B3it_XmlBind_Bmecat2005_IppInbound extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setIppInboundParams($value)
	{
		$this->_IppInboundParams = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_IppResponseTime
	 */
	public function getIppResponseTime()
	{
		if($this->_IppResponseTime == null)
		{
			$this->_IppResponseTime = new B3it_XmlBind_Bmecat2005_IppResponseTime();
		}
		
		return $this->_IppResponseTime;
	}
	
	/**
	 * @param $value IppResponseTime
	 * @return B3it_XmlBind_Bmecat2005_IppInbound extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setIppResponseTime($value)
	{
		$this->_IppResponseTime = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('IPP_INBOUND');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_IppInboundFormat != null){
			$this->_IppInboundFormat->toXml($xml);
		}
		if($this->_IppInboundParams != null){
			$this->_IppInboundParams->toXml($xml);
		}
		if($this->_IppResponseTime != null){
			$this->_IppResponseTime->toXml($xml);
		}


		return $xml;
	}
}