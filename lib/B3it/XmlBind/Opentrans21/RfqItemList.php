<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	RfqItemList
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_RfqItemList extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	
	/* @var B3it_XmlBind_Opentrans21_RfqItem */
	private $__RfqItemA = array();


	

	

	
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_RfqItem and add it to list
	 * @return B3it_XmlBind_Opentrans21_RfqItem
	 */
	public function getRfqItem()
	{
		$res = new B3it_XmlBind_Opentrans21_RfqItem();
		$this->__RfqItemA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_RfqItem
	 * @return B3it_XmlBind_Opentrans21_RfqItemList
	 */
	public function setRfqItem($value)
	{
		$this->__RfqItemA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_RfqItem[]
	 */
	public function getAllRfqItem()
	{
		return $this->__RfqItemA;
	}







	public function toXml($xml)
	{
		$node = new DOMElement('RFQ_ITEM_LIST');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__RfqItemA != null){
			foreach($this->__RfqItemA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
