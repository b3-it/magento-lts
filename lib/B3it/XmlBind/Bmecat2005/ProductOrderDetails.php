<?php
class B3it_XmlBind_Bmecat2005_ProductOrderDetails extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var OrderUnit */
	private $_OrderUnit = null;	

	/* @var ContentUnit */
	private $_ContentUnit = null;	

	/* @var NoCuPerOu */
	private $_NoCuPerOu = null;	

	/* @var SupplierPidref */
	private $_SupplierPidref = null;	

	/* @var SupplierIdref */
	private $_SupplierIdref = null;	

	/* @var PriceQuantity */
	private $_PriceQuantity = null;	

	/* @var QuantityMin */
	private $_QuantityMin = null;	

	/* @var QuantityInterval */
	private $_QuantityInterval = null;	

	/* @var QuantityMax */
	private $_QuantityMax = null;	

	/* @var PackingUnits */
	private $_PackingUnits = null;	

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
	 * @return B3it_XmlBind_Bmecat2005_OrderUnit
	 */
	public function getOrderUnit()
	{
		if($this->_OrderUnit == null)
		{
			$this->_OrderUnit = new B3it_XmlBind_Bmecat2005_OrderUnit();
		}
		
		return $this->_OrderUnit;
	}
	
	/**
	 * @param $value OrderUnit
	 * @return B3it_XmlBind_Bmecat2005_ProductOrderDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setOrderUnit($value)
	{
		$this->_OrderUnit = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ContentUnit
	 */
	public function getContentUnit()
	{
		if($this->_ContentUnit == null)
		{
			$this->_ContentUnit = new B3it_XmlBind_Bmecat2005_ContentUnit();
		}
		
		return $this->_ContentUnit;
	}
	
	/**
	 * @param $value ContentUnit
	 * @return B3it_XmlBind_Bmecat2005_ProductOrderDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setContentUnit($value)
	{
		$this->_ContentUnit = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_NoCuPerOu
	 */
	public function getNoCuPerOu()
	{
		if($this->_NoCuPerOu == null)
		{
			$this->_NoCuPerOu = new B3it_XmlBind_Bmecat2005_NoCuPerOu();
		}
		
		return $this->_NoCuPerOu;
	}
	
	/**
	 * @param $value NoCuPerOu
	 * @return B3it_XmlBind_Bmecat2005_ProductOrderDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setNoCuPerOu($value)
	{
		$this->_NoCuPerOu = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_SupplierPidref
	 */
	public function getSupplierPidref()
	{
		if($this->_SupplierPidref == null)
		{
			$this->_SupplierPidref = new B3it_XmlBind_Bmecat2005_SupplierPidref();
		}
		
		return $this->_SupplierPidref;
	}
	
	/**
	 * @param $value SupplierPidref
	 * @return B3it_XmlBind_Bmecat2005_ProductOrderDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setSupplierPidref($value)
	{
		$this->_SupplierPidref = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_SupplierIdref
	 */
	public function getSupplierIdref()
	{
		if($this->_SupplierIdref == null)
		{
			$this->_SupplierIdref = new B3it_XmlBind_Bmecat2005_SupplierIdref();
		}
		
		return $this->_SupplierIdref;
	}
	
	/**
	 * @param $value SupplierIdref
	 * @return B3it_XmlBind_Bmecat2005_ProductOrderDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setSupplierIdref($value)
	{
		$this->_SupplierIdref = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_PriceQuantity
	 */
	public function getPriceQuantity()
	{
		if($this->_PriceQuantity == null)
		{
			$this->_PriceQuantity = new B3it_XmlBind_Bmecat2005_PriceQuantity();
		}
		
		return $this->_PriceQuantity;
	}
	
	/**
	 * @param $value PriceQuantity
	 * @return B3it_XmlBind_Bmecat2005_ProductOrderDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setPriceQuantity($value)
	{
		$this->_PriceQuantity = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_QuantityMin
	 */
	public function getQuantityMin()
	{
		if($this->_QuantityMin == null)
		{
			$this->_QuantityMin = new B3it_XmlBind_Bmecat2005_QuantityMin();
		}
		
		return $this->_QuantityMin;
	}
	
	/**
	 * @param $value QuantityMin
	 * @return B3it_XmlBind_Bmecat2005_ProductOrderDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setQuantityMin($value)
	{
		$this->_QuantityMin = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_QuantityInterval
	 */
	public function getQuantityInterval()
	{
		if($this->_QuantityInterval == null)
		{
			$this->_QuantityInterval = new B3it_XmlBind_Bmecat2005_QuantityInterval();
		}
		
		return $this->_QuantityInterval;
	}
	
	/**
	 * @param $value QuantityInterval
	 * @return B3it_XmlBind_Bmecat2005_ProductOrderDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setQuantityInterval($value)
	{
		$this->_QuantityInterval = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_QuantityMax
	 */
	public function getQuantityMax()
	{
		if($this->_QuantityMax == null)
		{
			$this->_QuantityMax = new B3it_XmlBind_Bmecat2005_QuantityMax();
		}
		
		return $this->_QuantityMax;
	}
	
	/**
	 * @param $value QuantityMax
	 * @return B3it_XmlBind_Bmecat2005_ProductOrderDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setQuantityMax($value)
	{
		$this->_QuantityMax = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_PackingUnits
	 */
	public function getPackingUnits()
	{
		if($this->_PackingUnits == null)
		{
			$this->_PackingUnits = new B3it_XmlBind_Bmecat2005_PackingUnits();
		}
		
		return $this->_PackingUnits;
	}
	
	/**
	 * @param $value PackingUnits
	 * @return B3it_XmlBind_Bmecat2005_ProductOrderDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setPackingUnits($value)
	{
		$this->_PackingUnits = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('PRODUCT_ORDER_DETAILS');
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
		if($this->_SupplierPidref != null){
			$this->_SupplierPidref->toXml($xml);
		}
		if($this->_SupplierIdref != null){
			$this->_SupplierIdref->toXml($xml);
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
		if($this->_QuantityMax != null){
			$this->_QuantityMax->toXml($xml);
		}
		if($this->_PackingUnits != null){
			$this->_PackingUnits->toXml($xml);
		}


		return $xml;
	}
}