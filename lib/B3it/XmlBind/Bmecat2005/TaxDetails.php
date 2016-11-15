<?php
class B3it_XmlBind_Bmecat2005_TaxDetails extends B3it_XmlBind_Bmecat2005_XmlBind
{
	private $_attributes = array();



	/* @var CalculationSequence */
	private $_CalculationSequence = null;	

	/* @var TaxCategory */
	private $_TaxCategory = null;	

	/* @var TaxType */
	private $_TaxType = null;	

	/* @var Tax */
	private $_Tax = null;	

	/* @var ExemptionReason */
	private $_ExemptionReasons = array();	

	/* @var Jurisdiction */
	private $_Jurisdictions = array();	

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
	 * @return B3it_XmlBind_Bmecat2005_CalculationSequence
	 */
	public function getCalculationSequence()
	{
		if($this->_CalculationSequence == null)
		{
			$this->_CalculationSequence = new B3it_XmlBind_Bmecat2005_CalculationSequence();
		}
		
		return $this->_CalculationSequence;
	}
	
	/**
	 * @param $value CalculationSequence
	 * @return B3it_XmlBind_Bmecat2005_TaxDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setCalculationSequence($value)
	{
		$this->_CalculationSequence = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_TaxCategory
	 */
	public function getTaxCategory()
	{
		if($this->_TaxCategory == null)
		{
			$this->_TaxCategory = new B3it_XmlBind_Bmecat2005_TaxCategory();
		}
		
		return $this->_TaxCategory;
	}
	
	/**
	 * @param $value TaxCategory
	 * @return B3it_XmlBind_Bmecat2005_TaxDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setTaxCategory($value)
	{
		$this->_TaxCategory = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_TaxType
	 */
	public function getTaxType()
	{
		if($this->_TaxType == null)
		{
			$this->_TaxType = new B3it_XmlBind_Bmecat2005_TaxType();
		}
		
		return $this->_TaxType;
	}
	
	/**
	 * @param $value TaxType
	 * @return B3it_XmlBind_Bmecat2005_TaxDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setTaxType($value)
	{
		$this->_TaxType = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_Tax
	 */
	public function getTax()
	{
		if($this->_Tax == null)
		{
			$this->_Tax = new B3it_XmlBind_Bmecat2005_Tax();
		}
		
		return $this->_Tax;
	}
	
	/**
	 * @param $value Tax
	 * @return B3it_XmlBind_Bmecat2005_TaxDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setTax($value)
	{
		$this->_Tax = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_ExemptionReason[]
	 */
	public function getAllExemptionReason()
	{
		return $this->_ExemptionReasons;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_ExemptionReason and add it to list
	 * @return B3it_XmlBind_Bmecat2005_ExemptionReason
	 */
	public function getExemptionReason()
	{
		$res = new B3it_XmlBind_Bmecat2005_ExemptionReason();
		$this->_ExemptionReasons[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value ExemptionReason[]
	 * @return B3it_XmlBind_Bmecat2005_TaxDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setExemptionReason($value)
	{
		$this->_ExemptionReason = $value;
		return $this;
	}

	/**
	 * @return B3it_XmlBind_Bmecat2005_Jurisdiction[]
	 */
	public function getAllJurisdiction()
	{
		return $this->_Jurisdictions;
	}
	
	/**
	 * Create new B3it_XmlBind_Bmecat2005_Jurisdiction and add it to list
	 * @return B3it_XmlBind_Bmecat2005_Jurisdiction
	 */
	public function getJurisdiction()
	{
		$res = new B3it_XmlBind_Bmecat2005_Jurisdiction();
		$this->_Jurisdictions[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value Jurisdiction[]
	 * @return B3it_XmlBind_Bmecat2005_TaxDetails extends B3it_XmlBind_Bmecat2005_XmlBind
	 */
	public function setJurisdiction($value)
	{
		$this->_Jurisdiction = $value;
		return $this;
	}
	public function toXml($xml){
		 $node = new DOMElement('TAX_DETAILS');
		 $xml = $xml->appendChild($node);

		foreach($this->_attributes as $key => $value){
			$xml->setAttribute($key,$value);
		}

		if($this->_CalculationSequence != null){
			$this->_CalculationSequence->toXml($xml);
		}
		if($this->_TaxCategory != null){
			$this->_TaxCategory->toXml($xml);
		}
		if($this->_TaxType != null){
			$this->_TaxType->toXml($xml);
		}
		if($this->_Tax != null){
			$this->_Tax->toXml($xml);
		}
		if($this->_ExemptionReasons != null){
			foreach($this->_ExemptionReasons as $item){
				$item->toXml($xml);
			}
		}
		if($this->_Jurisdictions != null){
			foreach($this->_Jurisdictions as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}
}