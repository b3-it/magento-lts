<?php
class B3it_XmlBind_Bmecat2005_IppOperation extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var IppOperationId */
	private $_IppOperationId = null;	

	/* @var IppOperationType */
	private $_IppOperationType = null;	

	/* @var IppOperationDescr */
	private $_IppOperationDescrs = array();	

	/* @var IppOutbound */
	private $_IppOutbounds = array();	

	/* @var IppInbound */
	private $_IppInbounds = array();	

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
	 * @return B3it_XmlBind_Bmecat2005_IppOperationId
	 */
	public function getIppOperationId()
	{
		if($this->_IppOperationId == null)
		{
			$this->_IppOperationId = new B3it_XmlBind_Bmecat2005_IppOperationId();
		}
		
		return $this->_IppOperationId;
	}
	
	/**
	 * @param $value IppOperationId
	 * @return B3it_XmlBind_Bmecat2005_IppOperation extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setIppOperationId($value)
	{
		$this->_IppOperationId = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_IppOperationType
	 */
	public function getIppOperationType()
	{
		if($this->_IppOperationType == null)
		{
			$this->_IppOperationType = new B3it_XmlBind_Bmecat2005_IppOperationType();
		}
		
		return $this->_IppOperationType;
	}
	
	/**
	 * @param $value IppOperationType
	 * @return B3it_XmlBind_Bmecat2005_IppOperation extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setIppOperationType($value)
	{
		$this->_IppOperationType = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_IppOperationDescr[]
	 */
	public function getAllIppOperationDescr()
	{
		return $this->_IppOperationDescrs;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_IppOperationDescr and add it to list
	 * @return B3it_XmlBind_Bmecat2005_IppOperationDescr
	 */
	public function getIppOperationDescr()
	{
		$res = new B3it_XmlBind_Bmecat2005_IppOperationDescr();
		$this->_IppOperationDescrs[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value IppOperationDescr[]
	 * @return B3it_XmlBind_Bmecat2005_IppOperation extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setIppOperationDescr($value)
	{
		$this->_IppOperationDescr = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_IppOutbound[]
	 */
	public function getAllIppOutbound()
	{
		return $this->_IppOutbounds;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_IppOutbound and add it to list
	 * @return B3it_XmlBind_Bmecat2005_IppOutbound
	 */
	public function getIppOutbound()
	{
		$res = new B3it_XmlBind_Bmecat2005_IppOutbound();
		$this->_IppOutbounds[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value IppOutbound[]
	 * @return B3it_XmlBind_Bmecat2005_IppOperation extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setIppOutbound($value)
	{
		$this->_IppOutbound = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_IppInbound[]
	 */
	public function getAllIppInbound()
	{
		return $this->_IppInbounds;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_IppInbound and add it to list
	 * @return B3it_XmlBind_Bmecat2005_IppInbound
	 */
	public function getIppInbound()
	{
		$res = new B3it_XmlBind_Bmecat2005_IppInbound();
		$this->_IppInbounds[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value IppInbound[]
	 * @return B3it_XmlBind_Bmecat2005_IppOperation extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setIppInbound($value)
	{
		$this->_IppInbound = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('IPP_OPERATION');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_IppOperationId != null){
			$this->_IppOperationId->toXml($xml);
		}
		if($this->_IppOperationType != null){
			$this->_IppOperationType->toXml($xml);
		}
		if($this->_IppOperationDescrs != null){
			foreach($this->_IppOperationDescrs as $item){
				$item->toXml($xml);
			}
		}
		if($this->_IppOutbounds != null){
			foreach($this->_IppOutbounds as $item){
				$item->toXml($xml);
			}
		}
		if($this->_IppInbounds != null){
			foreach($this->_IppInbounds as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}
}