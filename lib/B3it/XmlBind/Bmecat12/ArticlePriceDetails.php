<?php
class B3it_XmlBind_Bmecat12_ArticlePriceDetails extends B3it_XmlBind_Bmecat12_XmlBind
{
	private $_attributes = array();



	/* @var ArticlePriceDetails_Datetime */
	private $_Datetimes = array();	

	/* @var DailyPrice */
	private $_DailyPrice = null;	

	/* @var ArticlePrice */
	private $_ArticlePrices = array();	

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
	 * @return B3it_XmlBind_Bmecat12_ArticlePriceDetails_Datetime[]
	 */
	public function getAllDatetime()
	{
		return $this->_Datetimes;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat12_ArticlePriceDetails_Datetime and add it to list
	 * @return B3it_XmlBind_Bmecat12_ArticlePriceDetails_Datetime
	 */
	public function getDatetime()
	{
		$res = new B3it_XmlBind_Bmecat12_ArticlePriceDetails_Datetime();
		$this->_Datetimes[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value Datetime[]
	 * @return B3it_XmlBind_Bmecat12_ArticlePriceDetails extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setDatetime($value)
	{
		$this->_Datetime = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_DailyPrice
	 */
	public function getDailyPrice()
	{
		if($this->_DailyPrice == null)
		{
			$this->_DailyPrice = new B3it_XmlBind_Bmecat12_DailyPrice();
		}
		
		return $this->_DailyPrice;
	}
	
	/**
	 * @param $value DailyPrice
	 * @return B3it_XmlBind_Bmecat12_ArticlePriceDetails extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setDailyPrice($value)
	{
		$this->_DailyPrice = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat12_ArticlePrice[]
	 */
	public function getAllArticlePrice()
	{
		return $this->_ArticlePrices;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat12_ArticlePrice and add it to list
	 * @return B3it_XmlBind_Bmecat12_ArticlePrice
	 */
	public function getArticlePrice()
	{
		$res = new B3it_XmlBind_Bmecat12_ArticlePrice();
		$this->_ArticlePrices[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value ArticlePrice[]
	 * @return B3it_XmlBind_Bmecat12_ArticlePriceDetails extends B3it_XmlBind_Bmecat12_XmlBind
	 */
	public function setArticlePrice($value)
	{
		$this->_ArticlePrice = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('ARTICLE_PRICE_DETAILS');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_Datetimes != null){
			foreach($this->_Datetimes as $item){
				$item->toXml($xml);
			}
		}
		if($this->_DailyPrice != null){
			$this->_DailyPrice->toXml($xml);
		}
		if($this->_ArticlePrices != null){
			foreach($this->_ArticlePrices as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}
}