<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Dispatchnotification
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Dispatchnotification extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_DispatchnotificationHeader */
	private $__DispatchnotificationHeader = null;

	/* @var B3it_XmlBind_Opentrans21_DispatchnotificationItemList */
	private $__DispatchnotificationItemList = null;

	/* @var B3it_XmlBind_Opentrans21_DispatchnotificationSummary */
	private $__DispatchnotificationSummary = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_DispatchnotificationHeader
	 */
	public function getDispatchnotificationHeader()
	{
		if($this->__DispatchnotificationHeader == null)
		{
			$this->__DispatchnotificationHeader = new B3it_XmlBind_Opentrans21_DispatchnotificationHeader();
		}
	
		return $this->__DispatchnotificationHeader;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_DispatchnotificationHeader
	 * @return B3it_XmlBind_Opentrans21_Dispatchnotification
	 */
	public function setDispatchnotificationHeader($value)
	{
		$this->__DispatchnotificationHeader = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_DispatchnotificationItemList
	 */
	public function getDispatchnotificationItemList()
	{
		if($this->__DispatchnotificationItemList == null)
		{
			$this->__DispatchnotificationItemList = new B3it_XmlBind_Opentrans21_DispatchnotificationItemList();
		}
	
		return $this->__DispatchnotificationItemList;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_DispatchnotificationItemList
	 * @return B3it_XmlBind_Opentrans21_Dispatchnotification
	 */
	public function setDispatchnotificationItemList($value)
	{
		$this->__DispatchnotificationItemList = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_DispatchnotificationSummary
	 */
	public function getDispatchnotificationSummary()
	{
		if($this->__DispatchnotificationSummary == null)
		{
			$this->__DispatchnotificationSummary = new B3it_XmlBind_Opentrans21_DispatchnotificationSummary();
		}
	
		return $this->__DispatchnotificationSummary;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_DispatchnotificationSummary
	 * @return B3it_XmlBind_Opentrans21_Dispatchnotification
	 */
	public function setDispatchnotificationSummary($value)
	{
		$this->__DispatchnotificationSummary = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('DISPATCHNOTIFICATION');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__DispatchnotificationHeader != null){
			$this->__DispatchnotificationHeader->toXml($xml);
		}
		if($this->__DispatchnotificationItemList != null){
			$this->__DispatchnotificationItemList->toXml($xml);
		}
		if($this->__DispatchnotificationSummary != null){
			$this->__DispatchnotificationSummary->toXml($xml);
		}


		return $xml;
	}

}
