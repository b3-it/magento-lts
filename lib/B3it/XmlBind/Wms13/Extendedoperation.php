<?php
/**
 *
 * XML Bind  für WMS 1.3
 * @category   	B3it
 * @package    	B3it_XmlBind_Wms13_
 * @name       	Extendedoperation
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Wms13_Extendedoperation extends B3it_XmlBind_Wms13_Operationtype
{
	
	

	

	

	





	public function toXml($xml)
	{
		$node = new DOMElement('_ExtendedOperation');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		

		$xml = parent::toXml($xml);

		return $xml;
	}

}
