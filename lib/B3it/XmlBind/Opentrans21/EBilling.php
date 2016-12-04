<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	EBilling
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_EBilling extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_InvoiceOriginal */
	private $__InvoiceOriginal = null;

	
	/* @var B3it_XmlBind_Opentrans21_SignatureAndVerification */
	private $__SignatureAndVerificationA = array();


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_InvoiceOriginal
	 */
	public function getInvoiceOriginal()
	{
		if($this->__InvoiceOriginal == null)
		{
			$this->__InvoiceOriginal = new B3it_XmlBind_Opentrans21_InvoiceOriginal();
		}
	
		return $this->__InvoiceOriginal;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_InvoiceOriginal
	 * @return B3it_XmlBind_Opentrans21_EBilling
	 */
	public function setInvoiceOriginal($value)
	{
		$this->__InvoiceOriginal = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_SignatureAndVerification and add it to list
	 * @return B3it_XmlBind_Opentrans21_SignatureAndVerification
	 */
	public function getSignatureAndVerification()
	{
		$res = new B3it_XmlBind_Opentrans21_SignatureAndVerification();
		$this->__SignatureAndVerificationA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_SignatureAndVerification
	 * @return B3it_XmlBind_Opentrans21_EBilling
	 */
	public function setSignatureAndVerification($value)
	{
		$this->__SignatureAndVerificationA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_SignatureAndVerification[]
	 */
	public function getAllSignatureAndVerification()
	{
		return $this->__SignatureAndVerificationA;
	}







	public function toXml($xml)
	{
		$node = new DOMElement('E_BILLING');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__InvoiceOriginal != null){
			$this->__InvoiceOriginal->toXml($xml);
		}
		if($this->__SignatureAndVerificationA != null){
			foreach($this->__SignatureAndVerificationA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
