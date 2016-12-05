<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Receiptacknowledgement
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Receiptacknowledgement extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_ReceiptacknowledgementHeader */
	private $__ReceiptacknowledgementHeader = null;

	/* @var B3it_XmlBind_Opentrans21_ReceiptacknowledgementItemList */
	private $__ReceiptacknowledgementItemList = null;

	/* @var B3it_XmlBind_Opentrans21_ReceiptacknowledgementSummary */
	private $__ReceiptacknowledgementSummary = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_ReceiptacknowledgementHeader
	 */
	public function getReceiptacknowledgementHeader()
	{
		if($this->__ReceiptacknowledgementHeader == null)
		{
			$this->__ReceiptacknowledgementHeader = new B3it_XmlBind_Opentrans21_ReceiptacknowledgementHeader();
		}
	
		return $this->__ReceiptacknowledgementHeader;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_ReceiptacknowledgementHeader
	 * @return B3it_XmlBind_Opentrans21_Receiptacknowledgement
	 */
	public function setReceiptacknowledgementHeader($value)
	{
		$this->__ReceiptacknowledgementHeader = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_ReceiptacknowledgementItemList
	 */
	public function getReceiptacknowledgementItemList()
	{
		if($this->__ReceiptacknowledgementItemList == null)
		{
			$this->__ReceiptacknowledgementItemList = new B3it_XmlBind_Opentrans21_ReceiptacknowledgementItemList();
		}
	
		return $this->__ReceiptacknowledgementItemList;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_ReceiptacknowledgementItemList
	 * @return B3it_XmlBind_Opentrans21_Receiptacknowledgement
	 */
	public function setReceiptacknowledgementItemList($value)
	{
		$this->__ReceiptacknowledgementItemList = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_ReceiptacknowledgementSummary
	 */
	public function getReceiptacknowledgementSummary()
	{
		if($this->__ReceiptacknowledgementSummary == null)
		{
			$this->__ReceiptacknowledgementSummary = new B3it_XmlBind_Opentrans21_ReceiptacknowledgementSummary();
		}
	
		return $this->__ReceiptacknowledgementSummary;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_ReceiptacknowledgementSummary
	 * @return B3it_XmlBind_Opentrans21_Receiptacknowledgement
	 */
	public function setReceiptacknowledgementSummary($value)
	{
		$this->__ReceiptacknowledgementSummary = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('RECEIPTACKNOWLEDGEMENT');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__ReceiptacknowledgementHeader != null){
			$this->__ReceiptacknowledgementHeader->toXml($xml);
		}
		if($this->__ReceiptacknowledgementItemList != null){
			$this->__ReceiptacknowledgementItemList->toXml($xml);
		}
		if($this->__ReceiptacknowledgementSummary != null){
			$this->__ReceiptacknowledgementSummary->toXml($xml);
		}


		return $xml;
	}

}
