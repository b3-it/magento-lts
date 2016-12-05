<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	AllowOrCharges
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_AllowOrCharges extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	
	/* @var B3it_XmlBind_Opentrans21_AllowOrCharge */
	private $__AllowOrChargeA = array();


	

	

	
	

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
	 * @return B3it_XmlBind_Opentrans21_AllowOrCharges
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







	public function toXml($xml)
	{
		$node = new DOMElement('ALLOW_OR_CHARGES');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__AllowOrChargeA != null){
			foreach($this->__AllowOrChargeA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
