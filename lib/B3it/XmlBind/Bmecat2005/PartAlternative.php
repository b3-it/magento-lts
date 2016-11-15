<?php
class B3it_XmlBind_Bmecat2005_PartAlternative extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var SupplierPidref */
	private $_SupplierPidref = null;	

	/* @var SupplierIdref */
	private $_SupplierIdref = null;	

	/* @var ProductOrder */
	private $_ProductOrder = null;	

	/* @var DefaultFlag */
	private $_DefaultFlag = null;	

	/* @var ConfigCode */
	private $_ConfigCode = null;	

	/* @var ProductPriceDetails */
	private $_ProductPriceDetails = null;	

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
	 * @return B3it_XmlBind_Bmecat2005_PartAlternative extends B3it_XmlBind_Bmecat2005_XmlBind
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
	 * @return B3it_XmlBind_Bmecat2005_PartAlternative extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setSupplierIdref($value)
	{
		$this->_SupplierIdref = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ProductOrder
	 */
	public function getProductOrder()
	{
		if($this->_ProductOrder == null)
		{
			$this->_ProductOrder = new B3it_XmlBind_Bmecat2005_ProductOrder();
		}
		
		return $this->_ProductOrder;
	}
	
	/**
	 * @param $value ProductOrder
	 * @return B3it_XmlBind_Bmecat2005_PartAlternative extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setProductOrder($value)
	{
		$this->_ProductOrder = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_DefaultFlag
	 */
	public function getDefaultFlag()
	{
		if($this->_DefaultFlag == null)
		{
			$this->_DefaultFlag = new B3it_XmlBind_Bmecat2005_DefaultFlag();
		}
		
		return $this->_DefaultFlag;
	}
	
	/**
	 * @param $value DefaultFlag
	 * @return B3it_XmlBind_Bmecat2005_PartAlternative extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setDefaultFlag($value)
	{
		$this->_DefaultFlag = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ConfigCode
	 */
	public function getConfigCode()
	{
		if($this->_ConfigCode == null)
		{
			$this->_ConfigCode = new B3it_XmlBind_Bmecat2005_ConfigCode();
		}
		
		return $this->_ConfigCode;
	}
	
	/**
	 * @param $value ConfigCode
	 * @return B3it_XmlBind_Bmecat2005_PartAlternative extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setConfigCode($value)
	{
		$this->_ConfigCode = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ProductPriceDetails
	 */
	public function getProductPriceDetails()
	{
		if($this->_ProductPriceDetails == null)
		{
			$this->_ProductPriceDetails = new B3it_XmlBind_Bmecat2005_ProductPriceDetails();
		}
		
		return $this->_ProductPriceDetails;
	}
	
	/**
	 * @param $value ProductPriceDetails
	 * @return B3it_XmlBind_Bmecat2005_PartAlternative extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setProductPriceDetails($value)
	{
		$this->_ProductPriceDetails = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('PART_ALTERNATIVE');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_SupplierPidref != null){
			$this->_SupplierPidref->toXml($xml);
		}
		if($this->_SupplierIdref != null){
			$this->_SupplierIdref->toXml($xml);
		}
		if($this->_ProductOrder != null){
			$this->_ProductOrder->toXml($xml);
		}
		if($this->_DefaultFlag != null){
			$this->_DefaultFlag->toXml($xml);
		}
		if($this->_ConfigCode != null){
			$this->_ConfigCode->toXml($xml);
		}
		if($this->_ProductPriceDetails != null){
			$this->_ProductPriceDetails->toXml($xml);
		}


		return $xml;
	}
}