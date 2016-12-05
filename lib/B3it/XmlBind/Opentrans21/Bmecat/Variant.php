<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_Variant
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_Variant extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_Fvalue */
	private $__FvalueA = array();

	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_ValueIdref */
	private $__ValueIdrefA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_SupplierAidSupplement */
	private $__SupplierAidSupplement = null;


	

	

	
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_Fvalue and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Fvalue
	 */
	public function getFvalue()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_Fvalue();
		$this->__FvalueA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Fvalue
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Variant
	 */
	public function setFvalue($value)
	{
		$this->__FvalueA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Fvalue[]
	 */
	public function getAllFvalue()
	{
		return $this->__FvalueA;
	}


	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_ValueIdref and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ValueIdref
	 */
	public function getValueIdref()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_ValueIdref();
		$this->__ValueIdrefA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_ValueIdref
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Variant
	 */
	public function setValueIdref($value)
	{
		$this->__ValueIdrefA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_ValueIdref[]
	 */
	public function getAllValueIdref()
	{
		return $this->__ValueIdrefA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_SupplierAidSupplement
	 */
	public function getSupplierAidSupplement()
	{
		if($this->__SupplierAidSupplement == null)
		{
			$this->__SupplierAidSupplement = new B3it_XmlBind_Opentrans21_Bmecat_SupplierAidSupplement();
		}
	
		return $this->__SupplierAidSupplement;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_SupplierAidSupplement
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Variant
	 */
	public function setSupplierAidSupplement($value)
	{
		$this->__SupplierAidSupplement = $value;
		return $this;
	}





	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:VARIANT');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:VARIANT');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__FvalueA != null){
			foreach($this->__FvalueA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__ValueIdrefA != null){
			foreach($this->__ValueIdrefA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__SupplierAidSupplement != null){
			$this->__SupplierAidSupplement->toXml($xml);
		}


		return $xml;
	}

}
