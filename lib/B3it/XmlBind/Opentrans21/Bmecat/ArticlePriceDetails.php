<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_ArticlePriceDetails
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_ArticlePriceDetails extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_ValidStartDate */
	private $__ValidStartDate = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_ValidEndDate */
	private $__ValidEndDate = null;

	
	/* @var B3it_XmlBind_Opentrans21_ArticlePriceDetails_Bmecat_Datetime */
	private $__DatetimeA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_DailyPrice */
	private $__DailyPrice = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_ArticlePrice */
	private $__ArticlePriceA = array();


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ValidStartDate
	 */
	public function getValidStartDate()
	{
		if($this->__ValidStartDate == null)
		{
			$this->__ValidStartDate = new B3it_XmlBind_Opentrans21_Bmecat_ValidStartDate();
		}
	
		return $this->__ValidStartDate;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ValidStartDate
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticlePriceDetails
	 */
	public function setValidStartDate($value)
	{
		$this->__ValidStartDate = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ValidEndDate
	 */
	public function getValidEndDate()
	{
		if($this->__ValidEndDate == null)
		{
			$this->__ValidEndDate = new B3it_XmlBind_Opentrans21_Bmecat_ValidEndDate();
		}
	
		return $this->__ValidEndDate;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ValidEndDate
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticlePriceDetails
	 */
	public function setValidEndDate($value)
	{
		$this->__ValidEndDate = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_ArticlePriceDetails_Bmecat_Datetime and add it to list
	 * @return B3it_XmlBind_Opentrans21_ArticlePriceDetails_Bmecat_Datetime
	 */
	public function getDatetime()
	{
		$res = new B3it_XmlBind_Opentrans21_ArticlePriceDetails_Bmecat_Datetime();
		$this->__DatetimeA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_ArticlePriceDetails_Bmecat_Datetime
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticlePriceDetails
	 */
	public function setDatetime($value)
	{
		$this->__DatetimeA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_ArticlePriceDetails_Bmecat_Datetime[]
	 */
	public function getAllDatetime()
	{
		return $this->__DatetimeA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_DailyPrice
	 */
	public function getDailyPrice()
	{
		if($this->__DailyPrice == null)
		{
			$this->__DailyPrice = new B3it_XmlBind_Opentrans21_Bmecat_DailyPrice();
		}
	
		return $this->__DailyPrice;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_DailyPrice
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticlePriceDetails
	 */
	public function setDailyPrice($value)
	{
		$this->__DailyPrice = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_ArticlePrice and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticlePrice
	 */
	public function getArticlePrice()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_ArticlePrice();
		$this->__ArticlePriceA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ArticlePrice
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticlePriceDetails
	 */
	public function setArticlePrice($value)
	{
		$this->__ArticlePriceA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ArticlePrice[]
	 */
	public function getAllArticlePrice()
	{
		return $this->__ArticlePriceA;
	}







	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:ARTICLE_PRICE_DETAILS');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:ARTICLE_PRICE_DETAILS');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__ValidStartDate != null){
			$this->__ValidStartDate->toXml($xml);
		}
		if($this->__ValidEndDate != null){
			$this->__ValidEndDate->toXml($xml);
		}
		if($this->__DatetimeA != null){
			foreach($this->__DatetimeA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__DailyPrice != null){
			$this->__DailyPrice->toXml($xml);
		}
		if($this->__ArticlePriceA != null){
			foreach($this->__ArticlePriceA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
