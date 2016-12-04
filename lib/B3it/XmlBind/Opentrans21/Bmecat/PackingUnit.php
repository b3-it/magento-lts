<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_PackingUnit
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_PackingUnit extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_QuantityMin */
	private $__QuantityMin = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_QuantityMax */
	private $__QuantityMax = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_PackingUnitCode */
	private $__PackingUnitCode = null;

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_PackingUnitDescr */
	private $__PackingUnitDescrA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_SupplierPid */
	private $__SupplierPid = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_SupplierPidref */
	private $__SupplierPidref = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_SupplierIdref */
	private $__SupplierIdref = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_QuantityMin
	 */
	public function getQuantityMin()
	{
		if($this->__QuantityMin == null)
		{
			$this->__QuantityMin = new B3it_XmlBind_Opentrans21_Bmecat_QuantityMin();
		}
	
		return $this->__QuantityMin;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_QuantityMin
	 * @return B3it_XmlBind_Opentrans21_Bmecat_PackingUnit
	 */
	public function setQuantityMin($value)
	{
		$this->__QuantityMin = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_QuantityMax
	 */
	public function getQuantityMax()
	{
		if($this->__QuantityMax == null)
		{
			$this->__QuantityMax = new B3it_XmlBind_Opentrans21_Bmecat_QuantityMax();
		}
	
		return $this->__QuantityMax;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_QuantityMax
	 * @return B3it_XmlBind_Opentrans21_Bmecat_PackingUnit
	 */
	public function setQuantityMax($value)
	{
		$this->__QuantityMax = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_PackingUnitCode
	 */
	public function getPackingUnitCode()
	{
		if($this->__PackingUnitCode == null)
		{
			$this->__PackingUnitCode = new B3it_XmlBind_Opentrans21_Bmecat_PackingUnitCode();
		}
	
		return $this->__PackingUnitCode;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_PackingUnitCode
	 * @return B3it_XmlBind_Opentrans21_Bmecat_PackingUnit
	 */
	public function setPackingUnitCode($value)
	{
		$this->__PackingUnitCode = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_PackingUnitDescr and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_PackingUnitDescr
	 */
	public function getPackingUnitDescr()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_PackingUnitDescr();
		$this->__PackingUnitDescrA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_PackingUnitDescr
	 * @return B3it_XmlBind_Opentrans21_Bmecat_PackingUnit
	 */
	public function setPackingUnitDescr($value)
	{
		$this->__PackingUnitDescrA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_PackingUnitDescr[]
	 */
	public function getAllPackingUnitDescr()
	{
		return $this->__PackingUnitDescrA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_SupplierPid
	 */
	public function getSupplierPid()
	{
		if($this->__SupplierPid == null)
		{
			$this->__SupplierPid = new B3it_XmlBind_Opentrans21_Bmecat_SupplierPid();
		}
	
		return $this->__SupplierPid;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_SupplierPid
	 * @return B3it_XmlBind_Opentrans21_Bmecat_PackingUnit
	 */
	public function setSupplierPid($value)
	{
		$this->__SupplierPid = $value;
		return $this;
	}
	
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
	 * @return B3it_XmlBind_Opentrans21_Bmecat_PackingUnit
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
	 * @return B3it_XmlBind_Opentrans21_Bmecat_PackingUnit
	 */
	public function setSupplierIdref($value)
	{
		$this->__SupplierIdref = $value;
		return $this;
	}





	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:PACKING_UNIT');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:PACKING_UNIT');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__QuantityMin != null){
			$this->__QuantityMin->toXml($xml);
		}
		if($this->__QuantityMax != null){
			$this->__QuantityMax->toXml($xml);
		}
		if($this->__PackingUnitCode != null){
			$this->__PackingUnitCode->toXml($xml);
		}
		if($this->__PackingUnitDescrA != null){
			foreach($this->__PackingUnitDescrA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__SupplierPid != null){
			$this->__SupplierPid->toXml($xml);
		}
		if($this->__SupplierPidref != null){
			$this->__SupplierPidref->toXml($xml);
		}
		if($this->__SupplierIdref != null){
			$this->__SupplierIdref->toXml($xml);
		}


		return $xml;
	}

}
