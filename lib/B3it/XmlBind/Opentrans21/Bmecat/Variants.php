<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_Variants
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_Variants extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_Variant */
	private $__VariantA = array();

	/* @var B3it_XmlBind_Opentrans21_Bmecat_Vorder */
	private $__Vorder = null;


	

	

	
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Bmecat_Variant and add it to list
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Variant
	 */
	public function getVariant()
	{
		$res = new B3it_XmlBind_Opentrans21_Bmecat_Variant();
		$this->__VariantA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Variant
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Variants
	 */
	public function setVariant($value)
	{
		$this->__VariantA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Variant[]
	 */
	public function getAllVariant()
	{
		return $this->__VariantA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Vorder
	 */
	public function getVorder()
	{
		if($this->__Vorder == null)
		{
			$this->__Vorder = new B3it_XmlBind_Opentrans21_Bmecat_Vorder();
		}
	
		return $this->__Vorder;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_Vorder
	 * @return B3it_XmlBind_Opentrans21_Bmecat_Variants
	 */
	public function setVorder($value)
	{
		$this->__Vorder = $value;
		return $this;
	}





	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:VARIANTS');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:VARIANTS');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__VariantA != null){
			foreach($this->__VariantA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__Vorder != null){
			$this->__Vorder->toXml($xml);
		}


		return $xml;
	}

}
