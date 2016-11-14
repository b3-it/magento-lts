<?php
class B3it_XmlBind_Bmecat12_ClassificationSystemFeatureTemplate extends B3it_XmlBind_Bmecat12_XmlBind
{
	private $_attributes = array();



	/* @var FtId */
	private $_FtId = null;	

	/* @var FtName */
	private $_FtName = null;	

	/* @var FtDescr */
	private $_FtDescr = null;	

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
	 * @return B3it_XmlBind_Bmecat12_FtId
	 */
	public function getFtId()
	{
		if($this->_FtId == null)
		{
			$this->_FtId = new B3it_XmlBind_Bmecat12_FtId();
		}
		
		return $this->_FtId;
	}
	
	/**
	 * @param $value FtId
	 * @return B3it_XmlBind_Bmecat12_ClassificationSystemFeatureTemplate extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setFtId($value)
	{
		$this->_FtId = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_FtName
	 */
	public function getFtName()
	{
		if($this->_FtName == null)
		{
			$this->_FtName = new B3it_XmlBind_Bmecat12_FtName();
		}
		
		return $this->_FtName;
	}
	
	/**
	 * @param $value FtName
	 * @return B3it_XmlBind_Bmecat12_ClassificationSystemFeatureTemplate extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setFtName($value)
	{
		$this->_FtName = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_FtDescr
	 */
	public function getFtDescr()
	{
		if($this->_FtDescr == null)
		{
			$this->_FtDescr = new B3it_XmlBind_Bmecat12_FtDescr();
		}
		
		return $this->_FtDescr;
	}
	
	/**
	 * @param $value FtDescr
	 * @return B3it_XmlBind_Bmecat12_ClassificationSystemFeatureTemplate extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setFtDescr($value)
	{
		$this->_FtDescr = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('CLASSIFICATION_SYSTEM_FEATURE_TEMPLATE');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_FtId != null){
			$this->_FtId->toXml($xml);
		}
		if($this->_FtName != null){
			$this->_FtName->toXml($xml);
		}
		if($this->_FtDescr != null){
			$this->_FtDescr->toXml($xml);
		}


		return $xml;
	}
}