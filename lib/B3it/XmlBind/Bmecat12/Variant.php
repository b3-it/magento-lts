<?php
class B3it_XmlBind_Bmecat12_Variant extends B3it_XmlBind_Bmecat12_XmlBind
{
	private $_attributes = array();



	/* @var Fvalue */
	private $_Fvalue = null;	

	/* @var SupplierAidSupplement */
	private $_SupplierAidSupplement = null;	

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
	 * @return B3it_XmlBind_Bmecat12_Fvalue
	 */
	public function getFvalue()
	{
		if($this->_Fvalue == null)
		{
			$this->_Fvalue = new B3it_XmlBind_Bmecat12_Fvalue();
		}
		
		return $this->_Fvalue;
	}
	
	/**
	 * @param $value Fvalue
	 * @return B3it_XmlBind_Bmecat12_Variant extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setFvalue($value)
	{
		$this->_Fvalue = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_SupplierAidSupplement
	 */
	public function getSupplierAidSupplement()
	{
		if($this->_SupplierAidSupplement == null)
		{
			$this->_SupplierAidSupplement = new B3it_XmlBind_Bmecat12_SupplierAidSupplement();
		}
		
		return $this->_SupplierAidSupplement;
	}
	
	/**
	 * @param $value SupplierAidSupplement
	 * @return B3it_XmlBind_Bmecat12_Variant extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setSupplierAidSupplement($value)
	{
		$this->_SupplierAidSupplement = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('VARIANT');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_Fvalue != null){
			$this->_Fvalue->toXml($xml);
		}
		if($this->_SupplierAidSupplement != null){
			$this->_SupplierAidSupplement->toXml($xml);
		}


		return $xml;
	}
}