<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	RemittanceadviceSummary
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_RemittanceadviceSummary extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_TotalItemNum */
	private $__TotalItemNum = null;

	/* @var B3it_XmlBind_Opentrans21_OriginalSummaryAmount */
	private $__OriginalSummaryAmount = null;

	/* @var B3it_XmlBind_Opentrans21_AdjustedSummaryAmount */
	private $__AdjustedSummaryAmount = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_TotalItemNum
	 */
	public function getTotalItemNum()
	{
		if($this->__TotalItemNum == null)
		{
			$this->__TotalItemNum = new B3it_XmlBind_Opentrans21_TotalItemNum();
		}
	
		return $this->__TotalItemNum;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_TotalItemNum
	 * @return B3it_XmlBind_Opentrans21_RemittanceadviceSummary
	 */
	public function setTotalItemNum($value)
	{
		$this->__TotalItemNum = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_OriginalSummaryAmount
	 */
	public function getOriginalSummaryAmount()
	{
		if($this->__OriginalSummaryAmount == null)
		{
			$this->__OriginalSummaryAmount = new B3it_XmlBind_Opentrans21_OriginalSummaryAmount();
		}
	
		return $this->__OriginalSummaryAmount;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_OriginalSummaryAmount
	 * @return B3it_XmlBind_Opentrans21_RemittanceadviceSummary
	 */
	public function setOriginalSummaryAmount($value)
	{
		$this->__OriginalSummaryAmount = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_AdjustedSummaryAmount
	 */
	public function getAdjustedSummaryAmount()
	{
		if($this->__AdjustedSummaryAmount == null)
		{
			$this->__AdjustedSummaryAmount = new B3it_XmlBind_Opentrans21_AdjustedSummaryAmount();
		}
	
		return $this->__AdjustedSummaryAmount;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_AdjustedSummaryAmount
	 * @return B3it_XmlBind_Opentrans21_RemittanceadviceSummary
	 */
	public function setAdjustedSummaryAmount($value)
	{
		$this->__AdjustedSummaryAmount = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('REMITTANCEADVICE_SUMMARY');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__TotalItemNum != null){
			$this->__TotalItemNum->toXml($xml);
		}
		if($this->__OriginalSummaryAmount != null){
			$this->__OriginalSummaryAmount->toXml($xml);
		}
		if($this->__AdjustedSummaryAmount != null){
			$this->__AdjustedSummaryAmount->toXml($xml);
		}


		return $xml;
	}

}
