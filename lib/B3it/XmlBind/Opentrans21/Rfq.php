<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Rfq
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Rfq extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_RfqHeader */
	private $__RfqHeader = null;

	/* @var B3it_XmlBind_Opentrans21_RfqItemList */
	private $__RfqItemList = null;

	/* @var B3it_XmlBind_Opentrans21_RfqSummary */
	private $__RfqSummary = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_RfqHeader
	 */
	public function getRfqHeader()
	{
		if($this->__RfqHeader == null)
		{
			$this->__RfqHeader = new B3it_XmlBind_Opentrans21_RfqHeader();
		}
	
		return $this->__RfqHeader;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_RfqHeader
	 * @return B3it_XmlBind_Opentrans21_Rfq
	 */
	public function setRfqHeader($value)
	{
		$this->__RfqHeader = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_RfqItemList
	 */
	public function getRfqItemList()
	{
		if($this->__RfqItemList == null)
		{
			$this->__RfqItemList = new B3it_XmlBind_Opentrans21_RfqItemList();
		}
	
		return $this->__RfqItemList;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_RfqItemList
	 * @return B3it_XmlBind_Opentrans21_Rfq
	 */
	public function setRfqItemList($value)
	{
		$this->__RfqItemList = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_RfqSummary
	 */
	public function getRfqSummary()
	{
		if($this->__RfqSummary == null)
		{
			$this->__RfqSummary = new B3it_XmlBind_Opentrans21_RfqSummary();
		}
	
		return $this->__RfqSummary;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_RfqSummary
	 * @return B3it_XmlBind_Opentrans21_Rfq
	 */
	public function setRfqSummary($value)
	{
		$this->__RfqSummary = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('RFQ');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__RfqHeader != null){
			$this->__RfqHeader->toXml($xml);
		}
		if($this->__RfqItemList != null){
			$this->__RfqItemList->toXml($xml);
		}
		if($this->__RfqSummary != null){
			$this->__RfqSummary->toXml($xml);
		}


		return $xml;
	}

}
