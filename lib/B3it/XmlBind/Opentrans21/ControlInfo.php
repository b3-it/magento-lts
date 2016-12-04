<?php
/**
 *
 * XML Bind  für Opentrans 2.1
 * @category   	B3it
 * @package    	B3it_XmlBind_Opentrans21_
 * @name       	ControlInfo
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_XmlBind_Opentrans21_ControlInfo extends B3it_XmlBind_Opentrans21_XmlObject
{
	
	
	/* @var B3it_XmlBind_Opentrans21_StopAutomaticProcessing */
	private $__StopAutomaticProcessing = null;

	/* @var B3it_XmlBind_Opentrans21_GeneratorInfo */
	private $__GeneratorInfo = null;

	/* @var B3it_XmlBind_Opentrans21_GenerationDate */
	private $__GenerationDate = null;


	

	

	
	
	/**
	 * @return B3it_XmlBind_Opentrans21_StopAutomaticProcessing
	 */
	public function getStopAutomaticProcessing()
	{
		if($this->__StopAutomaticProcessing == null)
		{
			$this->__StopAutomaticProcessing = new B3it_XmlBind_Opentrans21_StopAutomaticProcessing();
		}
	
		return $this->__StopAutomaticProcessing;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_StopAutomaticProcessing
	 * @return B3it_XmlBind_Opentrans21_ControlInfo
	 */
	public function setStopAutomaticProcessing($value)
	{
		$this->__StopAutomaticProcessing = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_GeneratorInfo
	 */
	public function getGeneratorInfo()
	{
		if($this->__GeneratorInfo == null)
		{
			$this->__GeneratorInfo = new B3it_XmlBind_Opentrans21_GeneratorInfo();
		}
	
		return $this->__GeneratorInfo;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_GeneratorInfo
	 * @return B3it_XmlBind_Opentrans21_ControlInfo
	 */
	public function setGeneratorInfo($value)
	{
		$this->__GeneratorInfo = $value;
		return $this;
	}
	
	/**
	 * @return B3it_XmlBind_Opentrans21_GenerationDate
	 */
	public function getGenerationDate()
	{
		if($this->__GenerationDate == null)
		{
			$this->__GenerationDate = new B3it_XmlBind_Opentrans21_GenerationDate();
		}
	
		return $this->__GenerationDate;
	}
	
	/**
	 * @param $value B3it_XmlBind_Opentrans21_GenerationDate
	 * @return B3it_XmlBind_Opentrans21_ControlInfo
	 */
	public function setGenerationDate($value)
	{
		$this->__GenerationDate = $value;
		return $this;
	}





	public function toXml($xml)
	{
		$node = new DOMElement('CONTROL_INFO');
		$xml = $xml->appendChild($node);
		foreach($this->getAttributes() as $key => $value){
			$xml->setAttribute($key,$value);
		}
		
		if($this->__StopAutomaticProcessing != null){
			$this->__StopAutomaticProcessing->toXml($xml);
		}
		if($this->__GeneratorInfo != null){
			$this->__GeneratorInfo->toXml($xml);
		}
		if($this->__GenerationDate != null){
			$this->__GenerationDate->toXml($xml);
		}


		return $xml;
	}

}
