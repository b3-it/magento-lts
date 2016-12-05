<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	RemittanceadviceItemList
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_RemittanceadviceItemList extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	
	/* @var B3it_XmlBind_Opentrans21_RemittanceadviceItem */
	private $__RemittanceadviceItemA = array();


	

	

	
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_RemittanceadviceItem and add it to list
	 * @return B3it_XmlBind_Opentrans21_RemittanceadviceItem
	 */
	public function getRemittanceadviceItem()
	{
		$res = new B3it_XmlBind_Opentrans21_RemittanceadviceItem();
		$this->__RemittanceadviceItemA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_RemittanceadviceItem
	 * @return B3it_XmlBind_Opentrans21_RemittanceadviceItemList
	 */
	public function setRemittanceadviceItem($value)
	{
		$this->__RemittanceadviceItemA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_RemittanceadviceItem[]
	 */
	public function getAllRemittanceadviceItem()
	{
		return $this->__RemittanceadviceItemA;
	}







	public function toXml($xml)
	{
		$node = new DOMElement('REMITTANCEADVICE_ITEM_LIST');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__RemittanceadviceItemA != null){
			foreach($this->__RemittanceadviceItemA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
