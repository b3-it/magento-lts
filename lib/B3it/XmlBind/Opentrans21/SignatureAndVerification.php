<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	SignatureAndVerification
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_SignatureAndVerification extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Signature */
	private $__Signature = null;

	
	/* @var B3it_XmlBind_Opentrans21_Verification */
	private $__VerificationA = array();


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Signature
	 */
	public function getSignature()
	{
		if($this->__Signature == null)
		{
			$this->__Signature = new B3it_XmlBind_Opentrans21_Signature();
		}
	
		return $this->__Signature;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Signature
	 * @return B3it_XmlBind_Opentrans21_SignatureAndVerification
	 */
	public function setSignature($value)
	{
		$this->__Signature = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_Verification and add it to list
	 * @return B3it_XmlBind_Opentrans21_Verification
	 */
	public function getVerification()
	{
		$res = new B3it_XmlBind_Opentrans21_Verification();
		$this->__VerificationA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Verification
	 * @return B3it_XmlBind_Opentrans21_SignatureAndVerification
	 */
	public function setVerification($value)
	{
		$this->__VerificationA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Verification[]
	 */
	public function getAllVerification()
	{
		return $this->__VerificationA;
	}







	public function toXml($xml)
	{
		$node = new DOMElement('SIGNATURE_AND_VERIFICATION');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__Signature != null){
			$this->__Signature->toXml($xml);
		}
		if($this->__VerificationA != null){
			foreach($this->__VerificationA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
