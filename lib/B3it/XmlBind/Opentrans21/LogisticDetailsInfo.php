<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	LogisticDetailsInfo
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_LogisticDetailsInfo extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_CountryOfOrigin */
	private $__CountryOfOriginA = array();

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_Transport */
	private $__TransportA = array();

	/* @var B3it_XmlBind_Opentrans21_PackageInfo */
	private $__PackageInfo = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_MeansOfTransport */
	private $__MeansOfTransportA = array();


	

	

	
	

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
	 * @return B3it_XmlBind_Opentrans21_LogisticDetailsInfo
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
	 * @return B3it_XmlBind_Opentrans21_LogisticDetailsInfo
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
	 * @return B3it_XmlBind_Opentrans21_LogisticDetailsInfo
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
	 * @return B3it_XmlBind_Opentrans21_LogisticDetailsInfo
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
		$node = new DOMElement('LOGISTIC_DETAILS_INFO');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__CountryOfOriginA != null){
			foreach($this->__CountryOfOriginA as $item){
				$item->toXml($xml);
			}
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
