<?php
class B3it_XmlBind_Bmecat2005_ConfigFeature extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var Fref */
	private $_Fref = null;	

	/* @var Ftemplate */
	private $_Ftemplate = null;	

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
	 * @return B3it_XmlBind_Bmecat2005_Fref
	 */
	public function getFref()
	{
		if($this->_Fref == null)
		{
			$this->_Fref = new B3it_XmlBind_Bmecat2005_Fref();
		}
		
		return $this->_Fref;
	}
	
	/**
	 * @param $value Fref
	 * @return B3it_XmlBind_Bmecat2005_ConfigFeature extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setFref($value)
	{
		$this->_Fref = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_Ftemplate
	 */
	public function getFtemplate()
	{
		if($this->_Ftemplate == null)
		{
			$this->_Ftemplate = new B3it_XmlBind_Bmecat2005_Ftemplate();
		}
		
		return $this->_Ftemplate;
	}
	
	/**
	 * @param $value Ftemplate
	 * @return B3it_XmlBind_Bmecat2005_ConfigFeature extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setFtemplate($value)
	{
		$this->_Ftemplate = $value;
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
	 * @return B3it_XmlBind_Bmecat2005_ConfigFeature extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setMimeInfo($value)
	{
		$this->_MimeInfo = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('CONFIG_FEATURE');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_Fref != null){
			$this->_Fref->toXml($xml);
		}
		if($this->_Ftemplate != null){
			$this->_Ftemplate->toXml($xml);
		}
		if($this->_MimeInfo != null){
			$this->_MimeInfo->toXml($xml);
		}


		return $xml;
	}
}