<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	OrderresponseItemList
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_OrderresponseItemList extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	
	/* @var B3it_XmlBind_Opentrans21_OrderresponseItem */
	private $__OrderresponseItemA = array();


	

	

	
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_OrderresponseItem and add it to list
	 * @return B3it_XmlBind_Opentrans21_OrderresponseItem
	 */
	public function getOrderresponseItem()
	{
		$res = new B3it_XmlBind_Opentrans21_OrderresponseItem();
		$this->__OrderresponseItemA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_OrderresponseItem
	 * @return B3it_XmlBind_Opentrans21_OrderresponseItemList
	 */
	public function setOrderresponseItem($value)
	{
		$this->__OrderresponseItemA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_OrderresponseItem[]
	 */
	public function getAllOrderresponseItem()
	{
		return $this->__OrderresponseItemA;
	}







	public function toXml($xml)
	{
		$node = new DOMElement('ORDERRESPONSE_ITEM_LIST');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__OrderresponseItemA != null){
			foreach($this->__OrderresponseItemA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
