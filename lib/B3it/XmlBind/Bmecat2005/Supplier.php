<?php
class B3it_XmlBind_Bmecat2005_Supplier extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var SupplierId */
	private $_SupplierIds = array();	

	/* @var SupplierName */
	private $_SupplierName = null;	

	/* @var Supplier_Address */
	private $_Address = null;	

	/* @var MimeInfo */
	private $_MimeInfo = null;	

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
	 * @return B3it_XmlBind_Bmecat2005_SupplierId[]
	 */
	public function getAllSupplierId()
	{
		return $this->_SupplierIds;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_SupplierId and add it to list
	 * @return B3it_XmlBind_Bmecat2005_SupplierId
	 */
	public function getSupplierId()
	{
		$res = new B3it_XmlBind_Bmecat2005_SupplierId();
		$this->_SupplierIds[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value SupplierId[]
	 * @return B3it_XmlBind_Bmecat2005_Supplier extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setSupplierId($value)
	{
		$this->_SupplierId = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_SupplierName
	 */
	public function getSupplierName()
	{
		if($this->_SupplierName == null)
		{
			$this->_SupplierName = new B3it_XmlBind_Bmecat2005_SupplierName();
		}
		
		return $this->_SupplierName;
	}
	
	/**
	 * @param $value SupplierName
	 * @return B3it_XmlBind_Bmecat2005_Supplier extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setSupplierName($value)
	{
		$this->_SupplierName = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_Supplier_Address
	 */
	public function getAddress()
	{
		if($this->_Address == null)
		{
			$this->_Address = new B3it_XmlBind_Bmecat2005_Supplier_Address();
		}
		
		return $this->_Address;
	}
	
	/**
	 * @param $value Address
	 * @return B3it_XmlBind_Bmecat2005_Supplier extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setAddress($value)
	{
		$this->_Address = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_MimeInfo
	 */
	public function getMimeInfo()
	{
		if($this->_MimeInfo == null)
		{
			$this->_MimeInfo = new B3it_XmlBind_Bmecat2005_MimeInfo();
		}
		
		return $this->_MimeInfo;
	}
	
	/**
	 * @param $value MimeInfo
	 * @return B3it_XmlBind_Bmecat2005_Supplier extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setMimeInfo($value)
	{
		$this->_MimeInfo = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('SUPPLIER');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_SupplierIds != null){
			foreach($this->_SupplierIds as $item){
				$item->toXml($xml);
			}
		}
		if($this->_SupplierName != null){
			$this->_SupplierName->toXml($xml);
		}
		if($this->_Address != null){
			$this->_Address->toXml($xml);
		}
		if($this->_MimeInfo != null){
			$this->_MimeInfo->toXml($xml);
		}


		return $xml;
	}
}