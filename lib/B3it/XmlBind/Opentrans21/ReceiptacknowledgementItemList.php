<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	ReceiptacknowledgementItemList
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_ReceiptacknowledgementItemList extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	
	/* @var B3it_XmlBind_Opentrans21_ReceiptacknowledgementItem */
	private $__ReceiptacknowledgementItemA = array();


	

	

	
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_ReceiptacknowledgementItem and add it to list
	 * @return B3it_XmlBind_Opentrans21_ReceiptacknowledgementItem
	 */
	public function getReceiptacknowledgementItem()
	{
		$res = new B3it_XmlBind_Opentrans21_ReceiptacknowledgementItem();
		$this->__ReceiptacknowledgementItemA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_ReceiptacknowledgementItem
	 * @return B3it_XmlBind_Opentrans21_ReceiptacknowledgementItemList
	 */
	public function setReceiptacknowledgementItem($value)
	{
		$this->__ReceiptacknowledgementItemA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_ReceiptacknowledgementItem[]
	 */
	public function getAllReceiptacknowledgementItem()
	{
		return $this->__ReceiptacknowledgementItemA;
	}







	public function toXml($xml)
	{
		$node = new DOMElement('RECEIPTACKNOWLEDGEMENT_ITEM_LIST');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__ReceiptacknowledgementItemA != null){
			foreach($this->__ReceiptacknowledgementItemA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
