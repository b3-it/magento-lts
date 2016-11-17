<?php
class B3it_XmlBind_Bmecat2005_ArticleLogisticDetails extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var CustomsTariffNumber */
	private $_CustomsTariffNumbers = array();	

	/* @var StatisticsFactor */
	private $_StatisticsFactor = null;	

	/* @var CountryOfOrigin */
	private $_CountryOfOrigins = array();	

	/* @var ProductDimensions */
	private $_ProductDimensions = null;	

	/* @var DeliveryTimes */
	private $_DeliveryTimess = array();	

	/* @var Transport */
	private $_Transports = array();	

	/* @var MeansOfTransport */
	private $_MeansOfTransports = array();	

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
	 * @return B3it_XmlBind_Bmecat2005_CustomsTariffNumber[]
	 */
	public function getAllCustomsTariffNumber()
	{
		return $this->_CustomsTariffNumbers;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_CustomsTariffNumber and add it to list
	 * @return B3it_XmlBind_Bmecat2005_CustomsTariffNumber
	 */
	public function getCustomsTariffNumber()
	{
		$res = new B3it_XmlBind_Bmecat2005_CustomsTariffNumber();
		$this->_CustomsTariffNumbers[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value CustomsTariffNumber[]
	 * @return B3it_XmlBind_Bmecat2005_ArticleLogisticDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setCustomsTariffNumber($value)
	{
		$this->_CustomsTariffNumber = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_StatisticsFactor
	 */
	public function getStatisticsFactor()
	{
		if($this->_StatisticsFactor == null)
		{
			$this->_StatisticsFactor = new B3it_XmlBind_Bmecat2005_StatisticsFactor();
		}
		
		return $this->_StatisticsFactor;
	}
	
	/**
	 * @param $value StatisticsFactor
	 * @return B3it_XmlBind_Bmecat2005_ArticleLogisticDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setStatisticsFactor($value)
	{
		$this->_StatisticsFactor = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_CountryOfOrigin[]
	 */
	public function getAllCountryOfOrigin()
	{
		return $this->_CountryOfOrigins;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_CountryOfOrigin and add it to list
	 * @return B3it_XmlBind_Bmecat2005_CountryOfOrigin
	 */
	public function getCountryOfOrigin()
	{
		$res = new B3it_XmlBind_Bmecat2005_CountryOfOrigin();
		$this->_CountryOfOrigins[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value CountryOfOrigin[]
	 * @return B3it_XmlBind_Bmecat2005_ArticleLogisticDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setCountryOfOrigin($value)
	{
		$this->_CountryOfOrigin = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ProductDimensions
	 */
	public function getProductDimensions()
	{
		if($this->_ProductDimensions == null)
		{
			$this->_ProductDimensions = new B3it_XmlBind_Bmecat2005_ProductDimensions();
		}
		
		return $this->_ProductDimensions;
	}
	
	/**
	 * @param $value ProductDimensions
	 * @return B3it_XmlBind_Bmecat2005_ArticleLogisticDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setProductDimensions($value)
	{
		$this->_ProductDimensions = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_DeliveryTimes[]
	 */
	public function getAllDeliveryTimes()
	{
		return $this->_DeliveryTimess;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_DeliveryTimes and add it to list
	 * @return B3it_XmlBind_Bmecat2005_DeliveryTimes
	 */
	public function getDeliveryTimes()
	{
		$res = new B3it_XmlBind_Bmecat2005_DeliveryTimes();
		$this->_DeliveryTimess[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value DeliveryTimes[]
	 * @return B3it_XmlBind_Bmecat2005_ArticleLogisticDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setDeliveryTimes($value)
	{
		$this->_DeliveryTimes = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_Transport[]
	 */
	public function getAllTransport()
	{
		return $this->_Transports;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_Transport and add it to list
	 * @return B3it_XmlBind_Bmecat2005_Transport
	 */
	public function getTransport()
	{
		$res = new B3it_XmlBind_Bmecat2005_Transport();
		$this->_Transports[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value Transport[]
	 * @return B3it_XmlBind_Bmecat2005_ArticleLogisticDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setTransport($value)
	{
		$this->_Transport = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_MeansOfTransport[]
	 */
	public function getAllMeansOfTransport()
	{
		return $this->_MeansOfTransports;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_MeansOfTransport and add it to list
	 * @return B3it_XmlBind_Bmecat2005_MeansOfTransport
	 */
	public function getMeansOfTransport()
	{
		$res = new B3it_XmlBind_Bmecat2005_MeansOfTransport();
		$this->_MeansOfTransports[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value MeansOfTransport[]
	 * @return B3it_XmlBind_Bmecat2005_ArticleLogisticDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setMeansOfTransport($value)
	{
		$this->_MeansOfTransport = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('ARTICLE_LOGISTIC_DETAILS');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_CustomsTariffNumbers != null){
			foreach($this->_CustomsTariffNumbers as $item){
				$item->toXml($xml);
			}
		}
		if($this->_StatisticsFactor != null){
			$this->_StatisticsFactor->toXml($xml);
		}
		if($this->_CountryOfOrigins != null){
			foreach($this->_CountryOfOrigins as $item){
				$item->toXml($xml);
			}
		}
		if($this->_ProductDimensions != null){
			$this->_ProductDimensions->toXml($xml);
		}
		if($this->_DeliveryTimess != null){
			foreach($this->_DeliveryTimess as $item){
				$item->toXml($xml);
			}
		}
		if($this->_Transports != null){
			foreach($this->_Transports as $item){
				$item->toXml($xml);
			}
		}
		if($this->_MeansOfTransports != null){
			foreach($this->_MeansOfTransports as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}
}