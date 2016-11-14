<?php
class B3it_XmlBind_Bmecat12_Header extends B3it_XmlBind_Bmecat12_XmlBind
{
	private $_attributes = array();



	/* @var GeneratorInfo */
	private $_GeneratorInfo = null;	

	/* @var Catalog */
	private $_Catalog = null;	

	/* @var Buyer */
	private $_Buyer = null;	

	/* @var Agreement */
	private $_Agreements = array();	

	/* @var Supplier */
	private $_Supplier = null;	

	/* @var Header_UserDefinedExtensions */
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
	 * @return B3it_XmlBind_Bmecat12_GeneratorInfo
	 */
	public function getGeneratorInfo()
	{
		if($this->_GeneratorInfo == null)
		{
			$this->_GeneratorInfo = new B3it_XmlBind_Bmecat12_GeneratorInfo();
		}
		
		return $this->_GeneratorInfo;
	}
	
	/**
	 * @param $value GeneratorInfo
	 * @return B3it_XmlBind_Bmecat12_Header extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setGeneratorInfo($value)
	{
		$this->_GeneratorInfo = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_Catalog
	 */
	public function getCatalog()
	{
		if($this->_Catalog == null)
		{
			$this->_Catalog = new B3it_XmlBind_Bmecat12_Catalog();
		}
		
		return $this->_Catalog;
	}
	
	/**
	 * @param $value Catalog
	 * @return B3it_XmlBind_Bmecat12_Header extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setCatalog($value)
	{
		$this->_Catalog = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_Buyer
	 */
	public function getBuyer()
	{
		if($this->_Buyer == null)
		{
			$this->_Buyer = new B3it_XmlBind_Bmecat12_Buyer();
		}
		
		return $this->_Buyer;
	}
	
	/**
	 * @param $value Buyer
	 * @return B3it_XmlBind_Bmecat12_Header extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setBuyer($value)
	{
		$this->_Buyer = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_Agreement[]
	 */
	public function getAllAgreement()
	{
		return $this->_Agreements;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat12_Agreement and add it to list
	 * @return B3it_XmlBind_Bmecat12_Agreement
	 */
	public function getAgreement()
	{
		$res = new B3it_XmlBind_Bmecat12_Agreement();
		$this->_Agreements[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value Agreement[]
	 * @return B3it_XmlBind_Bmecat12_Header extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setAgreement($value)
	{
		$this->_Agreement = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_Supplier
	 */
	public function getSupplier()
	{
		if($this->_Supplier == null)
		{
			$this->_Supplier = new B3it_XmlBind_Bmecat12_Supplier();
		}
		
		return $this->_Supplier;
	}
	
	/**
	 * @param $value Supplier
	 * @return B3it_XmlBind_Bmecat12_Header extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setSupplier($value)
	{
		$this->_Supplier = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_Header_UserDefinedExtensions
	 */
	public function getUserDefinedExtensions()
	{
		if($this->_UserDefinedExtensions == null)
		{
			$this->_UserDefinedExtensions = new B3it_XmlBind_Bmecat12_Header_UserDefinedExtensions();
		}
		
		return $this->_UserDefinedExtensions;
	}
	
	/**
	 * @param $value UserDefinedExtensions
	 * @return B3it_XmlBind_Bmecat12_Header extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setUserDefinedExtensions($value)
	{
		$this->_UserDefinedExtensions = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('HEADER');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_GeneratorInfo != null){
			$this->_GeneratorInfo->toXml($xml);
		}
		if($this->_Catalog != null){
			$this->_Catalog->toXml($xml);
		}
		if($this->_Buyer != null){
			$this->_Buyer->toXml($xml);
		}
		if($this->_Agreements != null){
			foreach($this->_Agreements as $item){
				$item->toXml($xml);
			}
		}
		if($this->_Supplier != null){
			$this->_Supplier->toXml($xml);
		}
		if($this->_UserDefinedExtensions != null){
			$this->_UserDefinedExtensions->toXml($xml);
		}


		return $xml;
	}
}