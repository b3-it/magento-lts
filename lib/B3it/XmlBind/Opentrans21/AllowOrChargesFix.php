<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	AllowOrChargesFix
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_AllowOrChargesFix extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	
	/* @var B3it_XmlBind_Opentrans21_AllowOrCharge */
	private $__AllowOrChargeA = array();

	/* @var B3it_XmlBind_Opentrans21_AllowOrChargesTotalAmount */
	private $__AllowOrChargesTotalAmount = null;


	

	

	
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_AllowOrCharge and add it to list
	 * @return B3it_XmlBind_Opentrans21_AllowOrCharge
	 */
	public function getAllowOrCharge()
	{
		$res = new B3it_XmlBind_Opentrans21_AllowOrCharge();
		$this->__AllowOrChargeA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_AllowOrCharge
	 * @return B3it_XmlBind_Opentrans21_AllowOrChargesFix
	 */
	public function setAllowOrCharge($value)
	{
		$this->__AllowOrChargeA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_AllowOrCharge[]
	 */
	public function getAllAllowOrCharge()
	{
		return $this->__AllowOrChargeA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_AllowOrChargesTotalAmount
	 */
	public function getAllowOrChargesTotalAmount()
	{
		if($this->__AllowOrChargesTotalAmount == null)
		{
			$this->__AllowOrChargesTotalAmount = new B3it_XmlBind_Opentrans21_AllowOrChargesTotalAmount();
		}
	
		return $this->__AllowOrChargesTotalAmount;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_AllowOrChargesTotalAmount
	 * @return B3it_XmlBind_Opentrans21_AllowOrChargesFix
	 */
	public function setAllowOrChargesTotalAmount($value)
	{
		$this->__AllowOrChargesTotalAmount = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('ALLOW_OR_CHARGES_FIX');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__AllowOrChargeA != null){
			foreach($this->__AllowOrChargeA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__AllowOrChargesTotalAmount != null){
			$this->__AllowOrChargesTotalAmount->toXml($xml);
		}


		return $xml;
	}

}
