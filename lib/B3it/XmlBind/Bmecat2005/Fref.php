<?php
class B3it_XmlBind_Bmecat2005_Fref extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var ReferenceFeatureSystemName */
	private $_ReferenceFeatureSystemName = null;	

	/* @var FtIdref */
	private $_FtIdref = null;	

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
	 * @return B3it_XmlBind_Bmecat2005_ReferenceFeatureSystemName
	 */
	public function getReferenceFeatureSystemName()
	{
		if($this->_ReferenceFeatureSystemName == null)
		{
			$this->_ReferenceFeatureSystemName = new B3it_XmlBind_Bmecat2005_ReferenceFeatureSystemName();
		}
		
		return $this->_ReferenceFeatureSystemName;
	}
	
	/**
	 * @param $value ReferenceFeatureSystemName
	 * @return B3it_XmlBind_Bmecat2005_Fref extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setReferenceFeatureSystemName($value)
	{
		$this->_ReferenceFeatureSystemName = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_FtIdref
	 */
	public function getFtIdref()
	{
		if($this->_FtIdref == null)
		{
			$this->_FtIdref = new B3it_XmlBind_Bmecat2005_FtIdref();
		}
		
		return $this->_FtIdref;
	}
	
	/**
	 * @param $value FtIdref
	 * @return B3it_XmlBind_Bmecat2005_Fref extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setFtIdref($value)
	{
		$this->_FtIdref = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('FREF');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_ReferenceFeatureSystemName != null){
			$this->_ReferenceFeatureSystemName->toXml($xml);
		}
		if($this->_FtIdref != null){
			$this->_FtIdref->toXml($xml);
		}


		return $xml;
	}
}