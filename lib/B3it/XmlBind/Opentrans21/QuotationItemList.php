<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	QuotationItemList
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_QuotationItemList extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	
	/* @var B3it_XmlBind_Opentrans21_QuotationItem */
	private $__QuotationItemA = array();


	

	

	
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_QuotationItem and add it to list
	 * @return B3it_XmlBind_Opentrans21_QuotationItem
	 */
	public function getQuotationItem()
	{
		$res = new B3it_XmlBind_Opentrans21_QuotationItem();
		$this->__QuotationItemA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_QuotationItem
	 * @return B3it_XmlBind_Opentrans21_QuotationItemList
	 */
	public function setQuotationItem($value)
	{
		$this->__QuotationItemA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_QuotationItem[]
	 */
	public function getAllQuotationItem()
	{
		return $this->__QuotationItemA;
	}







	public function toXml($xml)
	{
		$node = new DOMElement('QUOTATION_ITEM_LIST');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__QuotationItemA != null){
			foreach($this->__QuotationItemA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
