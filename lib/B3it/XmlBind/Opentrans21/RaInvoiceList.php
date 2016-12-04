<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	RaInvoiceList
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_RaInvoiceList extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	
	/* @var B3it_XmlBind_Opentrans21_RaInvoiceListItem */
	private $__RaInvoiceListItemA = array();


	

	

	
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_RaInvoiceListItem and add it to list
	 * @return B3it_XmlBind_Opentrans21_RaInvoiceListItem
	 */
	public function getRaInvoiceListItem()
	{
		$res = new B3it_XmlBind_Opentrans21_RaInvoiceListItem();
		$this->__RaInvoiceListItemA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_RaInvoiceListItem
	 * @return B3it_XmlBind_Opentrans21_RaInvoiceList
	 */
	public function setRaInvoiceListItem($value)
	{
		$this->__RaInvoiceListItemA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_RaInvoiceListItem[]
	 */
	public function getAllRaInvoiceListItem()
	{
		return $this->__RaInvoiceListItemA;
	}







	public function toXml($xml)
	{
		$node = new DOMElement('RA_INVOICE_LIST');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__RaInvoiceListItemA != null){
			foreach($this->__RaInvoiceListItemA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
