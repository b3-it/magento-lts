<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	TotalTax
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_TotalTax extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	
	/* @var B3it_XmlBind_Opentrans21_TaxDetailsFix */
	private $__TaxDetailsFixA = array();


	

	

	
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_TaxDetailsFix and add it to list
	 * @return B3it_XmlBind_Opentrans21_TaxDetailsFix
	 */
	public function getTaxDetailsFix()
	{
		$res = new B3it_XmlBind_Opentrans21_TaxDetailsFix();
		$this->__TaxDetailsFixA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_TaxDetailsFix
	 * @return B3it_XmlBind_Opentrans21_TotalTax
	 */
	public function setTaxDetailsFix($value)
	{
		$this->__TaxDetailsFixA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_TaxDetailsFix[]
	 */
	public function getAllTaxDetailsFix()
	{
		return $this->__TaxDetailsFixA;
	}







	public function toXml($xml)
	{
		$node = new DOMElement('TOTAL_TAX');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__TaxDetailsFixA != null){
			foreach($this->__TaxDetailsFixA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
