<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	Bmecat_AgreementRef
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_Bmecat_AgreementRef extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_Bmecat_AgreementIdref */
	private $__AgreementIdref = null;

	/* @var B3it_XmlBind_Opentrans21_Bmecat_AgreementLineIdref */
	private $__AgreementLineIdref = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_AgreementIdref
	 */
	public function getAgreementIdref()
	{
		if($this->__AgreementIdref == null)
		{
			$this->__AgreementIdref = new B3it_XmlBind_Opentrans21_Bmecat_AgreementIdref();
		}
	
		return $this->__AgreementIdref;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_AgreementIdref
	 * @return B3it_XmlBind_Opentrans21_Bmecat_AgreementRef
	 */
	public function setAgreementIdref($value)
	{
		$this->__AgreementIdref = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_Bmecat_AgreementLineIdref
	 */
	public function getAgreementLineIdref()
	{
		if($this->__AgreementLineIdref == null)
		{
			$this->__AgreementLineIdref = new B3it_XmlBind_Opentrans21_Bmecat_AgreementLineIdref();
		}
	
		return $this->__AgreementLineIdref;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_Bmecat_AgreementLineIdref
	 * @return B3it_XmlBind_Opentrans21_Bmecat_AgreementRef
	 */
	public function setAgreementLineIdref($value)
	{
		$this->__AgreementLineIdref = $value;
		return $this;
	}





	public function toXml($xml)
	{
	if( $xml instanceof DOMDocument){
			$node = $xml->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:AGREEMENT_REF');
		} else {
			$node = $xml->ownerDocument->createElementNS('http://www.bmecat.org/bmecat/2005','bmecat:AGREEMENT_REF');
		}
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__AgreementIdref != null){
			$this->__AgreementIdref->toXml($xml);
		}
		if($this->__AgreementLineIdref != null){
			$this->__AgreementLineIdref->toXml($xml);
		}


		return $xml;
	}

}
