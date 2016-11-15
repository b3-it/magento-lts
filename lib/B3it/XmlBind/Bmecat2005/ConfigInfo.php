<?php
class B3it_XmlBind_Bmecat2005_ConfigInfo extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var ConfigCode */
	private $_ConfigCode = null;	

	/* @var ProductPriceDetails */
	private $_ProductPriceDetails = null;	

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
	 * @return B3it_XmlBind_Bmecat2005_ConfigCode
	 */
	public function getConfigCode()
	{
		if($this->_ConfigCode == null)
		{
			$this->_ConfigCode = new B3it_XmlBind_Bmecat2005_ConfigCode();
		}
		
		return $this->_ConfigCode;
	}
	
	/**
	 * @param $value ConfigCode
	 * @return B3it_XmlBind_Bmecat2005_ConfigInfo extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setConfigCode($value)
	{
		$this->_ConfigCode = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ProductPriceDetails
	 */
	public function getProductPriceDetails()
	{
		if($this->_ProductPriceDetails == null)
		{
			$this->_ProductPriceDetails = new B3it_XmlBind_Bmecat2005_ProductPriceDetails();
		}
		
		return $this->_ProductPriceDetails;
	}
	
	/**
	 * @param $value ProductPriceDetails
	 * @return B3it_XmlBind_Bmecat2005_ConfigInfo extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setProductPriceDetails($value)
	{
		$this->_ProductPriceDetails = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('CONFIG_INFO');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_ConfigCode != null){
			$this->_ConfigCode->toXml($xml);
		}
		if($this->_ProductPriceDetails != null){
			$this->_ProductPriceDetails->toXml($xml);
		}


		return $xml;
	}
}