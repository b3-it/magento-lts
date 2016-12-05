<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	PartialDeliveryList
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_PartialDeliveryList extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	
	/* @var B3it_XmlBind_Opentrans21_PartialDelivery */
	private $__PartialDeliveryA = array();


	

	

	
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_PartialDelivery and add it to list
	 * @return B3it_XmlBind_Opentrans21_PartialDelivery
	 */
	public function getPartialDelivery()
	{
		$res = new B3it_XmlBind_Opentrans21_PartialDelivery();
		$this->__PartialDeliveryA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_PartialDelivery
	 * @return B3it_XmlBind_Opentrans21_PartialDeliveryList
	 */
	public function setPartialDelivery($value)
	{
		$this->__PartialDeliveryA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_PartialDelivery[]
	 */
	public function getAllPartialDelivery()
	{
		return $this->__PartialDeliveryA;
	}







	public function toXml($xml)
	{
		$node = new DOMElement('PARTIAL_DELIVERY_LIST');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__PartialDeliveryA != null){
			foreach($this->__PartialDeliveryA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
