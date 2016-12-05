<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_PartAlternative
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_PartAlternative extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_SupplierPidref */
	private $__SupplierPidref = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_SupplierIdref */
	private $__SupplierIdref = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_ProductOrder */
	private $__ProductOrder = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_DefaultFlag */
	private $__DefaultFlag = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_ConfigCode */
	private $__ConfigCode = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_ProductPriceDetails */
	private $__ProductPriceDetails = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_SupplierPidref
	 */
	public function getSupplierPidref()
	{
		if($this->__SupplierPidref == null)
		{
			$this->__SupplierPidref = new B3it_XmlBind_Opentrans21_Bmecat_SupplierPidref();
		}
	
		return $this->__SupplierPidref;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_SupplierPidref
	 * @return B3it_XmlBind_Opentrans21_Bmecat_PartAlternative
	 */
	public function setSupplierPidref($value)
	{
		$this->__SupplierPidref = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_SupplierIdref
	 */
	public function getSupplierIdref()
	{
		if($this->__SupplierIdref == null)
		{
			$this->__SupplierIdref = new B3it_XmlBind_Opentrans21_Bmecat_SupplierIdref();
		}
	
		return $this->__SupplierIdref;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_SupplierIdref
	 * @return B3it_XmlBind_Opentrans21_Bmecat_PartAlternative
	 */
	public function setSupplierIdref($value)
	{
		$this->__SupplierIdref = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ProductOrder
	 */
	public function getProductOrder()
	{
		if($this->__ProductOrder == null)
		{
			$this->__ProductOrder = new B3it_XmlBind_Opentrans21_Bmecat_ProductOrder();
		}
	
		return $this->__ProductOrder;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ProductOrder
	 * @return B3it_XmlBind_Opentrans21_Bmecat_PartAlternative
	 */
	public function setProductOrder($value)
	{
		$this->__ProductOrder = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_DefaultFlag
	 */
	public function getDefaultFlag()
	{
		if($this->__DefaultFlag == null)
		{
			$this->__DefaultFlag = new B3it_XmlBind_Opentrans21_Bmecat_DefaultFlag();
		}
	
		return $this->__DefaultFlag;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_DefaultFlag
	 * @return B3it_XmlBind_Opentrans21_Bmecat_PartAlternative
	 */
	public function setDefaultFlag($value)
	{
		$this->__DefaultFlag = $value;
		return $this;
	}
	
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
	 * @return B3it_XmlBind_Opentrans21_Bmecat_PartAlternative
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
	 * @return B3it_XmlBind_Opentrans21_Bmecat_PartAlternative
	 */
	public function setProductPriceDetails($value)
	{
		$this->__ProductPriceDetails = $value;
		return $this;
	}





	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:PART_ALTERNATIVE');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:PART_ALTERNATIVE');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__SupplierPidref != null){
			$this->__SupplierPidref->toXml($xml);
		}
		if($this->__SupplierIdref != null){
			$this->__SupplierIdref->toXml($xml);
		}
		if($this->__ProductOrder != null){
			$this->__ProductOrder->toXml($xml);
		}
		if($this->__DefaultFlag != null){
			$this->__DefaultFlag->toXml($xml);
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
