<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	InvoiceCorrection
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_InvoiceCorrection extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_InvoiceReference */
	private $__InvoiceReference = null;

	
	/* @var B3it_XmlBind_Opentrans21_AdjustmentReasonDescr */
	private $__AdjustmentReasonDescrA = array();

	/* @var B3it_XmlBind_Opentrans21_AdjustmentReasonCode */
	private $__AdjustmentReasonCode = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_InvoiceReference
	 */
	public function getInvoiceReference()
	{
		if($this->__InvoiceReference == null)
		{
			$this->__InvoiceReference = new B3it_XmlBind_Opentrans21_InvoiceReference();
		}
	
		return $this->__InvoiceReference;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_InvoiceReference
	 * @return B3it_XmlBind_Opentrans21_InvoiceCorrection
	 */
	public function setInvoiceReference($value)
	{
		$this->__InvoiceReference = $value;
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
	 * @return B3it_XmlBind_Opentrans21_InvoiceCorrection
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
	 * @return B3it_XmlBind_Opentrans21_InvoiceCorrection
	 */
	public function setAdjustmentReasonCode($value)
	{
		$this->__AdjustmentReasonCode = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('INVOICE_CORRECTION');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__InvoiceReference != null){
			$this->__InvoiceReference->toXml($xml);
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
