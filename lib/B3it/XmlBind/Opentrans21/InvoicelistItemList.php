<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	InvoicelistItemList
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_InvoicelistItemList extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	
	/* @var B3it_XmlBind_Opentrans21_InvoicelistItem */
	private $__InvoicelistItemA = array();


	

	

	
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_InvoicelistItem and add it to list
	 * @return B3it_XmlBind_Opentrans21_InvoicelistItem
	 */
	public function getInvoicelistItem()
	{
		$res = new B3it_XmlBind_Opentrans21_InvoicelistItem();
		$this->__InvoicelistItemA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_InvoicelistItem
	 * @return B3it_XmlBind_Opentrans21_InvoicelistItemList
	 */
	public function setInvoicelistItem($value)
	{
		$this->__InvoicelistItemA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_InvoicelistItem[]
	 */
	public function getAllInvoicelistItem()
	{
		return $this->__InvoicelistItemA;
	}







	public function toXml($xml)
	{
		$node = new DOMElement('INVOICELIST_ITEM_LIST');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__InvoicelistItemA != null){
			foreach($this->__InvoicelistItemA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
