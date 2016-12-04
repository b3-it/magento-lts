<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	RfqSummary
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_RfqSummary extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_TotalItemNum */
	private $__TotalItemNum = null;


	

	

	
	
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
	 * @return B3it_XmlBind_Opentrans21_RfqSummary
	 */
	public function setTotalItemNum($value)
	{
		$this->__TotalItemNum = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('RFQ_SUMMARY');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__TotalItemNum != null){
			$this->__TotalItemNum->toXml($xml);
		}


		return $xml;
	}

}
