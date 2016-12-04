<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	ProductPriceDetails
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_ProductPriceDetails extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_ValidStartDate */
	private $__ValidStartDate = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_ValidEndDate */
	private $__ValidEndDate = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_DailyPrice */
	private $__DailyPrice = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_ProductPrice */
	private $__ProductPriceA = array();


	

	

	
	
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
	 * @return B3it_XmlBind_Opentrans21_ProductPriceDetails
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
	 * @return B3it_XmlBind_Opentrans21_ProductPriceDetails
	 */
	public function setValidEndDate($value)
	{
		$this->__ValidEndDate = $value;
		return $this;
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
	 * @return B3it_XmlBind_Opentrans21_ProductPriceDetails
	 */
	public function setDailyPrice($value)
	{
		$this->__DailyPrice = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_ProductPrice and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ProductPrice
	 */
	public function getProductPrice()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_ProductPrice();
		$this->__ProductPriceA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ProductPrice
	 * @return B3it_XmlBind_Opentrans21_ProductPriceDetails
	 */
	public function setProductPrice($value)
	{
		$this->__ProductPriceA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ProductPrice[]
	 */
	public function getAllProductPrice()
	{
		return $this->__ProductPriceA;
	}







	public function toXml($xml)
	{
		$node = new DOMElement('PRODUCT_PRICE_DETAILS');
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
		if($this->__DailyPrice != null){
			$this->__DailyPrice->toXml($xml);
		}
		if($this->__ProductPriceA != null){
			foreach($this->__ProductPriceA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
