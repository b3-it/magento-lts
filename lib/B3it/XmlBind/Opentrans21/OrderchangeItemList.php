<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	OrderchangeItemList
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_OrderchangeItemList extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	
	/* @var B3it_XmlBind_Opentrans21_OrderItem */
	private $__OrderItemA = array();


	

	

	
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_OrderItem and add it to list
	 * @return B3it_XmlBind_Opentrans21_OrderItem
	 */
	public function getOrderItem()
	{
		$res = new B3it_XmlBind_Opentrans21_OrderItem();
		$this->__OrderItemA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_OrderItem
	 * @return B3it_XmlBind_Opentrans21_OrderchangeItemList
	 */
	public function setOrderItem($value)
	{
		$this->__OrderItemA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_OrderItem[]
	 */
	public function getAllOrderItem()
	{
		return $this->__OrderItemA;
	}







	public function toXml($xml)
	{
		$node = new DOMElement('ORDERCHANGE_ITEM_LIST');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__OrderItemA != null){
			foreach($this->__OrderItemA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
