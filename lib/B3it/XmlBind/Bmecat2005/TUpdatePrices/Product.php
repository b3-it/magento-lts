<?php
class B3it_XmlBind_Bmecat2005_TUpdatePrices_Product extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var SupplierPid */
	private $_SupplierPid = null;	

	/* @var SupplierIdref */
	private $_SupplierIdref = null;	

	/* @var ProductPriceDetails */
	private $_ProductPriceDetailss = array();	

	/* @var UserDefinedExtensions */
	private $_UserDefinedExtensions = null;	

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
	 * @return B3it_XmlBind_Bmecat2005_TUpdatePrices_Product extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setSupplierPid($value)
	{
		$this->_SupplierPid = $value;
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
	 * @return B3it_XmlBind_Bmecat2005_TUpdatePrices_Product extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setSupplierIdref($value)
	{
		$this->_SupplierIdref = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ProductPriceDetails[]
	 */
	public function getAllProductPriceDetails()
	{
		return $this->_ProductPriceDetailss;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_ProductPriceDetails and add it to list
	 * @return B3it_XmlBind_Bmecat2005_ProductPriceDetails
	 */
	public function getProductPriceDetails()
	{
		$res = new B3it_XmlBind_Bmecat2005_ProductPriceDetails();
		$this->_ProductPriceDetailss[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value ProductPriceDetails[]
	 * @return B3it_XmlBind_Bmecat2005_TUpdatePrices_Product extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setProductPriceDetails($value)
	{
		$this->_ProductPriceDetails = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_UserDefinedExtensions
	 */
	public function getUserDefinedExtensions()
	{
		if($this->_UserDefinedExtensions == null)
		{
			$this->_UserDefinedExtensions = new B3it_XmlBind_Bmecat2005_UserDefinedExtensions();
		}
		
		return $this->_UserDefinedExtensions;
	}
	
	/**
	 * @param $value UserDefinedExtensions
	 * @return B3it_XmlBind_Bmecat2005_TUpdatePrices_Product extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setUserDefinedExtensions($value)
	{
		$this->_UserDefinedExtensions = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('PRODUCT');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_SupplierPid != null){
			$this->_SupplierPid->toXml($xml);
		}
		if($this->_SupplierIdref != null){
			$this->_SupplierIdref->toXml($xml);
		}
		if($this->_ProductPriceDetailss != null){
			foreach($this->_ProductPriceDetailss as $item){
				$item->toXml($xml);
			}
		}
		if($this->_UserDefinedExtensions != null){
			$this->_UserDefinedExtensions->toXml($xml);
		}


		return $xml;
	}
}