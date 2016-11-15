<?php
class B3it_XmlBind_Bmecat2005_AgreementRef extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var AgreementIdref */
	private $_AgreementIdref = null;	

	/* @var AgreementLineIdref */
	private $_AgreementLineIdref = null;	

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
	 * @return B3it_XmlBind_Bmecat2005_AgreementIdref
	 */
	public function getAgreementIdref()
	{
		if($this->_AgreementIdref == null)
		{
			$this->_AgreementIdref = new B3it_XmlBind_Bmecat2005_AgreementIdref();
		}
		
		return $this->_AgreementIdref;
	}
	
	/**
	 * @param $value AgreementIdref
	 * @return B3it_XmlBind_Bmecat2005_AgreementRef extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setAgreementIdref($value)
	{
		$this->_AgreementIdref = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_AgreementLineIdref
	 */
	public function getAgreementLineIdref()
	{
		if($this->_AgreementLineIdref == null)
		{
			$this->_AgreementLineIdref = new B3it_XmlBind_Bmecat2005_AgreementLineIdref();
		}
		
		return $this->_AgreementLineIdref;
	}
	
	/**
	 * @param $value AgreementLineIdref
	 * @return B3it_XmlBind_Bmecat2005_AgreementRef extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setAgreementLineIdref($value)
	{
		$this->_AgreementLineIdref = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('AGREEMENT_REF');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_AgreementIdref != null){
			$this->_AgreementIdref->toXml($xml);
		}
		if($this->_AgreementLineIdref != null){
			$this->_AgreementLineIdref->toXml($xml);
		}


		return $xml;
	}
}