<?php
class B3it_XmlBind_Bmecat2005_PackingUnit extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var QuantityMin */
	private $_QuantityMin = null;	

	/* @var QuantityMax */
	private $_QuantityMax = null;	

	/* @var PackingUnitCode */
	private $_PackingUnitCode = null;	

	/* @var PackingUnitDescr */
	private $_PackingUnitDescrs = array();	

	/* @var SupplierPid */
	private $_SupplierPid = null;	

	/* @var SupplierPidref */
	private $_SupplierPidref = null;	

	/* @var SupplierIdref */
	private $_SupplierIdref = null;	

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
	 * @return B3it_XmlBind_Bmecat2005_PackingUnit extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setQuantityMin($value)
	{
		$this->_QuantityMin = $value;
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
	 * @return B3it_XmlBind_Bmecat2005_PackingUnit extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setQuantityMax($value)
	{
		$this->_QuantityMax = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_PackingUnitCode
	 */
	public function getPackingUnitCode()
	{
		if($this->_PackingUnitCode == null)
		{
			$this->_PackingUnitCode = new B3it_XmlBind_Bmecat2005_PackingUnitCode();
		}
		
		return $this->_PackingUnitCode;
	}
	
	/**
	 * @param $value PackingUnitCode
	 * @return B3it_XmlBind_Bmecat2005_PackingUnit extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setPackingUnitCode($value)
	{
		$this->_PackingUnitCode = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_PackingUnitDescr[]
	 */
	public function getAllPackingUnitDescr()
	{
		return $this->_PackingUnitDescrs;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_PackingUnitDescr and add it to list
	 * @return B3it_XmlBind_Bmecat2005_PackingUnitDescr
	 */
	public function getPackingUnitDescr()
	{
		$res = new B3it_XmlBind_Bmecat2005_PackingUnitDescr();
		$this->_PackingUnitDescrs[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value PackingUnitDescr[]
	 * @return B3it_XmlBind_Bmecat2005_PackingUnit extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setPackingUnitDescr($value)
	{
		$this->_PackingUnitDescr = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_SupplierPid
	 */
	public function getSupplierPid()
	{
		if($this->_SupplierPid == null)
		{
			$this->_SupplierPid = new B3it_XmlBind_Bmecat2005_SupplierPid();
		}
		
		return $this->_SupplierPid;
	}
	
	/**
	 * @param $value SupplierPid
	 * @return B3it_XmlBind_Bmecat2005_PackingUnit extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setSupplierPid($value)
	{
		$this->_SupplierPid = $value;
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
	 * @return B3it_XmlBind_Bmecat2005_PackingUnit extends B3it_XmlBind_Bmecat2005_XmlBind
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
	 * @return B3it_XmlBind_Bmecat2005_PackingUnit extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setSupplierIdref($value)
	{
		$this->_SupplierIdref = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('PACKING_UNIT');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_QuantityMin != null){
			$this->_QuantityMin->toXml($xml);
		}
		if($this->_QuantityMax != null){
			$this->_QuantityMax->toXml($xml);
		}
		if($this->_PackingUnitCode != null){
			$this->_PackingUnitCode->toXml($xml);
		}
		if($this->_PackingUnitDescrs != null){
			foreach($this->_PackingUnitDescrs as $item){
				$item->toXml($xml);
			}
		}
		if($this->_SupplierPid != null){
			$this->_SupplierPid->toXml($xml);
		}
		if($this->_SupplierPidref != null){
			$this->_SupplierPidref->toXml($xml);
		}
		if($this->_SupplierIdref != null){
			$this->_SupplierIdref->toXml($xml);
		}


		return $xml;
	}
}