<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	InvoiceAdjustment
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_InvoiceAdjustment extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_AdjustedInvoiceSummary */
	private $__AdjustedInvoiceSummary = null;

	
	/* @var B3it_XmlBind_Opentrans21_AdjustmentReasonDescr */
	private $__AdjustmentReasonDescrA = array();

	/* @var B3it_XmlBind_Opentrans21_AdjustmentReasonCode */
	private $__AdjustmentReasonCode = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_AdjustedInvoiceSummary
	 */
	public function getAdjustedInvoiceSummary()
	{
		if($this->__AdjustedInvoiceSummary == null)
		{
			$this->__AdjustedInvoiceSummary = new B3it_XmlBind_Opentrans21_AdjustedInvoiceSummary();
		}
	
		return $this->__AdjustedInvoiceSummary;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_AdjustedInvoiceSummary
	 * @return B3it_XmlBind_Opentrans21_InvoiceAdjustment
	 */
	public function setAdjustedInvoiceSummary($value)
	{
		$this->__AdjustedInvoiceSummary = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_AdjustmentReasonDescr and add it to list
	 * @return B3it_XmlBind_Opentrans21_AdjustmentReasonDescr
	 */
	public function getAdjustmentReasonDescr()
	{
		$res = new B3it_XmlBind_Opentrans21_AdjustmentReasonDescr();
		$this->__AdjustmentReasonDescrA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_AdjustmentReasonDescr
	 * @return B3it_XmlBind_Opentrans21_InvoiceAdjustment
	 */
	public function setAdjustmentReasonDescr($value)
	{
		$this->__AdjustmentReasonDescrA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_AdjustmentReasonDescr[]
	 */
	public function getAllAdjustmentReasonDescr()
	{
		return $this->__AdjustmentReasonDescrA;
	}


	
	/**
	 * @return B3it_XmlBind_Opentrans21_AdjustmentReasonCode
	 */
	public function getAdjustmentReasonCode()
	{
		if($this->__AdjustmentReasonCode == null)
		{
			$this->__AdjustmentReasonCode = new B3it_XmlBind_Opentrans21_AdjustmentReasonCode();
		}
	
		return $this->__AdjustmentReasonCode;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_AdjustmentReasonCode
	 * @return B3it_XmlBind_Opentrans21_InvoiceAdjustment
	 */
	public function setAdjustmentReasonCode($value)
	{
		$this->__AdjustmentReasonCode = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('INVOICE_ADJUSTMENT');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__AdjustedInvoiceSummary != null){
			$this->__AdjustedInvoiceSummary->toXml($xml);
		}
		if($this->__AdjustmentReasonDescrA != null){
			foreach($this->__AdjustmentReasonDescrA as $item){
				$item->toXml($xml);
			}
		}
		if($this->__AdjustmentReasonCode != null){
			$this->__AdjustmentReasonCode->toXml($xml);
		}


		return $xml;
	}

}
