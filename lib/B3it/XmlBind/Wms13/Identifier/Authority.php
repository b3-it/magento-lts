<?php
/**
 *
 * XML Bind  f�r Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Wms13_
 * @name       	Identifier_Authority
 * @author 		Holger K�gel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Wms13_Identifier_Authority extends B3it_XmlBind_Wms13_XmlObject
{
	
	

	

	

	





	public function toXml($xml)
	{
		$node = new DOMElement('authority');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		


		return $xml;
	}

}
