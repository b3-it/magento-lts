<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	ProductComponents
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_ProductComponents extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	
	/* @var B3it_XmlBind_Opentrans21_ProductComponent */
	private $__ProductComponentA = array();


	

	

	
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_ProductComponent and add it to list
	 * @return B3it_XmlBind_Opentrans21_ProductComponent
	 */
	public function getProductComponent()
	{
		$res = new B3it_XmlBind_Opentrans21_ProductComponent();
		$this->__ProductComponentA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_ProductComponent
	 * @return B3it_XmlBind_Opentrans21_ProductComponents
	 */
	public function setProductComponent($value)
	{
		$this->__ProductComponentA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_ProductComponent[]
	 */
	public function getAllProductComponent()
	{
		return $this->__ProductComponentA;
	}







	public function toXml($xml)
	{
		$node = new DOMElement('PRODUCT_COMPONENTS');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__ProductComponentA != null){
			foreach($this->__ProductComponentA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
