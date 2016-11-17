<?php
class B3it_XmlBind_Bmecat2005_ArticleDimensions extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var Volume */
	private $_Volume = null;	

	/* @var Weight */
	private $_Weight = null;	

	/* @var Length */
	private $_Length = null;	

	/* @var Width */
	private $_Width = null;	

	/* @var Depth */
	private $_Depth = null;	

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
	 * @return B3it_XmlBind_Bmecat2005_Volume
	 */
	public function getVolume()
	{
		if($this->_Volume == null)
		{
			$this->_Volume = new B3it_XmlBind_Bmecat2005_Volume();
		}
		
		return $this->_Volume;
	}
	
	/**
	 * @param $value Volume
	 * @return B3it_XmlBind_Bmecat2005_ArticleDimensions extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setVolume($value)
	{
		$this->_Volume = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_Weight
	 */
	public function getWeight()
	{
		if($this->_Weight == null)
		{
			$this->_Weight = new B3it_XmlBind_Bmecat2005_Weight();
		}
		
		return $this->_Weight;
	}
	
	/**
	 * @param $value Weight
	 * @return B3it_XmlBind_Bmecat2005_ArticleDimensions extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setWeight($value)
	{
		$this->_Weight = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_Length
	 */
	public function getLength()
	{
		if($this->_Length == null)
		{
			$this->_Length = new B3it_XmlBind_Bmecat2005_Length();
		}
		
		return $this->_Length;
	}
	
	/**
	 * @param $value Length
	 * @return B3it_XmlBind_Bmecat2005_ArticleDimensions extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setLength($value)
	{
		$this->_Length = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_Width
	 */
	public function getWidth()
	{
		if($this->_Width == null)
		{
			$this->_Width = new B3it_XmlBind_Bmecat2005_Width();
		}
		
		return $this->_Width;
	}
	
	/**
	 * @param $value Width
	 * @return B3it_XmlBind_Bmecat2005_ArticleDimensions extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setWidth($value)
	{
		$this->_Width = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_Depth
	 */
	public function getDepth()
	{
		if($this->_Depth == null)
		{
			$this->_Depth = new B3it_XmlBind_Bmecat2005_Depth();
		}
		
		return $this->_Depth;
	}
	
	/**
	 * @param $value Depth
	 * @return B3it_XmlBind_Bmecat2005_ArticleDimensions extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setDepth($value)
	{
		$this->_Depth = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('ARTICLE_DIMENSIONS');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_Volume != null){
			$this->_Volume->toXml($xml);
		}
		if($this->_Weight != null){
			$this->_Weight->toXml($xml);
		}
		if($this->_Length != null){
			$this->_Length->toXml($xml);
		}
		if($this->_Width != null){
			$this->_Width->toXml($xml);
		}
		if($this->_Depth != null){
			$this->_Depth->toXml($xml);
		}


		return $xml;
	}
}