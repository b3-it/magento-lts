<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_TaxDetails
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_TaxDetails extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_CalculationSequence */
	private $__CalculationSequence = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_TaxCategory */
	private $__TaxCategory = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_TaxType */
	private $__TaxType = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_Tax */
	private $__Tax = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_ExemptionReason */
	private $__ExemptionReasonA = array();

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_Jurisdiction */
	private $__JurisdictionA = array();


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_CalculationSequence
	 */
	public function getCalculationSequence()
	{
		if($this->__CalculationSequence == null)
		{
			$this->__CalculationSequence = new B3it_XmlBind_Opentrans21_Bmecat_CalculationSequence();
		}
	
		return $this->__CalculationSequence;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_CalculationSequence
	 * @return B3it_XmlBind_Opentrans21_Bmecat_TaxDetails
	 */
	public function setCalculationSequence($value)
	{
		$this->__CalculationSequence = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_TaxCategory
	 */
	public function getTaxCategory()
	{
		if($this->__TaxCategory == null)
		{
			$this->__TaxCategory = new B3it_XmlBind_Opentrans21_Bmecat_TaxCategory();
		}
	
		return $this->__TaxCategory;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_TaxCategory
	 * @return B3it_XmlBind_Opentrans21_Bmecat_TaxDetails
	 */
	public function setTaxCategory($value)
	{
		$this->__TaxCategory = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_TaxType
	 */
	public function getTaxType()
	{
		if($this->__TaxType == null)
		{
			$this->__TaxType = new B3it_XmlBind_Opentrans21_Bmecat_TaxType();
		}
	
		return $this->__TaxType;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_TaxType
	 * @return B3it_XmlBind_Opentrans21_Bmecat_TaxDetails
	 */
	public function setTaxType($value)
	{
		$this->__TaxType = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Tax
	 */
	public function getTax()
	{
		if($this->__Tax == null)
		{
			$this->__Tax = new B3it_XmlBind_Opentrans21_Bmecat_Tax();
		}
	
		return $this->__Tax;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Tax
	 * @return B3it_XmlBind_Opentrans21_Bmecat_TaxDetails
	 */
	public function setTax($value)
	{
		$this->__Tax = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_ExemptionReason and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ExemptionReason
	 */
	public function getExemptionReason()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_ExemptionReason();
		$this->__ExemptionReasonA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ExemptionReason
	 * @return B3it_XmlBind_Opentrans21_Bmecat_TaxDetails
	 */
	public function setExemptionReason($value)
	{
		$this->__ExemptionReasonA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ExemptionReason[]
	 */
	public function getAllExemptionReason()
	{
		return $this->__ExemptionReasonA;
	}


	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_Jurisdiction and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Jurisdiction
	 */
	public function getJurisdiction()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_Jurisdiction();
		$this->__JurisdictionA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Jurisdiction
	 * @return B3it_XmlBind_Opentrans21_Bmecat_TaxDetails
	 */
	public function setJurisdiction($value)
	{
		$this->__JurisdictionA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Jurisdiction[]
	 */
	public function getAllJurisdiction()
	{
		return $this->__JurisdictionA;
	}







	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:TAX_DETAILS');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:TAX_DETAILS');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__CalculationSequence != null){
			$this->__CalculationSequence->toXml($xml);
		}
		if($this->__TaxCategory != null){
			$this->__TaxCategory->toXml($xml);
		}
		if($this->__TaxType != null){
			$this->__TaxType->toXml($xml);
		}
		if($this->__Tax != null){
			$this->__Tax->toXml($xml);
		}
		if($this->__ExemptionReasonA != null){
			foreach($this->__ExemptionReasonA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__JurisdictionA != null){
			foreach($this->__JurisdictionA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
