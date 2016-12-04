<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_ProductIppDetails
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_ProductIppDetails extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_Ipp */
	private $__IppA = array();


	

	

	
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_Ipp and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Ipp
	 */
	public function getIpp()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_Ipp();
		$this->__IppA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Ipp
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ProductIppDetails
	 */
	public function setIpp($value)
	{
		$this->__IppA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Ipp[]
	 */
	public function getAllIpp()
	{
		return $this->__IppA;
	}







	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:PRODUCT_IPP_DETAILS');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:PRODUCT_IPP_DETAILS');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__IppA != null){
			foreach($this->__IppA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
