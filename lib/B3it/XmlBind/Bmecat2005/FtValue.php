<?php
class B3it_XmlBind_Bmecat2005_FtValue extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var ValueIdref */
	private $_ValueIdref = null;	

	/* @var ValueSimple */
	private $_ValueSimple = null;	

	/* @var ValueText */
	private $_ValueText = null;	

	/* @var ValueRange */
	private $_ValueRange = null;	

	/* @var MimeInfo */
	private $_MimeInfo = null;	

	/* @var ConfigInfo */
	private $_ConfigInfo = null;	

	/* @var ValueOrder */
	private $_ValueOrder = null;	

	/* @var DefaultFlag */
	private $_DefaultFlag = null;	

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
	 * @return B3it_XmlBind_Bmecat2005_ValueIdref
	 */
	public function getValueIdref()
	{
		if($this->_ValueIdref == null)
		{
			$this->_ValueIdref = new B3it_XmlBind_Bmecat2005_ValueIdref();
		}
		
		return $this->_ValueIdref;
	}
	
	/**
	 * @param $value ValueIdref
	 * @return B3it_XmlBind_Bmecat2005_FtValue extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setValueIdref($value)
	{
		$this->_ValueIdref = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ValueSimple
	 */
	public function getValueSimple()
	{
		if($this->_ValueSimple == null)
		{
			$this->_ValueSimple = new B3it_XmlBind_Bmecat2005_ValueSimple();
		}
		
		return $this->_ValueSimple;
	}
	
	/**
	 * @param $value ValueSimple
	 * @return B3it_XmlBind_Bmecat2005_FtValue extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setValueSimple($value)
	{
		$this->_ValueSimple = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ValueText
	 */
	public function getValueText()
	{
		if($this->_ValueText == null)
		{
			$this->_ValueText = new B3it_XmlBind_Bmecat2005_ValueText();
		}
		
		return $this->_ValueText;
	}
	
	/**
	 * @param $value ValueText
	 * @return B3it_XmlBind_Bmecat2005_FtValue extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setValueText($value)
	{
		$this->_ValueText = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ValueRange
	 */
	public function getValueRange()
	{
		if($this->_ValueRange == null)
		{
			$this->_ValueRange = new B3it_XmlBind_Bmecat2005_ValueRange();
		}
		
		return $this->_ValueRange;
	}
	
	/**
	 * @param $value ValueRange
	 * @return B3it_XmlBind_Bmecat2005_FtValue extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setValueRange($value)
	{
		$this->_ValueRange = $value;
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
	 * @return B3it_XmlBind_Bmecat2005_FtValue extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setMimeInfo($value)
	{
		$this->_MimeInfo = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ConfigInfo
	 */
	public function getConfigInfo()
	{
		if($this->_ConfigInfo == null)
		{
			$this->_ConfigInfo = new B3it_XmlBind_Bmecat2005_ConfigInfo();
		}
		
		return $this->_ConfigInfo;
	}
	
	/**
	 * @param $value ConfigInfo
	 * @return B3it_XmlBind_Bmecat2005_FtValue extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setConfigInfo($value)
	{
		$this->_ConfigInfo = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ValueOrder
	 */
	public function getValueOrder()
	{
		if($this->_ValueOrder == null)
		{
			$this->_ValueOrder = new B3it_XmlBind_Bmecat2005_ValueOrder();
		}
		
		return $this->_ValueOrder;
	}
	
	/**
	 * @param $value ValueOrder
	 * @return B3it_XmlBind_Bmecat2005_FtValue extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setValueOrder($value)
	{
		$this->_ValueOrder = $value;
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
	 * @return B3it_XmlBind_Bmecat2005_FtValue extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setDefaultFlag($value)
	{
		$this->_DefaultFlag = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('FT_VALUE');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_ValueIdref != null){
			$this->_ValueIdref->toXml($xml);
		}
		if($this->_ValueSimple != null){
			$this->_ValueSimple->toXml($xml);
		}
		if($this->_ValueText != null){
			$this->_ValueText->toXml($xml);
		}
		if($this->_ValueRange != null){
			$this->_ValueRange->toXml($xml);
		}
		if($this->_MimeInfo != null){
			$this->_MimeInfo->toXml($xml);
		}
		if($this->_ConfigInfo != null){
			$this->_ConfigInfo->toXml($xml);
		}
		if($this->_ValueOrder != null){
			$this->_ValueOrder->toXml($xml);
		}
		if($this->_DefaultFlag != null){
			$this->_DefaultFlag->toXml($xml);
		}


		return $xml;
	}
}