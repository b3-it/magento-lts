<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	SupplierParty
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_SupplierParty extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_Party */
	private $__Party = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Party
	 */
	public function getParty()
	{
		if($this->__Party == null)
		{
			$this->__Party = new B3it_XmlBind_Opentrans21_Bmecat_Party();
		}
	
		return $this->__Party;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Party
	 * @return B3it_XmlBind_Opentrans21_SupplierParty
	 */
	public function setParty($value)
	{
		$this->__Party = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('SUPPLIER_PARTY');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__Party != null){
			$this->__Party->toXml($xml);
		}


		return $xml;
	}

}
