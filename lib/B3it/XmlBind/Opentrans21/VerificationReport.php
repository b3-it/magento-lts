<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	VerificationReport
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_VerificationReport extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_VerificationAttachment */
	private $__VerificationAttachment = null;

	/* @var B3it_XmlBind_Opentrans21_VerificationProtocol */
	private $__VerificationProtocol = null;

	/* @var B3it_XmlBind_Opentrans21_VerificationXmlreport */
	private $__VerificationXmlreport = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_VerificationAttachment
	 */
	public function getVerificationAttachment()
	{
		if($this->__VerificationAttachment == null)
		{
			$this->__VerificationAttachment = new B3it_XmlBind_Opentrans21_VerificationAttachment();
		}
	
		return $this->__VerificationAttachment;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_VerificationAttachment
	 * @return B3it_XmlBind_Opentrans21_VerificationReport
	 */
	public function setVerificationAttachment($value)
	{
		$this->__VerificationAttachment = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_VerificationProtocol
	 */
	public function getVerificationProtocol()
	{
		if($this->__VerificationProtocol == null)
		{
			$this->__VerificationProtocol = new B3it_XmlBind_Opentrans21_VerificationProtocol();
		}
	
		return $this->__VerificationProtocol;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_VerificationProtocol
	 * @return B3it_XmlBind_Opentrans21_VerificationReport
	 */
	public function setVerificationProtocol($value)
	{
		$this->__VerificationProtocol = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_VerificationXmlreport
	 */
	public function getVerificationXmlreport()
	{
		if($this->__VerificationXmlreport == null)
		{
			$this->__VerificationXmlreport = new B3it_XmlBind_Opentrans21_VerificationXmlreport();
		}
	
		return $this->__VerificationXmlreport;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_VerificationXmlreport
	 * @return B3it_XmlBind_Opentrans21_VerificationReport
	 */
	public function setVerificationXmlreport($value)
	{
		$this->__VerificationXmlreport = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('VERIFICATION_REPORT');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__VerificationAttachment != null){
			$this->__VerificationAttachment->toXml($xml);
		}
		if($this->__VerificationProtocol != null){
			$this->__VerificationProtocol->toXml($xml);
		}
		if($this->__VerificationXmlreport != null){
			$this->__VerificationXmlreport->toXml($xml);
		}


		return $xml;
	}

}
