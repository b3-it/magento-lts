<?php
/**
 *
 * XML Bind  f�r Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	AllowOrChargeBase
 * @author 		Holger K�gel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_AllowOrChargeBase extends B3it_XmlBind_Opentrans21_Bmecat_Dtfloat
{
	
	

	

	

	





	public function toXml($xml)
	{
		$node = new DOMElement('ALLOW_OR_CHARGE_BASE');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		

		$xml = parent::toXml($xml);

		return $xml;
	}

}