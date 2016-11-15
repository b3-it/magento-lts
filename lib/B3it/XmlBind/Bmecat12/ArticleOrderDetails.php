<?php
class B3it_XmlBind_Bmecat12_ArticleOrderDetails extends B3it_XmlBind_Bmecat12_XmlBind
{
	private $_attributes = array();



	/* @var OrderUnit */
	private $_OrderUnit = null;	

	/* @var ContentUnit */
	private $_ContentUnit = null;	

	/* @var NoCuPerOu */
	private $_NoCuPerOu = null;	

	/* @var PriceQuantity */
	private $_PriceQuantity = null;	

	/* @var QuantityMin */
	private $_QuantityMin = null;	

	/* @var QuantityInterval */
	private $_QuantityInterval = null;	

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
	 * @return B3it_XmlBind_Bmecat12_OrderUnit
	 */
	public function getOrderUnit()
	{
		if($this->_OrderUnit == null)
		{
			$this->_OrderUnit = new B3it_XmlBind_Bmecat12_OrderUnit();
		}
		
		return $this->_OrderUnit;
	}
	
	/**
	 * @param $value OrderUnit
	 * @return B3it_XmlBind_Bmecat12_ArticleOrderDetails extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setOrderUnit($value)
	{
		$this->_OrderUnit = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_ContentUnit
	 */
	public function getContentUnit()
	{
		if($this->_ContentUnit == null)
		{
			$this->_ContentUnit = new B3it_XmlBind_Bmecat12_ContentUnit();
		}
		
		return $this->_ContentUnit;
	}
	
	/**
	 * @param $value ContentUnit
	 * @return B3it_XmlBind_Bmecat12_ArticleOrderDetails extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setContentUnit($value)
	{
		$this->_ContentUnit = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_NoCuPerOu
	 */
	public function getNoCuPerOu()
	{
		if($this->_NoCuPerOu == null)
		{
			$this->_NoCuPerOu = new B3it_XmlBind_Bmecat12_NoCuPerOu();
		}
		
		return $this->_NoCuPerOu;
	}
	
	/**
	 * @param $value NoCuPerOu
	 * @return B3it_XmlBind_Bmecat12_ArticleOrderDetails extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setNoCuPerOu($value)
	{
		$this->_NoCuPerOu = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_PriceQuantity
	 */
	public function getPriceQuantity()
	{
		if($this->_PriceQuantity == null)
		{
			$this->_PriceQuantity = new B3it_XmlBind_Bmecat12_PriceQuantity();
		}
		
		return $this->_PriceQuantity;
	}
	
	/**
	 * @param $value PriceQuantity
	 * @return B3it_XmlBind_Bmecat12_ArticleOrderDetails extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setPriceQuantity($value)
	{
		$this->_PriceQuantity = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_QuantityMin
	 */
	public function getQuantityMin()
	{
		if($this->_QuantityMin == null)
		{
			$this->_QuantityMin = new B3it_XmlBind_Bmecat12_QuantityMin();
		}
		
		return $this->_QuantityMin;
	}
	
	/**
	 * @param $value QuantityMin
	 * @return B3it_XmlBind_Bmecat12_ArticleOrderDetails extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setQuantityMin($value)
	{
		$this->_QuantityMin = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_QuantityInterval
	 */
	public function getQuantityInterval()
	{
		if($this->_QuantityInterval == null)
		{
			$this->_QuantityInterval = new B3it_XmlBind_Bmecat12_QuantityInterval();
		}
		
		return $this->_QuantityInterval;
	}
	
	/**
	 * @param $value QuantityInterval
	 * @return B3it_XmlBind_Bmecat12_ArticleOrderDetails extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setQuantityInterval($value)
	{
		$this->_QuantityInterval = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('ARTICLE_ORDER_DETAILS');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_OrderUnit != null){
			$this->_OrderUnit->toXml($xml);
		}
		if($this->_ContentUnit != null){
			$this->_ContentUnit->toXml($xml);
		}
		if($this->_NoCuPerOu != null){
			$this->_NoCuPerOu->toXml($xml);
		}
		if($this->_PriceQuantity != null){
			$this->_PriceQuantity->toXml($xml);
		}
		if($this->_QuantityMin != null){
			$this->_QuantityMin->toXml($xml);
		}
		if($this->_QuantityInterval != null){
			$this->_QuantityInterval->toXml($xml);
		}


		return $xml;
	}
}