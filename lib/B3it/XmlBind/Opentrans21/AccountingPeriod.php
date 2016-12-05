<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	AccountingPeriod
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_AccountingPeriod extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_AccountingPeriodStartDate */
	private $__AccountingPeriodStartDate = null;

	/* @var B3it_XmlBind_Opentrans21_AccountingPeriodEndDate */
	private $__AccountingPeriodEndDate = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_AccountingPeriodStartDate
	 */
	public function getAccountingPeriodStartDate()
	{
		if($this->__AccountingPeriodStartDate == null)
		{
			$this->__AccountingPeriodStartDate = new B3it_XmlBind_Opentrans21_AccountingPeriodStartDate();
		}
	
		return $this->__AccountingPeriodStartDate;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_AccountingPeriodStartDate
	 * @return B3it_XmlBind_Opentrans21_AccountingPeriod
	 */
	public function setAccountingPeriodStartDate($value)
	{
		$this->__AccountingPeriodStartDate = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_AccountingPeriodEndDate
	 */
	public function getAccountingPeriodEndDate()
	{
		if($this->__AccountingPeriodEndDate == null)
		{
			$this->__AccountingPeriodEndDate = new B3it_XmlBind_Opentrans21_AccountingPeriodEndDate();
		}
	
		return $this->__AccountingPeriodEndDate;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_AccountingPeriodEndDate
	 * @return B3it_XmlBind_Opentrans21_AccountingPeriod
	 */
	public function setAccountingPeriodEndDate($value)
	{
		$this->__AccountingPeriodEndDate = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('ACCOUNTING_PERIOD');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__AccountingPeriodStartDate != null){
			$this->__AccountingPeriodStartDate->toXml($xml);
		}
		if($this->__AccountingPeriodEndDate != null){
			$this->__AccountingPeriodEndDate->toXml($xml);
		}


		return $xml;
	}

}
