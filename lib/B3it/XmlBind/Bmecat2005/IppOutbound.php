<?php
class B3it_XmlBind_Bmecat2005_IppOutbound extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var IppOutboundFormat */
	private $_IppOutboundFormat = null;	

	/* @var IppOutboundParams */
	private $_IppOutboundParams = null;	

	/* @var IppUri */
	private $_IppUris = array();	

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
	 * @return B3it_XmlBind_Bmecat2005_IppOutboundFormat
	 */
	public function getIppOutboundFormat()
	{
		if($this->_IppOutboundFormat == null)
		{
			$this->_IppOutboundFormat = new B3it_XmlBind_Bmecat2005_IppOutboundFormat();
		}
		
		return $this->_IppOutboundFormat;
	}
	
	/**
	 * @param $value IppOutboundFormat
	 * @return B3it_XmlBind_Bmecat2005_IppOutbound extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setIppOutboundFormat($value)
	{
		$this->_IppOutboundFormat = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_IppOutboundParams
	 */
	public function getIppOutboundParams()
	{
		if($this->_IppOutboundParams == null)
		{
			$this->_IppOutboundParams = new B3it_XmlBind_Bmecat2005_IppOutboundParams();
		}
		
		return $this->_IppOutboundParams;
	}
	
	/**
	 * @param $value IppOutboundParams
	 * @return B3it_XmlBind_Bmecat2005_IppOutbound extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setIppOutboundParams($value)
	{
		$this->_IppOutboundParams = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_IppUri[]
	 */
	public function getAllIppUri()
	{
		return $this->_IppUris;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_IppUri and add it to list
	 * @return B3it_XmlBind_Bmecat2005_IppUri
	 */
	public function getIppUri()
	{
		$res = new B3it_XmlBind_Bmecat2005_IppUri();
		$this->_IppUris[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value IppUri[]
	 * @return B3it_XmlBind_Bmecat2005_IppOutbound extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setIppUri($value)
	{
		$this->_IppUri = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('IPP_OUTBOUND');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_IppOutboundFormat != null){
			$this->_IppOutboundFormat->toXml($xml);
		}
		if($this->_IppOutboundParams != null){
			$this->_IppOutboundParams->toXml($xml);
		}
		if($this->_IppUris != null){
			foreach($this->_IppUris as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}
}