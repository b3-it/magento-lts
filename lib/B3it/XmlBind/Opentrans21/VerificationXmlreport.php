<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	VerificationXmlreport
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_VerificationXmlreport extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_XmlFormat */
	private $__XmlFormat = null;

	/* @var B3it_XmlBind_Opentrans21_ReportUdx */
	private $__ReportUdx = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_XmlFormat
	 */
	public function getXmlFormat()
	{
		if($this->__XmlFormat == null)
		{
			$this->__XmlFormat = new B3it_XmlBind_Opentrans21_XmlFormat();
		}
	
		return $this->__XmlFormat;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_XmlFormat
	 * @return B3it_XmlBind_Opentrans21_VerificationXmlreport
	 */
	public function setXmlFormat($value)
	{
		$this->__XmlFormat = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_ReportUdx
	 */
	public function getReportUdx()
	{
		if($this->__ReportUdx == null)
		{
			$this->__ReportUdx = new B3it_XmlBind_Opentrans21_ReportUdx();
		}
	
		return $this->__ReportUdx;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_ReportUdx
	 * @return B3it_XmlBind_Opentrans21_VerificationXmlreport
	 */
	public function setReportUdx($value)
	{
		$this->__ReportUdx = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('VERIFICATION_XMLREPORT');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__XmlFormat != null){
			$this->__XmlFormat->toXml($xml);
		}
		if($this->__ReportUdx != null){
			$this->__ReportUdx->toXml($xml);
		}


		return $xml;
	}

}
