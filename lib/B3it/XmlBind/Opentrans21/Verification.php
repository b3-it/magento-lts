<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Verification
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Verification extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_VerificationPartyIdref */
	private $__VerificationPartyIdref = null;

	/* @var B3it_XmlBind_Opentrans21_VerificationSuccess */
	private $__VerificationSuccess = null;

	/* @var B3it_XmlBind_Opentrans21_VerificationReport */
	private $__VerificationReport = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_VerificationPartyIdref
	 */
	public function getVerificationPartyIdref()
	{
		if($this->__VerificationPartyIdref == null)
		{
			$this->__VerificationPartyIdref = new B3it_XmlBind_Opentrans21_VerificationPartyIdref();
		}
	
		return $this->__VerificationPartyIdref;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_VerificationPartyIdref
	 * @return B3it_XmlBind_Opentrans21_Verification
	 */
	public function setVerificationPartyIdref($value)
	{
		$this->__VerificationPartyIdref = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_VerificationSuccess
	 */
	public function getVerificationSuccess()
	{
		if($this->__VerificationSuccess == null)
		{
			$this->__VerificationSuccess = new B3it_XmlBind_Opentrans21_VerificationSuccess();
		}
	
		return $this->__VerificationSuccess;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_VerificationSuccess
	 * @return B3it_XmlBind_Opentrans21_Verification
	 */
	public function setVerificationSuccess($value)
	{
		$this->__VerificationSuccess = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_VerificationReport
	 */
	public function getVerificationReport()
	{
		if($this->__VerificationReport == null)
		{
			$this->__VerificationReport = new B3it_XmlBind_Opentrans21_VerificationReport();
		}
	
		return $this->__VerificationReport;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_VerificationReport
	 * @return B3it_XmlBind_Opentrans21_Verification
	 */
	public function setVerificationReport($value)
	{
		$this->__VerificationReport = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('VERIFICATION');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__VerificationPartyIdref != null){
			$this->__VerificationPartyIdref->toXml($xml);
		}
		if($this->__VerificationSuccess != null){
			$this->__VerificationSuccess->toXml($xml);
		}
		if($this->__VerificationReport != null){
			$this->__VerificationReport->toXml($xml);
		}


		return $xml;
	}

}
