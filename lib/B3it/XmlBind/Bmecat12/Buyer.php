<?php
class B3it_XmlBind_Bmecat12_Buyer extends B3it_XmlBind_Bmecat12_XmlBind
{
	private $_attributes = array();



	/* @var BuyerId */
	private $_BuyerId = null;	

	/* @var BuyerName */
	private $_BuyerName = null;	

	/* @var Buyer_Address */
	private $_Address = null;	

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
	 * @return B3it_XmlBind_Bmecat12_BuyerId
	 */
	public function getBuyerId()
	{
		if($this->_BuyerId == null)
		{
			$this->_BuyerId = new B3it_XmlBind_Bmecat12_BuyerId();
		}
		
		return $this->_BuyerId;
	}
	
	/**
	 * @param $value BuyerId
	 * @return B3it_XmlBind_Bmecat12_Buyer extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setBuyerId($value)
	{
		$this->_BuyerId = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_BuyerName
	 */
	public function getBuyerName()
	{
		if($this->_BuyerName == null)
		{
			$this->_BuyerName = new B3it_XmlBind_Bmecat12_BuyerName();
		}
		
		return $this->_BuyerName;
	}
	
	/**
	 * @param $value BuyerName
	 * @return B3it_XmlBind_Bmecat12_Buyer extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setBuyerName($value)
	{
		$this->_BuyerName = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_Buyer_Address
	 */
	public function getAddress()
	{
		if($this->_Address == null)
		{
			$this->_Address = new B3it_XmlBind_Bmecat12_Buyer_Address();
		}
		
		return $this->_Address;
	}
	
	/**
	 * @param $value Address
	 * @return B3it_XmlBind_Bmecat12_Buyer extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setAddress($value)
	{
		$this->_Address = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('BUYER');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_BuyerId != null){
			$this->_BuyerId->toXml($xml);
		}
		if($this->_BuyerName != null){
			$this->_BuyerName->toXml($xml);
		}
		if($this->_Address != null){
			$this->_Address->toXml($xml);
		}


		return $xml;
	}
}