<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	VerificationProtocol
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_VerificationProtocol extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_ResultCode */
	private $__ResultCode = null;

	
	/* @var B3it_XmlBind_Opentrans21_ResultDescr */
	private $__ResultDescrA = array();


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_ResultCode
	 */
	public function getResultCode()
	{
		if($this->__ResultCode == null)
		{
			$this->__ResultCode = new B3it_XmlBind_Opentrans21_ResultCode();
		}
	
		return $this->__ResultCode;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_ResultCode
	 * @return B3it_XmlBind_Opentrans21_VerificationProtocol
	 */
	public function setResultCode($value)
	{
		$this->__ResultCode = $value;
		return $this;
	}
	

	/**
	 * Create new B3it_XmlBind_Opentrans21_ResultDescr and add it to list
	 * @return B3it_XmlBind_Opentrans21_ResultDescr
	 */
	public function getResultDescr()
	{
		$res = new B3it_XmlBind_Opentrans21_ResultDescr();
		$this->__ResultDescrA[] = $res;
			
		return $res;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_ResultDescr
	 * @return B3it_XmlBind_Opentrans21_VerificationProtocol
	 */
	public function setResultDescr($value)
	{
		$this->__ResultDescrA[] = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_ResultDescr[]
	 */
	public function getAllResultDescr()
	{
		return $this->__ResultDescrA;
	}







	public function toXml($xml)
	{
		$node = new DOMElement('VERIFICATION_PROTOCOL');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__ResultCode != null){
			$this->__ResultCode->toXml($xml);
		}
		if($this->__ResultDescrA != null){
			foreach($this->__ResultDescrA as $item){
				$item->toXml($xml);
			}
		}


		return $xml;
	}

}
