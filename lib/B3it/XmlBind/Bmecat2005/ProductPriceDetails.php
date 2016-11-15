<?php
class B3it_XmlBind_Bmecat2005_ProductPriceDetails extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var ValidStartDate */
	private $_ValidStartDate = null;	

	/* @var ValidEndDate */
	private $_ValidEndDate = null;	

	/* @var ProductPriceDetails_Datetime */
	private $_Datetimes = array();	

	/* @var DailyPrice */
	private $_DailyPrice = null;	

	/* @var ProductPrice */
	private $_ProductPrices = array();	

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
	 * @return B3it_XmlBind_Bmecat2005_ValidStartDate
	 */
	public function getValidStartDate()
	{
		if($this->_ValidStartDate == null)
		{
			$this->_ValidStartDate = new B3it_XmlBind_Bmecat2005_ValidStartDate();
		}
		
		return $this->_ValidStartDate;
	}
	
	/**
	 * @param $value ValidStartDate
	 * @return B3it_XmlBind_Bmecat2005_ProductPriceDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setValidStartDate($value)
	{
		$this->_ValidStartDate = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ValidEndDate
	 */
	public function getValidEndDate()
	{
		if($this->_ValidEndDate == null)
		{
			$this->_ValidEndDate = new B3it_XmlBind_Bmecat2005_ValidEndDate();
		}
		
		return $this->_ValidEndDate;
	}
	
	/**
	 * @param $value ValidEndDate
	 * @return B3it_XmlBind_Bmecat2005_ProductPriceDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setValidEndDate($value)
	{
		$this->_ValidEndDate = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ProductPriceDetails_Datetime[]
	 */
	public function getAllDatetime()
	{
		return $this->_Datetimes;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_ProductPriceDetails_Datetime and add it to list
	 * @return B3it_XmlBind_Bmecat2005_ProductPriceDetails_Datetime
	 */
	public function getDatetime()
	{
		$res = new B3it_XmlBind_Bmecat2005_ProductPriceDetails_Datetime();
		$this->_Datetimes[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value Datetime[]
	 * @return B3it_XmlBind_Bmecat2005_ProductPriceDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setDatetime($value)
	{
		$this->_Datetime = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_DailyPrice
	 */
	public function getDailyPrice()
	{
		if($this->_DailyPrice == null)
		{
			$this->_DailyPrice = new B3it_XmlBind_Bmecat2005_DailyPrice();
		}
		
		return $this->_DailyPrice;
	}
	
	/**
	 * @param $value DailyPrice
	 * @return B3it_XmlBind_Bmecat2005_ProductPriceDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setDailyPrice($value)
	{
		$this->_DailyPrice = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ProductPrice[]
	 */
	public function getAllProductPrice()
	{
		return $this->_ProductPrices;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_ProductPrice and add it to list
	 * @return B3it_XmlBind_Bmecat2005_ProductPrice
	 */
	public function getProductPrice()
	{
		$res = new B3it_XmlBind_Bmecat2005_ProductPrice();
		$this->_ProductPrices[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value ProductPrice[]
	 * @return B3it_XmlBind_Bmecat2005_ProductPriceDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setProductPrice($value)
	{
		$this->_ProductPrice = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('PRODUCT_PRICE_DETAILS');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_ValidStartDate != null){
			$this->_ValidStartDate->toXml($xml);
		}
		if($this->_ValidEndDate != null){
			$this->_ValidEndDate->toXml($xml);
		}
		if($this->_Datetimes != null){
			foreach($this->_Datetimes as $item){
				$item->toXml($xml);
			}
		}
		if($this->_DailyPrice != null){
			$this->_DailyPrice->toXml($xml);
		}
		if($this->_ProductPrices != null){
			foreach($this->_ProductPrices as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}
}