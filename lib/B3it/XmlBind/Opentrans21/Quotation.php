<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Quotation
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Quotation extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_QuotationHeader */
	private $__QuotationHeader = null;

	/* @var B3it_XmlBind_Opentrans21_QuotationItemList */
	private $__QuotationItemList = null;

	/* @var B3it_XmlBind_Opentrans21_QuotationSummary */
	private $__QuotationSummary = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_QuotationHeader
	 */
	public function getQuotationHeader()
	{
		if($this->__QuotationHeader == null)
		{
			$this->__QuotationHeader = new B3it_XmlBind_Opentrans21_QuotationHeader();
		}
	
		return $this->__QuotationHeader;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_QuotationHeader
	 * @return B3it_XmlBind_Opentrans21_Quotation
	 */
	public function setQuotationHeader($value)
	{
		$this->__QuotationHeader = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_QuotationItemList
	 */
	public function getQuotationItemList()
	{
		if($this->__QuotationItemList == null)
		{
			$this->__QuotationItemList = new B3it_XmlBind_Opentrans21_QuotationItemList();
		}
	
		return $this->__QuotationItemList;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_QuotationItemList
	 * @return B3it_XmlBind_Opentrans21_Quotation
	 */
	public function setQuotationItemList($value)
	{
		$this->__QuotationItemList = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_QuotationSummary
	 */
	public function getQuotationSummary()
	{
		if($this->__QuotationSummary == null)
		{
			$this->__QuotationSummary = new B3it_XmlBind_Opentrans21_QuotationSummary();
		}
	
		return $this->__QuotationSummary;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_QuotationSummary
	 * @return B3it_XmlBind_Opentrans21_Quotation
	 */
	public function setQuotationSummary($value)
	{
		$this->__QuotationSummary = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('QUOTATION');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__QuotationHeader != null){
			$this->__QuotationHeader->toXml($xml);
		}
		if($this->__QuotationItemList != null){
			$this->__QuotationItemList->toXml($xml);
		}
		if($this->__QuotationSummary != null){
			$this->__QuotationSummary->toXml($xml);
		}


		return $xml;
	}

}
