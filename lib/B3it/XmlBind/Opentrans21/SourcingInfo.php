<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	SourcingInfo
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_SourcingInfo extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_QuotationId */
	private $__QuotationId = null;

	
	/* @var B3it_XmlBind_Opentrans21_Agreement */
	private $__AgreementA = array();

	/* @var B3it_XmlBind_Opentrans21_CatalogReference */
	private $__CatalogReference = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_QuotationId
	 */
	public function getQuotationId()
	{
		if($this->__QuotationId == null)
		{
			$this->__QuotationId = new B3it_XmlBind_Opentrans21_QuotationId();
		}
	
		return $this->__QuotationId;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_QuotationId
	 * @return B3it_XmlBind_Opentrans21_SourcingInfo
	 */
	public function setQuotationId($value)
	{
		$this->__QuotationId = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Agreement and add it to list
	 * @return B3it_XmlBind_Opentrans21_Agreement
	 */
	public function getAgreement()
	{
		$res = new B3it_XmlBind_Opentrans21_Agreement();
		$this->__AgreementA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Agreement
	 * @return B3it_XmlBind_Opentrans21_SourcingInfo
	 */
	public function setAgreement($value)
	{
		$this->__AgreementA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Agreement[]
	 */
	public function getAllAgreement()
	{
		return $this->__AgreementA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_CatalogReference
	 */
	public function getCatalogReference()
	{
		if($this->__CatalogReference == null)
		{
			$this->__CatalogReference = new B3it_XmlBind_Opentrans21_CatalogReference();
		}
	
		return $this->__CatalogReference;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_CatalogReference
	 * @return B3it_XmlBind_Opentrans21_SourcingInfo
	 */
	public function setCatalogReference($value)
	{
		$this->__CatalogReference = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('SOURCING_INFO');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__QuotationId != null){
			$this->__QuotationId->toXml($xml);
		}
		if($this->__AgreementA != null){
			foreach($this->__AgreementA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__CatalogReference != null){
			$this->__CatalogReference->toXml($xml);
		}


		return $xml;
	}

}
