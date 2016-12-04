<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_ConfigInfo
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_ConfigInfo extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_ConfigCode */
	private $__ConfigCode = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_ProductPriceDetails */
	private $__ProductPriceDetails = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ConfigCode
	 */
	public function getConfigCode()
	{
		if($this->__ConfigCode == null)
		{
			$this->__ConfigCode = new B3it_XmlBind_Opentrans21_Bmecat_ConfigCode();
		}
	
		return $this->__ConfigCode;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ConfigCode
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ConfigInfo
	 */
	public function setConfigCode($value)
	{
		$this->__ConfigCode = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ProductPriceDetails
	 */
	public function getProductPriceDetails()
	{
		if($this->__ProductPriceDetails == null)
		{
			$this->__ProductPriceDetails = new B3it_XmlBind_Opentrans21_Bmecat_ProductPriceDetails();
		}
	
		return $this->__ProductPriceDetails;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ProductPriceDetails
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ConfigInfo
	 */
	public function setProductPriceDetails($value)
	{
		$this->__ProductPriceDetails = $value;
		return $this;
	}





	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:CONFIG_INFO');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:CONFIG_INFO');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__ConfigCode != null){
			$this->__ConfigCode->toXml($xml);
		}
		if($this->__ProductPriceDetails != null){
			$this->__ProductPriceDetails->toXml($xml);
		}


		return $xml;
	}

}
