<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	AllowOrChargeValue
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_AllowOrChargeValue extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_AocPercentageFactor */
	private $__AocPercentageFactor = null;

	/* @var B3it_XmlBind_Opentrans21_AocMonetaryAmount */
	private $__AocMonetaryAmount = null;

	/* @var B3it_XmlBind_Opentrans21_AocOrderUnitsCount */
	private $__AocOrderUnitsCount = null;

	/* @var B3it_XmlBind_Opentrans21_AocAdditionalItems */
	private $__AocAdditionalItems = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_AocPercentageFactor
	 */
	public function getAocPercentageFactor()
	{
		if($this->__AocPercentageFactor == null)
		{
			$this->__AocPercentageFactor = new B3it_XmlBind_Opentrans21_AocPercentageFactor();
		}
	
		return $this->__AocPercentageFactor;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_AocPercentageFactor
	 * @return B3it_XmlBind_Opentrans21_AllowOrChargeValue
	 */
	public function setAocPercentageFactor($value)
	{
		$this->__AocPercentageFactor = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_AocMonetaryAmount
	 */
	public function getAocMonetaryAmount()
	{
		if($this->__AocMonetaryAmount == null)
		{
			$this->__AocMonetaryAmount = new B3it_XmlBind_Opentrans21_AocMonetaryAmount();
		}
	
		return $this->__AocMonetaryAmount;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_AocMonetaryAmount
	 * @return B3it_XmlBind_Opentrans21_AllowOrChargeValue
	 */
	public function setAocMonetaryAmount($value)
	{
		$this->__AocMonetaryAmount = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_AocOrderUnitsCount
	 */
	public function getAocOrderUnitsCount()
	{
		if($this->__AocOrderUnitsCount == null)
		{
			$this->__AocOrderUnitsCount = new B3it_XmlBind_Opentrans21_AocOrderUnitsCount();
		}
	
		return $this->__AocOrderUnitsCount;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_AocOrderUnitsCount
	 * @return B3it_XmlBind_Opentrans21_AllowOrChargeValue
	 */
	public function setAocOrderUnitsCount($value)
	{
		$this->__AocOrderUnitsCount = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_AocAdditionalItems
	 */
	public function getAocAdditionalItems()
	{
		if($this->__AocAdditionalItems == null)
		{
			$this->__AocAdditionalItems = new B3it_XmlBind_Opentrans21_AocAdditionalItems();
		}
	
		return $this->__AocAdditionalItems;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_AocAdditionalItems
	 * @return B3it_XmlBind_Opentrans21_AllowOrChargeValue
	 */
	public function setAocAdditionalItems($value)
	{
		$this->__AocAdditionalItems = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('ALLOW_OR_CHARGE_VALUE');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__AocPercentageFactor != null){
			$this->__AocPercentageFactor->toXml($xml);
		}
		if($this->__AocMonetaryAmount != null){
			$this->__AocMonetaryAmount->toXml($xml);
		}
		if($this->__AocOrderUnitsCount != null){
			$this->__AocOrderUnitsCount->toXml($xml);
		}
		if($this->__AocAdditionalItems != null){
			$this->__AocAdditionalItems->toXml($xml);
		}


		return $xml;
	}

}
