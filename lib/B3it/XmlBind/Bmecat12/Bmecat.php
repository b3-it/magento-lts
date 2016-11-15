<?php
class B3it_XmlBind_Bmecat12_Bmecat extends B3it_XmlBind_Bmecat12_XmlBind
{
	private $_attributes = array();



	/* @var Header */
	private $_Header = null;	

	/* @var TNewCatalog */
	private $_TNewCatalog = null;	

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
	 * @return B3it_XmlBind_Bmecat12_Header
	 */
	public function getHeader()
	{
		if($this->_Header == null)
		{
			$this->_Header = new B3it_XmlBind_Bmecat12_Header();
		}
		
		return $this->_Header;
	}
	
	/**
	 * @param $value Header
	 * @return B3it_XmlBind_Bmecat12_Bmecat extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setHeader($value)
	{
		$this->_Header = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_TNewCatalog
	 */
	public function getTNewCatalog()
	{
		if($this->_TNewCatalog == null)
		{
			$this->_TNewCatalog = new B3it_XmlBind_Bmecat12_TNewCatalog();
		}
		
		return $this->_TNewCatalog;
	}
	
	/**
	 * @param $value TNewCatalog
	 * @return B3it_XmlBind_Bmecat12_Bmecat extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setTNewCatalog($value)
	{
		$this->_TNewCatalog = $value;
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


		return $xml;
	}
}