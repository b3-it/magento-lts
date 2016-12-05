<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Remittanceadvice
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Remittanceadvice extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_RemittanceadviceHeader */
	private $__RemittanceadviceHeader = null;

	/* @var B3it_XmlBind_Opentrans21_RemittanceadviceItemList */
	private $__RemittanceadviceItemList = null;

	/* @var B3it_XmlBind_Opentrans21_RemittanceadviceSummary */
	private $__RemittanceadviceSummary = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_RemittanceadviceHeader
	 */
	public function getRemittanceadviceHeader()
	{
		if($this->__RemittanceadviceHeader == null)
		{
			$this->__RemittanceadviceHeader = new B3it_XmlBind_Opentrans21_RemittanceadviceHeader();
		}
	
		return $this->__RemittanceadviceHeader;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_RemittanceadviceHeader
	 * @return B3it_XmlBind_Opentrans21_Remittanceadvice
	 */
	public function setRemittanceadviceHeader($value)
	{
		$this->__RemittanceadviceHeader = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_RemittanceadviceItemList
	 */
	public function getRemittanceadviceItemList()
	{
		if($this->__RemittanceadviceItemList == null)
		{
			$this->__RemittanceadviceItemList = new B3it_XmlBind_Opentrans21_RemittanceadviceItemList();
		}
	
		return $this->__RemittanceadviceItemList;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_RemittanceadviceItemList
	 * @return B3it_XmlBind_Opentrans21_Remittanceadvice
	 */
	public function setRemittanceadviceItemList($value)
	{
		$this->__RemittanceadviceItemList = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_RemittanceadviceSummary
	 */
	public function getRemittanceadviceSummary()
	{
		if($this->__RemittanceadviceSummary == null)
		{
			$this->__RemittanceadviceSummary = new B3it_XmlBind_Opentrans21_RemittanceadviceSummary();
		}
	
		return $this->__RemittanceadviceSummary;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_RemittanceadviceSummary
	 * @return B3it_XmlBind_Opentrans21_Remittanceadvice
	 */
	public function setRemittanceadviceSummary($value)
	{
		$this->__RemittanceadviceSummary = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('REMITTANCEADVICE');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__RemittanceadviceHeader != null){
			$this->__RemittanceadviceHeader->toXml($xml);
		}
		if($this->__RemittanceadviceItemList != null){
			$this->__RemittanceadviceItemList->toXml($xml);
		}
		if($this->__RemittanceadviceSummary != null){
			$this->__RemittanceadviceSummary->toXml($xml);
		}


		return $xml;
	}

}
