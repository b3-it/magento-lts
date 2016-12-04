<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_PackingUnits
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_PackingUnits extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_PackingUnit */
	private $__PackingUnitA = array();


	

	

	
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_PackingUnit and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_PackingUnit
	 */
	public function getPackingUnit()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_PackingUnit();
		$this->__PackingUnitA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_PackingUnit
	 * @return B3it_XmlBind_Opentrans21_Bmecat_PackingUnits
	 */
	public function setPackingUnit($value)
	{
		$this->__PackingUnitA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_PackingUnit[]
	 */
	public function getAllPackingUnit()
	{
		return $this->__PackingUnitA;
	}







	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:PACKING_UNITS');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:PACKING_UNITS');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__PackingUnitA != null){
			foreach($this->__PackingUnitA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
