<?php
/**
 *
 * XML Bind  f�r WMS 1.3
 * @category   	B3it
 * @package    	B3it_XmlBind_Wms13_
 * @name       	Addresstype
 * @author 		Holger K�gel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Wms13_Addresstype extends B3it_XmlBind_Wms13_XmlObject
{
	
	

	

	

	





	public function toXml($xml)
	{
		$node = new DOMElement('AddressType');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		


		return $xml;
	}

}
