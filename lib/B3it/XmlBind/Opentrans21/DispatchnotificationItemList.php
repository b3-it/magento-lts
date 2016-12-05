<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	DispatchnotificationItemList
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_DispatchnotificationItemList extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	
	/* @var B3it_XmlBind_Opentrans21_DispatchnotificationItem */
	private $__DispatchnotificationItemA = array();


	

	

	
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_DispatchnotificationItem and add it to list
	 * @return B3it_XmlBind_Opentrans21_DispatchnotificationItem
	 */
	public function getDispatchnotificationItem()
	{
		$res = new B3it_XmlBind_Opentrans21_DispatchnotificationItem();
		$this->__DispatchnotificationItemA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_DispatchnotificationItem
	 * @return B3it_XmlBind_Opentrans21_DispatchnotificationItemList
	 */
	public function setDispatchnotificationItem($value)
	{
		$this->__DispatchnotificationItemA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_DispatchnotificationItem[]
	 */
	public function getAllDispatchnotificationItem()
	{
		return $this->__DispatchnotificationItemA;
	}







	public function toXml($xml)
	{
		$node = new DOMElement('DISPATCHNOTIFICATION_ITEM_LIST');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__DispatchnotificationItemA != null){
			foreach($this->__DispatchnotificationItemA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
