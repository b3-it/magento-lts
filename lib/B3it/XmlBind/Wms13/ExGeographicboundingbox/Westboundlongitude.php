<?php
/**
 *
 * XML Bind  f�r WMS 1.3
 * @category   	B3it
 * @package    	B3it_XmlBind_Wms13_
 * @name       	ExGeographicboundingbox_Westboundlongitude
 * @author 		Holger K�gel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Wms13_ExGeographicboundingbox_Westboundlongitude extends B3it_XmlBind_Wms13_Longitudetype
{
	
	

	

	

	





	public function toXml($xml)
	{
		$node = new DOMElement('westBoundLongitude');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		

		$xml = parent::toXml($xml);

		return $xml;
	}

}