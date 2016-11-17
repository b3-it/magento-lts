<?php
class B3it_XmlBind_Bmecat12_ArticlePrice extends B3it_XmlBind_Bmecat12_XmlBind
{
	private $_attributes = array();



	/* @var PriceAmount */
	private $_PriceAmount = null;	

	/* @var PriceCurrency */
	private $_PriceCurrency = null;	

	/* @var Tax */
	private $_Tax = null;	

	/* @var PriceFactor */
	private $_PriceFactor = null;	

	/* @var LowerBound */
	private $_LowerBound = null;	

	/* @var Territory */
	private $_Territorys = array();	

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
	 * @return B3it_XmlBind_Bmecat12_PriceAmount
	 */
	public function getPriceAmount()
	{
		if($this->_PriceAmount == null)
		{
			$this->_PriceAmount = new B3it_XmlBind_Bmecat12_PriceAmount();
		}
		
		return $this->_PriceAmount;
	}
	
	/**
	 * @param $value PriceAmount
	 * @return B3it_XmlBind_Bmecat12_ArticlePrice extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setPriceAmount($value)
	{
		$this->_PriceAmount = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_PriceCurrency
	 */
	public function getPriceCurrency()
	{
		if($this->_PriceCurrency == null)
		{
			$this->_PriceCurrency = new B3it_XmlBind_Bmecat12_PriceCurrency();
		}
		
		return $this->_PriceCurrency;
	}
	
	/**
	 * @param $value PriceCurrency
	 * @return B3it_XmlBind_Bmecat12_ArticlePrice extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setPriceCurrency($value)
	{
		$this->_PriceCurrency = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_Tax
	 */
	public function getTax()
	{
		if($this->_Tax == null)
		{
			$this->_Tax = new B3it_XmlBind_Bmecat12_Tax();
		}
		
		return $this->_Tax;
	}
	
	/**
	 * @param $value Tax
	 * @return B3it_XmlBind_Bmecat12_ArticlePrice extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setTax($value)
	{
		$this->_Tax = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_PriceFactor
	 */
	public function getPriceFactor()
	{
		if($this->_PriceFactor == null)
		{
			$this->_PriceFactor = new B3it_XmlBind_Bmecat12_PriceFactor();
		}
		
		return $this->_PriceFactor;
	}
	
	/**
	 * @param $value PriceFactor
	 * @return B3it_XmlBind_Bmecat12_ArticlePrice extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setPriceFactor($value)
	{
		$this->_PriceFactor = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_LowerBound
	 */
	public function getLowerBound()
	{
		if($this->_LowerBound == null)
		{
			$this->_LowerBound = new B3it_XmlBind_Bmecat12_LowerBound();
		}
		
		return $this->_LowerBound;
	}
	
	/**
	 * @param $value LowerBound
	 * @return B3it_XmlBind_Bmecat12_ArticlePrice extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setLowerBound($value)
	{
		$this->_LowerBound = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_Territory[]
	 */
	public function getAllTerritory()
	{
		return $this->_Territorys;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat12_Territory and add it to list
	 * @return B3it_XmlBind_Bmecat12_Territory
	 */
	public function getTerritory()
	{
		$res = new B3it_XmlBind_Bmecat12_Territory();
		$this->_Territorys[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value Territory[]
	 * @return B3it_XmlBind_Bmecat12_ArticlePrice extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setTerritory($value)
	{
		$this->_Territory = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('ARTICLE_PRICE');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_PriceAmount != null){
			$this->_PriceAmount->toXml($xml);
		}
		if($this->_PriceCurrency != null){
			$this->_PriceCurrency->toXml($xml);
		}
		if($this->_Tax != null){
			$this->_Tax->toXml($xml);
		}
		if($this->_PriceFactor != null){
			$this->_PriceFactor->toXml($xml);
		}
		if($this->_LowerBound != null){
			$this->_LowerBound->toXml($xml);
		}
		if($this->_Territorys != null){
			foreach($this->_Territorys as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}
}