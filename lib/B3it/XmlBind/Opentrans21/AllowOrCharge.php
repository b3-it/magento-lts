<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	AllowOrCharge
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_AllowOrCharge extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_AllowOrChargeSequence */
	private $__AllowOrChargeSequence = null;

	
	/* @var B3it_XmlBind_Opentrans21_AllowOrChargeName */
	private $__AllowOrChargeNameA = array();

	/* @var B3it_XmlBind_Opentrans21_AllowOrChargeType */
	private $__AllowOrChargeType = null;

	
	/* @var B3it_XmlBind_Opentrans21_AllowOrChargeDescr */
	private $__AllowOrChargeDescrA = array();

	/* @var B3it_XmlBind_Opentrans21_AllowOrChargeValue */
	private $__AllowOrChargeValue = null;

	/* @var B3it_XmlBind_Opentrans21_AllowOrChargeBase */
	private $__AllowOrChargeBase = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_AllowOrChargeSequence
	 */
	public function getAllowOrChargeSequence()
	{
		if($this->__AllowOrChargeSequence == null)
		{
			$this->__AllowOrChargeSequence = new B3it_XmlBind_Opentrans21_AllowOrChargeSequence();
		}
	
		return $this->__AllowOrChargeSequence;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_AllowOrChargeSequence
	 * @return B3it_XmlBind_Opentrans21_AllowOrCharge
	 */
	public function setAllowOrChargeSequence($value)
	{
		$this->__AllowOrChargeSequence = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_AllowOrChargeName and add it to list
	 * @return B3it_XmlBind_Opentrans21_AllowOrChargeName
	 */
	public function getAllowOrChargeName()
	{
		$res = new B3it_XmlBind_Opentrans21_AllowOrChargeName();
		$this->__AllowOrChargeNameA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_AllowOrChargeName
	 * @return B3it_XmlBind_Opentrans21_AllowOrCharge
	 */
	public function setAllowOrChargeName($value)
	{
		$this->__AllowOrChargeNameA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_AllowOrChargeName[]
	 */
	public function getAllAllowOrChargeName()
	{
		return $this->__AllowOrChargeNameA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_AllowOrChargeType
	 */
	public function getAllowOrChargeType()
	{
		if($this->__AllowOrChargeType == null)
		{
			$this->__AllowOrChargeType = new B3it_XmlBind_Opentrans21_AllowOrChargeType();
		}
	
		return $this->__AllowOrChargeType;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_AllowOrChargeType
	 * @return B3it_XmlBind_Opentrans21_AllowOrCharge
	 */
	public function setAllowOrChargeType($value)
	{
		$this->__AllowOrChargeType = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_AllowOrChargeDescr and add it to list
	 * @return B3it_XmlBind_Opentrans21_AllowOrChargeDescr
	 */
	public function getAllowOrChargeDescr()
	{
		$res = new B3it_XmlBind_Opentrans21_AllowOrChargeDescr();
		$this->__AllowOrChargeDescrA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_AllowOrChargeDescr
	 * @return B3it_XmlBind_Opentrans21_AllowOrCharge
	 */
	public function setAllowOrChargeDescr($value)
	{
		$this->__AllowOrChargeDescrA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_AllowOrChargeDescr[]
	 */
	public function getAllAllowOrChargeDescr()
	{
		return $this->__AllowOrChargeDescrA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_AllowOrChargeValue
	 */
	public function getAllowOrChargeValue()
	{
		if($this->__AllowOrChargeValue == null)
		{
			$this->__AllowOrChargeValue = new B3it_XmlBind_Opentrans21_AllowOrChargeValue();
		}
	
		return $this->__AllowOrChargeValue;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_AllowOrChargeValue
	 * @return B3it_XmlBind_Opentrans21_AllowOrCharge
	 */
	public function setAllowOrChargeValue($value)
	{
		$this->__AllowOrChargeValue = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_AllowOrChargeBase
	 */
	public function getAllowOrChargeBase()
	{
		if($this->__AllowOrChargeBase == null)
		{
			$this->__AllowOrChargeBase = new B3it_XmlBind_Opentrans21_AllowOrChargeBase();
		}
	
		return $this->__AllowOrChargeBase;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_AllowOrChargeBase
	 * @return B3it_XmlBind_Opentrans21_AllowOrCharge
	 */
	public function setAllowOrChargeBase($value)
	{
		$this->__AllowOrChargeBase = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('ALLOW_OR_CHARGE');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__AllowOrChargeSequence != null){
			$this->__AllowOrChargeSequence->toXml($xml);
		}
		if($this->__AllowOrChargeNameA != null){
			foreach($this->__AllowOrChargeNameA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__AllowOrChargeType != null){
			$this->__AllowOrChargeType->toXml($xml);
		}
		if($this->__AllowOrChargeDescrA != null){
			foreach($this->__AllowOrChargeDescrA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__AllowOrChargeValue != null){
			$this->__AllowOrChargeValue->toXml($xml);
		}
		if($this->__AllowOrChargeBase != null){
			$this->__AllowOrChargeBase->toXml($xml);
		}


		return $xml;
	}

}
