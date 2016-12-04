<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	LogisticDetails
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_LogisticDetails extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_CustomsTariffNumber */
	private $__CustomsTariffNumberA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_StatisticsFactor */
	private $__StatisticsFactor = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_CountryOfOrigin */
	private $__CountryOfOriginA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_ProductDimensions */
	private $__ProductDimensions = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_SpecialTreatmentClass */
	private $__SpecialTreatmentClass = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_Transport */
	private $__TransportA = array();

	/* @var B3it_XmlBind_Opentrans21_PackageInfo */
	private $__PackageInfo = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_MeansOfTransport */
	private $__MeansOfTransportA = array();


	

	

	
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_CustomsTariffNumber and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_CustomsTariffNumber
	 */
	public function getCustomsTariffNumber()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_CustomsTariffNumber();
		$this->__CustomsTariffNumberA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_CustomsTariffNumber
	 * @return B3it_XmlBind_Opentrans21_LogisticDetails
	 */
	public function setCustomsTariffNumber($value)
	{
		$this->__CustomsTariffNumberA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_CustomsTariffNumber[]
	 */
	public function getAllCustomsTariffNumber()
	{
		return $this->__CustomsTariffNumberA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_StatisticsFactor
	 */
	public function getStatisticsFactor()
	{
		if($this->__StatisticsFactor == null)
		{
			$this->__StatisticsFactor = new B3it_XmlBind_Opentrans21_Bmecat_StatisticsFactor();
		}
	
		return $this->__StatisticsFactor;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_StatisticsFactor
	 * @return B3it_XmlBind_Opentrans21_LogisticDetails
	 */
	public function setStatisticsFactor($value)
	{
		$this->__StatisticsFactor = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_CountryOfOrigin and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_CountryOfOrigin
	 */
	public function getCountryOfOrigin()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_CountryOfOrigin();
		$this->__CountryOfOriginA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_CountryOfOrigin
	 * @return B3it_XmlBind_Opentrans21_LogisticDetails
	 */
	public function setCountryOfOrigin($value)
	{
		$this->__CountryOfOriginA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_CountryOfOrigin[]
	 */
	public function getAllCountryOfOrigin()
	{
		return $this->__CountryOfOriginA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ProductDimensions
	 */
	public function getProductDimensions()
	{
		if($this->__ProductDimensions == null)
		{
			$this->__ProductDimensions = new B3it_XmlBind_Opentrans21_Bmecat_ProductDimensions();
		}
	
		return $this->__ProductDimensions;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ProductDimensions
	 * @return B3it_XmlBind_Opentrans21_LogisticDetails
	 */
	public function setProductDimensions($value)
	{
		$this->__ProductDimensions = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_SpecialTreatmentClass
	 */
	public function getSpecialTreatmentClass()
	{
		if($this->__SpecialTreatmentClass == null)
		{
			$this->__SpecialTreatmentClass = new B3it_XmlBind_Opentrans21_Bmecat_SpecialTreatmentClass();
		}
	
		return $this->__SpecialTreatmentClass;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_SpecialTreatmentClass
	 * @return B3it_XmlBind_Opentrans21_LogisticDetails
	 */
	public function setSpecialTreatmentClass($value)
	{
		$this->__SpecialTreatmentClass = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_Transport and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Transport
	 */
	public function getTransport()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_Transport();
		$this->__TransportA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Transport
	 * @return B3it_XmlBind_Opentrans21_LogisticDetails
	 */
	public function setTransport($value)
	{
		$this->__TransportA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Transport[]
	 */
	public function getAllTransport()
	{
		return $this->__TransportA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_PackageInfo
	 */
	public function getPackageInfo()
	{
		if($this->__PackageInfo == null)
		{
			$this->__PackageInfo = new B3it_XmlBind_Opentrans21_PackageInfo();
		}
	
		return $this->__PackageInfo;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_PackageInfo
	 * @return B3it_XmlBind_Opentrans21_LogisticDetails
	 */
	public function setPackageInfo($value)
	{
		$this->__PackageInfo = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_MeansOfTransport and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_MeansOfTransport
	 */
	public function getMeansOfTransport()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_MeansOfTransport();
		$this->__MeansOfTransportA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_MeansOfTransport
	 * @return B3it_XmlBind_Opentrans21_LogisticDetails
	 */
	public function setMeansOfTransport($value)
	{
		$this->__MeansOfTransportA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_MeansOfTransport[]
	 */
	public function getAllMeansOfTransport()
	{
		return $this->__MeansOfTransportA;
	}







	public function toXml($xml)
	{
		$node = new DOMElement('LOGISTIC_DETAILS');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__CustomsTariffNumberA != null){
			foreach($this->__CustomsTariffNumberA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__StatisticsFactor != null){
			$this->__StatisticsFactor->toXml($xml);
		}
		if($this->__CountryOfOriginA != null){
			foreach($this->__CountryOfOriginA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__ProductDimensions != null){
			$this->__ProductDimensions->toXml($xml);
		}
		if($this->__SpecialTreatmentClass != null){
			$this->__SpecialTreatmentClass->toXml($xml);
		}
		if($this->__TransportA != null){
			foreach($this->__TransportA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__PackageInfo != null){
			$this->__PackageInfo->toXml($xml);
		}
		if($this->__MeansOfTransportA != null){
			foreach($this->__MeansOfTransportA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
