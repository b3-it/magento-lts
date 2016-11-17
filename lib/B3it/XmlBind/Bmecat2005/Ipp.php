<?php
class B3it_XmlBind_Bmecat2005_Ipp extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var IppIdref */
	private $_IppIdref = null;	

	/* @var IppOperationIdref */
	private $_IppOperationIdrefs = array();	

	/* @var IppResponseTime */
	private $_IppResponseTime = null;	

	/* @var IppUri */
	private $_IppUris = array();	

	/* @var IppParam */
	private $_IppParams = array();	

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
	 * @return B3it_XmlBind_Bmecat2005_IppIdref
	 */
	public function getIppIdref()
	{
		if($this->_IppIdref == null)
		{
			$this->_IppIdref = new B3it_XmlBind_Bmecat2005_IppIdref();
		}
		
		return $this->_IppIdref;
	}
	
	/**
	 * @param $value IppIdref
	 * @return B3it_XmlBind_Bmecat2005_Ipp extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setIppIdref($value)
	{
		$this->_IppIdref = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_IppOperationIdref[]
	 */
	public function getAllIppOperationIdref()
	{
		return $this->_IppOperationIdrefs;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_IppOperationIdref and add it to list
	 * @return B3it_XmlBind_Bmecat2005_IppOperationIdref
	 */
	public function getIppOperationIdref()
	{
		$res = new B3it_XmlBind_Bmecat2005_IppOperationIdref();
		$this->_IppOperationIdrefs[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value IppOperationIdref[]
	 * @return B3it_XmlBind_Bmecat2005_Ipp extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setIppOperationIdref($value)
	{
		$this->_IppOperationIdref = $value;
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
	 * @return B3it_XmlBind_Bmecat2005_Ipp extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setIppResponseTime($value)
	{
		$this->_IppResponseTime = $value;
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
	 * @return B3it_XmlBind_Bmecat2005_Ipp extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setIppUri($value)
	{
		$this->_IppUri = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_IppParam[]
	 */
	public function getAllIppParam()
	{
		return $this->_IppParams;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_IppParam and add it to list
	 * @return B3it_XmlBind_Bmecat2005_IppParam
	 */
	public function getIppParam()
	{
		$res = new B3it_XmlBind_Bmecat2005_IppParam();
		$this->_IppParams[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value IppParam[]
	 * @return B3it_XmlBind_Bmecat2005_Ipp extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setIppParam($value)
	{
		$this->_IppParam = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('IPP');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_IppIdref != null){
			$this->_IppIdref->toXml($xml);
		}
		if($this->_IppOperationIdrefs != null){
			foreach($this->_IppOperationIdrefs as $item){
				$item->toXml($xml);
			}
		}
		if($this->_IppResponseTime != null){
			$this->_IppResponseTime->toXml($xml);
		}
		if($this->_IppUris != null){
			foreach($this->_IppUris as $item){
				$item->toXml($xml);
			}
		}
		if($this->_IppParams != null){
			foreach($this->_IppParams as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}
}