<?php
class B3it_XmlBind_Bmecat2005_Bmecat extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var Header */
	private $_Header = null;	

	/* @var TNewCatalog */
	private $_TNewCatalog = null;	

	/* @var TUpdateProducts */
	private $_TUpdateProducts = null;	

	/* @var TUpdatePrices */
	private $_TUpdatePrices = null;	

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
	 * @return B3it_XmlBind_Bmecat2005_Header
	 */
	public function getHeader()
	{
		if($this->_Header == null)
		{
			$this->_Header = new B3it_XmlBind_Bmecat2005_Header();
		}
		
		return $this->_Header;
	}
	
	/**
	 * @param $value Header
	 * @return B3it_XmlBind_Bmecat2005_Bmecat extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setHeader($value)
	{
		$this->_Header = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_TNewCatalog
	 */
	public function getTNewCatalog()
	{
		if($this->_TNewCatalog == null)
		{
			$this->_TNewCatalog = new B3it_XmlBind_Bmecat2005_TNewCatalog();
		}
		
		return $this->_TNewCatalog;
	}
	
	/**
	 * @param $value TNewCatalog
	 * @return B3it_XmlBind_Bmecat2005_Bmecat extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setTNewCatalog($value)
	{
		$this->_TNewCatalog = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_TUpdateProducts
	 */
	public function getTUpdateProducts()
	{
		if($this->_TUpdateProducts == null)
		{
			$this->_TUpdateProducts = new B3it_XmlBind_Bmecat2005_TUpdateProducts();
		}
		
		return $this->_TUpdateProducts;
	}
	
	/**
	 * @param $value TUpdateProducts
	 * @return B3it_XmlBind_Bmecat2005_Bmecat extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setTUpdateProducts($value)
	{
		$this->_TUpdateProducts = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_TUpdatePrices
	 */
	public function getTUpdatePrices()
	{
		if($this->_TUpdatePrices == null)
		{
			$this->_TUpdatePrices = new B3it_XmlBind_Bmecat2005_TUpdatePrices();
		}
		
		return $this->_TUpdatePrices;
	}
	
	/**
	 * @param $value TUpdatePrices
	 * @return B3it_XmlBind_Bmecat2005_Bmecat extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setTUpdatePrices($value)
	{
		$this->_TUpdatePrices = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('BMECAT');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_Header != null){
			$this->_Header->toXml($xml);
		}
		if($this->_TNewCatalog != null){
			$this->_TNewCatalog->toXml($xml);
		}
		if($this->_TUpdateProducts != null){
			$this->_TUpdateProducts->toXml($xml);
		}
		if($this->_TUpdatePrices != null){
			$this->_TUpdatePrices->toXml($xml);
		}


		return $xml;
	}
}