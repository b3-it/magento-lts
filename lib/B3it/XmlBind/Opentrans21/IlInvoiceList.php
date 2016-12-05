<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	IlInvoiceList
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_IlInvoiceList extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	
	/* @var B3it_XmlBind_Opentrans21_IlInvoiceListItem */
	private $__IlInvoiceListItemA = array();


	

	

	
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_IlInvoiceListItem and add it to list
	 * @return B3it_XmlBind_Opentrans21_IlInvoiceListItem
	 */
	public function getIlInvoiceListItem()
	{
		$res = new B3it_XmlBind_Opentrans21_IlInvoiceListItem();
		$this->__IlInvoiceListItemA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_IlInvoiceListItem
	 * @return B3it_XmlBind_Opentrans21_IlInvoiceList
	 */
	public function setIlInvoiceListItem($value)
	{
		$this->__IlInvoiceListItemA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_IlInvoiceListItem[]
	 */
	public function getAllIlInvoiceListItem()
	{
		return $this->__IlInvoiceListItemA;
	}







	public function toXml($xml)
	{
		$node = new DOMElement('IL_INVOICE_LIST');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__IlInvoiceListItemA != null){
			foreach($this->__IlInvoiceListItemA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
