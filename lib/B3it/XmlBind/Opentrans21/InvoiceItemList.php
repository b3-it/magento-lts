<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	InvoiceItemList
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_InvoiceItemList extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	
	/* @var B3it_XmlBind_Opentrans21_InvoiceItem */
	private $__InvoiceItemA = array();


	

	

	
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_InvoiceItem and add it to list
	 * @return B3it_XmlBind_Opentrans21_InvoiceItem
	 */
	public function getInvoiceItem()
	{
		$res = new B3it_XmlBind_Opentrans21_InvoiceItem();
		$this->__InvoiceItemA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_InvoiceItem
	 * @return B3it_XmlBind_Opentrans21_InvoiceItemList
	 */
	public function setInvoiceItem($value)
	{
		$this->__InvoiceItemA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_InvoiceItem[]
	 */
	public function getAllInvoiceItem()
	{
		return $this->__InvoiceItemA;
	}







	public function toXml($xml)
	{
		$node = new DOMElement('INVOICE_ITEM_LIST');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__InvoiceItemA != null){
			foreach($this->__InvoiceItemA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
