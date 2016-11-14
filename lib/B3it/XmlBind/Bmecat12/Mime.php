<?php
class B3it_XmlBind_Bmecat12_Mime extends B3it_XmlBind_Bmecat12_XmlBind
{
	private $_attributes = array();



	/* @var MimeType */
	private $_MimeType = null;	

	/* @var MimeSource */
	private $_MimeSource = null;	

	/* @var MimeDescr */
	private $_MimeDescr = null;	

	/* @var MimeAlt */
	private $_MimeAlt = null;	

	/* @var MimePurpose */
	private $_MimePurpose = null;	

	/* @var MimeOrder */
	private $_MimeOrder = null;	

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
	 * @return B3it_XmlBind_Bmecat12_MimeType
	 */
	public function getMimeType()
	{
		if($this->_MimeType == null)
		{
			$this->_MimeType = new B3it_XmlBind_Bmecat12_MimeType();
		}
		
		return $this->_MimeType;
	}
	
	/**
	 * @param $value MimeType
	 * @return B3it_XmlBind_Bmecat12_Mime extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setMimeType($value)
	{
		$this->_MimeType = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_MimeSource
	 */
	public function getMimeSource()
	{
		if($this->_MimeSource == null)
		{
			$this->_MimeSource = new B3it_XmlBind_Bmecat12_MimeSource();
		}
		
		return $this->_MimeSource;
	}
	
	/**
	 * @param $value MimeSource
	 * @return B3it_XmlBind_Bmecat12_Mime extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setMimeSource($value)
	{
		$this->_MimeSource = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_MimeDescr
	 */
	public function getMimeDescr()
	{
		if($this->_MimeDescr == null)
		{
			$this->_MimeDescr = new B3it_XmlBind_Bmecat12_MimeDescr();
		}
		
		return $this->_MimeDescr;
	}
	
	/**
	 * @param $value MimeDescr
	 * @return B3it_XmlBind_Bmecat12_Mime extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setMimeDescr($value)
	{
		$this->_MimeDescr = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_MimeAlt
	 */
	public function getMimeAlt()
	{
		if($this->_MimeAlt == null)
		{
			$this->_MimeAlt = new B3it_XmlBind_Bmecat12_MimeAlt();
		}
		
		return $this->_MimeAlt;
	}
	
	/**
	 * @param $value MimeAlt
	 * @return B3it_XmlBind_Bmecat12_Mime extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setMimeAlt($value)
	{
		$this->_MimeAlt = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_MimePurpose
	 */
	public function getMimePurpose()
	{
		if($this->_MimePurpose == null)
		{
			$this->_MimePurpose = new B3it_XmlBind_Bmecat12_MimePurpose();
		}
		
		return $this->_MimePurpose;
	}
	
	/**
	 * @param $value MimePurpose
	 * @return B3it_XmlBind_Bmecat12_Mime extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setMimePurpose($value)
	{
		$this->_MimePurpose = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_MimeOrder
	 */
	public function getMimeOrder()
	{
		if($this->_MimeOrder == null)
		{
			$this->_MimeOrder = new B3it_XmlBind_Bmecat12_MimeOrder();
		}
		
		return $this->_MimeOrder;
	}
	
	/**
	 * @param $value MimeOrder
	 * @return B3it_XmlBind_Bmecat12_Mime extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setMimeOrder($value)
	{
		$this->_MimeOrder = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('MIME');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_MimeType != null){
			$this->_MimeType->toXml($xml);
		}
		if($this->_MimeSource != null){
			$this->_MimeSource->toXml($xml);
		}
		if($this->_MimeDescr != null){
			$this->_MimeDescr->toXml($xml);
		}
		if($this->_MimeAlt != null){
			$this->_MimeAlt->toXml($xml);
		}
		if($this->_MimePurpose != null){
			$this->_MimePurpose->toXml($xml);
		}
		if($this->_MimeOrder != null){
			$this->_MimeOrder->toXml($xml);
		}


		return $xml;
	}
}